<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            
            // Log Classification
            $table->enum('type', [
                'export_attempt',           // User mencoba export
                'export_success',           // Export berhasil
                'export_limit_reached',     // Limit tercapai (untuk Free user)
                'premium_template_attempt', // Free user coba akses template Pro
                'subscription_upgraded',    // User upgrade ke Pro
                'subscription_expired',     // Subscription habis
                'login',                    // User login
                'logout',                   // User logout
                'admin_action',             // Action dari admin
                'system'                    // System log
            ]);
            
            // Log Details
            $table->string('action')->nullable(); // Deskripsi singkat action
            $table->text('description')->nullable(); // Detail lengkap
            
            // Related Entities (Polymorphic bisa, tapi simplified dulu)
            $table->string('loggable_type')->nullable(); // Model name
            $table->unsignedBigInteger('loggable_id')->nullable(); // Model ID
            
            // Metadata (JSON)
            $table->json('metadata')->nullable(); // Data tambahan seperti IP, user agent, etc
            
            // For Analytics
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            
            // Severity Level (untuk monitoring)
            $table->enum('level', ['info', 'warning', 'error', 'critical'])->default('info');
            
            $table->timestamp('created_at')->useCurrent();
            
            // Indexes untuk performance query
            $table->index('user_id');
            $table->index('type');
            $table->index('level');
            $table->index(['user_id', 'type']);
            $table->index('created_at');
            $table->index(['loggable_type', 'loggable_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};