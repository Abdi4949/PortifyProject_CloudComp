#!/bin/sh
set -e

echo "Starting Laravel application..."

# Fix permissions early
mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache || true
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || true
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache || true

# IMPORTANT: clear caches so new env/config (including SSL options) is applied
php artisan optimize:clear || true
rm -f bootstrap/cache/config.php bootstrap/cache/routes-v7.php bootstrap/cache/packages.php bootstrap/cache/services.php || true

# Start supervisor (nginx + php-fpm) FIRST so Azure warmup doesn't timeout
echo "Starting supervisor (nginx + php-fpm)..."
(/usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf) &

# Give nginx/php-fpm a moment
sleep 3

# Wait for DB (with timeout so container still starts even if DB is slow)
echo "Waiting for database connection (max 120s)..."
i=0
until php artisan migrate:status --no-interaction >/dev/null 2>&1; do
  i=$((i+1))
  if [ "$i" -ge 60 ]; then
    echo "DB still not ready after 120s, continuing startup (will retry migrations next restart)."
    break
  fi
  echo "Database is unavailable - sleeping"
  sleep 2
done

# Run migrations (non-fatal; don't block startup forever)
echo "Running migrations..."
php artisan migrate --force --no-interaction || echo "Migration failed (will retry on next start)."

# Seeder logic with FORCE_SEED support
echo "Checking if seeding is needed..."
SEEDED=$(php artisan tinker --execute="echo DB::table('users')->count();" 2>/dev/null || echo "error")

if [ "${FORCE_SEED}" = "true" ]; then
    echo "🔄 FORCE_SEED enabled - deleting old data and re-seeding..."
    php artisan tinker --execute="DB::table('users')->truncate(); DB::table('templates')->truncate(); echo 'Data cleared';" 2>/dev/null || true
    echo "Running fresh seeders..."
    php artisan db:seed --force --no-interaction || echo "Seeding failed (will retry on next start)."
    echo "✅ Seeders completed (forced)"
elif [ "$SEEDED" = "0" ]; then
    echo "Database is empty - running seeders..."
    php artisan db:seed --force --no-interaction || echo "Seeding failed (will retry on next start)."
    echo "✅ Seeders completed"
elif [ "$SEEDED" = "error" ]; then
    echo "⚠️  Could not check seeder status (table might not exist yet)"
else
    echo "ℹ️  Database already has $SEEDED users - skipping seeders"
    echo "   Set FORCE_SEED=true to force re-seed"
fi

# Cache after migrations and seeding (non-fatal)
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

echo "Application ready!"

# Keep container running
wait