<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TemplateController extends Controller
{
    /**
     * Data Pusat Template
     * Disimpan di sini agar bisa dipanggil oleh index() dan select()
     */
    private function getTemplates()
    {
        return collect([
            // ================= FREE TEMPLATES (1-5) =================
            [
                'id' => 1,
                'name' => 'Modern Minimal',
                'description' => 'Clean and minimal portfolio template perfect for developers.',
                'image' => 'modern-minimal.jpg',
                'is_premium' => false,
                'layout' => 'Single Column'
            ],
            [
                'id' => 2,
                'name' => 'Classic Professional',
                'description' => 'Traditional CV style template suitable for corporate professionals.',
                'image' => 'classic-pro.jpg',
                'is_premium' => false,
                'layout' => 'Two Column'
            ],
            [
                'id' => 3,
                'name' => 'Simple Resume',
                'description' => 'Straightforward resume template focusing on content clarity.',
                'image' => 'simple-resume.jpg',
                'is_premium' => false,
                'layout' => 'Text Focused'
            ],
            [
                'id' => 4,
                'name' => 'Junior Coder',
                'description' => 'A starter template for junior developers to showcase GitHub projects.',
                'image' => 'junior-coder.jpg',
                'is_premium' => false,
                'layout' => 'Grid System'
            ],
            [
                'id' => 5,
                'name' => 'Content Writer',
                'description' => 'Typography-focused layout for writers and bloggers.',
                'image' => 'content-writer.jpg',
                'is_premium' => false,
                'layout' => 'Blog Style'
            ],

            // ================= PRO TEMPLATES (6-20) =================
            [
                'id' => 6, 'name' => 'Creative Studio', 'description' => 'Bold and colorful.', 'image' => 'creative.jpg', 'is_premium' => true, 'layout' => 'Masonry'
            ],
            [
                'id' => 7, 'name' => 'Tech Developer Elite', 'description' => 'Dark mode optimized.', 'image' => 'tech-elite.jpg', 'is_premium' => true, 'layout' => 'Dark Mode'
            ],
            [
                'id' => 8, 'name' => 'UX/UI Showcase', 'description' => 'Case study layout.', 'image' => 'ux-showcase.jpg', 'is_premium' => true, 'layout' => 'Case Study'
            ],
            [
                'id' => 9, 'name' => 'Photographer Gallery', 'description' => 'Full-screen images.', 'image' => 'photography.jpg', 'is_premium' => true, 'layout' => 'Full Screen'
            ],
            [
                'id' => 10, 'name' => '3D Artist Motion', 'description' => 'Video background.', 'image' => '3d-motion.jpg', 'is_premium' => true, 'layout' => 'Video'
            ],
            [
                'id' => 11, 'name' => 'Agency Corporate', 'description' => 'Business landing page.', 'image' => 'agency.jpg', 'is_premium' => true, 'layout' => 'Landing'
            ],
            [
                'id' => 12, 'name' => 'SaaS Product', 'description' => 'Product marketing.', 'image' => 'saas.jpg', 'is_premium' => true, 'layout' => 'Marketing'
            ],
            [
                'id' => 13, 'name' => 'Architect Vision', 'description' => 'Geometric layout.', 'image' => 'architect.jpg', 'is_premium' => true, 'layout' => 'Geometric'
            ],
            [
                'id' => 14, 'name' => 'Fashion Lookbook', 'description' => 'Editorial style.', 'image' => 'fashion.jpg', 'is_premium' => true, 'layout' => 'Editorial'
            ],
            [
                'id' => 15, 'name' => 'Musician Press Kit', 'description' => 'Audio integrated.', 'image' => 'musician.jpg', 'is_premium' => true, 'layout' => 'Audio'
            ],
            [
                'id' => 16, 'name' => 'Medical Specialist', 'description' => 'Clean trustworthy.', 'image' => 'medical.jpg', 'is_premium' => true, 'layout' => 'Clean'
            ],
            [
                'id' => 17, 'name' => 'Legal Counsel', 'description' => 'Serious corporate.', 'image' => 'legal.jpg', 'is_premium' => true, 'layout' => 'Corporate'
            ],
            [
                'id' => 18, 'name' => 'Culinary Master', 'description' => 'Menu focused.', 'image' => 'culinary.jpg', 'is_premium' => true, 'layout' => 'Menu'
            ],
            [
                'id' => 19, 'name' => 'Academic Research', 'description' => 'Publication heavy.', 'image' => 'academic.jpg', 'is_premium' => true, 'layout' => 'List'
            ],
            [
                'id' => 20, 'name' => 'Influencer Media Kit', 'description' => 'Social stats focused.', 'image' => 'influencer.jpg', 'is_premium' => true, 'layout' => 'Infographic'
            ],
        ]);
    }

    public function index()
    {
        $templates = $this->getTemplates();
        return view('templates.index', compact('templates'));
    }

public function show($id)
    {
        // 1. TENTUKAN VIEW (Sama seperti sebelumnya)
        $viewName = match ((int)$id) {
            1, 4, 12 => 'exports.template1', 
            2, 11, 16, 17, 19 => 'exports.template2', 
            7, 10, 15 => 'exports.template3', 
            6, 9, 14, 18, 20 => 'exports.template4', 
            3, 5, 8, 13 => 'exports.template5',
            default => 'exports.template1',
        };

        // 2. BUAT DUMMY CONTENT (Sama seperti sebelumnya)
        $dummyContent = [
            'profile' => [
                'name' => 'John Doe (Preview)',
                'role' => 'Creative Designer',
                'bio' => 'This is a preview of how your bio will look.',
                'email' => 'hello@example.com',
                'linkedin' => 'https://linkedin.com/in/johndoe',
                'image' => null, 
            ],
            'skills' => ['UI/UX Design', 'Laravel', 'Tailwind CSS', 'React Native'],
            'projects' => [
                [
                    'title' => 'Project Alpha',
                    'description' => 'A stunning mobile application built for e-commerce.',
                    'link' => '#',
                    'image' => null
                ],
                [
                    'title' => 'Brand Identity',
                    'description' => 'Rebranding project for a tech startup.',
                    'link' => '#',
                    'image' => null
                ]
            ]
        ];

        // 3. MOCK OBJEK PORTFOLIO (PERBAIKAN DI SINI)
        $dummyPortfolio = new \App\Models\Portfolio();
        
        // --- TAMBAHKAN BARIS INI ---
        $dummyPortfolio->id = 0; // Berikan ID palsu (0) agar route generation tidak error
        // ---------------------------
        
        $dummyPortfolio->title = "Template Preview #" . $id;
        $dummyPortfolio->template_id = $id;

        // 4. TAMPILKAN VIEW
        return view($viewName, [
            'portfolio' => $dummyPortfolio,
            'content' => $dummyContent,
            'isPdf' => false 
        ]);
    }

    // === INI BAGIAN PENTING YANG DIAMANKAN ===
    public function select(Request $request, $id)
    {
        // 1. Ambil data template berdasarkan ID
        $template = $this->getTemplates()->firstWhere('id', $id);

        if (!$template) {
            return redirect()->back()->with('error', 'Template not found.');
        }

        // 2. SECURITY CHECK: Apakah Template Premium?
        $user = Auth::user();

        // Jika Premium TAPI User bukan Pro -> TENDANG ke halaman Upgrade
        if ($template['is_premium'] && $user->account_type !== 'pro') {
            return redirect()->route('upgrade')->with('error', '🔒 Oops! Template "' . $template['name'] . '" khusus untuk member PRO. Silakan upgrade dulu.');
        }

        // 3. Jika aman, lanjut ke pembuatan portfolio
        return redirect()->route('portfolios.create', ['template_id' => $id])
                         ->with('success', 'Template selected: ' . $template['name']);
    }
}