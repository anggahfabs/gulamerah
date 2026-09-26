<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Gumer — Pabrik Gula Aren & Kelapa Organik Standar Industri')</title>
    <meta name="description" content="@yield('meta-description', 'Pabrik produsen gula aren murni, gula kelapa, dan gula semut kristal organik standar ekspor. Pasokan industri F&B, horeca, dan jasa maklon private label.')">

    <!-- Google Fonts: Plus Jakarta Sans (Standar Nasional Tipografi Digital Indonesia) & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600;1,700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>
<body class="bg-[#FAF6EE] text-[#2C1810] font-sans antialiased selection:bg-[#C87D20] selection:text-white"
      x-data="{
          mobileMenuOpen: false,
          productDropdownOpen: false,
          scrolled: false,
          audienceMode: localStorage.getItem('gumer_audience') || 'b2b',
          setAudience(mode) {
              this.audienceMode = mode;
              localStorage.setItem('gumer_audience', mode);
              window.dispatchEvent(new CustomEvent('audience-changed', { detail: mode }));
          }
      }"
      @scroll.window="scrolled = (window.pageYOffset > 15)"
      @keydown.escape.window="productDropdownOpen = false; mobileMenuOpen = false">

    <!-- Top Announcement Strip -->
    <aside class="bg-[#2C1810] text-[#FAF6EE] text-[11px] py-2 px-4 border-b border-[#5C3317]/50 relative z-50 transition-opacity duration-300">
        <div class="max-w-[1380px] mx-auto flex flex-col sm:flex-row items-center justify-between gap-2 text-center sm:text-left">
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-[#C87D20] text-white font-bold text-[10px] uppercase tracking-wider shadow-2xs">
                    <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                    Suplai Pabrik
                </span>
                <span class="font-medium text-stone-200">{{ __('Kapasitas Pasokan 10+ Ton/Bulan • Uji Lab Sucofindo (MC ≤ 1.2%) • Sertifikasi Halal BPJPH') }}</span>
            </div>
            <div class="flex items-center gap-4 text-[11px] text-stone-300">
                <a href="{{ route('public.certifications') }}" class="hover:text-amber-400 transition underline underline-offset-2">{{ __('Lembar Hasil Uji Lab') }}</a>
                <span class="opacity-30">•</span>
                <a href="{{ route('public.services') }}" class="hover:text-amber-400 transition">{{ __('Jasa Maklon / OEM') }}</a>
                <span class="opacity-30">•</span>
                <a href="{{ route('admin.dashboard') }}" class="hover:text-amber-400 transition">{{ __('Portal Karyawan/Admin') }}</a>
            </div>
        </div>
    </aside>

    <!-- Main Navigation Header with Scroll Blur Effect -->
    <header class="sticky top-0 z-40 transition-all duration-300 ease-in-out border-b"
            :class="scrolled 
                ? 'bg-[#FAF6EE]/85 backdrop-blur-xl border-[#E8DFD1]/90 shadow-[0_10px_30px_-5px_rgba(44,24,16,0.08)] py-0.5' 
                : 'bg-[#FAF6EE]/95 backdrop-blur-md border-[#E8DFD1]/70 py-1'">
        <div class="max-w-[1380px] mx-auto px-4 sm:px-6 xl:px-8">
            <div class="flex items-center justify-between transition-all duration-300"
                 :class="scrolled ? 'h-16 sm:h-[4.25rem]' : 'h-20'">
                
                <!-- Zone 1 (Left): Brand Identity -->
                <a href="{{ route('home') }}" class="flex items-center gap-3.5 group shrink-0">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#5C3317] to-[#2C1810] border border-[#C87D20]/50 flex items-center justify-center text-amber-400 shadow-xs group-hover:scale-105 group-hover:border-[#C87D20] transition duration-200">
                        <svg class="w-5 h-5 text-amber-400" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div>
                        <span class="font-extrabold text-2xl tracking-tight text-[#2C1810] block leading-none">GUMER</span>
                        <span class="text-[9.5px] font-bold uppercase tracking-widest text-[#5C3317] block mt-1">{{ __('Pabrik Gula Aren') }}</span>
                    </div>
                </a>

                <!-- Zone 2 (Center): Perfectly Centered Navigation (mx-auto with equal whitespace left & right) -->
                <nav class="hidden xl:flex items-center gap-5 xl:gap-6 2xl:gap-7 text-xs xl:text-[13px] font-semibold text-[#2C1810] shrink-0 mx-auto px-6">
                        
                        <a href="{{ route('home') }}" 
                           class="py-2 hover:text-[#C87D20] transition relative group {{ request()->routeIs('home') ? 'text-[#C87D20] font-bold' : '' }}">
                            <span>{{ __('Beranda') }}</span>
                            @if(request()->routeIs('home'))
                                <span class="absolute bottom-0 left-0 w-full h-0.5 bg-[#C87D20] rounded-full"></span>
                            @endif
                        </a>

                        <!-- Katalog Produk Dropdown Trigger -->
                        <div class="relative" 
                             @mouseenter="productDropdownOpen = true" 
                             @mouseleave="productDropdownOpen = false"
                             @click.away="productDropdownOpen = false">
                            
                            <button type="button" 
                                    @click="productDropdownOpen = !productDropdownOpen"
                                    class="flex items-center gap-1.5 py-2 hover:text-[#C87D20] transition group focus:outline-none cursor-pointer {{ request()->routeIs('public.products*') ? 'text-[#C87D20] font-bold' : '' }}">
                                <span>{{ __('Katalog Produk') }}</span>
                                <svg class="w-3.5 h-3.5 transition-transform duration-200 text-stone-400 group-hover:text-[#C87D20]"
                                     :class="productDropdownOpen ? 'rotate-180 text-[#C87D20]' : ''" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Dropdown Menu Card -->
                            <div x-show="productDropdownOpen"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 translate-y-2 scale-98"
                                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                 x-transition:leave-end="opacity-0 translate-y-2 scale-98"
                                 class="absolute -left-16 pt-3 w-[620px] z-50"
                                 style="display: none;">
                                
                                <div class="bg-white/95 backdrop-blur-2xl rounded-2xl border border-[#E8DFD1] shadow-[0_20px_60px_-15px_rgba(44,24,16,0.15)] p-5 overflow-hidden">
                                    
                                    <!-- Dropdown Header Bar -->
                                    <div class="flex items-center justify-between pb-3 mb-3 border-b border-[#E8DFD1]/80">
                                        <div class="flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full bg-[#C87D20]"></span>
                                            <span class="text-[11px] font-extrabold uppercase tracking-wider text-[#7A695C]">{{ __('Komoditas Gula Aren & Kelapa Pabrik') }}</span>
                                        </div>
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-[#FAF6EE] text-[#5C3317] border border-[#E8DFD1]">
                                            SNI 01-3743-1995 • Organik
                                        </span>
                                    </div>

                                    <!-- 4 Product Categories (2x2 Grid) -->
                                    <div class="grid grid-cols-2 gap-2.5">
                                        
                                        <!-- Item 1: Gula Semut Aren Kristal -->
                                        <a href="{{ route('public.products') }}?category=gula-semut-aren" 
                                           class="group/item p-3 rounded-xl hover:bg-[#FAF6EE] border border-transparent hover:border-[#E8DFD1] transition flex items-start gap-3">
                                            <div class="w-10 h-10 rounded-lg bg-amber-50 border border-amber-200/60 flex items-center justify-center text-amber-700 shrink-0 group-hover/item:scale-105 group-hover/item:bg-[#C87D20] group-hover/item:text-white transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="flex items-center gap-1.5">
                                                    <span class="text-xs font-bold text-[#2C1810] group-hover/item:text-[#C87D20] transition">Gula Semut Aren</span>
                                                    <span class="text-[9px] font-bold px-1.5 py-0.2 rounded bg-amber-100/80 text-amber-900">Mesh 18</span>
                                                </div>
                                                <p class="text-[11px] text-stone-500 leading-snug mt-1">Kadar air MC ≤ 1.2%, butiran kristal seragam untuk ekspor & industri pangan.</p>
                                            </div>
                                        </a>

                                        <!-- Item 2: Gula Aren Cair (Liquid) -->
                                        <a href="{{ route('public.products') }}?category=gula-aren-cair" 
                                           class="group/item p-3 rounded-xl hover:bg-[#FAF6EE] border border-transparent hover:border-[#E8DFD1] transition flex items-start gap-3">
                                            <div class="w-10 h-10 rounded-lg bg-orange-50 border border-orange-200/60 flex items-center justify-center text-orange-700 shrink-0 group-hover/item:scale-105 group-hover/item:bg-[#8C532B] group-hover/item:text-white transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="flex items-center gap-1.5">
                                                    <span class="text-xs font-bold text-[#2C1810] group-hover/item:text-[#C87D20] transition">Gula Aren Cair</span>
                                                    <span class="text-[9px] font-bold px-1.5 py-0.2 rounded bg-orange-100/80 text-orange-900">75° Brix</span>
                                                </div>
                                                <p class="text-[11px] text-stone-500 leading-snug mt-1">Sirup nira murni barista & horeca, konsistensi stabil dan tidak mengkristal.</p>
                                            </div>
                                        </a>

                                        <!-- Item 3: Gula Aren Cetak Batok -->
                                        <a href="{{ route('public.products') }}?category=gula-aren-cetak" 
                                           class="group/item p-3 rounded-xl hover:bg-[#FAF6EE] border border-transparent hover:border-[#E8DFD1] transition flex items-start gap-3">
                                            <div class="w-10 h-10 rounded-lg bg-stone-100 border border-stone-300/60 flex items-center justify-center text-stone-700 shrink-0 group-hover/item:scale-105 group-hover/item:bg-[#5C3317] group-hover/item:text-white transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="flex items-center gap-1.5">
                                                    <span class="text-xs font-bold text-[#2C1810] group-hover/item:text-[#C87D20] transition">Gula Aren Batok</span>
                                                    <span class="text-[9px] font-bold px-1.5 py-0.2 rounded bg-stone-200/80 text-stone-800">Alami</span>
                                                </div>
                                                <p class="text-[11px] text-stone-500 leading-snug mt-1">Cetak batok kelapa tradisional murni tanpa sulfit, aroma smokey khas enau.</p>
                                            </div>
                                        </a>

                                        <!-- Item 4: Gula Kelapa Cetak Murni -->
                                        <a href="{{ route('public.products') }}?category=gula-kelapa-cetak" 
                                           class="group/item p-3 rounded-xl hover:bg-[#FAF6EE] border border-transparent hover:border-[#E8DFD1] transition flex items-start gap-3">
                                            <div class="w-10 h-10 rounded-lg bg-emerald-50 border border-emerald-200/60 flex items-center justify-center text-emerald-700 shrink-0 group-hover/item:scale-105 group-hover/item:bg-[#1B3B2B] group-hover/item:text-white transition">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="flex items-center gap-1.5">
                                                    <span class="text-xs font-bold text-[#2C1810] group-hover/item:text-[#C87D20] transition">Gula Kelapa Cetak</span>
                                                    <span class="text-[9px] font-bold px-1.5 py-0.2 rounded bg-emerald-100/80 text-emerald-900">Industri</span>
                                                </div>
                                                <p class="text-[11px] text-stone-500 leading-snug mt-1">Bahan baku gurih legit untuk industri kecap, biskuit, dan olahan bumbu masakan.</p>
                                            </div>
                                        </a>
                                    </div>

                                    <!-- Dropdown Footer Action Strip -->
                                    <div class="mt-4 pt-3 border-t border-[#E8DFD1]/80 flex items-center justify-between bg-[#FAF6EE]/80 -mx-5 -mb-5 px-5 py-3 rounded-b-2xl">
                                        <a href="{{ route('public.products') }}" class="text-xs font-bold text-[#C87D20] hover:text-[#5C3317] flex items-center gap-1.5 transition">
                                            <span>{{ __('Lihat Semua Katalog & Spesifikasi Produk') }}</span>
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                        </a>
                                        <a href="{{ route('public.certifications') }}" class="text-[11px] font-semibold text-stone-600 hover:text-stone-900 flex items-center gap-1 transition">
                                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            <span>{{ __('Uji Lab Sucofindo (COA)') }}</span>
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <a href="{{ route('public.services') }}" 
                           class="py-2 hover:text-[#C87D20] transition relative group {{ request()->routeIs('public.services') ? 'text-[#C87D20] font-bold' : '' }}">
                            <span>{{ __('Maklon & Industri') }}</span>
                            @if(request()->routeIs('public.services'))
                                <span class="absolute bottom-0 left-0 w-full h-0.5 bg-[#C87D20] rounded-full"></span>
                            @endif
                        </a>

                        <a href="{{ route('public.certifications') }}" 
                           class="py-2 hover:text-[#C87D20] transition relative group {{ request()->routeIs('public.certifications') ? 'text-[#C87D20] font-bold' : '' }}">
                            <span>{{ __('Standar Mutu') }}</span>
                            @if(request()->routeIs('public.certifications'))
                                <span class="absolute bottom-0 left-0 w-full h-0.5 bg-[#C87D20] rounded-full"></span>
                            @endif
                        </a>

                        <a href="{{ route('public.galleries') }}" 
                           class="py-2 hover:text-[#C87D20] transition relative group {{ request()->routeIs('public.galleries') ? 'text-[#C87D20] font-bold' : '' }}">
                            <span>{{ __('Fasilitas') }}</span>
                            @if(request()->routeIs('public.galleries'))
                                <span class="absolute bottom-0 left-0 w-full h-0.5 bg-[#C87D20] rounded-full"></span>
                            @endif
                        </a>

                        <a href="{{ route('public.articles') }}" 
                           class="py-2 hover:text-[#C87D20] transition relative group {{ request()->routeIs('public.articles*') ? 'text-[#C87D20] font-bold' : '' }}">
                            <span>{{ __('Wawasan') }}</span>
                            @if(request()->routeIs('public.articles*'))
                                <span class="absolute bottom-0 left-0 w-full h-0.5 bg-[#C87D20] rounded-full"></span>
                            @endif
                        </a>

                        <a href="{{ route('public.contact') }}" 
                           class="py-2 hover:text-[#C87D20] transition relative group {{ request()->routeIs('public.contact') ? 'text-[#C87D20] font-bold' : '' }}">
                            <span>{{ __('Kontak') }}</span>
                            @if(request()->routeIs('public.contact'))
                                <span class="absolute bottom-0 left-0 w-full h-0.5 bg-[#C87D20] rounded-full"></span>
                            @endif
                        </a>
                    </nav>

                <!-- Zone 3 (Right): Language Switcher, B2B Switcher & WhatsApp CTA Button -->
                <div class="hidden sm:flex items-center gap-2.5 xl:gap-3 shrink-0 pl-4 lg:pl-6 border-l border-[#E8DFD1]/80">
                    
                    <!-- Language Switcher (ID / EN) -->
                    <div class="p-1 rounded-xl bg-stone-100/90 border border-[#E8DFD1] flex items-center shadow-2xs shrink-0">
                        <a href="{{ route('lang.switch', 'id') }}" 
                           title="Bahasa Indonesia"
                           class="px-2 py-1 text-[11px] font-bold rounded-lg transition-all duration-200 flex items-center gap-1 {{ app()->getLocale() === 'id' ? 'bg-[#5C3317] text-white shadow-xs' : 'text-stone-600 hover:text-stone-900' }}">
                            <span>🇮🇩 ID</span>
                        </a>
                        <a href="{{ route('lang.switch', 'en') }}" 
                           title="English (International Export)"
                           class="px-2 py-1 text-[11px] font-bold rounded-lg transition-all duration-200 flex items-center gap-1 {{ app()->getLocale() === 'en' ? 'bg-[#C87D20] text-white shadow-xs' : 'text-stone-600 hover:text-stone-900' }}">
                            <span>🇬🇧 EN</span>
                        </a>
                    </div>
                    
                    <!-- Global Audience Switcher (B2B vs B2C) -->
                    <div class="p-1 rounded-xl bg-stone-100/90 border border-[#E8DFD1] flex items-center shadow-2xs shrink-0">
                        <button type="button" 
                                @click="setAudience('b2b')"
                                :class="audienceMode === 'b2b' ? 'bg-[#5C3317] text-white shadow-xs' : 'text-stone-600 hover:text-stone-900'"
                                class="px-2.5 xl:px-3 py-1.5 text-[11px] font-bold rounded-lg transition-all duration-200 flex items-center gap-1.5 cursor-pointer">
                            <span class="w-1.5 h-1.5 rounded-full" :class="audienceMode === 'b2b' ? 'bg-amber-400' : 'bg-transparent'"></span>
                            <span>{{ __('B2B Industri') }}</span>
                        </button>
                        <button type="button" 
                                @click="setAudience('b2c')"
                                :class="audienceMode === 'b2c' ? 'bg-[#C87D20] text-white shadow-xs' : 'text-stone-600 hover:text-stone-900'"
                                class="px-2.5 xl:px-3 py-1.5 text-[11px] font-bold rounded-lg transition-all duration-200 flex items-center gap-1.5 cursor-pointer">
                            <span class="w-1.5 h-1.5 rounded-full" :class="audienceMode === 'b2c' ? 'bg-white' : 'bg-transparent'"></span>
                            <span>{{ __('Retail / Cafe') }}</span>
                        </button>
                    </div>

                    @php
                        $salesPhone = \App\Models\Setting::get('whatsapp_sales', '6281234567890');
                        $cleanPhone = preg_replace('/[^0-9]/', '', $salesPhone);
                        if(str_starts_with($cleanPhone, '0')) {
                            $cleanPhone = '62' . substr($cleanPhone, 1);
                        }
                    @endphp

                    <!-- Direct WA Hotline CTA -->
                    <a href="https://wa.me/{{ $cleanPhone }}?text={{ urlencode('Halo Tim Pabrik Gula Merah Gumer, saya ingin berkonsultasi mengenai kebutuhan pasokan gula aren.') }}" 
                       target="_blank"
                       class="inline-flex items-center gap-2 px-3.5 xl:px-4 py-2 bg-[#1B3B2B] hover:bg-[#12271c] text-white text-xs font-bold rounded-xl transition duration-200 shadow-xs hover:shadow-md shrink-0">
                        <svg class="w-4 h-4 fill-current text-emerald-400" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                        <span x-text="audienceMode === 'b2b' ? '{{ __('Minta RFQ') }}' : '{{ __('Pesan via WA') }}'">{{ __('Minta RFQ') }}</span>
                    </a>
                </div>

                <!-- Mobile Hamburger Button -->
                <button type="button" @click="mobileMenuOpen = !mobileMenuOpen" class="xl:hidden p-2 rounded-xl text-stone-700 hover:bg-stone-200/60 focus:outline-none transition cursor-pointer">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu Drawer -->
        <div x-show="mobileMenuOpen" class="xl:hidden border-t border-[#E8DFD1] bg-[#FAF6EE]/95 backdrop-blur-xl px-5 py-6 space-y-4" style="display: none;"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2">
            
            <!-- Mobile Language Switcher (ID / EN) -->
            <div class="p-1 rounded-xl bg-stone-100 border border-[#E8DFD1] grid grid-cols-2 text-center text-xs font-bold shadow-2xs">
                <a href="{{ route('lang.switch', 'id') }}" class="py-2 rounded-lg transition flex items-center justify-center gap-1.5 {{ app()->getLocale() === 'id' ? 'bg-[#5C3317] text-white shadow-xs' : 'text-stone-600' }}">
                    <span>🇮🇩 Bahasa Indonesia</span>
                </a>
                <a href="{{ route('lang.switch', 'en') }}" class="py-2 rounded-lg transition flex items-center justify-center gap-1.5 {{ app()->getLocale() === 'en' ? 'bg-[#C87D20] text-white shadow-xs' : 'text-stone-600' }}">
                    <span>🇬🇧 English (Export)</span>
                </a>
            </div>

            <!-- Mobile Audience Switcher -->
            <div class="p-1 rounded-xl bg-white border border-[#E8DFD1] grid grid-cols-2 text-center">
                <button type="button" @click="setAudience('b2b')" :class="audienceMode === 'b2b' ? 'bg-[#5C3317] text-white' : 'text-stone-600'" class="py-2 text-xs font-bold rounded-lg transition">{{ __('B2B Industri') }}</button>
                <button type="button" @click="setAudience('b2c')" :class="audienceMode === 'b2c' ? 'bg-[#C87D20] text-white' : 'text-stone-600'" class="py-2 text-xs font-bold rounded-lg transition">{{ __('Retail / Eceran') }}</button>
            </div>

            <div class="flex flex-col space-y-2 text-sm font-bold text-[#2C1810]">
                <a href="{{ route('home') }}" class="py-1.5 hover:text-[#C87D20] transition">{{ __("Beranda") }}</a>
                
                <!-- Mobile Catalog Accordion -->
                <div x-data="{ mobileCatOpen: false }" class="border-y border-[#E8DFD1]/70 py-2">
                    <button type="button" @click="mobileCatOpen = !mobileCatOpen" class="w-full flex items-center justify-between py-1 text-sm font-bold text-[#2C1810] focus:outline-none">
                        <span>{{ __("Katalog Produk") }}</span>
                        <svg class="w-4 h-4 text-stone-400 transition-transform duration-200" :class="mobileCatOpen ? 'rotate-180 text-[#C87D20]' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="mobileCatOpen" class="pl-3 pt-2 space-y-2 text-xs font-medium text-stone-600" style="display: none;">
                        <a href="{{ route('public.products') }}?category=gula-semut-aren" class="block py-1 hover:text-[#C87D20]">Gula Semut Aren Kristal (Mesh 18)</a>
                        <a href="{{ route('public.products') }}?category=gula-aren-cair" class="block py-1 hover:text-[#C87D20]">Gula Aren Cair (75° Brix)</a>
                        <a href="{{ route('public.products') }}?category=gula-aren-cetak" class="block py-1 hover:text-[#C87D20]">Gula Aren Cetak Batok Murni</a>
                        <a href="{{ route('public.products') }}?category=gula-kelapa-cetak" class="block py-1 hover:text-[#C87D20]">Gula Kelapa Cetak Asli</a>
                        <a href="{{ route('public.products') }}" class="block py-1 font-bold text-[#C87D20]">Lihat Semua Katalog &rarr;</a>
                    </div>
                </div>

                <a href="{{ route('public.services') }}" class="py-1.5 hover:text-[#C87D20] transition">Maklon & Suplai Industri</a>
                <a href="{{ route('public.certifications') }}" class="py-1.5 hover:text-[#C87D20] transition">Standar Mutu & Lab</a>
                <a href="{{ route('public.galleries') }}" class="py-1.5 hover:text-[#C87D20] transition">{{ __("Fasilitas Pabrik") }}</a>
                <a href="{{ route('public.articles') }}" class="py-1.5 hover:text-[#C87D20] transition">Wawasan Industri</a>
                <a href="{{ route('public.contact') }}" class="py-1.5 hover:text-[#C87D20] transition">Kontak & Lokasi</a>
            </div>

            <div class="pt-3 border-t border-[#E8DFD1]">
                <a href="https://wa.me/{{ $cleanPhone }}" target="_blank" class="w-full py-3 bg-[#1B3B2B] text-white text-xs font-bold rounded-xl flex items-center justify-center gap-2 shadow-xs">
                    <svg class="w-4 h-4 fill-current text-emerald-400" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                    <span>Hubungi Sales WhatsApp</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Dynamic Content Slot -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Earthy Agro-Industrial Footer -->
    <footer class="bg-[#2C1810] text-[#FAF6EE] pt-16 pb-12 border-t-4 border-[#C87D20]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 pb-12 border-b border-white/10">
                
                <!-- Col 1: Profile & Credentials (2 cols) -->
                <div class="lg:col-span-2 space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-[#5C3317] border border-[#C87D20] flex items-center justify-center text-white">
                            <svg class="w-5 h-5 text-amber-400" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </div>
                        <div>
                            <span class="font-extrabold text-2xl text-white tracking-tight">GUMER</span>
                            <span class="text-[10px] font-bold uppercase tracking-widest text-amber-400/90 block">Pabrik Gula Aren Organik</span>
                        </div>
                    </div>

                    <p class="text-xs text-stone-300 leading-relaxed max-w-sm">
                        Produsen dan eksportir gula aren murni, gula semut kristal, dan gula kelapa alami Indonesia. Berdedikasi menjaga konsistensi mutu F&B industri modern lewat kendali kadar air presisi dan higienitas pabrik bersertifikasi.
                    </p>

                    <!-- Certification Pills -->
                    <div class="flex flex-wrap items-center gap-2 pt-2">
                        <span class="px-2.5 py-1 rounded-md bg-white/10 text-[10px] font-mono text-amber-300 border border-white/10">Halal ID3311000...</span>
                        <span class="px-2.5 py-1 rounded-md bg-white/10 text-[10px] font-mono text-amber-300 border border-white/10">P-IRT No. 2093...</span>
                        <span class="px-2.5 py-1 rounded-md bg-white/10 text-[10px] font-mono text-amber-300 border border-white/10">Sucofindo Lab Tested</span>
                    </div>
                </div>

                <!-- Col 2: Navigation Links -->
                <div>
                    <h4 class="font-bold text-sm text-white uppercase tracking-wider mb-4 border-l-2 border-[#C87D20] pl-2.5">Katalog & Layanan</h4>
                    <ul class="space-y-2.5 text-xs text-stone-300">
                        <li><a href="{{ route('public.products') }}?category=gula-semut-aren" class="hover:text-amber-400 transition">Gula Semut Kristal Organik</a></li>
                        <li><a href="{{ route('public.products') }}?category=gula-aren-cair" class="hover:text-amber-400 transition">Gula Aren Cair (Brix 78°)</a></li>
                        <li><a href="{{ route('public.products') }}?category=gula-aren-cetak" class="hover:text-amber-400 transition">Gula Aren Batok Cetak</a></li>
                        <li><a href="{{ route('public.services') }}" class="hover:text-amber-400 transition">Kontrak Suplai Pabrik & Cafe</a></li>
                        <li><a href="{{ route('public.services') }}" class="hover:text-amber-400 transition">Jasa Maklon OEM Kemasan Klien</a></li>
                    </ul>
                </div>

                <!-- Col 3: Operational & Factory Address -->
                <div>
                    <h4 class="font-bold text-sm text-white uppercase tracking-wider mb-4 border-l-2 border-[#C87D20] pl-2.5">Fasilitas Pabrik</h4>
                    <div class="space-y-3 text-xs text-stone-300">
                        <div>
                            <span class="block font-semibold text-white">Alamat Pabrik Utama:</span>
                            <span class="text-stone-400 leading-relaxed">{{ \App\Models\Setting::get('factory_address', 'Kawasan Agroindustri Aren, Lebak, Banten') }}</span>
                        </div>
                        <div>
                            <span class="block font-semibold text-white">Pusat Distribusi & Logistik:</span>
                            <span class="text-stone-400 leading-relaxed">{{ \App\Models\Setting::get('warehouse_address', 'Pergudangan Cikupa, Tangerang') }}</span>
                        </div>
                        <div>
                            <span class="block font-semibold text-white">Jam Operasional:</span>
                            <span class="text-stone-400">{{ \App\Models\Setting::get('operating_hours', 'Senin - Sabtu: 08.00 - 17.00 WIB') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Col 4: Newsletter Subscriber Form -->
                <div x-data="{
                    email: '',
                    loading: false,
                    submitted: false,
                    subscribe() {
                        if (!this.email) return;
                        this.loading = true;
                        fetch('{{ route('public.subscribe') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ email: this.email })
                        })
                        .then(res => res.json())
                        .then(data => {
                            this.loading = false;
                            this.submitted = true;
                            this.email = '';
                            window.Toast.fire({
                                icon: 'success',
                                title: data.message || 'Berhasil berlangganan!'
                            });
                        })
                        .catch(() => {
                            this.loading = false;
                            window.Toast.fire({
                                icon: 'error',
                                title: 'Gagal berlangganan. Coba lagi nanti.'
                            });
                        });
                    }
                }">
                    <h4 class="font-bold text-sm text-white uppercase tracking-wider mb-4 border-l-2 border-[#C87D20] pl-2.5">Update Komoditas</h4>
                    <p class="text-xs text-stone-300 leading-relaxed mb-3">Dapatkan pembaruan kuota panen nira, tren harga komoditas gula aren, dan penawaran B2B.</p>
                    
                    <form @submit.prevent="subscribe()" class="space-y-2">
                        <input type="email" x-model="email" required placeholder="Alamat email purchasing/Anda..."
                               class="w-full px-3.5 py-2.5 rounded-xl bg-white/10 border border-white/20 text-xs text-white placeholder-stone-400 focus:outline-none focus:ring-2 focus:ring-amber-500">
                        <button type="submit" :disabled="loading" 
                                class="w-full py-2.5 bg-[#C87D20] hover:bg-[#a96615] text-white text-xs font-bold rounded-xl transition shadow-xs flex items-center justify-center gap-2 cursor-pointer">
                            <span x-text="loading ? 'Memproses...' : 'Daftar Kabar Pasokan'">Daftar Kabar Pasokan</span>
                        </button>
                    </form>
                </div>

            </div>

            <!-- Bottom Copyright & Compliance Strip -->
            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-[11px] text-stone-400">
                <p>&copy; {{ date('Y') }} Gumer — Modern Brown Sugar Factory. {{ __('Hak Cipta Dilindungi Undang-Undang.') }}</p>
                <div class="flex items-center gap-4">
                    <span>Standar Mutu SNI & Ekspor</span>
                    <span>•</span>
                    <span>100% Nira Alami Tanpa Bahan Kimia Sulfir</span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Floating WhatsApp Action Widget -->
    <aside class="fixed bottom-6 right-6 z-50 flex items-center gap-2">
        <a href="https://wa.me/{{ $cleanPhone }}?text={{ urlencode('Halo Sales Pabrik Gumer, saya ingin berkonsultasi mengenai spesifikasi produk dan penawaran pasokan.') }}" 
           target="_blank" 
           class="group flex items-center gap-3 pl-4 pr-3 py-3 rounded-full bg-[#1B3B2B] hover:bg-[#12271c] text-white border-2 border-emerald-500/30 shadow-2xl transition duration-300 hover:scale-105">
            <div class="text-left hidden sm:block">
                <span class="block text-[10px] text-emerald-300 font-bold uppercase tracking-wider">Hotline Pabrik</span>
                <span class="block text-xs font-bold leading-tight">Konsultasi Sales</span>
            </div>
            <div class="w-10 h-10 rounded-full bg-emerald-600 flex items-center justify-center text-white shadow-xs group-hover:rotate-12 transition">
                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
            </div>
        </a>
    </aside>

    <!-- Global SweetAlert Flash Handler -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            @if(session('success'))
                window.Toast.fire({
                    icon: 'success',
                    title: '{{ session('success') }}'
                });
            @endif

            @if(session('error'))
                window.Toast.fire({
                    icon: 'error',
                    title: '{{ session('error') }}'
                });
            @endif
        });
    </script>

    @stack('scripts')
</body>
</html>
