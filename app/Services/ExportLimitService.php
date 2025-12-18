<?php

namespace App\Services;

use App\Models\User;
use App\Models\ActivityLog;
use Carbon\Carbon;

class ExportLimitService
{
    const FREE_EXPORT_LIMIT = 3; // Free user: 3x per minggu
    
    /**
     * Cek apakah user boleh export
     * 
     * @param User $user
     * @return array ['allowed' => bool, 'remaining' => int, 'message' => string]
     */
    public function canExport(User $user): array
    {
        // Pro user: unlimited
        if ($user->subscription_type === 'pro') {
            return [
                'allowed' => true,
                'remaining' => 'unlimited',
                'message' => 'You have unlimited exports'
            ];
        }
        
        // Check suspended
        if ($user->status === 'suspended') {
            return [
                'allowed' => false,
                'remaining' => 0,
                'message' => 'Your account is suspended'
            ];
        }
        
        // Reset mingguan jika sudah lewat 7 hari
        $this->resetWeeklyLimitIfNeeded($user);
        
        // Cek limit Free user
        if ($user->export_count >= self::FREE_EXPORT_LIMIT) {
            // Log untuk analytics
            $this->logLimitReached($user);
            
            $nextReset = $this->getNextResetDate($user);
            
            return [
                'allowed' => false,
                'remaining' => 0,
                'message' => "You've reached your weekly export limit (3x). Upgrade to Pro for unlimited exports! Limit resets on {$nextReset->format('d M Y')}"
            ];
        }
        
        $remaining = self::FREE_EXPORT_LIMIT - $user->export_count;
        
        return [
            'allowed' => true,
            'remaining' => $remaining,
            'message' => "You have {$remaining} exports remaining this week"
        ];
    }
    
    /**
     * Reset limit mingguan jika sudah lewat 7 hari
     * Logic: Cek apakah export_week_start sudah lebih dari 7 hari
     */
    private function resetWeeklyLimitIfNeeded(User $user): void
    {
        // Jika belum pernah export atau null
        if (!$user->export_week_start) {
            $user->export_week_start = Carbon::now()->startOfDay();
            $user->export_count = 0;
            $user->save();
            return;
        }
        
        $weekStart = Carbon::parse($user->export_week_start);
        $daysSinceStart = $weekStart->diffInDays(Carbon::now());
        
        // Jika sudah 7 hari atau lebih, reset counter
        if ($daysSinceStart >= 7) {
            $user->export_week_start = Carbon::now()->startOfDay();
            $user->export_count = 0;
            $user->save();
            
            // Log reset
            ActivityLog::create([
                'user_id' => $user->id,
                'type' => 'system',
                'action' => 'weekly_export_limit_reset',
                'description' => 'Weekly export limit has been reset',
                'level' => 'info'
            ]);
        }
    }
    
    /**
     * Increment counter setelah export berhasil
     */
    public function incrementExportCount(User $user): void
    {
        // Pastikan week_start sudah di-set
        if (!$user->export_week_start) {
            $user->export_week_start = Carbon::now()->startOfDay();
        }
        
        $user->increment('export_count');
        $user->last_export_at = Carbon::now();
        $user->save();
        
        // Log export success
        ActivityLog::create([
            'user_id' => $user->id,
            'type' => 'export_success',
            'action' => 'portfolio_exported',
            'description' => "User exported portfolio. Count: {$user->export_count}/" . self::FREE_EXPORT_LIMIT,
            'level' => 'info',
            'ip_address' => request()->ip()
        ]);
    }
    
    /**
     * Log ketika user mencapai limit (untuk analytics upsell)
     */
    private function logLimitReached(User $user): void
    {
        ActivityLog::create([
            'user_id' => $user->id,
            'type' => 'export_limit_reached',
            'action' => 'export_blocked',
            'description' => 'Free user tried to export but reached weekly limit',
            'metadata' => json_encode([
                'current_count' => $user->export_count,
                'limit' => self::FREE_EXPORT_LIMIT,
                'week_start' => $user->export_week_start
            ]),
            'level' => 'warning',
            'ip_address' => request()->ip()
        ]);
    }
    
    /**
     * Get tanggal reset berikutnya
     */
    private function getNextResetDate(User $user): Carbon
    {
        if (!$user->export_week_start) {
            return Carbon::now()->addDays(7);
        }
        
        return Carbon::parse($user->export_week_start)->addDays(7);
    }
    
    /**
     * Log ketika Free user mencoba akses template Pro
     */
    public function logPremiumTemplateAttempt(User $user, $templateId): void
    {
        ActivityLog::create([
            'user_id' => $user->id,
            'type' => 'premium_template_attempt',
            'action' => 'premium_template_blocked',
            'description' => 'Free user tried to access premium template',
            'metadata' => json_encode([
                'template_id' => $templateId,
                'subscription_type' => $user->subscription_type
            ]),
            'level' => 'warning',
            'ip_address' => request()->ip()
        ]);
    }
}