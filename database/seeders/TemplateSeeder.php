<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Template;
use Illuminate\Support\Str;

class TemplateSeeder extends Seeder
{
    public function run()
    {
        $templates = [
            // ================= FREE TEMPLATES (1-5) =================
            [
                'id' => 1,
                'name' => 'Modern Minimal',
                'description' => 'Clean and minimal portfolio template perfect for developers.',
                'image' => 'modern-minimal.jpg',
                'is_premium' => false,
                'layout' => 'Single Column',
                'is_published' => true
            ],
            [
                'id' => 2,
                'name' => 'Classic Professional',
                'description' => 'Traditional CV style template suitable for corporate professionals.',
                'image' => 'classic-pro.jpg',
                'is_premium' => false,
                'layout' => 'Two Column',
                'is_published' => true
            ],
            [
                'id' => 3,
                'name' => 'Simple Resume',
                'description' => 'Straightforward resume template focusing on content clarity.',
                'image' => 'simple-resume.jpg',
                'is_premium' => false,
                'layout' => 'Text Focused',
                'is_published' => true
            ],
            [
                'id' => 4,
                'name' => 'Junior Coder',
                'description' => 'A starter template for junior developers to showcase GitHub projects.',
                'image' => 'junior-coder.jpg',
                'is_premium' => false,
                'layout' => 'Grid System',
                'is_published' => true
            ],
            [
                'id' => 5,
                'name' => 'Content Writer',
                'description' => 'Typography-focused layout for writers and bloggers.',
                'image' => 'content-writer.jpg',
                'is_premium' => false,
                'layout' => 'Blog Style',
                'is_published' => true
            ],

            // ================= PRO TEMPLATES (6-20) =================
            [
                'id' => 6, 
                'name' => 'Creative Studio', 
                'description' => 'Bold and colorful layout for creative agencies.', 
                'image' => 'creative.jpg', 
                'is_premium' => true, 
                'layout' => 'Masonry',
                'is_published' => true
            ],
            [
                'id' => 7, 
                'name' => 'Tech Developer Elite', 
                'description' => 'Dark mode optimized for senior engineers.', 
                'image' => 'tech-elite.jpg', 
                'is_premium' => true, 
                'layout' => 'Dark Mode',
                'is_published' => true
            ],
            [
                'id' => 8, 
                'name' => 'UX/UI Showcase', 
                'description' => 'Perfect for detailed case studies and prototypes.', 
                'image' => 'ux-showcase.jpg', 
                'is_premium' => true, 
                'layout' => 'Case Study',
                'is_published' => true
            ],
            [
                'id' => 9, 
                'name' => 'Photographer Gallery', 
                'description' => 'Full-screen images to showcase photography.', 
                'image' => 'photography.jpg', 
                'is_premium' => true, 
                'layout' => 'Full Screen',
                'is_published' => true
            ],
            [
                'id' => 10, 
                'name' => '3D Artist Motion', 
                'description' => 'Supports video backgrounds and motion graphics.', 
                'image' => '3d-motion.jpg', 
                'is_premium' => true, 
                'layout' => 'Video',
                'is_published' => true
            ],
            [
                'id' => 11, 
                'name' => 'Agency Corporate', 
                'description' => 'Professional landing page for businesses.', 
                'image' => 'agency.jpg', 
                'is_premium' => true, 
                'layout' => 'Landing',
                'is_published' => true
            ],
            [
                'id' => 12, 
                'name' => 'SaaS Product', 
                'description' => 'Optimized for product marketing and conversions.', 
                'image' => 'saas.jpg', 
                'is_premium' => true, 
                'layout' => 'Marketing',
                'is_published' => true
            ],
            [
                'id' => 13, 
                'name' => 'Architect Vision', 
                'description' => 'Clean lines and geometric layout for architects.', 
                'image' => 'architect.jpg', 
                'is_premium' => true, 
                'layout' => 'Geometric',
                'is_published' => true
            ],
            [
                'id' => 14, 
                'name' => 'Fashion Lookbook', 
                'description' => 'Editorial style layout for fashion designers.', 
                'image' => 'fashion.jpg', 
                'is_premium' => true, 
                'layout' => 'Editorial',
                'is_published' => true
            ],
            [
                'id' => 15, 
                'name' => 'Musician Press Kit', 
                'description' => 'Integrated audio player and tour dates.', 
                'image' => 'musician.jpg', 
                'is_premium' => true, 
                'layout' => 'Audio',
                'is_published' => true
            ],
            [
                'id' => 16, 
                'name' => 'Medical Specialist', 
                'description' => 'Clean, trustworthy layout for medical professionals.', 
                'image' => 'medical.jpg', 
                'is_premium' => true, 
                'layout' => 'Clean',
                'is_published' => true
            ],
            [
                'id' => 17, 
                'name' => 'Legal Counsel', 
                'description' => 'Serious and corporate layout for lawyers.', 
                'image' => 'legal.jpg', 
                'is_premium' => true, 
                'layout' => 'Corporate',
                'is_published' => true
            ],
            [
                'id' => 18, 
                'name' => 'Culinary Master', 
                'description' => 'Menu-focused design for chefs and restaurants.', 
                'image' => 'culinary.jpg', 
                'is_premium' => true, 
                'layout' => 'Menu',
                'is_published' => true
            ],
            [
                'id' => 19, 
                'name' => 'Academic Research', 
                'description' => 'Publication-heavy layout for researchers.', 
                'image' => 'academic.jpg', 
                'is_premium' => true, 
                'layout' => 'List',
                'is_published' => true
            ],
            [
                'id' => 20, 
                'name' => 'Influencer Media Kit', 
                'description' => 'Highlight your social stats and reach.', 
                'image' => 'influencer.jpg', 
                'is_premium' => true, 
                'layout' => 'Infographic',
                'is_published' => true
            ],
        ];

        foreach ($templates as $template) {
            Template::updateOrCreate(
                ['id' => $template['id']], 
                array_merge($template, ['slug' => Str::slug($template['name'])]) // Generate slug otomatis
            );
        }
    }
}