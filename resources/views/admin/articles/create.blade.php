@extends('layouts.admin')

@section('title', 'Tulis Artikel Edukasi Baru - Gumer')
@section('header-title', 'Tulis Artikel Baru')
@section('header-subtitle', 'Bagikan pengetahuan standar mutu, proses pengolahan gula aren, dan aplikasi industri.')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Back Button & Breadcrumb -->
    <div>
        <a href="{{ route('admin.articles.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-stone-500 hover:text-[#5C3317] transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span>Kembali ke Daftar Artikel</span>
        </a>
    </div>

    <form method="POST" action="{{ route('admin.articles.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Main Column (2 cols) -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Title & Category Card -->
                <div class="bg-white p-6 rounded-2xl border border-[#E8DFD1] shadow-xs space-y-5">
                    <h3 class="font-serif font-bold text-base text-[#2C1810] border-b border-[#E8DFD1] pb-3">Konten Utama Artikel</h3>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">Judul Artikel *</label>
                        <input type="text" name="title" value="{{ old('title') }}" required placeholder="Contoh: Mengapa Kadar Air Gula Semut Aren Wajib di Bawah 1.5%?"
                               class="w-full px-4 py-3 text-sm font-semibold rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">Kategori *</label>
                            <input type="text" name="category" list="category-options" value="{{ old('category', 'Edukasi Industri') }}" required
                                   class="w-full px-4 py-2.5 text-sm rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
                            <datalist id="category-options">
                                <option value="Edukasi Industri">
                                <option value="Proses Produksi">
                                <option value="Aplikasi Kuliner & Horeca">
                                <option value="Standar Mutu & Lab">
                            </datalist>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">Nama Penulis *</label>
                            <input type="text" name="author_name" value="{{ old('author_name', auth()->user()->name ?? 'Tim Litbang Gumer') }}" required
                                   class="w-full px-4 py-2.5 text-sm rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">Ringkasan / Excerpt Singkat</label>
                        <textarea name="excerpt" rows="2" placeholder="Deskripsi ringkas 1-2 kalimat untuk pratinjau kartu artikel & SEO..."
                                  class="w-full px-4 py-2.5 text-xs rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">{{ old('excerpt') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">Isi Konten Artikel *</label>
                        <textarea name="content" rows="14" required placeholder="Tuliskan isi artikel edukasi secara detail..."
                                  class="w-full px-4 py-3 text-sm leading-relaxed rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20] font-sans">{{ old('content') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar Column (1 col) -->
            <div class="space-y-6">
                <!-- Publication Status Card -->
                <div class="bg-white p-6 rounded-2xl border border-[#E8DFD1] shadow-xs space-y-4">
                    <h3 class="font-serif font-bold text-base text-[#2C1810] border-b border-[#E8DFD1] pb-3">Status Publikasi</h3>

                    <label class="flex items-center gap-3 p-3 rounded-xl border border-[#E8DFD1] hover:bg-[#FAF6EE]/50 cursor-pointer transition">
                        <input type="checkbox" name="is_published" value="1" {{ old('is_published', true) ? 'checked' : '' }}
                               class="rounded border-[#E8DFD1] text-[#C87D20] focus:ring-[#C87D20] w-4 h-4">
                        <div>
                            <span class="block text-xs font-bold text-[#2C1810]">Publikasikan Langsung</span>
                            <span class="block text-[11px] text-stone-500">Artikel dapat langsung dibaca oleh publik</span>
                        </div>
                    </label>

                    <div class="pt-2">
                        <button type="submit" 
                                class="w-full py-3 bg-[#5C3317] hover:bg-[#2C1810] text-white text-xs font-bold rounded-xl transition shadow-xs flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Simpan & Terbitkan</span>
                        </button>
                    </div>
                </div>

                <!-- Cover Image Card -->
                <div class="bg-white p-6 rounded-2xl border border-[#E8DFD1] shadow-xs space-y-4">
                    <h3 class="font-serif font-bold text-base text-[#2C1810] border-b border-[#E8DFD1] pb-3">Foto Sampul / Cover</h3>

                    <p class="text-[11px] text-stone-500 leading-relaxed">Rasio landscape 16:9 disarankan (JPG, PNG, WebP Max 3MB).</p>

                    <div>
                        <input type="file" name="cover_image" accept="image/*"
                               class="w-full text-xs text-stone-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#FAF6EE] file:text-[#5C3317] hover:file:bg-stone-200">
                    </div>
                </div>
            </div>
        </div>
    </form>

</div>
@endsection
