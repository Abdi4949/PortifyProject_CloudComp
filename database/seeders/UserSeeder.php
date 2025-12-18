<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin User
        User::create([
            'name' => 'Admin Portify',
            'email' => 'admin@portify.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'account_type' => 'pro',
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // 2. Pro User (Berbayar)
        User::create([
            'name' => 'John Doe Pro',
            'email' => 'pro@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'account_type' => 'pro',
            'subscription_started_at' => now(),
            'subscription_expired_at' => now()->addMonths(1),
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // 3. Free User (Aktif, belum export)
        User::create([
            'name' => 'Jane Smith Free',
            'email' => 'free@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'subscription_type' => 'free',
            'export_count' => 0,
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // 4. Free User (Sudah export 2x)
        User::create([
            'name' => 'Bob Wilson',
            'email' => 'bob@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'subscription_type' => 'free',
            'export_count' => 2,
            'export_week_start' => now()->startOfDay(),
            'last_export_at' => now()->subDays(2),
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // 5. Free User (Limit tercapai, sudah 3x export)
        User::create([
            'name' => 'Alice Cooper',
            'email' => 'alice@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'subscription_type' => 'free',
            'export_count' => 3,
            'export_week_start' => now()->startOfDay(),
            'last_export_at' => now()->subDays(1),
            'status' => 'active',
            'email_verified_at' => now(),
        ]);

        // 6. Suspended User
        User::create([
            'name' => 'Suspended User',
            'email' => 'suspended@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'subscription_type' => 'free',
            'status' => 'suspended',
            'suspend_reason' => 'Violation of terms of service',
            'email_verified_at' => now(),
        ]);

        $this->command->info('✅ 6 users created successfully!');
    }
}