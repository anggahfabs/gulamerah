@extends('layouts.app')

@section('title', 'Katalog Gula Aren & Kelapa Organik Pabrik Gumer')
@section('meta-description', 'Katalog komoditas gula aren kristal semut, gula kelapa, dan gula aren cair murni. Pasokan industri, grosir karung 25kg, dan kemasan retail.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20 space-y-12">

    <!-- Page Header & Filter -->
    <div class="space-y-5 border-b border-[#E8DFD1] pb-8">
        <div class="flex items-center gap-2">
            <a href="{{ route('home') }}" class="text-xs text-stone-500 hover:text-[#5C3317]">Beranda</a>
            <span class="text-stone-300">/</span>
            <span class="text-xs font-bold text-[#5C3317]">Katalog Produk</span>
        </div>
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="font-serif font-black text-3xl sm:text-5xl text-[#2C1810]">{{ __('Katalog Komoditas Gula') }}</h1>
                <p class="text-xs sm:text-sm text-stone-600 mt-2 max-w-xl">
                    {{ __('Produk olahan nira murni berstandar mutu terukur. Tersedia dalam kemasan bulk pasokan industri (sak 25kg / jerigen) dan kemasan ritel higienis.') }}
                </p>
            </div>
            
            <span class="text-xs font-mono font-bold text-stone-500">Menampilkan {{ $products->total() }} Produk</span>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="bg-white p-4 sm:p-5 rounded-2xl border border-[#E8DFD1] shadow-xs">
        <form method="GET" action="{{ route('public.products') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
            <div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('Cari nama produk...') }}"
                       class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/40 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
            </div>

            <div>
                <select name="category" onchange="this.form.submit()" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/40 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
                    <option value="">{{ __('Semua Kategori') }}</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->slug }}" {{ request('category') === $cat->slug ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <select name="raw_material" onchange="this.form.submit()" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/40 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
                    <option value="">{{ __('Bahan Baku (Semua)') }}</option>
                    <option value="Aren Murni" {{ request('raw_material') === 'Aren Murni' ? 'selected' : '' }}>{{ __('Aren Murni') }}</option>
                    <option value="Kelapa Alami" {{ request('raw_material') === 'Kelapa Alami' ? 'selected' : '' }}>{{ __('Kelapa Alami') }}</option>
                </select>
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="flex-1 py-2.5 bg-[#5C3317] hover:bg-[#2C1810] text-white text-xs font-bold rounded-xl transition shadow-xs">
                    Terapkan Filter
                </button>
                @if(request()->anyFilled(['search', 'category', 'raw_material', 'product_form']))
                    <a href="{{ route('public.products') }}" class="px-3.5 py-2.5 bg-stone-100 text-stone-600 hover:text-stone-900 text-xs font-bold rounded-xl transition">{{ __('Reset') }}</a>
                @endif
            </div>
        </form>
    </div>

    <!-- Product Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
        @forelse($products as $prod)
            <div class="bg-white rounded-3xl border border-[#E8DFD1] shadow-xs overflow-hidden flex flex-col justify-between hover:border-[#C87D20] transition duration-300 group">
                <div>
                    <div class="aspect-[16/10] bg-stone-100 relative overflow-hidden border-b border-[#E8DFD1]">
                        @if($prod->thumbnail)
                            <img src="{{ asset('storage/' . $prod->thumbnail) }}" alt="{{ $prod->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-stone-300 bg-[#FAF6EE]">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </div>
                        @endif
                        <div class="absolute top-3 left-3">
                            <span class="px-2.5 py-1 text-[10px] font-bold rounded-lg bg-black/60 backdrop-blur-md text-white border border-white/20">
                                {{ $prod->raw_material ?: 'Aren Murni' }}
                            </span>
                        </div>
                        <div class="absolute top-3 right-3">
                            <span class="px-2.5 py-1 text-[10px] font-bold rounded-lg bg-white/90 backdrop-blur-md text-[#5C3317] border border-[#E8DFD1]">
                                {{ $prod->product_form ?: 'Kristal' }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6 space-y-4">
                        <div>
                            <span class="text-[10px] font-mono font-bold uppercase tracking-wider text-[#C87D20]">{{ $prod->category->name ?? 'Gula Aren' }}</span>
                            <h3 class="font-serif font-bold text-xl text-[#2C1810] mt-0.5 group-hover:text-[#C87D20] transition">
                                <a href="{{ route('public.products.show', $prod->slug) }}">{{ $prod->name }}</a>
                            </h3>
                            <p class="text-xs text-stone-500 line-clamp-2 mt-1.5 leading-relaxed">{{ $prod->short_description }}</p>
                        </div>

                        <!-- Physical Lab Specs Strip -->
                        <div class="grid grid-cols-3 gap-2 py-3 border-y border-[#E8DFD1] text-center font-mono">
                            <div class="bg-[#FAF6EE] p-2.5 rounded-xl">
                                <span class="block text-[9px] text-stone-400 uppercase">{{ __('Kadar Air (MC)') }}</span>
                                <span class="block text-xs font-bold text-[#5C3317]">{{ $prod->moisture_content ?: '≤ 1.2%' }}</span>
                            </div>
                            <div class="bg-[#FAF6EE] p-2.5 rounded-xl">
                                <span class="block text-[9px] text-stone-400 uppercase">{{ __('Ukuran Mesh') }}</span>
                                <span class="block text-xs font-bold text-[#5C3317]">{{ $prod->mesh_size ?: '18 Mesh' }}</span>
                            </div>
                            <div class="bg-[#FAF6EE] p-2.5 rounded-xl">
                                <span class="block text-[9px] text-stone-400 uppercase">{{ __('Masa Simpan') }}</span>
                                <span class="block text-xs font-bold text-[#5C3317]">{{ $prod->shelf_life ?: '24 Bln' }}</span>
                            </div>
                        </div>

                        <!-- Dynamic Pricing Mode -->
                        <div>
                            <template x-if="audienceMode === 'b2b'">
                                <div class="p-3 rounded-xl bg-amber-50/50 border border-amber-200">
                                    <span class="block text-[10px] font-mono uppercase tracking-wider text-amber-800">{{ __('Harga Pasokan Industri (Grosir)') }}</span>
                                    <div class="flex items-baseline gap-1 mt-0.5">
                                        <span class="text-xs text-stone-500">Mulai</span>
                                        <span class="font-serif font-black text-lg text-[#5C3317]">
                                            Rp {{ number_format($prod->min_b2b_price ?: 22000, 0, ',', '.') }}
                                        </span>
                                        <span class="text-xs text-stone-500">/ kg</span>
                                    </div>
                                    <span class="block text-[10px] text-amber-700 mt-0.5">{{ __('Min. Order Karung Sak 25kg / Jerigen') }}</span>
                                </div>
                            </template>

                            <template x-if="audienceMode === 'b2c'">
                                <div class="p-3 rounded-xl bg-[#FAF6EE] border border-[#E8DFD1]">
                                    <span class="block text-[10px] font-mono uppercase tracking-wider text-[#C87D20]">{{ __('Harga Retail Kemasan Pouch') }}</span>
                                    <div class="flex items-baseline gap-1 mt-0.5">
                                        <span class="font-serif font-black text-lg text-[#2C1810]">
                                            Rp {{ number_format($prod->min_b2c_price ?: 18000, 0, ',', '.') }}
                                        </span>
                                        <span class="text-xs text-stone-500">/ pack</span>
                                    </div>
                                    <span class="block text-[10px] text-stone-500 mt-0.5">{{ __('Pengiriman ritel via kurir ekspedisi') }}</span>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <div class="px-6 pb-6 flex items-center gap-3">
                    <a href="{{ route('public.products.show', $prod->slug) }}" 
                       class="flex-1 py-2.5 bg-white hover:bg-stone-50 text-[#5C3317] border border-[#E8DFD1] text-xs font-bold rounded-xl text-center transition shadow-2xs">
                        Detail Spek
                    </a>
                    
                    @php
                        $waProdText = urlencode("Halo Tim Sales Gumer, saya tertarik dengan produk " . $prod->name . ". Mohon informasi ketersediaan stok pasokan dan lembar COA.");
                    @endphp
                    <a href="https://wa.me/{{ preg_replace("/[^0-9]/", "", \App\Models\Setting::get("whatsapp_sales", "6281234567890")) }}?text={{ $waProdText }}"
                       target="_blank"
                       class="flex-1 py-2.5 bg-[#5C3317] hover:bg-[#2C1810] text-white text-xs font-bold rounded-xl text-center transition shadow-xs flex items-center justify-center gap-1.5">
                        <span x-text="audienceMode === 'b2b' ? '{{ __('Minta RFQ') }}' : '{{ __('Pesan via WA') }}'">Minta RFQ</span>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 text-center bg-white rounded-3xl border border-[#E8DFD1] text-stone-400">
                <p class="font-serif font-bold text-lg text-stone-600">Tidak ada produk yang cocok dengan filter pencarian.</p>
                <p class="text-xs mt-1">Coba gunakan kata kunci lain atau reset filter pencarian.</p>
            </div>
        @endforelse
    </div>

    @if($products->hasPages())
        <div class="p-4 sm:p-5 bg-white rounded-2xl border border-[#E8DFD1]">
            {{ $products->links() }}
        </div>
    @endif

</div>
@endsection
