<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class UserPortfolio extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'template_id',
        'title',
        'slug',
        'full_name',
        'profession',
        'bio',
        'email',
        'phone',
        'location',
        'website',
        'social_links',
        'skills',
        'projects',
        'experiences',
        'educations',
        'custom_sections',
        'profile_photo',
        'export_count',
        'last_exported_at',
        'status',
        'is_public',
    ];

    protected $casts = [
        'social_links' => 'array',
        'skills' => 'array',
        'projects' => 'array',
        'experiences' => 'array',
        'educations' => 'array',
        'custom_sections' => 'array',
        'last_exported_at' => 'datetime',
        'is_public' => 'boolean',
    ];

    // ==================== RELATIONSHIPS ====================
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function template()
    {
        return $this->belongsTo(Template::class);
    }

    public function exports()
    {
        return $this->hasMany(PortfolioExport::class);
    }

    // ==================== SCOPES ====================
    
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    // ==================== HELPER METHODS ====================
    
    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public function incrementExportCount()
    {
        $this->increment('export_count');
        $this->update(['last_exported_at' => now()]);
    }

    public function getPublicUrl(): string
    {
        return route('portfolio.public', $this->slug);
    }

    // ==================== EVENTS ====================
    
    protected static function boot()
    {
        parent::boot();

        // Auto generate slug saat create
        static::creating(function ($portfolio) {
            if (empty($portfolio->slug)) {
                $portfolio->slug = Str::slug($portfolio->title . '-' . Str::random(6));
            }
        });
    }
}