#!/bin/sh
set -e

echo "Starting Laravel application..."

# Fix permissions early
mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache || true
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache || true
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache || true

# IMPORTANT: clear caches so new env/config is applied
php artisan optimize:clear || true

rm -f bootstrap/cache/config.php bootstrap/cache/routes-v7.php bootstrap/cache/packages.php bootstrap/cache/services.php || true

# Start supervisor (nginx + php-fpm) FIRST
echo "Starting supervisor (nginx + php-fpm)..."
(/usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf) &

# Give nginx/php-fpm a moment
sleep 3

# Wait for DB (with timeout)
echo "Waiting for database connection (max 60s)..."
i=0
until php artisan db:monitor >/dev/null 2>&1 || php artisan migrate:status >/dev/null 2>&1; do
  i=$((i+1))
  if [ "$i" -ge 30 ]; then
    echo "DB still not ready after 60s, continuing startup..."
    break
  fi
  echo "Database is unavailable - sleeping ($i/30)"
  sleep 2
done

# Run migrations
echo "Running migrations..."
php artisan migrate --force --no-interaction || echo "Migration failed (check logs)."

# --- SEEDER LOGIC DIPERBAIKI (Cek User DAN Template) ---
echo "Checking data integrity..."

# Ambil jumlah data dengan penanganan error jika tabel belum ada
USER_COUNT=$(php artisan tinker --execute="try { echo DB::table('users')->count(); } catch (\Throwable \$e) { echo 0; }" | tr -d '[:space:]')
TEMPLATE_COUNT=$(php artisan tinker --execute="try { echo \Schema::hasTable('templates') ? DB::table('templates')->count() : 0; } catch (\Throwable \$e) { echo 0; }" | tr -d '[:space:]')

# Default ke 0 jika hasil kosong
: "${USER_COUNT:=0}"
: "${TEMPLATE_COUNT:=0}"

echo "Current Status: Users=$USER_COUNT, Templates=$TEMPLATE_COUNT"

if [ "${FORCE_SEED}" = "true" ]; then
    echo "🔄 FORCE_SEED enabled - resetting database..."
    php artisan migrate:fresh --seed --force
elif [ "$USER_COUNT" -eq 0 ] || [ "$TEMPLATE_COUNT" -eq 0 ]; then
    # JIKA USER KOSONG -ATAU- TEMPLATE KOSONG -> SEED ULANG
    echo "⚡ Data incomplete. Running seeders..."
    php artisan db:seed --force --no-interaction
else
    echo "✅ Database already populated. Skipping seeders."
fi
# -------------------------------------------------------

# Cache after migrations
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

echo "Application ready!"

# Keep container running
wait