<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificationController extends Controller
{
    public function index()
    {
        $certifications = Certification::latest()->paginate(10);
        return view('admin.certifications.index', compact('certifications'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'issuer' => 'required|string|max:255',
            'cert_number' => 'required|string|max:255',
            'valid_until' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'badge_image' => 'nullable|image|max:3072',
            'document_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('badge_image')) {
            $validated['badge_image'] = $request->file('badge_image')->store('certifications/badges', 'public');
        }

        if ($request->hasFile('document_file')) {
            $validated['document_file'] = $request->file('document_file')->store('certifications/docs', 'public');
        }

        Certification::create($validated);

        return redirect()->route('admin.certifications.index')->with('success', 'Sertifikasi & Legalitas berhasil ditambahkan!');
    }

    public function update(Request $request, Certification $certification)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'issuer' => 'required|string|max:255',
            'cert_number' => 'required|string|max:255',
            'valid_until' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'badge_image' => 'nullable|image|max:3072',
            'document_file' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('badge_image')) {
            if ($certification->badge_image && Storage::disk('public')->exists($certification->badge_image)) {
                Storage::disk('public')->delete($certification->badge_image);
            }
            $validated['badge_image'] = $request->file('badge_image')->store('certifications/badges', 'public');
        }

        if ($request->hasFile('document_file')) {
            if ($certification->document_file && Storage::disk('public')->exists($certification->document_file)) {
                Storage::disk('public')->delete($certification->document_file);
            }
            $validated['document_file'] = $request->file('document_file')->store('certifications/docs', 'public');
        }

        $certification->update($validated);

        return redirect()->route('admin.certifications.index')->with('success', 'Data sertifikasi berhasil diperbarui!');
    }

    public function destroy(Certification $certification)
    {
        if ($certification->badge_image && Storage::disk('public')->exists($certification->badge_image)) {
            Storage::disk('public')->delete($certification->badge_image);
        }
        if ($certification->document_file && Storage::disk('public')->exists($certification->document_file)) {
            Storage::disk('public')->delete($certification->document_file);
        }

        $name = $certification->name;
        $certification->delete();

        return redirect()->route('admin.certifications.index')->with('success', "Sertifikasi {$name} berhasil dihapus.");
    }
}
