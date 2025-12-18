<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Portfolio; // <--- 1. Pastikan Model Portfolio di-import

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'subscription_type',       // Field legacy (bisa jadi sama dengan account_type)
        'subscription_started_at',
        'subscription_expired_at',
        'export_count',
        'export_week_start',
        'last_export_at',
        'status',
        'suspend_reason',
        'account_type',          // Field yang kita pakai untuk Pro/Free
        'weekly_exports_count',  // Field limit export
        'last_export_week',      // Field reset mingguan
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'subscription_started_at' => 'datetime',
        'subscription_expired_at' => 'datetime',
        'export_week_start' => 'date',
        'last_export_at' => 'datetime',
        'password' => 'hashed',
    ];

    // ==================== RELATIONSHIPS ====================
    
    public function portfolios()
    {
        // PERBAIKAN DI SINI:
        // Ubah dari UserPortfolio::class menjadi Portfolio::class
        return $this->hasMany(Portfolio::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function exports()
    {
        return $this->hasMany(PortfolioExport::class);
    }

    // ==================== SCOPES ====================
    
    public function scopeFreeUsers($query)
    {
        // Sesuaikan jika kamu pakai 'account_type' atau 'subscription_type'
        return $query->where('account_type', 'free');
    }

    public function scopeProUsers($query)
    {
        return $query->where('account_type', 'pro');
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeSuspended($query)
    {
        return $query->where('status', 'suspended');
    }

    // ==================== HELPER METHODS ====================
    
    public function isPro(): bool
    {
        // Kita konsistenkan pakai account_type sesuai controller sebelumnya
        return $this->account_type === 'pro';
    }

    public function isFree(): bool
    {
        return $this->account_type === 'free'; // atau default null
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    public function isSuspended(): bool
    {
        return $this->status === 'suspended';
    }

    /**
     * Check apakah subscription masih aktif
     */
    public function hasActiveSubscription(): bool
    {
        if ($this->isFree()) {
            return false;
        }

        // Logic tambahan jika kamu pakai expired date
        if ($this->subscription_expired_at && now()->gt($this->subscription_expired_at)) {
            return false;
        }

        return true;
    }

    /**
     * Get jumlah hari tersisa subscription
     */
    public function subscriptionDaysRemaining(): int
    {
        if (!$this->hasActiveSubscription() || !$this->subscription_expired_at) {
            return 0;
        }

        return now()->diffInDays($this->subscription_expired_at);
    }
}