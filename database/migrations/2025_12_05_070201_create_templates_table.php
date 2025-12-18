<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('templates', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama template
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('thumbnail')->nullable(); // Path gambar preview
            
            // Template Type
            $table->enum('type', ['free', 'pro'])->default('free');
            $table->boolean('is_premium')->default(false); // Alias dari type
            
            // Status & Visibility
            $table->enum('status', ['draft', 'published', 'unpublished'])->default('draft');
            
            // Template Design Configuration (JSON)
            $table->json('design_config')->nullable(); // Menyimpan konfigurasi warna, font, layout
            
            // Statistics
            $table->unsignedInteger('usage_count')->default(0); // Berapa kali digunakan
            
            // Ordering
            $table->unsignedInteger('order')->default(0);
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('type');
            $table->index('status');
            $table->index(['status', 'type']); // Composite index untuk query efisien
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('templates');
    }
};