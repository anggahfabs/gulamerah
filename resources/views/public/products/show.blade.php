@extends('layouts.app')

@section('title', $product->name . ' — Spesifikasi Pabrik Gumer')
@section('meta-description', $product->short_description)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20 space-y-14"
     x-data="{
         selectedVariantId: {{ $product->variants->first()?->id ?? 'null' }},
         quantity: 1,
         activeTab: 'specs',
         variants: {{ json_encode($product->variants) }},
         get currentVariant() {
             return this.variants.find(v => v.id === this.selectedVariantId) || this.variants[0] || null;
         },
         get waOrderUrl() {
             let vName = this.currentVariant ? this.currentVariant.packaging_name : 'Standar';
             let text = 'Halo Tim Gumer,\n\nSaya ingin memesan produk:\n'
                      + '• Produk: {{ addslashes($product->name) }}\n'
                      + '• Varian Kemasan: ' + vName + '\n'
                      + '• Jumlah Pesanan: ' + this.quantity + ' pack/sak\n\n'
                      + 'Mohon informasi ongkir dan jadwal pengiriman. Terima kasih.';
             return 'https://wa.me/{{ preg_replace("/[^0-9]/", "", \App\Models\Setting::get("whatsapp_sales", "6281234567890")) }}?text=' + encodeURIComponent(text);
         }
     }">

    <!-- Breadcrumb -->
    <div class="flex items-center gap-2 text-xs text-stone-500">
        <a href="{{ route('home') }}" class="hover:text-[#5C3317]">Beranda</a>
        <span>/</span>
        <a href="{{ route('public.products') }}" class="hover:text-[#5C3317]">Katalog Produk</a>
        <span>/</span>
        <span class="font-bold text-[#5C3317]">{{ $product->name }}</span>
    </div>

    <!-- Product Showcase Top Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16">
        
        <!-- Left Image Showcase (5 cols) -->
        <div class="lg:col-span-5 space-y-4">
            <div class="aspect-square rounded-3xl overflow-hidden bg-white border border-[#E8DFD1] shadow-xs relative">
                @if($product->thumbnail)
                    <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center text-stone-300 bg-[#FAF6EE]">
                        <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                @endif
                <div class="absolute top-4 left-4">
                    <span class="px-3 py-1 rounded-full text-xs font-mono font-bold bg-[#1B3B2B] text-emerald-300 border border-emerald-400/30">
                        {{ $product->raw_material ?: '100% Organik' }}
                    </span>
                </div>
            </div>

            <!-- Multiple Images Thumbnails if available -->
            @if($product->images->isNotEmpty())
                <div class="grid grid-cols-4 gap-2">
                    @foreach($product->images as $img)
                        <div class="aspect-square rounded-xl overflow-hidden bg-stone-100 border border-[#E8DFD1]">
                            <img src="{{ asset('storage/' . $img->image_path) }}" alt="Preview" class="w-full h-full object-cover">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Right Product Specs & Purchase Box (7 cols) -->
        <div class="lg:col-span-7 space-y-7">
            <div>
                <span class="px-2.5 py-1 rounded-lg text-[10px] font-mono font-bold bg-[#FAF6EE] text-[#C87D20] border border-[#E8DFD1]">
                    {{ $product->category->name ?? 'Gula Aren' }} • {{ $product->product_form }}
                </span>
                <h1 class="font-serif font-black text-3xl sm:text-4xl text-[#2C1810] mt-3">{{ $product->name }}</h1>
                <p class="text-xs sm:text-sm text-stone-600 leading-relaxed mt-3">{{ $product->short_description }}</p>
            </div>

            <!-- Lab Proof Points Pills -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 py-5 border-y border-[#E8DFD1] font-mono text-center">
                <div class="p-3.5 bg-white rounded-xl border border-[#E8DFD1]">
                    <span class="block text-[10px] text-stone-400 uppercase">{{ __('Kadar Air (MC)') }}</span>
                    <span class="block text-sm font-bold text-[#5C3317]">{{ $product->moisture_content ?: '≤ 1.2%' }}</span>
                </div>
                <div class="p-3.5 bg-white rounded-xl border border-[#E8DFD1]">
                    <span class="block text-[10px] text-stone-400 uppercase">Mesh Sifter</span>
                    <span class="block text-sm font-bold text-[#5C3317]">{{ $product->mesh_size ?: '18 Mesh' }}</span>
                </div>
                <div class="p-3.5 bg-white rounded-xl border border-[#E8DFD1]">
                    <span class="block text-[10px] text-stone-400 uppercase">Brix Molasses</span>
                    <span class="block text-sm font-bold text-[#5C3317]">{{ $product->brix_content ?: '78° Brix' }}</span>
                </div>
                <div class="p-3.5 bg-white rounded-xl border border-[#E8DFD1]">
                    <span class="block text-[10px] text-stone-400 uppercase">{{ __('Masa Simpan') }}</span>
                    <span class="block text-sm font-bold text-[#5C3317]">{{ $product->shelf_life ?: '24 Bulan' }}</span>
                </div>
            </div>

            <!-- Packaging Selector -->
            @if($product->variants->isNotEmpty())
                <div class="space-y-3.5">
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-700">{{ __('Pilih Varian Kemasan:') }}</label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                        @foreach($product->variants as $var)
                            <button type="button" @click="selectedVariantId = {{ $var->id }}"
                                    :class="selectedVariantId === {{ $var->id }} ? 'border-[#C87D20] bg-amber-50/50 ring-2 ring-[#C87D20]/20' : 'border-[#E8DFD1] bg-white hover:bg-stone-50'"
                                    class="p-3.5 rounded-2xl border text-left transition">
                                <span class="block font-bold text-xs text-[#2C1810]">{{ $var->packaging_name }}</span>
                                <span class="block text-[11px] text-stone-500 mt-0.5">{{ $var->packaging_type }} ({{ $var->unit_weight_kg }} kg)</span>
                                @if($var->retail_price)
                                    <span class="block font-serif font-black text-sm text-[#5C3317] mt-1.5">
                                        Rp {{ number_format($var->retail_price, 0, ',', '.') }}
                                    </span>
                                @else
                                    <span class="block text-[10px] text-amber-700 font-bold mt-1.5">Harga Pasokan RFQ</span>
                                @endif
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Direct Dual Action CTA Box -->
            <div class="p-6 sm:p-7 rounded-2xl bg-white border border-[#E8DFD1] shadow-xs space-y-4">
                <div class="flex items-center justify-between border-b border-[#E8DFD1] pb-3">
                    <span class="text-xs font-bold text-stone-700 uppercase">{{ __('Alur Pemesanan & Penawaran:') }}</span>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">{{ __('Stok Siap Produksi') }}</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- WhatsApp Order CTA -->
                    <a :href="waOrderUrl" target="_blank"
                       class="py-3.5 px-4 bg-[#C87D20] hover:bg-[#a96615] text-white text-xs font-bold rounded-xl transition shadow-xs flex items-center justify-center gap-2 text-center">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                        <span>{{ __('Pesan via WhatsApp') }}</span>
                    </a>

                    <!-- Request Sample / B2B RFQ -->
                    <a href="{{ route('public.contact') }}?product={{ urlencode($product->name) }}"
                       class="py-3.5 px-4 bg-[#5C3317] hover:bg-[#2C1810] text-white text-xs font-bold rounded-xl transition shadow-xs flex items-center justify-center gap-2 text-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <span>{{ __('Minta Sample / RFQ') }}</span>
                    </a>
                </div>
            </div>
        </div>

    </div>

    <!-- B2B Volume Pricing Table -->
    @if($product->priceTiers->isNotEmpty())
        <div class="bg-white rounded-3xl p-8 sm:p-10 border border-[#E8DFD1] shadow-xs space-y-4">
            <div>
                <span class="text-[10px] font-mono uppercase tracking-wider text-[#C87D20]">{{ __('Tabel Transparansi Tier B2B') }}</span>
                <h3 class="font-serif font-bold text-2xl text-[#2C1810]">{{ __('Skema Harga Grosir & Kontrak Pabrik') }}</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-[#FAF6EE] text-[#5C3317] uppercase text-[11px] font-bold tracking-wider border-b border-[#E8DFD1]">
                        <tr>
                            <th class="px-6 py-3.5">{{ __('Tier Volume Kebutuhan') }}</th>
                            <th class="px-6 py-3.5">{{ __('Estimasi Harga Satuan') }}</th>
                            <th class="px-6 py-3.5">{{ __('Catatan Spesifikasi Pengiriman') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E8DFD1]">
                        @foreach($product->priceTiers as $tier)
                            <tr class="hover:bg-stone-50 transition">
                                <td class="px-6 py-4 font-mono font-bold text-stone-900">
                                    {{ number_format($tier->min_quantity_kg, 0) }} - {{ $tier->max_quantity_kg ? number_format($tier->max_quantity_kg, 0) . ' kg' : '> Di atasnya (Tonase)' }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="font-serif font-black text-sm text-[#5C3317]">
                                        Rp {{ number_format($tier->price_per_kg, 0, ',', '.') }}
                                    </span>
                                    <span class="text-stone-400 text-[11px]">/ kg</span>
                                </td>
                                <td class="px-6 py-4 text-stone-600">
                                    {{ $tier->note ?: 'Kemasan karung anyam 25kg, gratis palet kayu fumigasi ISPM-15' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Technical Specification Sheet & Full Description -->
    <div class="bg-white rounded-3xl p-8 sm:p-12 border border-[#E8DFD1] shadow-xs space-y-6">
        <h3 class="font-serif font-bold text-2xl text-[#2C1810] border-b border-[#E8DFD1] pb-4">{{ __('Spesifikasi Lengkap & Petunjuk Teknis') }}</h3>
        
        <div class="text-xs sm:text-sm text-stone-700 leading-relaxed font-sans whitespace-pre-line">
            {{ $product->full_description ?: $product->short_description }}
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t border-[#E8DFD1]">
            <div class="p-5 rounded-2xl bg-[#FAF6EE] border border-[#E8DFD1]">
                <h4 class="font-serif font-bold text-sm text-[#5C3317] mb-1.5">{{ __('Petunjuk Penyimpanan:') }}</h4>
                <p class="text-xs text-stone-600 leading-relaxed">{{ $product->storage_instruction ?: 'Simpan di ruangan sejuk dan kering dengan kelembaban udara di bawah 65%. Hindari paparan sinar matahari langsung dan pastikan kemasan tertutup rapat setelah dibuka.' }}</p>
            </div>

            <div class="p-5 rounded-2xl bg-[#FAF6EE] border border-[#E8DFD1]">
                <h4 class="font-serif font-bold text-sm text-[#5C3317] mb-1.5">{{ __('Rekomendasi Aplikasi Industri:') }}</h4>
                <p class="text-xs text-stone-600 leading-relaxed">{{ $product->recommendations ?: 'Sangat cocok untuk industri kecap premium, biskuit, granola, premix kopi susu kekinian, sirup herbal, serta taburan bakery dan horeca.' }}</p>
            </div>
        </div>
    </div>

</div>
@endsection
