<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Template extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'thumbnail',
        'type',
        'is_premium',
        'status',
        'design_config',
        'usage_count',
        'order',
        'image',
        'is_published',
        'layout',
    ];

    protected $casts = [
        'is_premium' => 'boolean',
        'design_config' => 'array',
        'usage_count' => 'integer',
        'order' => 'integer',
    ];

    // ==================== RELATIONSHIPS ====================
    
    public function portfolios()
    {
        return $this->hasMany(UserPortfolio::class);
    }

    // ==================== SCOPES ====================
    
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeFreeTemplates($query)
    {
        return $query->where('type', 'free');
    }

    public function scopeProTemplates($query)
    {
        return $query->where('type', 'pro');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc')->orderBy('created_at', 'desc');
    }

    // ==================== HELPER METHODS ====================
    
    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    public function isPremium(): bool
    {
        return $this->type === 'pro' || $this->is_premium;
    }

    public function isFree(): bool
    {
        return $this->type === 'free';
    }

    public function incrementUsage()
    {
        $this->increment('usage_count');
    }

    // ==================== EVENTS ====================
    
    protected static function boot()
    {
        parent::boot();

        // Auto generate slug saat create
        static::creating(function ($template) {
            if (empty($template->slug)) {
                $template->slug = Str::slug($template->name);
            }
            
            // Sync is_premium dengan type
            $template->is_premium = ($template->type === 'pro');
        });

        static::updating(function ($template) {
            // Sync is_premium dengan type
            $template->is_premium = ($template->type === 'pro');
        });
    }
}