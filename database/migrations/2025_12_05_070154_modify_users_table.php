<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Role
            $table->enum('role', ['user', 'admin'])->default('user')->after('password');
            
            // Membership & Subscription
            $table->enum('subscription_type', ['free', 'pro'])->default('free')->after('role');
            $table->timestamp('subscription_started_at')->nullable()->after('subscription_type');
            $table->timestamp('subscription_expired_at')->nullable()->after('subscription_started_at');
            
            // Export Limiting
            $table->unsignedInteger('export_count')->default(0)->after('subscription_expired_at');
            $table->date('export_week_start')->nullable()->after('export_count');
            $table->timestamp('last_export_at')->nullable()->after('export_week_start');
            
            // User Status
            $table->enum('status', ['active', 'suspended'])->default('active')->after('last_export_at');
            $table->text('suspend_reason')->nullable()->after('status');
            
            // Soft Deletes
            $table->softDeletes()->after('updated_at');
            
            // Indexes
            $table->index('subscription_type');
            $table->index('status');
            $table->index('export_week_start');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role', 'subscription_type', 'subscription_started_at', 
                'subscription_expired_at', 'export_count', 'export_week_start',
                'last_export_at', 'status', 'suspend_reason'
            ]);
            $table->dropSoftDeletes();
        });
    }
};