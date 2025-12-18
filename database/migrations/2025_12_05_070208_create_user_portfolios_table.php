<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_portfolios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('template_id')->constrained()->onDelete('cascade');
            
            // Portfolio Basic Info
            $table->string('title')->default('My Portfolio');
            $table->string('slug')->unique();
            
            // Personal Information
            $table->string('full_name');
            $table->string('profession')->nullable();
            $table->text('bio')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('location')->nullable();
            $table->string('website')->nullable();
            
            // Social Media (JSON)
            $table->json('social_links')->nullable(); // {linkedin, github, instagram, dll}
            
            // Skills (JSON Array)
            $table->json('skills')->nullable(); // ["PHP", "Laravel", "Vue.js"]
            
            // Portfolio Content (JSON)
            $table->json('projects')->nullable(); // [{title, desc, image, url}, ...]
            $table->json('experiences')->nullable(); // [{company, position, period, desc}, ...]
            $table->json('educations')->nullable(); // [{school, degree, period}, ...]
            
            // Customization
            $table->json('custom_sections')->nullable(); // Untuk section tambahan
            $table->string('profile_photo')->nullable();
            
            // Export History
            $table->unsignedInteger('export_count')->default(0);
            $table->timestamp('last_exported_at')->nullable();
            
            // Status
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->boolean('is_public')->default(false); // Jika ingin ada fitur share portfolio online
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indexes
            $table->index('user_id');
            $table->index('template_id');
            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_portfolios');
    }
};