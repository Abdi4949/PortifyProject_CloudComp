<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('weekly_exports_count')->default(0); // Hitungan export
            $table->timestamp('last_export_week')->nullable();   // Kapan terakhir export
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['weekly_exports_count', 'last_export_week']);
        });
    }
};