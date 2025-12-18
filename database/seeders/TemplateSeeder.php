<?php

namespace Database\Seeders;

use App\Models\Template;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            // FREE TEMPLATES
            [
                'name' => 'Modern Minimal',
                'slug' => 'modern-minimal',
                'description' => 'Clean and minimal portfolio template perfect for developers and designers',
                'type' => 'free',
                'status' => 'published',
                'order' => 1,
                'design_config' => [
                    'primary_color' => '#3B82F6',
                    'font_family' => 'Inter',
                    'layout' => 'single-column',
                ],
            ],
            [
                'name' => 'Classic Professional',
                'slug' => 'classic-professional',
                'description' => 'Traditional CV style template suitable for any profession',
                'type' => 'free',
                'status' => 'published',
                'order' => 2,
                'design_config' => [
                    'primary_color' => '#1F2937',
                    'font_family' => 'Georgia',
                    'layout' => 'two-column',
                ],
            ],
            [
                'name' => 'Simple Resume',
                'slug' => 'simple-resume',
                'description' => 'Straightforward resume template focusing on content',
                'type' => 'free',
                'status' => 'published',
                'order' => 3,
                'design_config' => [
                    'primary_color' => '#10B981',
                    'font_family' => 'Arial',
                    'layout' => 'single-column',
                ],
            ],

            // PRO TEMPLATES
            [
                'name' => 'Creative Portfolio',
                'slug' => 'creative-portfolio',
                'description' => 'Eye-catching design for creative professionals with image galleries',
                'type' => 'pro',
                'status' => 'published',
                'order' => 4,
                'design_config' => [
                    'primary_color' => '#F59E0B',
                    'font_family' => 'Poppins',
                    'layout' => 'masonry',
                    'features' => ['image_gallery', 'project_showcase'],
                ],
            ],
            [
                'name' => 'Tech Developer',
                'slug' => 'tech-developer',
                'description' => 'Code-focused template with syntax highlighting and GitHub integration',
                'type' => 'pro',
                'status' => 'published',
                'order' => 5,
                'design_config' => [
                    'primary_color' => '#8B5CF6',
                    'font_family' => 'Fira Code',
                    'layout' => 'sidebar',
                    'features' => ['github_stats', 'code_snippets'],
                ],
            ],
            [
                'name' => 'Executive Premium',
                'slug' => 'executive-premium',
                'description' => 'Sophisticated template for C-level executives and senior professionals',
                'type' => 'pro',
                'status' => 'published',
                'order' => 6,
                'design_config' => [
                    'primary_color' => '#DC2626',
                    'font_family' => 'Playfair Display',
                    'layout' => 'asymmetric',
                    'features' => ['timeline', 'testimonials'],
                ],
            ],
            [
                'name' => 'Designer Showcase',
                'slug' => 'designer-showcase',
                'description' => 'Portfolio template with focus on visual projects and case studies',
                'type' => 'pro',
                'status' => 'published',
                'order' => 7,
                'design_config' => [
                    'primary_color' => '#EC4899',
                    'font_family' => 'Montserrat',
                    'layout' => 'grid',
                    'features' => ['case_studies', 'before_after'],
                ],
            ],

            // UNPUBLISHED TEMPLATE (untuk testing admin)
            [
                'name' => 'Coming Soon Template',
                'slug' => 'coming-soon',
                'description' => 'Template that is still in development',
                'type' => 'pro',
                'status' => 'draft',
                'order' => 99,
            ],
        ];

        foreach ($templates as $template) {
            Template::create($template);
        }

        $this->command->info('✅ ' . count($templates) . ' templates created successfully!');
        $this->command->info('   - 3 Free templates (Published)');
        $this->command->info('   - 4 Pro templates (Published)');
        $this->command->info('   - 1 Draft template');
    }
}