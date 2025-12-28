<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserPortfolio;
use App\Models\User;
use App\Models\Template;

class UserPortfolioSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil user dan template yang ada
        $users = User::where('role', 'user')->get();
        $templates = Template::all();

        // Pastikan ada user dan template sebelum membuat data
        if ($users->count() > 0 && $templates->count() > 0) {
            
            // Buat 15 Portofolio Dummy
            for ($i = 0; $i < 15; $i++) {
                UserPortfolio::create([
                    'user_id' => $users->random()->id,      // Pilih user acak
                    'template_id' => $templates->random()->id, // Pilih template acak
                    'title' => 'My Awesome Portfolio ' . ($i + 1),
                    'slug' => 'portfolio-' . ($i + 1) . '-' . uniqid(),
                    'content' => json_encode(['about' => 'This is a sample content.']),
                    'status' => 'published', // Status published agar terhitung aktif
                    'created_at' => now()->subDays(rand(1, 30)), // Tanggal acak 1-30 hari lalu
                ]);
            }
        }
    }
}
