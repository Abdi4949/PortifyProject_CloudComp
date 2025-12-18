<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolio_exports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_portfolio_id')->constrained()->onDelete('cascade');
            
            // Export Details
            $table->string('file_name');
            $table->string('file_path')->nullable(); // Jika disimpan sementara di server
            $table->string('file_size')->nullable(); // Dalam bytes
            
            // Export Configuration
            $table->enum('format', ['pdf', 'png', 'jpg'])->default('pdf'); // Future expansion
            $table->json('export_settings')->nullable(); // Paper size, orientation, dll
            
            // Status
            $table->enum('status', ['processing', 'completed', 'failed'])->default('completed');
            $table->text('error_message')->nullable();
            
            // Analytics
            $table->string('ip_address', 45)->nullable();
            $table->integer('download_count')->default(1); // Jika user download ulang
            $table->timestamp('last_downloaded_at')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index('user_id');
            $table->index('user_portfolio_id');
            $table->index(['user_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolio_exports');
    }
};