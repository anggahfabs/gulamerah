@extends('layouts.admin')

@section('title', 'Kelola Produk & Varian')
@section('header-title', 'Katalog Produk Pabrik')
@section('header-subtitle', 'Kelola master data gula aren & kelapa, spesifikasi uji lab, varian kemasan, dan tier harga volume')

@section('content')
<div class="space-y-6">

    <!-- Action Bar & Filters -->
    <div class="bg-white p-5 rounded-2xl border border-[#E8DFD1] shadow-xs flex flex-col md:flex-row items-center justify-between gap-4">
        <!-- Search & Category Filters -->
        <form method="GET" action="{{ route('admin.products.index') }}" class="flex flex-wrap items-center gap-3 w-full md:w-auto">
            <div class="relative w-full sm:w-64">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari nama produk, bentuk..."
                       class="w-full pl-9 pr-4 py-2 text-xs rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20] text-[#2C1810]">
                <svg class="w-4 h-4 text-stone-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>

            <select name="category_id" onchange="this.form.submit()" 
                    class="py-2 px-3 text-xs rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20] text-[#2C1810]">
                <option value="">Semua Kategori</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>

            @if(request()->anyFilled(['search', 'category_id']))
                <a href="{{ route('admin.products.index') }}" class="text-xs text-red-600 hover:underline">Reset</a>
            @endif
        </form>

        <!-- Add Product CTA -->
        <a href="{{ route('admin.products.create') }}" 
           class="px-4 py-2.5 rounded-xl bg-[#5C3317] hover:bg-[#2C1810] text-white text-xs font-semibold flex items-center gap-2 transition shadow-xs w-full md:w-auto justify-center cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <span>Tambah Master Produk</span>
        </a>
    </div>

    <!-- Products Table Card -->
    <div class="bg-white rounded-2xl border border-[#E8DFD1] shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-[#FAF6EE] border-b border-[#E8DFD1] text-[11px] font-bold uppercase tracking-wider text-stone-500">
                        <th class="py-3.5 px-5">Foto & Nama Produk</th>
                        <th class="py-3.5 px-4">Kategori & Bentuk</th>
                        <th class="py-3.5 px-4">Spesifikasi Lab</th>
                        <th class="py-3.5 px-4">Varian Kemasan</th>
                        <th class="py-3.5 px-4">Tier Volume B2B</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E8DFD1]">
                    @forelse($products as $product)
                        <tr class="hover:bg-[#FAF6EE]/40 transition">
                            <!-- Foto & Nama -->
                            <td class="py-4 px-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-xl bg-stone-100 border border-[#E8DFD1] overflow-hidden shrink-0 flex items-center justify-center font-bold text-[#5C3317]">
                                        @if($product->thumbnail)
                                            <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                        @else
                                            <span class="text-xs">GUMER</span>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <div class="font-bold text-[#2C1810] text-sm flex items-center gap-2">
                                            <span>{{ $product->name }}</span>
                                            @if($product->is_featured)
                                                <span class="px-1.5 py-0.5 rounded text-[9px] font-bold bg-amber-100 text-amber-800 border border-amber-200">Unggulan</span>
                                            @endif
                                        </div>
                                        <p class="text-xs text-stone-500 truncate max-w-xs">{{ $product->short_description ?: 'Bahan baku murni dari nira pilihan' }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- Kategori & Bentuk -->
                            <td class="py-4 px-4">
                                <div class="font-semibold text-xs text-[#5C3317]">{{ $product->category->name ?? 'Uncategorized' }}</div>
                                <span class="inline-block mt-0.5 px-2 py-0.5 rounded text-[10px] font-medium bg-stone-100 text-stone-700">
                                    {{ $product->raw_material }} • {{ $product->product_form }}
                                </span>
                            </td>

                            <!-- Spesifikasi Lab -->
                            <td class="py-4 px-4 text-xs font-mono">
                                @if($product->moisture_content)
                                    <div class="text-stone-700">KA: <span class="font-bold text-[#2C1810]">{{ $product->moisture_content }}</span></div>
                                @endif
                                @if($product->mesh_size)
                                    <div class="text-stone-500">{{ $product->mesh_size }}</div>
                                @elseif($product->brix_content)
                                    <div class="text-amber-700 font-semibold">{{ $product->brix_content }}</div>
                                @endif
                            </td>

                            <!-- Varian Kemasan -->
                            <td class="py-4 px-4 text-xs">
                                <span class="font-semibold text-[#2C1810]">{{ $product->variants->count() }} Pilihan Kemasan</span>
                                @if($product->variants->isNotEmpty())
                                    <p class="text-[11px] text-stone-500 truncate max-w-[150px]">
                                        {{ $product->variants->first()->packaging_name }}
                                        @if($product->variants->count() > 1) +{{ $product->variants->count() - 1 }} lainnya @endif
                                    </p>
                                @endif
                            </td>

                            <!-- Tier Volume B2B -->
                            <td class="py-4 px-4 text-xs">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-[#FAF6EE] text-[#5C3317] border border-[#E8DFD1]">
                                    {{ $product->priceTiers->count() }} Level Tier
                                </span>
                                @if($product->priceTiers->isNotEmpty())
                                    <div class="text-[11px] font-mono text-emerald-700 font-semibold mt-1">
                                        Mulai Rp {{ number_format($product->min_b2b_price, 0, ',', '.') }}/kg
                                    </div>
                                @endif
                            </td>

                            <!-- Status Aktif Toggle -->
                            <td class="py-4 px-4">
                                <form method="POST" action="{{ route('admin.products.toggle-status', $product->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="px-2.5 py-1 rounded-full text-[10px] font-bold transition cursor-pointer {{ $product->is_active ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-stone-200 text-stone-600 hover:bg-stone-300' }}">
                                        {{ $product->is_active ? '● Aktif di Web' : '○ Nonaktif' }}
                                    </button>
                                </form>
                            </td>

                            <!-- Aksi -->
                            <td class="py-4 px-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" 
                                       class="p-2 rounded-lg bg-stone-100 hover:bg-[#5C3317] hover:text-white text-stone-700 transition" title="Edit Produk">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>

                                    <form id="delete-product-{{ $product->id }}" method="POST" action="{{ route('admin.products.destroy', $product->id) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete('delete-product-{{ $product->id }}', 'Hapus produk {{ addslashes($product->name) }} beserta varian dan tier harganya?')"
                                                class="p-2 rounded-lg bg-red-50 hover:bg-red-600 hover:text-white text-red-600 transition cursor-pointer" title="Hapus Produk">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-stone-400">
                                Belum ada data produk gula. Klik "Tambah Master Produk" untuk menambahkan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($products->hasPages())
            <div class="p-4 border-t border-[#E8DFD1]">
                {{ $products->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
