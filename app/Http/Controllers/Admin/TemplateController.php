<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TemplateController extends Controller
{
    public function index()
    {
        $templates = Template::latest()->paginate(10);
        return view('admin.templates.index', compact('templates'));
    }

    public function create()
    {
        return view('admin.templates.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'view_path' => 'required|string|max:255', // misal: pdf.templates.modern
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'type' => 'required|in:free,pro',
        ]);

        $path = $request->file('thumbnail')->store('templates', 'public');

        Template::create([
            'name' => $request->name,
            'view_path' => $request->view_path,
            'thumbnail' => $path,
            'is_premium' => $request->type === 'pro',
            'is_active' => true,
        ]);

        return redirect()->route('admin.templates.index')
            ->with('success', 'Template created successfully');
    }

    public function edit(Template $template)
    {
        return view('admin.templates.edit', compact('template'));
    }

    public function update(Request $request, Template $template)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'view_path' => 'required|string|max:255',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'type' => 'required|in:free,pro',
        ]);

        $data = [
            'name' => $request->name,
            'view_path' => $request->view_path,
            'is_premium' => $request->type === 'pro',
            'is_active' => $request->has('is_active'),
        ];

        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($template->thumbnail) {
                Storage::disk('public')->delete($template->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('templates', 'public');
        }

        $template->update($data);

        return redirect()->route('admin.templates.index')
            ->with('success', 'Template updated successfully');
    }

    public function destroy(Template $template)
    {
        if ($template->thumbnail) {
            Storage::disk('public')->delete($template->thumbnail);
        }
        $template->delete();

        return redirect()->route('admin.templates.index')
            ->with('success', 'Template deleted successfully');
    }
}