<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_tagline' => 'nullable|string|max:255',
            'whatsapp_sales' => 'required|string|max:50',
            'whatsapp_cs' => 'nullable|string|max:50',
            'email_sales' => 'required|email|max:100',
            'factory_address' => 'required|string',
            'warehouse_address' => 'nullable|string',
            'operating_hours' => 'nullable|string',
            'google_maps_embed' => 'nullable|string',
            'hero_headline' => 'required|string|max:255',
            'hero_subtitle' => 'required|string',
            'hero_badge' => 'nullable|string|max:100',
            'hero_image' => 'nullable|image|max:4096',
        ]);

        foreach ($validated as $key => $val) {
            if ($key !== 'hero_image') {
                Setting::set($key, $val);
            }
        }

        if ($request->hasFile('hero_image')) {
            $oldImage = Setting::get('hero_image');
            if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                Storage::disk('public')->delete($oldImage);
            }
            $path = $request->file('hero_image')->store('settings', 'public');
            Setting::set('hero_image', $path);
        }

        return back()->with('success', 'Pengaturan website & kontak pabrik berhasil diperbarui!');
    }
}
