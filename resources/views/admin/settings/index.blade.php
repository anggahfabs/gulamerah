@extends('layouts.admin')

@section('title', 'Pengaturan Website & Kontak Pabrik - Gumer')
@section('header-title', 'Pengaturan Website & Kontak')
@section('header-subtitle', 'Kelola informasi legalitas pabrik, nomor hotline WhatsApp sales, alamat gudang, dan hero banner.')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Section 1: Profil & Identitas Pabrik -->
        <div class="bg-white p-6 rounded-2xl border border-[#E8DFD1] shadow-xs space-y-5">
            <div class="border-b border-[#E8DFD1] pb-3">
                <h3 class="font-serif font-bold text-base text-[#2C1810]">Profil & Identitas Pabrik</h3>
                <p class="text-xs text-stone-500">Nama brand dan informasi legalitas operasional pabrik.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">Nama Pabrik / Website *</label>
                    <input type="text" name="site_name" value="{{ old('site_name', $settings['site_name'] ?? 'Gumer - Pabrik Gula Merah') }}" required
                           class="w-full px-4 py-2.5 text-sm rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">Tagline / Slogan</label>
                    <input type="text" name="site_tagline" value="{{ old('site_tagline', $settings['site_tagline'] ?? 'Produsen & Suplai Industri Gula Aren Organik') }}"
                           class="w-full px-4 py-2.5 text-sm rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">Jam Operasional Pabrik & Kantor</label>
                <input type="text" name="operating_hours" value="{{ old('operating_hours', $settings['operating_hours'] ?? 'Senin - Sabtu: 08.00 - 17.00 WIB') }}"
                       class="w-full px-4 py-2.5 text-sm rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">Alamat Pabrik Utama *</label>
                    <textarea name="factory_address" rows="3" required
                              class="w-full px-4 py-2.5 text-xs rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">{{ old('factory_address', $settings['factory_address'] ?? 'Kawasan Agroindustri Aren, Lebak, Banten, Indonesia') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">Alamat Gudang & Distribusi</label>
                    <textarea name="warehouse_address" rows="3"
                              class="w-full px-4 py-2.5 text-xs rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">{{ old('warehouse_address', $settings['warehouse_address'] ?? 'Pusat Distribusi Pergudangan Logistik Cikupa, Tangerang') }}</textarea>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">Google Maps Embed URL / Iframe</label>
                <textarea name="google_maps_embed" rows="2" placeholder="Masukkan URL embed peta Google Maps..."
                          class="w-full px-4 py-2.5 text-xs font-mono rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">{{ old('google_maps_embed', $settings['google_maps_embed'] ?? '') }}</textarea>
            </div>
        </div>

        <!-- Section 2: Saluran Kontak & WhatsApp -->
        <div class="bg-white p-6 rounded-2xl border border-[#E8DFD1] shadow-xs space-y-5">
            <div class="border-b border-[#E8DFD1] pb-3">
                <h3 class="font-serif font-bold text-base text-[#2C1810]">Saluran Kontak & Hotline WhatsApp</h3>
                <p class="text-xs text-stone-500">Nomor ini akan digunakan otomatis pada tombol chat penawaran dan bantuan cepat.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">WhatsApp Sales B2B *</label>
                    <input type="text" name="whatsapp_sales" value="{{ old('whatsapp_sales', $settings['whatsapp_sales'] ?? '6281234567890') }}" required placeholder="e.g. 6281234567890"
                           class="w-full px-4 py-2.5 text-sm font-mono rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
                    <p class="text-[10px] text-stone-400 mt-1">Gunakan format angka dengan awalan 62</p>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">WhatsApp Layanan CS / Retail</label>
                    <input type="text" name="whatsapp_cs" value="{{ old('whatsapp_cs', $settings['whatsapp_cs'] ?? '6281298765432') }}" placeholder="e.g. 6281298765432"
                           class="w-full px-4 py-2.5 text-sm font-mono rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">Email Penawaran Resmi *</label>
                    <input type="email" name="email_sales" value="{{ old('email_sales', $settings['email_sales'] ?? 'sales@gumer.id') }}" required placeholder="e.g. sales@gumer.id"
                           class="w-full px-4 py-2.5 text-sm rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
                </div>
            </div>
        </div>

        <!-- Section 3: Banner & Hero Homepage -->
        <div class="bg-white p-6 rounded-2xl border border-[#E8DFD1] shadow-xs space-y-5">
            <div class="border-b border-[#E8DFD1] pb-3">
                <h3 class="font-serif font-bold text-base text-[#2C1810]">Banner Hero Beranda Utama</h3>
                <p class="text-xs text-stone-500">Tampilan headline pertama saat calon mitra dan pengunjung membuka website.</p>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">Badge Label Hero</label>
                <input type="text" name="hero_badge" value="{{ old('hero_badge', $settings['hero_badge'] ?? 'Pabrik Gula Merah & Kristal Aren Standar Ekspor') }}"
                       class="w-full px-4 py-2.5 text-sm rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">Headline Utama *</label>
                <input type="text" name="hero_headline" value="{{ old('hero_headline', $settings['hero_headline'] ?? 'Kemurnian Gula Aren Alami untuk Standar Industri F&B Modern') }}" required
                       class="w-full px-4 py-2.5 text-sm font-semibold rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">Subtitle / Deskripsi Hero *</label>
                <textarea name="hero_subtitle" rows="3" required
                          class="w-full px-4 py-2.5 text-sm rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">{{ old('hero_subtitle', $settings['hero_subtitle'] ?? 'Kapasitas pasokan 10+ ton per bulan dengan kadar air terukur (MC ≤ 1.2%), sertifikasi Halal, P-IRT, dan uji lab Sucofindo untuk konsistensi rasa produk Anda.') }}</textarea>
            </div>

            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">Upload Foto Hero Baru (Max 4MB)</label>
                @if(!empty($settings['hero_image']))
                    <div class="mb-3 w-48 aspect-video rounded-xl overflow-hidden border border-[#E8DFD1]">
                        <img src="{{ asset('storage/' . $settings['hero_image']) }}" alt="Hero" class="w-full h-full object-cover">
                    </div>
                @endif
                <input type="file" name="hero_image" accept="image/*"
                       class="w-full text-xs text-stone-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#FAF6EE] file:text-[#5C3317] hover:file:bg-stone-200">
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex items-center justify-end">
            <button type="submit" 
                    class="px-8 py-3 bg-[#5C3317] hover:bg-[#2C1810] text-white text-xs font-bold rounded-xl transition shadow-xs flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span>Simpan Semua Pengaturan</span>
            </button>
        </div>
    </form>

</div>
@endsection
