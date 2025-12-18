<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'template_id',
        'content',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // --- TAMBAHKAN INI ---
    public function template()
    {
        // Hubungkan ke Model Template (Asumsi kamu punya Model Template)
        // Kalau belum punya Model Template, nanti kita pakai 'App\Models\Template'
        // Untuk sementara, fungsi ini akan mencegah error crash, meski datanya null
        return $this->belongsTo(Template::class);
    }
}