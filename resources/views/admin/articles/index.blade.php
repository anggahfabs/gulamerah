@extends('layouts.admin')

@section('title', 'Artikel & Wawasan Industri - Gumer')
@section('header-title', 'Artikel & Edukasi Industri')
@section('header-subtitle', 'Kelola artikel riset, panduan aplikasi gula aren pada industri F&B, dan transparansi standar mutu pabrik.')

@section('content')
<div class="space-y-6">

    <!-- Top Action & Search Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-[#E8DFD1] shadow-xs">
        <form method="GET" action="{{ route('admin.articles.index') }}" class="flex flex-wrap items-center gap-3 flex-1">
            <div class="relative min-w-[240px] flex-1 max-w-md">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul artikel..."
                       class="w-full pl-10 pr-4 py-2 text-xs rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/40 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
                <svg class="w-4 h-4 text-stone-400 absolute left-3.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>

            <select name="category" onchange="this.form.submit()" class="px-3.5 py-2 text-xs rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/40 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
                <option value="">Semua Kategori</option>
                <option value="Edukasi Industri" {{ request('category') === 'Edukasi Industri' ? 'selected' : '' }}>Edukasi Industri</option>
                <option value="Proses Produksi" {{ request('category') === 'Proses Produksi' ? 'selected' : '' }}>Proses Produksi</option>
                <option value="Aplikasi Kuliner & Horeca" {{ request('category') === 'Aplikasi Kuliner & Horeca' ? 'selected' : '' }}>Aplikasi Kuliner & Horeca</option>
                <option value="Standar Mutu & Lab" {{ request('category') === 'Standar Mutu & Lab' ? 'selected' : '' }}>Standar Mutu & Lab</option>
            </select>

            @if(request()->anyFilled(['search', 'category']))
                <a href="{{ route('admin.articles.index') }}" class="text-xs text-stone-500 hover:text-stone-800 underline">Reset</a>
            @endif
        </form>

        <a href="{{ route('admin.articles.create') }}" 
           class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-[#C87D20] hover:bg-[#a96615] text-white text-xs font-bold rounded-xl transition shadow-xs whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <span>Tulis Artikel Baru</span>
        </a>
    </div>

    <!-- Table Card -->
    <div class="bg-white rounded-2xl border border-[#E8DFD1] shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-[#FAF6EE] text-[#5C3317] uppercase text-[11px] font-bold tracking-wider border-b border-[#E8DFD1]">
                    <tr>
                        <th class="px-6 py-4">Artikel</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Penulis & Tanggal</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E8DFD1]">
                    @forelse($articles as $article)
                        <tr class="hover:bg-stone-50/80 transition">
                            <!-- Article Cover & Title -->
                            <td class="px-6 py-4">
                                <div class="flex items-start gap-4 max-w-md">
                                    <div class="w-16 h-12 rounded-lg bg-stone-100 overflow-hidden flex-shrink-0 border border-[#E8DFD1]">
                                        @if($article->cover_image)
                                            <img src="{{ asset('storage/' . $article->cover_image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-stone-300">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="font-serif font-bold text-sm text-[#2C1810] line-clamp-1 mb-1 hover:text-[#C87D20]">
                                            <a href="{{ route('admin.articles.edit', $article->id) }}">{{ $article->title }}</a>
                                        </h4>
                                        <p class="text-stone-500 line-clamp-1 text-[11px] leading-relaxed">{{ $article->excerpt ?: strip_tags($article->content) }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- Category -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2.5 py-1 text-[11px] font-semibold rounded-lg bg-[#FAF6EE] text-[#5C3317] border border-[#E8DFD1]">
                                    {{ $article->category }}
                                </span>
                            </td>

                            <!-- Author & Date -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium text-stone-800">{{ $article->author_name }}</div>
                                <div class="text-[11px] text-stone-400 mt-0.5">{{ $article->created_at->format('d M Y, H:i') }} WIB</div>
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($article->is_published)
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-[11px] font-bold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Terbit
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-[11px] font-bold rounded-full bg-amber-50 text-amber-700 border border-amber-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                        Draf
                                    </span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.articles.edit', $article->id) }}" 
                                       class="p-2 text-stone-600 hover:text-[#5C3317] hover:bg-[#FAF6EE] rounded-lg transition" title="Edit Artikel">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form id="delete-art-{{ $article->id }}" method="POST" action="{{ route('admin.articles.destroy', $article->id) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete('delete-art-{{ $article->id }}', 'Hapus artikel &quot;{{ addslashes($article->title) }}&quot;?')" 
                                                class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-stone-400">
                                <svg class="w-12 h-12 mx-auto text-stone-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                                <p class="font-medium text-stone-600">Belum ada artikel edukasi.</p>
                                <p class="text-[11px] text-stone-400 mt-1">Mulai tulis artikel pertama untuk mengedukasi calon mitra industri.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($articles->hasPages())
            <div class="p-4 border-t border-[#E8DFD1]">
                {{ $articles->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
