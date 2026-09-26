@extends('layouts.app')

@section('title', 'Layanan Maklon OEM & Pasokan Industri — Gumer')
@section('meta-description', 'Layanan kontrak pasokan tonase gula aren pabrik, jasa maklon private label kemasan klien, dan suplai rutin horeca.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20 space-y-16">

    <!-- Header -->
    <div class="text-center max-w-2xl mx-auto space-y-4">
        <span class="text-xs font-bold uppercase tracking-wider text-[#C87D20]">{{ __('Mitra Solusi Industri Agro') }}</span>
        <h1 class="font-serif font-black text-3xl sm:text-5xl text-[#2C1810]">{{ __('Layanan Pasokan & Maklon OEM') }}</h1>
        <p class="text-xs sm:text-sm text-stone-600 leading-relaxed">
            {{ __('Menyediakan kepastian suplai komoditas gula aren berkualitas tinggi, formulasi konsisten, dan fleksibilitas kemasan untuk brand dan pabrik Anda.') }}
        </p>
    </div>

    <!-- 3 Core Services -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
        @foreach($services as $srv)
            <div class="p-7 sm:p-8 rounded-3xl bg-white border border-[#E8DFD1] shadow-xs flex flex-col justify-between hover:border-[#C87D20] transition duration-300">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="w-12 h-12 rounded-2xl bg-[#FAF6EE] border border-[#E8DFD1] flex items-center justify-center text-[#5C3317]">
                            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        @if($srv->badge_text)
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-mono font-bold bg-[#FAF6EE] text-[#5C3317] border border-[#E8DFD1]">{{ $srv->badge_text }}</span>
                        @endif
                    </div>

                    <div>
                        <h3 class="font-serif font-bold text-2xl text-[#2C1810]">{{ $srv->title }}</h3>
                        <p class="text-xs text-stone-500 mt-2 leading-relaxed">{{ $srv->description }}</p>
                    </div>

                    @if(!empty($srv->features))
                        <ul class="space-y-2.5 pt-5 mt-1 border-t border-[#E8DFD1]/60 text-xs text-stone-600">
                            @foreach($srv->features as $f)
                                <li class="flex items-start gap-2">
                                    <svg class="w-4 h-4 text-emerald-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span>{{ $f }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>

                <div class="pt-6 mt-auto">
                    <a href="{{ route('public.contact') }}?service={{ urlencode($srv->title) }}"
                       class="w-full py-3 bg-[#5C3317] hover:bg-[#2C1810] text-white text-xs font-bold rounded-xl text-center block transition shadow-xs">
                        Konsultasi Kemitraan Ini
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Maklon Onboarding Workflow -->
    <div class="bg-white rounded-3xl p-8 sm:p-12 lg:p-14 border border-[#E8DFD1] shadow-xs space-y-8">
        <div class="text-center max-w-xl mx-auto space-y-2">
            <span class="text-xs font-bold uppercase tracking-wider text-[#C87D20]">{{ __('Alur Kerja Sama') }}</span>
            <h2 class="font-serif font-bold text-2xl sm:text-3xl text-[#2C1810]">{{ __('4 Langkah Maklon Private Label') }}</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="p-5 sm:p-6 rounded-2xl bg-[#FAF6EE] border border-[#E8DFD1] space-y-2">
                <span class="font-mono font-black text-2xl text-[#C87D20]">01</span>
                <h4 class="font-serif font-bold text-sm text-[#2C1810]">{{ __('Diskusi Spek & Sampel') }}</h4>
                <p class="text-xs text-stone-500 leading-relaxed">{{ __('Menentukan bentuk gula (semut kristal / cair), ukuran mesh, serta mengirimkan sampel uji lab gratis.') }}</p>
            </div>

            <div class="p-5 rounded-2xl bg-[#FAF6EE] border border-[#E8DFD1] space-y-2">
                <span class="font-mono font-black text-2xl text-[#C87D20]">02</span>
                <h4 class="font-serif font-bold text-sm text-[#2C1810]">{{ __('Persetujuan Formulasi') }}</h4>
                <p class="text-xs text-stone-500 leading-relaxed">{{ __('Evaluasi organoleptik dan uji kompatibilitas formula pada lini produksi calon mitra.') }}</p>
            </div>

            <div class="p-5 rounded-2xl bg-[#FAF6EE] border border-[#E8DFD1] space-y-2">
                <span class="font-mono font-black text-2xl text-[#C87D20]">03</span>
                <h4 class="font-serif font-bold text-sm text-[#2C1810]">{{ __('Desain Kemasan & Izin') }}</h4>
                <p class="text-xs text-stone-500 leading-relaxed">{{ __('Penyusunan artwork kemasan standing pouch / sachet brand Anda dengan pencantuman nomor izin resmi.') }}</p>
            </div>

            <div class="p-5 rounded-2xl bg-[#FAF6EE] border border-[#E8DFD1] space-y-2">
                <span class="font-mono font-black text-2xl text-[#C87D20]">04</span>
                <h4 class="font-serif font-bold text-sm text-[#2C1810]">{{ __('Produksi Massal & Kirim') }}</h4>
                <p class="text-xs text-stone-500 leading-relaxed">{{ __('Produksi steril berkala dengan garansi ketersediaan stok dan jadwal pengiriman tepat waktu.') }}</p>
            </div>
        </div>
    </div>

</div>
@endsection
