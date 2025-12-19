<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; // Tambahkan ini untuk generate Slug

class TemplateController extends Controller
{
    /**
     * Menampilkan daftar template.
     */
    public function index()
    {
        // Kita urutkan berdasarkan ID agar rapi
        $templates = Template::orderBy('id', 'asc')->paginate(10);
        return view('admin.templates.index', compact('templates'));
    }

    /**
     * Menampilkan form create.
     */
    public function create()
    {
        return view('admin.templates.create');
    }

    /**
     * Menyimpan template baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'layout' => 'required|string|max:255', // Menggantikan view_path
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Menggantikan thumbnail
            'type' => 'required|in:free,pro', // Input dari form berupa pilihan Free/Pro
        ]);

        // Upload Gambar
        $path = $request->file('image')->store('templates', 'public');

        Template::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name), // Generate slug otomatis
            'description' => $request->description,
            'layout' => $request->layout,
            'image' => $path,
            'is_premium' => $request->type === 'pro', // Konversi ke Boolean
            'is_published' => true, // Default langsung publish saat create
        ]);

        return redirect()->route('admin.templates.index')
            ->with('success', 'Template created successfully');
    }

    /**
     * Menampilkan form edit.
     */
    public function edit(Template $template)
    {
        return view('admin.templates.edit', compact('template'));
    }

    /**
     * Update data template.
     */
    public function update(Request $request, Template $template)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'layout' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'type' => 'required|in:free,pro',
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'layout' => $request->layout,
            'is_premium' => $request->type === 'pro',
            // Kita tidak update is_published di sini, tapi di method togglePublish
        ];

        // Logic Update Gambar
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($template->image) {
                Storage::disk('public')->delete($template->image);
            }
            $data['image'] = $request->file('image')->store('templates', 'public');
        }

        $template->update($data);

        return redirect()->route('admin.templates.index')
            ->with('success', 'Template updated successfully');
    }

    /**
     * Hapus template.
     */
    public function destroy(Template $template)
    {
        if ($template->image) {
            Storage::disk('public')->delete($template->image);
        }
        $template->delete();

        return redirect()->route('admin.templates.index')
            ->with('success', 'Template deleted successfully');
    }

    /**
     * FITUR BARU: Toggle Publish / Unpublish
     * Diakses via route PATCH /admin/templates/{id}/toggle
     */
    public function togglePublish($id)
    {
        $template = Template::findOrFail($id);
        
        // Ubah status kebalikannya (True jadi False, False jadi True)
        $template->is_published = !$template->is_published;
        $template->save();

        $status = $template->is_published ? 'Published' : 'Unpublished';
        
        return redirect()->back()->with('success', "Template '{$template->name}' is now {$status}.");
    }
}