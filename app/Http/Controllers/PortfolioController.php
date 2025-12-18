<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolios = Portfolio::where('user_id', Auth::id())->latest()->get();
        return view('portfolios.index', compact('portfolios'));
    }

    public function create(Request $request)
    {
        $templateId = $request->query('template_id');

        if (!$templateId) {
            return redirect()->route('templates.index')->with('error', 'Please select a template first.');
        }

        return view('portfolios.create', compact('templateId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'template_id' => 'required|integer',
        ]);

        Portfolio::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'template_id' => $request->template_id,
            'content' => json_encode([]), 
            'status' => 'draft',
        ]);

        return redirect()->route('portfolios.index')->with('success', 'Portfolio created successfully! 🚀');
    }

    public function edit($id)
    {
        $portfolio = Portfolio::where('user_id', Auth::id())->findOrFail($id);
        $content = json_decode($portfolio->content, true) ?? [];

        return view('portfolios.edit', compact('portfolio', 'content'));
    }

    public function update(Request $request, $id)
    {
        // Tambahkan validasi dasar untuk file upload
        $request->validate([
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'projects.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $portfolio = Portfolio::where('user_id', Auth::id())->findOrFail($id);
        $skills = $request->skills ? array_map('trim', explode(',', $request->skills)) : [];

        // 1. LOGIC FOTO PROFIL
        $profileImagePath = null;
        
        if ($request->hasFile('profile_image') && $request->file('profile_image')->isValid()) {
            $file = $request->file('profile_image');
            $fileName = 'profile_' . time() . '.' . $file->extension();
            $file->storeAs('portfolio_images', $fileName, 'public'); 
            $profileImagePath = 'portfolio_images/' . $fileName;
        } elseif ($request->old_profile_image) {
            $profileImagePath = $request->old_profile_image;
        }

        $newContent = [
            'profile' => [
                'name' => $request->name,
                'role' => $request->role,
                'bio' => $request->bio,
                'email' => $request->email,
                'linkedin' => $request->linkedin,
                'github' => $request->github,
                'image' => $profileImagePath,
            ],
            'skills' => $skills,
            'projects' => [],
        ];

        // 2. LOGIC PROJECT IMAGE
        $projectsInput = $request->input('projects', []);
        $projectsFiles = $request->file('projects') ?? [];

        foreach ($projectsInput as $index => $projectData) {
            $imagePath = null;
            $uploadedFile = $projectsFiles[$index]['image'] ?? null;

            if ($uploadedFile && $uploadedFile->isValid()) {
                $fileName = time() . '_' . $index . '.' . $uploadedFile->extension();
                $uploadedFile->storeAs('portfolio_images', $fileName, 'public'); 
                $imagePath = 'portfolio_images/' . $fileName;
            } elseif (isset($projectData['old_image']) && !empty($projectData['old_image'])) {
                $imagePath = $projectData['old_image'];
            }

            $newContent['projects'][] = [
                'title' => $projectData['title'] ?? '',
                'description' => $projectData['description'] ?? '',
                'link' => $projectData['link'] ?? '#',
                'image' => $imagePath,
            ];
        }

        $portfolio->update([
            'title' => $request->portfolio_title,
            'content' => json_encode($newContent),
            'status' => $request->action == 'publish' ? 'published' : 'draft',
        ]);

        return redirect()->back()->with('success', 'Portfolio updated successfully!');
    }

    public function show($id)
    {
        $portfolio = Portfolio::findOrFail($id);
        $content = json_decode($portfolio->content, true) ?? [];

        // --- 1. SIAPKAN GAMBAR (Agar muncul di Preview Web) ---
        // Kita gunakan logika yang sama dengan Export PDF
        if (!empty($content['profile']['image'])) {
            $content['profile']['base64'] = $this->imageToBase64($content['profile']['image']);
        }

        if (!empty($content['projects'])) {
            foreach ($content['projects'] as $key => $project) {
                if (!empty($project['image'])) {
                    $content['projects'][$key]['base64'] = $this->imageToBase64($project['image']);
                }
            }
        }

        // --- 2. PILIH TAMPILAN SESUAI TEMPLATE ID ---
        // (Sama persis dengan logika di exportPdf)
        $viewName = match ((int)$portfolio->template_id) {
            // GROUP 1: MODERN STANDARD
            1, 4, 12 => 'exports.template1', 

            // GROUP 2: FORMAL / SIDEBAR
            2, 11, 16, 17, 19 => 'exports.template2', 

            // GROUP 3: DARK MODE
            7, 10, 15 => 'exports.template3', 

            // GROUP 4: VISUAL / GALLERY
            6, 9, 14, 18, 20 => 'exports.template4', 

            // GROUP 5: MINIMALIST
            3, 5, 8, 13 => 'exports.template5',

            // Default fallback
            default => 'exports.template1',
        };

        // --- 3. TAMPILKAN KE BROWSER ---
        // Kita set 'isPdf' => false, barangkali nanti butuh beda styling
        return view($viewName, compact('portfolio', 'content') + ['isPdf' => false]);
    }

    public function destroy($id)
    {
        $portfolio = Portfolio::where('user_id', Auth::id())->findOrFail($id);
        $portfolio->delete();
        return redirect()->route('portfolios.index')->with('success', 'Portfolio deleted successfully! 🗑️');
    }

    // --- FITUR EXPORT PDF (FINAL VERSION) ---
    public function exportPdf($id)
    {
        $user = Auth::user();
        $portfolio = Portfolio::findOrFail($id);

        // --- 1. LOGIC LIMIT USER FREE ---
        if ($user->account_type !== 'pro') {
            $startOfWeek = Carbon::now()->startOfWeek();
            
            // Reset counter jika minggu baru
            if (!$user->last_export_week || Carbon::parse($user->last_export_week)->lt($startOfWeek)) {
                $user->weekly_exports_count = 0;
                $user->last_export_week = Carbon::now();
                $user->save();
            }

            // Cek limit (Maksimal 3x seminggu)
            if ($user->weekly_exports_count >= 3) {
                return redirect()->back()->with('error', '⚠️ Kuota export mingguan habis! Upgrade ke Pro untuk unlimited export.');
            }

            // Tambah counter
            $user->increment('weekly_exports_count');
            $user->update(['last_export_week' => Carbon::now()]);
        }

        // --- 2. PERSIAPAN KONTEN ---
        $content = json_decode($portfolio->content, true) ?? [];

        // Convert Profile Image ke Base64
        if (!empty($content['profile']['image'])) {
            $content['profile']['base64'] = $this->imageToBase64($content['profile']['image']);
        }

        // Convert Project Images ke Base64
        if (!empty($content['projects'])) {
            foreach ($content['projects'] as $key => $project) {
                if (!empty($project['image'])) {
                    $content['projects'][$key]['base64'] = $this->imageToBase64($project['image']);
                }
            }
        }

        // --- 3. MAPPING TEMPLATE ID KE FILE VIEW ---
        $viewName = match ((int)$portfolio->template_id) {
            // GROUP 1: MODERN STANDARD (Header Biru/Warna)
            1, 4, 12 => 'exports.template1', 

            // GROUP 2: FORMAL / SIDEBAR (CV Style)
            2, 11, 16, 17, 19 => 'exports.template2', 

            // GROUP 3: DARK MODE (Tech/Music/Video)
            7, 10, 15 => 'exports.template3', // Pastikan file 'premium_dark.blade.php' di-rename jadi 'template3.blade.php' biar rapi

            // GROUP 4: VISUAL / GALLERY FOCUSED (Gambar Besar)
            6, 9, 14, 18, 20 => 'exports.template4', 

            // GROUP 5: MINIMALIST / TEXT FOCUSED (Bersih)
            3, 5, 8, 13 => 'exports.template5',

            // Default fallback
            default => 'exports.template1',
        };  
        
        $pdf = Pdf::loadView($viewName, compact('portfolio', 'content') + ['isPdf' => true]);
        return $pdf->download('Portfolio-' . str_replace(' ', '-', $portfolio->title) . '.pdf');
    }

    // Helper Image
    private function imageToBase64($path)
    {
        try {
            $cleanPath = str_replace(['public/', 'storage/'], '', $path);
            $fullPath = storage_path('app/public/' . $cleanPath);

            if (!file_exists($fullPath)) {
                return null;
            }

            $type = pathinfo($fullPath, PATHINFO_EXTENSION);
            $data = file_get_contents($fullPath);
            return 'data:image/' . $type . ';base64,' . base64_encode($data);
        } catch (\Exception $e) {
            return null;
        }
    }
}