@extends('layouts.app')

@section('title', 'Gumer — Pabrik Gula Aren & Kelapa Organik Standar Industri')
@section('meta-description', 'Pabrik produsen gula aren murni, gula kelapa, dan gula semut kristal organik standar ekspor. Pasokan industri F&B, horeca, dan jasa maklon private label.')

@section('content')
<div class="space-y-20 sm:space-y-28 pb-20 sm:pb-28"
     x-data="{
         // State for Interactive Certification Modal
         certModalOpen: false,
         selectedCert: null,
         openCertModal(cert) {
             this.selectedCert = cert;
             this.certModalOpen = true;
         },

         // State for Interactive B2B Volume Calculator
         calcProduct: 'gula-semut',
         calcVolume: 500,
         basePrice: 28000,
         
         get calculatedTier() {
             let v = parseInt(this.calcVolume) || 0;
             if (v >= 2000) {
                 return { price: 22000, tierName: 'Tier Super Grosir (> 2 Ton)', discount: 'Hemat Rp 6.000/kg' };
             } else if (v >= 500) {
                 return { price: 24500, tierName: 'Tier Industri (500 kg - 2 Ton)', discount: 'Hemat Rp 3.500/kg' };
             } else if (v >= 100) {
                 return { price: 26500, tierName: 'Tier Menengah (100 - 500 kg)', discount: 'Hemat Rp 1.500/kg' };
             } else {
                 return { price: 28000, tierName: 'Volume Minimum (< 100 kg)', discount: 'Harga Dasar Retail B2B' };
             }
         },

         get estimatedTotal() {
             return (parseInt(this.calcVolume) || 0) * this.calculatedTier.price;
         },

         get recommendedPackaging() {
             let v = parseInt(this.calcVolume) || 0;
             if (this.calcProduct === 'gula-cair') {
                 let jerigen = Math.ceil(v / 25);
                 return jerigen + ' Jerigen Food Grade (25 kg / jerigen)';
             } else {
                 let sak = Math.ceil(v / 25);
                 return sak + ' Sak Karung Anyam Karung Lapis PE (25 kg / sak)';
             }
         },

         get waCalculatorUrl() {
             let v = parseInt(this.calcVolume) || 0;
             let prodName = this.calcProduct === 'gula-semut' ? 'Gula Semut Kristal Aren Organik' : (this.calcProduct === 'gula-cair' ? 'Gula Aren Cair (Brix 78°)' : 'Gula Aren Cetak Batok');
             let text = 'Halo Tim Sales Pabrik Gula Gumer,\n\nSaya menggunakan Kalkulator Volume B2B di website dan ingin mengajukan penawaran pasokan:\n'
                      + '• Produk: ' + prodName + '\n'
                      + '• Estimasi Kebutuhan: ' + v + ' kg/bulan\n'
                      + '• Estimasi Tier: ' + this.calculatedTier.tierName + ' (Rp ' + this.calculatedTier.price.toLocaleString('id-ID') + '/kg)\n'
                      + '• Rekomendasi Kemasan: ' + this.recommendedPackaging + '\n\n'
                      + 'Mohon informasi prosedur pengiriman sampel uji mutu dan draft kontrak kerja sama pasokan. Terima kasih.';
             return 'https://wa.me/{{ preg_replace("/[^0-9]/", "", \App\Models\Setting::get("whatsapp_sales", "6281234567890")) }}?text=' + encodeURIComponent(text);
         },

         // State for 5-Step Process Interactive Stepper
         activeStep: 1,

         // Active Category Filter for Products
         activeCategory: 'all'
     }">

    <!-- ========================================== -->
    <!-- 1. HERO SECTION (Anti-AI-Slop Craftsmanship) -->
    <!-- ========================================== -->
    <section class="relative pt-14 sm:pt-20 lg:pt-24 overflow-hidden">
        <!-- Subtle Natural Radial Texture -->
        <div class="absolute top-0 right-1/4 w-[500px] h-[500px] bg-amber-500/10 rounded-full blur-3xl pointer-events-none -z-10"></div>
        <div class="absolute bottom-0 left-10 w-[400px] h-[400px] bg-[#1B3B2B]/5 rounded-full blur-3xl pointer-events-none -z-10"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-14 items-center">
                
                <!-- Left Editorial Headline & Value Prop (7 cols) -->
                <div class="lg:col-span-7 space-y-6">
                    
                    <!-- Tactile Badge -->
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white border border-[#E8DFD1] text-[11px] font-bold text-[#5C3317] shadow-2xs">
                        <span class="w-2 h-2 rounded-full bg-[#C87D20] animate-pulse"></span>
                        <span>{{ __(\App\Models\Setting::get('hero_badge', 'Pabrik Gula Merah & Kristal Aren Standar Ekspor')) }}</span>
                    </div>

                    <!-- Editorial Artisan Title (Fraunces Serif) -->
                    <h1 class="font-serif font-black text-4xl sm:text-5xl lg:text-6xl text-[#2C1810] leading-[1.12] tracking-tight">
                        {{ __(\App\Models\Setting::get('hero_headline', 'Kemurnian Gula Aren Alami untuk Standar Industri F&B Modern')) }}
                    </h1>

                    <p class="text-sm sm:text-base text-stone-600 leading-relaxed max-w-2xl font-normal">
                        {{ __(\App\Models\Setting::get('hero_subtitle', 'Kapasitas pasokan 10+ ton per bulan dengan kendali kadar air presisi (MC ≤ 1.2%), sertifikasi Halal BPJPH, P-IRT, dan uji laboratorium Sucofindo untuk konsistensi rasa produk Anda.')) }}
                    </p>

                    <!-- Dual CTA Buttons Based on Audience Switcher -->
                    <div class="pt-2 flex flex-wrap items-center gap-4">
                        <template x-if="audienceMode === 'b2b'">
                            <div class="flex flex-wrap items-center gap-4">
                                <a href="#kalkulator-rfq" 
                                   class="px-6 py-3.5 bg-[#5C3317] hover:bg-[#2C1810] text-white text-xs font-bold rounded-xl transition shadow-xs flex items-center gap-2.5">
                                    <span>{{ __('Hitung Estimasi Harga & RFQ') }}</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </a>
                                <a href="{{ route('public.certifications') }}" 
                                   class="px-6 py-3.5 bg-white hover:bg-[#FAF6EE] text-[#5C3317] border border-[#E8DFD1] text-xs font-bold rounded-xl transition shadow-2xs flex items-center gap-2">
                                    <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <span>{{ __('Lihat Lembar Uji Lab (COA)') }}</span>
                                </a>
                            </div>
                        </template>

                        <template x-if="audienceMode === 'b2c'">
                            <div class="flex flex-wrap items-center gap-4">
                                <a href="#katalog-produk" 
                                   class="px-6 py-3.5 bg-[#C87D20] hover:bg-[#a96615] text-white text-xs font-bold rounded-xl transition shadow-xs flex items-center gap-2.5">
                                    <span>{{ __('Lihat Pilihan Kemasan Pouch') }}</span>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </a>
                                <a href="https://wa.me/{{ preg_replace("/[^0-9]/", "", \App\Models\Setting::get("whatsapp_sales", "6281234567890")) }}?text={{ urlencode('Halo Gumer, saya ingin pesan gula aren kemasan retail.') }}" 
                                   target="_blank"
                                   class="px-6 py-3.5 bg-white hover:bg-[#FAF6EE] text-[#2C1810] border border-[#E8DFD1] text-xs font-bold rounded-xl transition shadow-2xs flex items-center gap-2">
                                    <svg class="w-4 h-4 text-emerald-600 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                                    <span>{{ __('Pesan Langsung via WhatsApp') }}</span>
                                </a>
                            </div>
                        </template>
                    </div>

                    <!-- Industrial Spec Highlights (4 Proof Points) -->
                    <div class="pt-7 grid grid-cols-2 sm:grid-cols-4 gap-3.5 border-t border-[#E8DFD1] mt-1">
                        <div class="p-3 bg-white/70 rounded-xl border border-[#E8DFD1]">
                            <span class="block text-[10px] font-mono uppercase tracking-wider text-stone-500">{{ __('Kadar Air (MC)') }}</span>
                            <span class="block font-mono font-bold text-sm text-[#5C3317] mt-0.5">≤ 1.2%</span>
                            <span class="block text-[10px] text-stone-400">{{ __('Anti-Gumpal Ekspor') }}</span>
                        </div>
                        <div class="p-3 bg-white/70 rounded-xl border border-[#E8DFD1]">
                            <span class="block text-[10px] font-mono uppercase tracking-wider text-stone-500">{{ __('Ukuran Mesh') }}</span>
                            <span class="block font-mono font-bold text-sm text-[#5C3317] mt-0.5">18 - 20 Mesh</span>
                            <span class="block text-[10px] text-stone-400">{{ __('Granulasi Presisi') }}</span>
                        </div>
                        <div class="p-3 bg-white/70 rounded-xl border border-[#E8DFD1]">
                            <span class="block text-[10px] font-mono uppercase tracking-wider text-stone-500">{{ __('Brix Aren Cair') }}</span>
                            <span class="block font-mono font-bold text-sm text-[#5C3317] mt-0.5">78° Brix</span>
                            <span class="block text-[10px] text-stone-400">{{ __('Kental Alami') }}</span>
                        </div>
                        <div class="p-3 bg-white/70 rounded-xl border border-[#E8DFD1]">
                            <span class="block text-[10px] font-mono uppercase tracking-wider text-stone-500">{{ __('Kapasitas Bulanan') }}</span>
                            <span class="block font-mono font-bold text-sm text-[#5C3317] mt-0.5">10+ Ton</span>
                            <span class="block text-[10px] text-stone-400">{{ __('Kontrak Siap Suplai') }}</span>
                        </div>
                    </div>

                </div>

                <!-- Right Visual Hero & Batch Authenticity Card (5 cols) -->
                <div class="lg:col-span-5 relative">
                    <div class="relative bg-white rounded-3xl p-4 sm:p-6 border border-[#E8DFD1] shadow-xl overflow-hidden group">
                        
                        <!-- Hero Photo -->
                        <div class="aspect-[4/3] rounded-2xl bg-stone-100 overflow-hidden relative border border-[#E8DFD1]">
                            @php $heroImg = \App\Models\Setting::get('hero_image'); @endphp
                            @if($heroImg)
                                <img src="{{ asset('storage/' . $heroImg) }}" alt="Pabrik Gula Aren Gumer" class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                            @else
                                <div class="w-full h-full bg-gradient-to-tr from-[#5C3317] to-[#8C532B] flex flex-col items-center justify-center text-white p-8 text-center">
                                    <div class="w-16 h-16 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center justify-center mb-4">
                                        <svg class="w-8 h-8 text-amber-300" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                                    </div>
                                    <h3 class="font-serif font-bold text-xl text-amber-100">Fasilitas Pabrik Gumer</h3>
                                    <p class="text-xs text-amber-200/80 mt-1 max-w-xs">Pengolahan Nira Organik Higienis Standar Ekspor di Lebak, Banten</p>
                                </div>
                            @endif

                            <div class="absolute top-3 right-3">
                                <span class="px-3 py-1 rounded-full text-[10px] font-mono font-bold bg-[#1B3B2B]/90 backdrop-blur-md text-emerald-300 border border-emerald-400/30">
                                    100% Organik
                                </span>
                            </div>
                        </div>

                        <!-- Physical Verification Certificate Card -->
                        <div class="mt-4 p-4 sm:p-5 rounded-2xl bg-[#FAF6EE] border border-[#E8DFD1] space-y-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                                    <span class="font-mono text-xs font-bold text-[#2C1810]">{{ __('Jaminan Uji Mutu Pabrik') }}</span>
                                </div>
                                <span class="text-[10px] font-mono text-stone-500">COA Ref: #SUC-2026</span>
                            </div>

                            <p class="text-[11px] text-stone-600 leading-relaxed">
                                {{ __('Setiap batch produksi gula kristal semut aren melalui uji gravimetri laboratorium Sucofindo untuk memastikan kadar abu < 2.0% dan bebas kontaminasi logam berat.') }}
                            </p>

                            <div class="flex items-center justify-between pt-1 text-[11px] font-bold text-[#5C3317]">
                                <a href="{{ route('public.certifications') }}" class="hover:text-[#C87D20] underline transition">{{ __('Unduh Lembar Spek Teknis') }}</a>
                                <span class="text-stone-400 font-mono">Lot #GMR-2026-A1</span>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- ========================================== -->
    <!-- 2. CERTIFICATION & LAB BADGES GRID (Task 5.4) -->
    <!-- ========================================== -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-3xl p-6 sm:p-8 lg:p-10 border border-[#E8DFD1] shadow-xs">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-8">
                <div>
                    <span class="text-[11px] font-bold uppercase tracking-wider text-[#C87D20]">{{ __('Transparansi Standar Legalitas') }}</span>
                    <h2 class="font-serif font-bold text-2xl sm:text-3xl text-[#2C1810] mt-1">{{ __('Sertifikasi & Verifikasi Mutu Laboratorium') }}</h2>
                </div>
                <p class="text-xs text-stone-500 max-w-md leading-relaxed">
                    {{ __('Kredibilitas pabrik kami dibuktikan dengan dokumen resmi negara dan hasil laboratorium terakreditasi KAN untuk kenyamanan audit mitra industri.') }}
                </p>
            </div>

            <!-- Certification Badges Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @forelse($certifications as $cert)
                    <div @click="openCertModal({{ json_encode($cert) }})"
                         class="p-5 sm:p-6 rounded-2xl border border-[#E8DFD1] bg-[#FAF6EE]/40 hover:bg-white hover:border-[#C87D20] transition duration-300 cursor-pointer group shadow-2xs">
                        
                        <div class="flex items-center justify-between mb-3">
                            <div class="w-10 h-10 rounded-xl bg-white border border-[#E8DFD1] flex items-center justify-center text-[#5C3317] group-hover:scale-110 transition shadow-2xs">
                                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </div>
                            <span class="text-[10px] font-bold text-[#C87D20] uppercase tracking-wider group-hover:underline">{{ __('Detail Dokumen →') }}</span>
                        </div>

                        <h3 class="font-serif font-bold text-sm text-[#2C1810] line-clamp-1 mb-1">{{ $cert->name }}</h3>
                        <p class="text-xs text-stone-500 font-mono mb-2 line-clamp-1">{{ $cert->cert_number }}</p>
                        
                        <div class="pt-2 border-t border-[#E8DFD1]/60 flex items-center justify-between text-[11px] text-stone-400">
                            <span>{{ $cert->issuer }}</span>
                            <span class="font-medium text-emerald-700">{{ __('Aktif') }}</span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-6 text-center text-xs text-stone-400">{{ __('Sertifikasi sedang diperbarui di database.') }}</div>
                @endforelse
            </div>
        </div>
    </section>


    <!-- ========================================== -->
    <!-- 3. INTERACTIVE BENTO PRODUCT CATALOG (Task 4.4 & 5.5) -->
    <!-- ========================================== -->
    <section id="katalog-produk" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10 sm:space-y-12">
        
        <!-- Header & Category Filter Pills -->
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 sm:gap-8 border-b border-[#E8DFD1] pb-8 sm:pb-10">
            <div>
                <div class="inline-flex items-center gap-2 mb-2.5">
                    <span class="w-2 h-2 rounded-full bg-[#5C3317]"></span>
                    <span class="text-xs font-bold uppercase tracking-wider text-[#5C3317]">{{ __('Katalog Produk Pabrik') }}</span>
                </div>
                <h2 class="font-serif font-bold text-3xl sm:text-4xl text-[#2C1810]">{{ __('Komoditas Gula Aren & Kelapa Murni') }}</h2>
            </div>

            <!-- Category Filter Pills (Spacious slide list with comfortable touch padding) -->
            <div class="flex items-center gap-2.5 sm:gap-3 overflow-x-auto py-2 px-1">
                <button type="button" @click="activeCategory = 'all'"
                        :class="activeCategory === 'all' ? 'bg-[#5C3317] text-white shadow-xs' : 'bg-white text-stone-600 border border-[#E8DFD1] hover:bg-stone-50 hover:text-stone-900'"
                        class="px-5 py-2.5 rounded-xl text-xs font-bold transition-all duration-200 whitespace-nowrap cursor-pointer shadow-2xs">
                    Semua Produk
                </button>
                @foreach($categories as $cat)
                    <button type="button" @click="activeCategory = '{{ $cat->slug }}'"
                            :class="activeCategory === '{{ $cat->slug }}' ? 'bg-[#5C3317] text-white shadow-xs' : 'bg-white text-stone-600 border border-[#E8DFD1] hover:bg-stone-50 hover:text-stone-900'"
                            class="px-5 py-2.5 rounded-xl text-xs font-bold transition-all duration-200 whitespace-nowrap cursor-pointer shadow-2xs">
                        {{ $cat->name }}
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Bento Grid Products -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 mt-2 sm:mt-4">
            @foreach($featuredProducts as $prod)
                <div x-show="activeCategory === 'all' || activeCategory === '{{ $prod->category->slug ?? '' }}'"
                     class="bg-white rounded-3xl border border-[#E8DFD1] shadow-xs overflow-hidden flex flex-col justify-between hover:border-[#C87D20] transition duration-300 group">
                    
                    <div>
                        <!-- Product Thumbnail -->
                        <div class="aspect-[16/10] bg-stone-100 relative overflow-hidden border-b border-[#E8DFD1]">
                            @if($prod->thumbnail)
                                <img src="{{ asset('storage/' . $prod->thumbnail) }}" alt="{{ $prod->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-stone-300 bg-[#FAF6EE]">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                    <span class="text-[11px] font-mono mt-1 text-stone-400">Komoditas Gumer</span>
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

                        <!-- Product Content & Lab Badges -->
                        <div class="p-6 space-y-4">
                            <div>
                                <span class="text-[10px] font-mono font-bold uppercase tracking-wider text-[#C87D20]">{{ $prod->category->name ?? 'Gula Aren' }}</span>
                                <h3 class="font-serif font-bold text-xl text-[#2C1810] mt-0.5 group-hover:text-[#C87D20] transition">
                                    <a href="{{ route('public.products.show', $prod->slug) }}">{{ $prod->name }}</a>
                                </h3>
                                <p class="text-xs text-stone-500 line-clamp-2 mt-1.5 leading-relaxed">{{ $prod->short_description }}</p>
                            </div>

                            <!-- Physical Lab Specs Strip -->
                            <div class="grid grid-cols-3 gap-2.5 py-3.5 border-y border-[#E8DFD1] text-center font-mono">
                                <div class="bg-[#FAF6EE] p-2.5 rounded-xl">
                                    <span class="block text-[9px] text-stone-400 uppercase">Kadar Air</span>
                                    <span class="block text-xs font-bold text-[#5C3317]">{{ $prod->moisture_content ?: '≤ 1.2%' }}</span>
                                </div>
                                <div class="bg-[#FAF6EE] p-2.5 rounded-xl">
                                    <span class="block text-[9px] text-stone-400 uppercase">Ukuran Mesh</span>
                                    <span class="block text-xs font-bold text-[#5C3317]">{{ $prod->mesh_size ?: '18 Mesh' }}</span>
                                </div>
                                <div class="bg-[#FAF6EE] p-2.5 rounded-xl">
                                    <span class="block text-[9px] text-stone-400 uppercase">Masa Simpan</span>
                                    <span class="block text-xs font-bold text-[#5C3317]">{{ $prod->shelf_life ?: '24 Bln' }}</span>
                                </div>
                            </div>

                            <!-- Pricing Display Adapted to Audience Mode -->
                            <div>
                                <!-- B2B Mode: Volume Tier Starting Price -->
                                <template x-if="audienceMode === 'b2b'">
                                    <div class="p-3 rounded-xl bg-amber-50/50 border border-amber-200">
                                        <span class="block text-[10px] font-mono uppercase tracking-wider text-amber-800">{{ __('Harga Pasokan Industri (Grosir)') }}</span>
                                        <div class="flex items-baseline gap-1 mt-0.5">
                                            <span class="text-xs text-stone-500">{{ __('Mulai') }}</span>
                                            <span class="font-serif font-black text-lg text-[#5C3317]">
                                                Rp {{ number_format($prod->min_b2b_price ?: 22000, 0, ',', '.') }}
                                            </span>
                                            <span class="text-xs text-stone-500">/ kg</span>
                                        </div>
                                        <span class="block text-[10px] text-amber-700 mt-0.5">{{ __('Min. Order Karung Sak 25kg / Jerigen') }}</span>
                                    </div>
                                </template>

                                <!-- B2C Mode: Retail Pack Starting Price -->
                                <template x-if="audienceMode === 'b2c'">
                                    <div class="p-3 rounded-xl bg-[#FAF6EE] border border-[#E8DFD1]">
                                        <span class="block text-[10px] font-mono uppercase tracking-wider text-[#C87D20]">{{ __('Harga Retail Kemasan Pouch') }}</span>
                                        <div class="flex items-baseline gap-1 mt-0.5">
                                            <span class="font-serif font-black text-lg text-[#2C1810]">
                                                Rp {{ number_format($prod->min_b2c_price ?: 18000, 0, ',', '.') }}
                                            </span>
                                            <span class="text-xs text-stone-500">/ pack</span>
                                        </div>
                                        <span class="block text-[10px] text-stone-500 mt-0.5">{{ __('Siap kirim ke seluruh Indonesia via ekspedisi') }}</span>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- Card Footer Actions -->
                    <div class="px-6 pb-6 flex items-center gap-3">
                        <a href="{{ route('public.products.show', $prod->slug) }}" 
                           class="flex-1 py-2.5 bg-white hover:bg-stone-50 text-[#5C3317] border border-[#E8DFD1] text-xs font-bold rounded-xl text-center transition shadow-2xs">
                            Detail Spek
                        </a>

                        <template x-if="audienceMode === 'b2b'">
                            <a href="#kalkulator-rfq" 
                               @click="calcProduct = '{{ $prod->product_form === 'Cair' ? 'gula-cair' : 'gula-semut' }}'"
                               class="flex-1 py-2.5 bg-[#5C3317] hover:bg-[#2C1810] text-white text-xs font-bold rounded-xl text-center transition shadow-xs">
                                Minta Sample / RFQ
                            </a>
                        </template>

                        <template x-if="audienceMode === 'b2c'">
                            @php
                                $waB2cText = urlencode("Halo Tim Gumer, saya ingin memesan produk retail " . $prod->name . ". Mohon info ongkir dan ketersediaan kemasan pouch.");
                            @endphp
                            <a href="https://wa.me/{{ preg_replace("/[^0-9]/", "", \App\Models\Setting::get("whatsapp_sales", "6281234567890")) }}?text={{ $waB2cText }}"
                               target="_blank"
                               class="flex-1 py-2.5 bg-[#C87D20] hover:bg-[#a96615] text-white text-xs font-bold rounded-xl text-center transition shadow-xs flex items-center justify-center gap-1.5">
                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                                <span>{{ __('Pesan via WA') }}</span>
                            </a>
                        </template>
                    </div>

                </div>
            @endforeach
        </div>
    </section>


    <!-- ========================================== -->
    <!-- 4. INTERACTIVE B2B VOLUME CALCULATOR (Task 5.2) -->
    <!-- ========================================== -->
    <section id="kalkulator-rfq" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-[#2C1810] text-[#FAF6EE] rounded-3xl p-6 sm:p-10 lg:p-12 border-2 border-[#5C3317] shadow-2xl relative overflow-hidden">
            
            <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                
                <!-- Left Intro & Parameters (6 cols) -->
                <div class="lg:col-span-6 space-y-6">
                    <div>
                        <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#C87D20]/20 text-[#C87D20] text-xs font-bold font-mono">
                            Kalkulator Harga B2B Realtime
                        </span>
                        <h2 class="font-serif font-black text-3xl sm:text-4xl text-white mt-3">
                            Transparansi Penawaran Volume Tonase
                        </h2>
                        <p class="text-xs sm:text-sm text-stone-300 mt-2 leading-relaxed">
                            {{ __('Pabrik kami memberlakukan tier harga kuantitatif transparan. Geser volume kebutuhan bulanan Anda untuk menghitung estimasi harga satuan dan efisiensi biaya bahan baku.') }}
                        </p>
                    </div>

                    <!-- Calculator Inputs -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-amber-300 mb-1.5">{{ __('Pilih Jenis Komoditas Gula') }}</label>
                            <select x-model="calcProduct" class="w-full px-4 py-3 text-xs font-bold rounded-xl bg-white/10 border border-white/20 text-white focus:outline-none focus:ring-2 focus:ring-amber-500">
                                <option value="gula-semut" class="text-stone-900">Gula Semut Aren Kristal Organik (Mesh 18)</option>
                                <option value="gula-cair" class="text-stone-900">Gula Aren Cair Alami (Brix 78°)</option>
                                <option value="gula-cetak" class="text-stone-900">Gula Aren Cetak Batok Murni</option>
                            </select>
                        </div>

                        <div>
                            <div class="flex items-center justify-between text-xs mb-1.5">
                                <span class="font-bold uppercase tracking-wider text-amber-300">{{ __('Estimasi Kebutuhan Pasokan Bulanan') }}</span>
                                <span class="font-mono font-bold text-white text-sm" x-text="calcVolume + ' Kilogram (' + (calcVolume/1000).toFixed(1) + ' Ton)'"></span>
                            </div>
                            <input type="range" min="100" max="5000" step="50" x-model="calcVolume"
                                   class="w-full h-2.5 bg-white/20 rounded-lg appearance-none cursor-pointer accent-[#C87D20]">
                            <div class="flex justify-between text-[10px] text-stone-400 font-mono mt-1">
                                <span>100 kg (Sampel / Horeca)</span>
                                <span>1.000 kg (1 Ton)</span>
                                <span>5.000 kg (5 Ton Pabrik)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Calculation Summary Card (6 cols) -->
                <div class="lg:col-span-6 bg-white/5 backdrop-blur-md rounded-2xl p-5 sm:p-7 lg:p-8 border border-white/15 space-y-5">
                    
                    <div class="flex items-center justify-between border-b border-white/10 pb-4">
                        <div>
                            <span class="text-[10px] font-mono text-stone-400 uppercase tracking-wider">{{ __('Status Tier Pembelian') }}</span>
                            <h3 class="font-serif font-bold text-lg text-amber-300 mt-0.5" x-text="calculatedTier.tierName"></h3>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-xs font-mono font-bold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30" x-text="calculatedTier.discount"></span>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-3.5 rounded-xl bg-black/20 border border-white/10">
                            <span class="block text-[10px] font-mono text-stone-400 uppercase">{{ __('Estimasi Harga Per Kg') }}</span>
                            <div class="flex items-baseline gap-1 mt-1">
                                <span class="font-mono font-black text-xl text-white" x-text="'Rp ' + calculatedTier.price.toLocaleString('id-ID')"></span>
                            </div>
                        </div>

                        <div class="p-3.5 rounded-xl bg-black/20 border border-white/10">
                            <span class="block text-[10px] font-mono text-stone-400 uppercase">{{ __('Estimasi Total Nilai PO') }}</span>
                            <div class="flex items-baseline gap-1 mt-1">
                                <span class="font-mono font-black text-xl text-amber-400" x-text="'Rp ' + estimatedTotal.toLocaleString('id-ID')"></span>
                            </div>
                        </div>
                    </div>

                    <div class="p-3.5 rounded-xl bg-black/20 border border-white/10 text-xs">
                        <span class="block text-[10px] font-mono text-stone-400 uppercase mb-1">{{ __('Rekomendasi Spesifikasi Kemasan Pasokan:') }}</span>
                        <span class="font-medium text-stone-200" x-text="recommendedPackaging"></span>
                    </div>

                    <!-- Direct RFQ WhatsApp CTA -->
                    <a :href="waCalculatorUrl" target="_blank"
                       class="w-full py-4 bg-[#C87D20] hover:bg-[#a96615] text-white text-xs font-bold rounded-xl transition shadow-lg flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                        <span>{{ __('Kirim Permintaan Penawaran (RFQ) via WhatsApp') }}</span>
                    </a>
                </div>

            </div>
        </div>
    </section>


    <!-- ========================================== -->
    <!-- 5. INTERACTIVE 5-STEP FARM-TO-FACTORY (Task 5.3) -->
    <!-- ========================================== -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        <div class="text-center max-w-2xl mx-auto space-y-3">
            <span class="text-xs font-bold uppercase tracking-wider text-[#C87D20]">{{ __('Alur Higienitas Pengolahan') }}</span>
            <h2 class="font-serif font-bold text-3xl sm:text-4xl text-[#2C1810]">{{ __('5 Tahap Standar Farm-to-Factory') }}</h2>
            <p class="text-xs sm:text-sm text-stone-500 leading-relaxed">
                {{ __('Dari pohon aren liar di perbukitan Banten hingga menjadi butiran kristal steril berstandar ekspor ke mancanegara.') }}
            </p>
        </div>

        <!-- 5 Steps Interactive Nav Tabs -->
        <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
            @php
                $steps = [
                    1 => ['title' => '1. Penderesan Nira', 'sub' => 'Panen Nira Alami Pagi Hari'],
                    2 => ['title' => '2. Uji Keasaman', 'sub' => 'Filter Ganda & Uji pH Segar'],
                    3 => ['title' => '3. Evaporasi Higienis', 'sub' => 'Pemasakan Kontrol Suhu'],
                    4 => ['title' => '4. Kristalisasi', 'sub' => 'Pengeringan & Ayakan Mesh 18'],
                    5 => ['title' => '5. QC & Pengiriman', 'sub' => 'Uji Lab Sucofindo & Kirim'],
                ];
            @endphp

            @foreach($steps as $idx => $s)
                <button type="button" @click="activeStep = {{ $idx }}"
                        :class="activeStep === {{ $idx }} ? 'bg-[#5C3317] text-white shadow-xs border-[#5C3317]' : 'bg-white text-[#2C1810] border-[#E8DFD1] hover:bg-stone-50'"
                        class="p-4 rounded-2xl border text-left transition duration-200">
                    <span class="block font-serif font-bold text-xs sm:text-sm">{{ $s['title'] }}</span>
                    <span class="block text-[10px] text-stone-400 mt-1 line-clamp-1" :class="activeStep === {{ $idx }} ? 'text-amber-200' : ''">{{ $s['sub'] }}</span>
                </button>
            @endforeach
        </div>

        <!-- Step Detail Content Display -->
        <div class="bg-white rounded-3xl p-6 sm:p-10 lg:p-12 border border-[#E8DFD1] shadow-xs">
            <!-- Step 1 -->
            <div x-show="activeStep === 1" class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                <div class="space-y-4">
                    <span class="px-3 py-1 rounded-full text-xs font-mono font-bold bg-[#FAF6EE] text-[#5C3317] border border-[#E8DFD1]">Tahap 01: Pemanenan Berkelanjutan</span>
                    <h3 class="font-serif font-bold text-2xl text-[#2C1810]">Penderesan Nira Alami di Kebun Aren Lestari</h3>
                    <p class="text-xs sm:text-sm text-stone-600 leading-relaxed">
                        Nira dipanen setiap pagi dari mayang pohon aren liar (Arenga pinnata) oleh kelompok tani binaan Gumer. Pengumpulan menggunakan bumbung bambu tradisional yang dibersihkan secara steril tanpa menggunakan pengawet kimia seperti natrium benzoat atau natrium metabisulfit.
                    </p>
                    <div class="grid grid-cols-2 gap-4 pt-2">
                        <div class="p-3 bg-[#FAF6EE] rounded-xl border border-[#E8DFD1]">
                            <span class="block text-[10px] text-stone-400 uppercase font-mono">Standar Nira Segar</span>
                            <span class="font-bold text-xs text-[#5C3317]">pH 6.5 - 7.0 (Manis Segar)</span>
                        </div>
                        <div class="p-3 bg-[#FAF6EE] rounded-xl border border-[#E8DFD1]">
                            <span class="block text-[10px] text-stone-400 uppercase font-mono">Waktu Pengolahan</span>
                            <span class="font-bold text-xs text-[#5C3317]">&lt; 3 Jam Pasca Penderesan</span>
                        </div>
                    </div>
                </div>
                <div class="rounded-2xl overflow-hidden aspect-[4/3] bg-stone-100 border border-[#E8DFD1]">
                    <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&w=800&q=80" alt="Penderesan Nira" class="w-full h-full object-cover">
                </div>
            </div>

            <!-- Step 2 -->
            <div x-show="activeStep === 2" class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center" style="display: none;">
                <div class="space-y-4">
                    <span class="px-3 py-1 rounded-full text-xs font-mono font-bold bg-[#FAF6EE] text-[#5C3317] border border-[#E8DFD1]">Tahap 02: Purifikasi Nira</span>
                    <h3 class="font-serif font-bold text-2xl text-[#2C1810]">Penyaringan Ganda & Uji Sensorik</h3>
                    <p class="text-xs sm:text-sm text-stone-600 leading-relaxed">
                        Saat tiba di fasilitas penerimaan pabrik, seluruh jerigen nira langsung disaring menggunakan filter bertingkat stainless steel 100-mesh untuk memisahkan serat sabut alami dan debu mikroskopis. Sampel nira diuji sensorik dan diukur kadar gula alaminya dengan refraktometer digital.
                    </p>
                    <div class="grid grid-cols-2 gap-4 pt-2">
                        <div class="p-3 bg-[#FAF6EE] rounded-xl border border-[#E8DFD1]">
                            <span class="block text-[10px] text-stone-400 uppercase font-mono">Metode Filtrasi</span>
                            <span class="font-bold text-xs text-[#5C3317]">Dual Mesh Stainless 316</span>
                        </div>
                        <div class="p-3 bg-[#FAF6EE] rounded-xl border border-[#E8DFD1]">
                            <span class="block text-[10px] text-stone-400 uppercase font-mono">Brix Awal Nira</span>
                            <span class="font-bold text-xs text-[#5C3317]">12° - 14° Brix Segar</span>
                        </div>
                    </div>
                </div>
                <div class="rounded-2xl overflow-hidden aspect-[4/3] bg-stone-100 border border-[#E8DFD1]">
                    <img src="https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=800&q=80" alt="Uji Sensorik" class="w-full h-full object-cover">
                </div>
            </div>

            <!-- Step 3 -->
            <div x-show="activeStep === 3" class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center" style="display: none;">
                <div class="space-y-4">
                    <span class="px-3 py-1 rounded-full text-xs font-mono font-bold bg-[#FAF6EE] text-[#5C3317] border border-[#E8DFD1]">Tahap 03: Evaporasi Terkontrol</span>
                    <h3 class="font-serif font-bold text-2xl text-[#2C1810]">Pemasakan & Evaporasi Higienis</h3>
                    <p class="text-xs sm:text-sm text-stone-600 leading-relaxed">
                        Nira dimasak dalam tungku jacketed pan stainless steel food grade dengan kontrol suhu termostat digital. Suhu dijaga stabil antara 100°C - 105°C untuk memicu karamelisasi alami tanpa merusak aroma floral khas nira aren atau menimbulkan rasa gosong pahit.
                    </p>
                    <div class="grid grid-cols-2 gap-4 pt-2">
                        <div class="p-3 bg-[#FAF6EE] rounded-xl border border-[#E8DFD1]">
                            <span class="block text-[10px] text-stone-400 uppercase font-mono">Suhu Pengolahan</span>
                            <span class="font-bold text-xs text-[#5C3317]">100°C - 105°C Presisi</span>
                        </div>
                        <div class="p-3 bg-[#FAF6EE] rounded-xl border border-[#E8DFD1]">
                            <span class="block text-[10px] text-stone-400 uppercase font-mono">Hasil Karamel</span>
                            <span class="font-bold text-xs text-[#5C3317]">Brix 78° - 82° Molasses</span>
                        </div>
                    </div>
                </div>
                <div class="rounded-2xl overflow-hidden aspect-[4/3] bg-stone-100 border border-[#E8DFD1]">
                    <img src="https://images.unsplash.com/photo-1581092335397-9583fe92d232?auto=format&fit=crop&w=800&q=80" alt="Pemasakan Nira" class="w-full h-full object-cover">
                </div>
            </div>

            <!-- Step 4 -->
            <div x-show="activeStep === 4" class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center" style="display: none;">
                <div class="space-y-4">
                    <span class="px-3 py-1 rounded-full text-xs font-mono font-bold bg-[#FAF6EE] text-[#5C3317] border border-[#E8DFD1]">Tahap 04: Kristalisasi Granulasi</span>
                    <h3 class="font-serif font-bold text-2xl text-[#2C1810]">Pengeringan Kristal & Ayakan Mesh 18</h3>
                    <p class="text-xs sm:text-sm text-stone-600 leading-relaxed">
                        Molasses aren didinginkan dan digerus dengan mesin granulasi mekanis hingga membentuk serbuk kristal halus. Serbuk kemudian dikeringkan dalam rotary dryer oven suhu 50°C hingga kadar air mencapai ≤ 1.2%, lalu diayak dengan vibrating sifter 18 mesh untuk butiran seragam.
                    </p>
                    <div class="grid grid-cols-2 gap-4 pt-2">
                        <div class="p-3 bg-[#FAF6EE] rounded-xl border border-[#E8DFD1]">
                            <span class="block text-[10px] text-stone-400 uppercase font-mono">Kadar Air Akhir</span>
                            <span class="font-bold text-xs text-[#5C3317]">MC ≤ 1.2% (Standar Ekspor)</span>
                        </div>
                        <div class="p-3 bg-[#FAF6EE] rounded-xl border border-[#E8DFD1]">
                            <span class="block text-[10px] text-stone-400 uppercase font-mono">Keseragaman Ukuran</span>
                            <span class="font-bold text-xs text-[#5C3317]">Ayakan Vibrasi Mesh 18</span>
                        </div>
                    </div>
                </div>
                <div class="rounded-2xl overflow-hidden aspect-[4/3] bg-stone-100 border border-[#E8DFD1]">
                    <img src="https://images.unsplash.com/photo-1587293852726-70cdb56c2866?auto=format&fit=crop&w=800&q=80" alt="Kristalisasi Gula Semut" class="w-full h-full object-cover">
                </div>
            </div>

            <!-- Step 5 -->
            <div x-show="activeStep === 5" class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center" style="display: none;">
                <div class="space-y-4">
                    <span class="px-3 py-1 rounded-full text-xs font-mono font-bold bg-[#FAF6EE] text-[#5C3317] border border-[#E8DFD1]">Tahap 05: QC & Pengemasan</span>
                    <h3 class="font-serif font-bold text-2xl text-[#2C1810]">Verifikasi Laboratorium & Distribusi</h3>
                    <p class="text-xs sm:text-sm text-stone-600 leading-relaxed">
                        Produk dikemas dalam ruang clean-room steril. Untuk pesanan B2B, digunakan sak anyam 25kg dengan liner plastik food grade anti-udara. Sampel acak dikirim ke laboratorium Sucofindo untuk penerbitan lembar Certificate of Analysis (COA) sebelum didistribusikan.
                    </p>
                    <div class="grid grid-cols-2 gap-4 pt-2">
                        <div class="p-3 bg-[#FAF6EE] rounded-xl border border-[#E8DFD1]">
                            <span class="block text-[10px] text-stone-400 uppercase font-mono">Dokumen Kelulusan</span>
                            <span class="font-bold text-xs text-[#5C3317]">COA Lab Sucofindo Lengkap</span>
                        </div>
                        <div class="p-3 bg-[#FAF6EE] rounded-xl border border-[#E8DFD1]">
                            <span class="block text-[10px] text-stone-400 uppercase font-mono">Pengiriman</span>
                            <span class="font-bold text-xs text-[#5C3317]">Armada Truk & Kontainer FCL</span>
                        </div>
                    </div>
                </div>
                <div class="rounded-2xl overflow-hidden aspect-[4/3] bg-stone-100 border border-[#E8DFD1]">
                    <img src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=800&q=80" alt="Distribusi Armada Pabrik" class="w-full h-full object-cover">
                </div>
            </div>
        </div>
    </section>


    <!-- ========================================== -->
    <!-- 6. B2B & OEM MAKLON SERVICES (Task 4.6) -->
    <!-- ========================================== -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-6 border-b border-[#E8DFD1] pb-7">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-[#C87D20]">{{ __('Kerja Sama Korporasi & Maklon') }}</span>
                <h2 class="font-serif font-bold text-3xl sm:text-4xl text-[#2C1810] mt-1">{{ __('Layanan Pasokan & Private Label') }}</h2>
            </div>
            <a href="{{ route('public.services') }}" class="text-xs font-bold text-[#5C3317] hover:text-[#C87D20] underline transition">
                {{ __('Pelajari Detail Kerja Sama →') }}
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($services as $srv)
                <div class="p-6 sm:p-8 rounded-3xl bg-white border border-[#E8DFD1] shadow-xs flex flex-col justify-between hover:border-[#C87D20] transition duration-300 group">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="w-12 h-12 rounded-2xl bg-[#FAF6EE] border border-[#E8DFD1] flex items-center justify-center text-[#5C3317] group-hover:scale-110 transition shadow-2xs">
                                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            </div>
                            @if($srv->badge_text)
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-mono font-bold bg-[#FAF6EE] text-[#5C3317] border border-[#E8DFD1]">
                                    {{ $srv->badge_text }}
                                </span>
                            @endif
                        </div>

                        <div>
                            <h3 class="font-serif font-bold text-xl text-[#2C1810]">{{ $srv->title }}</h3>
                            <p class="text-xs text-stone-500 mt-2 leading-relaxed">{{ $srv->description }}</p>
                        </div>

                        @if(!empty($srv->features))
                            <ul class="space-y-2 pt-2 border-t border-[#E8DFD1]/60 text-xs text-stone-600">
                                @foreach($srv->features as $f)
                                    <li class="flex items-start gap-2">
                                        <svg class="w-4 h-4 text-emerald-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        <span>{{ $f }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

                    <div class="pt-6 mt-6 border-t border-[#E8DFD1]">
                        <a href="{{ route('public.contact') }}?service={{ urlencode($srv->title) }}" 
                           class="w-full py-2.5 bg-[#FAF6EE] hover:bg-[#5C3317] hover:text-white text-[#5C3317] border border-[#E8DFD1] text-xs font-bold rounded-xl transition text-center block">
                            Konsultasi Kemitraan
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>


    <!-- ========================================== -->
    <!-- 7. FACTORY GALLERIES (Task 4.7) -->
    <!-- ========================================== -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <div class="flex items-end justify-between border-b border-[#E8DFD1] pb-6">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-[#C87D20]">{{ __('Dokumentasi Otentik') }}</span>
                <h2 class="font-serif font-bold text-2xl sm:text-3xl text-[#2C1810]">{{ __('Fasilitas Produksi & Kebun Aren') }}</h2>
            </div>
            <a href="{{ route('public.galleries') }}" class="text-xs font-bold text-[#5C3317] hover:text-[#C87D20] underline transition">
                {{ __('Semua Foto Fasilitas →') }}
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
            @foreach($galleries as $gal)
                <div class="aspect-square rounded-2xl overflow-hidden bg-stone-100 border border-[#E8DFD1] relative group shadow-2xs">
                    <img src="{{ asset('storage/' . $gal->image_path) }}" alt="{{ $gal->title }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition duration-300 p-3 flex flex-col justify-end text-white">
                        <span class="text-[9px] uppercase font-bold text-amber-300">{{ $gal->category }}</span>
                        <span class="font-serif text-xs font-bold leading-tight line-clamp-2 mt-0.5">{{ $gal->title }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </section>


    <!-- ========================================== -->
    <!-- 8. EDUCATIONAL ARTICLES (Task 4.8) -->
    <!-- ========================================== -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <div class="flex items-end justify-between border-b border-[#E8DFD1] pb-6">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-[#C87D20]">{{ __('Riset & Wawasan Komoditas') }}</span>
                <h2 class="font-serif font-bold text-2xl sm:text-3xl text-[#2C1810]">{{ __('Edukasi Standar Industri') }}</h2>
            </div>
            <a href="{{ route('public.articles') }}" class="text-xs font-bold text-[#5C3317] hover:text-[#C87D20] underline transition">
                {{ __('Semua Artikel →') }}
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($articles as $art)
                <div class="bg-white rounded-3xl border border-[#E8DFD1] shadow-xs overflow-hidden flex flex-col justify-between hover:border-[#C87D20] transition duration-300 group">
                    <div>
                        <div class="aspect-[16/9] bg-stone-100 overflow-hidden border-b border-[#E8DFD1]">
                            @if($art->cover_image)
                                <img src="{{ asset('storage/' . $art->cover_image) }}" alt="{{ $art->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-stone-300 bg-[#FAF6EE]">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-6 space-y-2">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-[#FAF6EE] text-[#5C3317] border border-[#E8DFD1]">{{ $art->category }}</span>
                            <h3 class="font-serif font-bold text-lg text-[#2C1810] group-hover:text-[#C87D20] transition leading-snug">
                                <a href="{{ route('public.articles.show', $art->slug) }}">{{ $art->title }}</a>
                            </h3>
                            <p class="text-xs text-stone-500 line-clamp-2 leading-relaxed">{{ $art->excerpt ?: strip_tags($art->content) }}</p>
                        </div>
                    </div>
                    <div class="px-6 pb-5 pt-4 flex items-center justify-between text-[11px] text-stone-400 border-t border-[#E8DFD1]/60">
                        <span>{{ $art->author_name }}</span>
                        <span>{{ $art->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </section>


    <!-- ========================================== -->
    <!-- 9. DUAL ACTION B2B RFQ INQUIRY FORM (Task 6.1) -->
    <!-- ========================================== -->
    <section id="kontak-rfq" class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8"
             x-data="{
                 rfqForm: {
                     full_name: '',
                     company_name: '',
                     phone_number: '',
                     email: '',
                     inquiry_type: 'Kontrak Pasokan Industri Rutin',
                     product_interest: 'Gula Semut Aren Kristal Organik',
                     estimated_volume: '500 kg - 1 Ton / bulan',
                     message: ''
                 },
                 submitting: false,
                 submitForm() {
                     this.submitting = true;
                     fetch('{{ route('public.rfq.submit') }}', {
                         method: 'POST',
                         headers: {
                             'Content-Type': 'application/json',
                             'X-CSRF-TOKEN': '{{ csrf_token() }}',
                             'Accept': 'application/json'
                         },
                         body: JSON.stringify(this.rfqForm)
                     })
                     .then(res => res.json())
                     .then(data => {
                         this.submitting = false;
                         window.Toast.fire({
                             icon: 'success',
                             title: data.message || 'Permintaan penawaran tersimpan! Mengalihkan ke WhatsApp...'
                         });
                         if (data.redirect_url) {
                             setTimeout(() => {
                                 window.open(data.redirect_url, '_blank');
                             }, 800);
                         }
                     })
                     .catch(() => {
                         this.submitting = false;
                         window.Toast.fire({
                             icon: 'error',
                             title: 'Terjadi kesalahan saat mengirim form. Silakan coba lagi.'
                         });
                     });
                 }
             }">

        <div class="bg-white rounded-3xl p-6 sm:p-10 lg:p-12 border border-[#E8DFD1] shadow-xl space-y-8">
            <div class="text-center max-w-xl mx-auto space-y-3">
                <span class="text-xs font-bold uppercase tracking-wider text-[#C87D20]">{{ __('Dual Action Procurement Portal') }}</span>
                <h2 class="font-serif font-bold text-3xl sm:text-4xl text-[#2C1810]">{{ __('Ajukan Penawaran & Permintaan Sample') }}</h2>
                <p class="text-xs sm:text-sm text-stone-500 leading-relaxed">
                    {{ __('Data inquiry Anda akan tersimpan otomatis di database sistem audit pabrik kami dan langsung terhubung dengan PIC Sales WhatsApp untuk respons dalam hitungan menit.') }}
                </p>
            </div>

            <form @submit.prevent="submitForm()" class="space-y-5">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">{{ __('Nama Lengkap PIC *') }}</label>
                        <input type="text" x-model="rfqForm.full_name" required placeholder="Contoh: Budi Santoso"
                               class="w-full px-4 py-3 text-sm rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">{{ __('Nama Perusahaan / Brand / Cafe') }}</label>
                        <input type="text" x-model="rfqForm.company_name" placeholder="Contoh: PT Kopi Nusantara / Roastery"
                               class="w-full px-4 py-3 text-xs rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">{{ __('Nomor WhatsApp Aktif *') }}</label>
                        <input type="text" x-model="rfqForm.phone_number" required placeholder="Contoh: 081234567890"
                               class="w-full px-4 py-3 text-xs rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">{{ __('Email Perusahaan / Pribadi') }}</label>
                        <input type="email" x-model="rfqForm.email" placeholder="Contoh: purchasing@kopinusantara.com"
                               class="w-full px-4 py-3 text-xs rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">{{ __('Tipe Kebutuhan *') }}</label>
                        <select x-model="rfqForm.inquiry_type" class="w-full px-4 py-3 text-xs rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
                            <option value="Kontrak Pasokan Industri Rutin">Kontrak Pasokan Industri Rutin</option>
                            <option value="Permintaan Sample Gratis (Uji Lab)">Permintaan Sample Gratis (Uji Lab)</option>
                            <option value="Jasa Maklon OEM Kemasan Klien">Jasa Maklon OEM Kemasan Klien</option>
                            <option value="Suplai Horeca / Jaringan Cafe">Suplai Horeca / Jaringan Cafe</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">{{ __('Produk yang Diminati') }}</label>
                        <select x-model="rfqForm.product_interest" class="w-full px-4 py-3 text-xs rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
                            <option value="Gula Semut Aren Kristal Organik">Gula Semut Aren Kristal Organik</option>
                            <option value="Gula Aren Cair (Brix 78°)">Gula Aren Cair (Brix 78°)</option>
                            <option value="Gula Aren Cetak Batok Murni">Gula Aren Cetak Batok Murni</option>
                            <option value="Gula Kelapa Cetak Alami">Gula Kelapa Cetak Alami</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">{{ __('Estimasi Volume') }}</label>
                        <input type="text" x-model="rfqForm.estimated_volume" placeholder="Contoh: 500 kg / bulan"
                               class="w-full px-4 py-3 text-xs rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">{{ __('Catatan Spesifikasi Khusus / Kebutuhan Lab') }}</label>
                    <textarea x-model="rfqForm.message" rows="3" placeholder="Tuliskan jika membutuhkan batas kadar air khusus, mesh tertentu, pengemasan private label, atau alamat pengiriman sampel..."
                              class="w-full px-4 py-3 text-xs rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]"></textarea>
                </div>

                <div class="text-center pt-2">
                    <button type="submit" :disabled="submitting"
                            class="w-full sm:w-auto px-10 py-4 bg-[#5C3317] hover:bg-[#2C1810] text-white text-xs font-bold rounded-xl transition shadow-md flex items-center justify-center gap-2 mx-auto">
                        <span x-text="submitting ? '{{ __('Menyimpan & Menghubungkan...') }}' : '{{ __('Kirim Penawaran & Hubungi Sales via WhatsApp') }}'">{{ __('Kirim Penawaran & Hubungi Sales via WhatsApp') }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>
            </form>
        </div>
    </section>


    <!-- ========================================== -->
    <!-- 10. MODAL VIEWER SERTIFIKASI (Task 5.4) -->
    <!-- ========================================== -->
    <div x-show="certModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs" style="display: none;"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100">
        
        <div class="bg-white rounded-3xl border border-[#E8DFD1] shadow-2xl w-full max-w-lg overflow-hidden" @click.outside="certModalOpen = false">
            <div class="px-6 py-4 bg-[#FAF6EE] border-b border-[#E8DFD1] flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-600"></span>
                    <h3 class="font-serif font-bold text-base text-[#2C1810]" x-text="selectedCert?.name || '{{ __('Dokumen Sertifikasi') }}'"></h3>
                </div>
                <button type="button" @click="certModalOpen = false" class="text-stone-400 hover:text-stone-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="p-6 space-y-4 text-xs">
                <div class="grid grid-cols-2 gap-3">
                    <div class="p-3 bg-[#FAF6EE] rounded-xl border border-[#E8DFD1]">
                        <span class="block text-[10px] font-mono text-stone-400 uppercase">{{ __('Instansi Penerbit') }}</span>
                        <span class="font-bold text-stone-800 text-sm mt-0.5" x-text="selectedCert?.issuer"></span>
                    </div>
                    <div class="p-3 bg-[#FAF6EE] rounded-xl border border-[#E8DFD1]">
                        <span class="block text-[10px] font-mono text-stone-400 uppercase">{{ __('Masa Berlaku') }}</span>
                        <span class="font-bold text-stone-800 text-sm mt-0.5" x-text="selectedCert?.valid_until || '{{ __('Berlaku Seterusnya') }}'"></span>
                    </div>
                </div>

                <div class="p-3 bg-[#FAF6EE] rounded-xl border border-[#E8DFD1]">
                    <span class="block text-[10px] font-mono text-stone-400 uppercase">{{ __('Nomor Registrasi Resmi') }}</span>
                    <span class="font-mono font-bold text-[#5C3317] text-sm mt-0.5" x-text="selectedCert?.cert_number"></span>
                </div>

                <div>
                    <span class="block text-[10px] font-mono text-stone-400 uppercase mb-1">{{ __('Ruang Lingkup Uji Mutu & Standar:') }}</span>
                    <p class="text-stone-600 leading-relaxed" x-text="selectedCert?.description || 'Dokumen legalitas kepatuhan produksi pangan higienis.'"></p>
                </div>

                <template x-if="selectedCert?.document_file">
                    <div class="pt-2">
                        <a :href="'/storage/' + selectedCert?.document_file" target="_blank"
                           class="w-full py-3 bg-[#5C3317] hover:bg-[#2C1810] text-white font-bold rounded-xl transition text-center flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            <span>{{ __('Buka Salinan Scan Dokumen Asli (PDF/JPG)') }}</span>
                        </a>
                    </div>
                </template>
            </div>
        </div>
    </div>

</div>
@endsection
