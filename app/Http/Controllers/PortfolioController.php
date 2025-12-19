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

    // --- UPDATE METHOD (DIPERBAIKI) ---
    public function update(Request $request, $id)
    {
        // 1. Validasi Input yang mendukung Nested Array
        $request->validate([
            'title' => 'required|string|max:255',
            'profile.name' => 'nullable|string', // Nullable biar gak error kalau user belum isi
            'profile.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'projects.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $portfolio = Portfolio::where('user_id', Auth::id())->findOrFail($id);
        
        // Ambil konten lama (decode JSON jadi Array) untuk mempertahankan data yang tidak diubah
        $content = json_decode($portfolio->content, true) ?? [];

        // --- 2. UPDATE PROFILE ---
        // Kita pakai $request->input('key') karena datanya nested array
        $content['profile']['name']     = $request->input('profile.name');
        $content['profile']['role']     = $request->input('profile.role');
        $content['profile']['bio']      = $request->input('profile.bio');
        $content['profile']['email']    = $request->input('profile.email');
        $content['profile']['linkedin'] = $request->input('profile.linkedin');

        // --- 3. UPDATE SKILLS (FIX ERROR ARRAY) ---
        // View mengirim skills sebagai array (skills[]), jadi tidak perlu explode
        if ($request->has('skills') && is_array($request->skills)) {
            // Filter array agar tidak menyimpan string kosong
            $content['skills'] = array_filter($request->skills, fn($value) => !is_null($value) && $value !== '');
        } else {
            $content['skills'] = [];
        }

        // --- 4. UPLOAD FOTO PROFIL ---
        if ($request->hasFile('profile.image')) {
            // Hapus file lama jika perlu (opsional)
            // if (!empty($content['profile']['image'])) Storage::disk('public')->delete($content['profile']['image']);

            // Simpan file baru
            $path = $request->file('profile.image')->store('portfolios/profiles', 'public');
            $content['profile']['image'] = $path;
        }

        // --- 5. UPLOAD PROJECTS & GAMBARNYA ---
        if ($request->has('projects') && is_array($request->projects)) {
            
            foreach ($request->projects as $index => $projectData) {
                // Update Text Data Project
                $content['projects'][$index]['title']       = $projectData['title'] ?? '';
                $content['projects'][$index]['description'] = $projectData['description'] ?? '';
                $content['projects'][$index]['link']        = $projectData['link'] ?? '';

                // Handle Upload Gambar Project (Nested File)
                // Akses file menggunakan notasi dot: projects.0.image
                if ($request->hasFile("projects.{$index}.image")) {
                    $path = $request->file("projects.{$index}.image")->store('portfolios/projects', 'public');
                    $content['projects'][$index]['image'] = $path;
                } 
                // Jika user tidak upload gambar baru, biarkan gambar lama tetap ada di $content
            }
        }

        // Simpan ke Database
        $portfolio->title = $request->title;
        $portfolio->content = json_encode($content); 
        // Status published/draft (Opsional, jika ada inputnya)
        if ($request->has('status')) {
            $portfolio->status = $request->status;
        }
        
        $portfolio->save();

        return redirect()->back()->with('success', 'Portfolio updated successfully!');
    }

    public function show($id)
    {
        $portfolio = Portfolio::findOrFail($id);
        $content = json_decode($portfolio->content, true) ?? [];

        // --- 1. SIAPKAN GAMBAR (Agar muncul di Preview Web) ---
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
        $viewName = match ((int)$portfolio->template_id) {
            1, 4, 12 => 'exports.template1', 
            2, 11, 16, 17, 19 => 'exports.template2', 
            7, 10, 15 => 'exports.template3', 
            6, 9, 14, 18, 20 => 'exports.template4', 
            3, 5, 8, 13 => 'exports.template5',
            default => 'exports.template1',
        };

        return view($viewName, compact('portfolio', 'content') + ['isPdf' => false]);
    }

    public function destroy($id)
    {
        $portfolio = Portfolio::where('user_id', Auth::id())->findOrFail($id);
        $portfolio->delete();
        return redirect()->route('portfolios.index')->with('success', 'Portfolio deleted successfully! 🗑️');
    }

    // --- FITUR EXPORT PDF ---
    public function exportPdf($id)
    {
        $user = Auth::user();
        $portfolio = Portfolio::findOrFail($id);

        // --- 1. LOGIC LIMIT USER FREE ---
        if ($user->account_type !== 'pro') {
            $startOfWeek = Carbon::now()->startOfWeek();
            
            if (!$user->last_export_week || Carbon::parse($user->last_export_week)->lt($startOfWeek)) {
                $user->weekly_exports_count = 0;
                $user->last_export_week = Carbon::now();
                $user->save();
            }

            if ($user->weekly_exports_count >= 3) {
                return redirect()->back()->with('error', '⚠️ Kuota export mingguan habis! Upgrade ke Pro untuk unlimited export.');
            }

            $user->increment('weekly_exports_count');
            $user->update(['last_export_week' => Carbon::now()]);
        }

        // --- 2. PERSIAPAN KONTEN ---
        $content = json_decode($portfolio->content, true) ?? [];

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

        // --- 3. MAPPING TEMPLATE ---
        $viewName = match ((int)$portfolio->template_id) {
            1, 4, 12 => 'exports.template1', 
            2, 11, 16, 17, 19 => 'exports.template2', 
            7, 10, 15 => 'exports.template3', 
            6, 9, 14, 18, 20 => 'exports.template4', 
            3, 5, 8, 13 => 'exports.template5',
            default => 'exports.template1',
        };  
        
        $pdf = Pdf::loadView($viewName, compact('portfolio', 'content') + ['isPdf' => true]);
        return $pdf->download('Portfolio-' . str_replace(' ', '-', $portfolio->title) . '.pdf');
    }

    // Helper Image
    private function imageToBase64($path)
    {
        try {
            // Hapus prefix public/ atau storage/ jika ada, karena storage_path butuh path murni
            $cleanPath = str_replace(['public/', 'storage/'], '', $path);
            
            // Coba path storage (untuk file upload user)
            $fullPath = storage_path('app/public/' . $cleanPath);

            // Jika tidak ketemu, coba path public biasa (untuk assets default)
            if (!file_exists($fullPath)) {
                 $fullPath = public_path($path);
            }

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