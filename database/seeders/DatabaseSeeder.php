<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            TemplateSeeder::class,
        ]);

        $this->command->info('');
        $this->command->info('========================================');
        $this->command->info('Database seeding completed!');
        $this->command->info('========================================');
        $this->command->info('');
        $this->command->info('Login Credentials:');
        $this->command->info('');
        $this->command->info('Admin:');
        $this->command->info('   Email: admin@portify.com');
        $this->command->info('   Password: password');
        $this->command->info('');
        $this->command->info('Pro User:');
        $this->command->info('   Email: pro@example.com');
        $this->command->info('   Password: password');
        $this->command->info('');
        $this->command->info('Free User:');
        $this->command->info('   Email: free@example.com');
        $this->command->info('   Password: password');
        $this->command->info('');
        $this->command->info('========================================');
    }
}