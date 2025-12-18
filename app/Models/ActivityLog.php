<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    public $timestamps = false; // Hanya pakai created_at
    
    protected $fillable = [
        'user_id',
        'type',
        'action',
        'description',
        'loggable_type',
        'loggable_id',
        'metadata',
        'ip_address',
        'user_agent',
        'level',
    ];

    protected $casts = [
        'metadata' => 'array',
        'created_at' => 'datetime',
    ];

    // ==================== RELATIONSHIPS ====================
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function loggable()
    {
        return $this->morphTo();
    }

    // ==================== SCOPES ====================
    
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeExportAttempts($query)
    {
        return $query->whereIn('type', ['export_attempt', 'export_success', 'export_limit_reached']);
    }

    public function scopePremiumAttempts($query)
    {
        return $query->where('type', 'premium_template_attempt');
    }

    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    // ==================== HELPER METHODS ====================
    
    public static function logExportAttempt($user, $portfolio = null)
    {
        return self::create([
            'user_id' => $user->id,
            'type' => 'export_attempt',
            'action' => 'export_initiated',
            'description' => 'User attempted to export portfolio',
            'loggable_type' => $portfolio ? UserPortfolio::class : null,
            'loggable_id' => $portfolio?->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'level' => 'info',
        ]);
    }

    public static function logLogin($user)
    {
        return self::create([
            'user_id' => $user->id,
            'type' => 'login',
            'action' => 'user_logged_in',
            'description' => 'User logged in successfully',
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'level' => 'info',
        ]);
    }

    public static function logAdminAction($admin, $action, $description, $metadata = [])
    {
        return self::create([
            'user_id' => $admin->id,
            'type' => 'admin_action',
            'action' => $action,
            'description' => $description,
            'metadata' => $metadata,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'level' => 'info',
        ]);
    }
}