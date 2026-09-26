<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::latest()->paginate(10);
        return view('admin.services.index', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'badge_text' => 'nullable|string|max:100',
            'description' => 'required|string',
            'features' => 'nullable|string', // comma or newline separated
            'is_active' => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_active'] = $request->boolean('is_active', true);

        if (!empty($request->features)) {
            $validated['features'] = array_values(array_filter(array_map('trim', explode("\n", str_replace("\r", "", $request->features)))));
        } else {
            $validated['features'] = [];
        }

        Service::create($validated);

        return redirect()->route('admin.services.index')->with('success', 'Layanan B2B / Maklon berhasil ditambahkan!');
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'badge_text' => 'nullable|string|max:100',
            'description' => 'required|string',
            'features' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_active'] = $request->boolean('is_active', true);

        if (!empty($request->features)) {
            $validated['features'] = array_values(array_filter(array_map('trim', explode("\n", str_replace("\r", "", $request->features)))));
        } else {
            $validated['features'] = [];
        }

        $service->update($validated);

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil diperbarui!');
    }

    public function destroy(Service $service)
    {
        $title = $service->title;
        $service->delete();
        return redirect()->route('admin.services.index')->with('success', "Layanan {$title} berhasil dihapus.");
    }
}
