<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan 'role' jika belum ada
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('user')->after('email');
            }

            // Tambahkan 'account_type' (Ini yang bikin error tadi)
            if (!Schema::hasColumn('users', 'account_type')) {
                $table->string('account_type')->default('free')->after('role');
            }

            // Tambahkan 'status' jika belum ada
            if (!Schema::hasColumn('users', 'status')) {
                $table->string('status')->default('active')->after('account_type');
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'account_type', 'status']);
        });
    }
};
