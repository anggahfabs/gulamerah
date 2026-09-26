@extends('layouts.app')

@section('title', 'Galeri Fasilitas Pabrik & Kebun Aren — Gumer')
@section('meta-description', 'Dokumentasi visual fasilitas pengolahan higienis pabrik gula aren Gumer, kebun aren lestari di Lebak Banten, dan proses pengemasan steril.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20 space-y-12">

    <div class="text-center max-w-2xl mx-auto space-y-4">
        <span class="text-xs font-bold uppercase tracking-wider text-[#C87D20]">{{ __('Transparansi Operasional') }}</span>
        <h1 class="font-serif font-black text-3xl sm:text-5xl text-[#2C1810]">{{ __('Galeri Fasilitas & Produksi') }}</h1>
        <p class="text-xs sm:text-sm text-stone-600 leading-relaxed">
            {{ __('Menyajikan dokumentasi otentik proses pengolahan dari hulu kebun aren hingga hilir pergudangan siap distribusi.') }}
        </p>
    </div>

    <!-- Category Filter -->
    <div class="flex items-center justify-center gap-2 overflow-x-auto pb-2">
        <a href="{{ route('public.galleries') }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ !request('category') ? 'bg-[#5C3317] text-white shadow-xs' : 'bg-white text-stone-600 border border-[#E8DFD1]' }}">{{ __('Semua Fasilitas') }}</a>
        @foreach(['Kebun Aren', 'Pemrosesan Kristal', 'Pengemasan & Lab', 'Gudang & Pengiriman'] as $cat)
            <a href="{{ route('public.galleries', ['category' => $cat]) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ request('category') === $cat ? 'bg-[#5C3317] text-white shadow-xs' : 'bg-white text-stone-600 border border-[#E8DFD1]' }}">{{ $cat }}</a>
        @endforeach
    </div>

    <!-- Gallery Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 lg:gap-6">
        @forelse($galleries as $gal)
            <div class="bg-white rounded-3xl border border-[#E8DFD1] shadow-xs overflow-hidden group">
                <div class="aspect-video bg-stone-100 overflow-hidden relative border-b border-[#E8DFD1]">
                    <img src="{{ asset('storage/' . $gal->image_path) }}" alt="{{ $gal->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    <div class="absolute top-3 left-3">
                        <span class="px-2.5 py-1 text-[10px] font-bold rounded-lg bg-black/60 backdrop-blur-md text-white border border-white/20">
                            {{ $gal->category }}
                        </span>
                    </div>
                </div>
                <div class="p-5 sm:p-6 space-y-2">
                    <h3 class="font-serif font-bold text-lg text-[#2C1810]">{{ $gal->title }}</h3>
                    <p class="text-xs text-stone-500 leading-relaxed">{{ $gal->caption ?: 'Dokumentasi fasilitas resmi Pabrik Gula Merah Gumer.' }}</p>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center text-stone-400">Belum ada foto dalam kategori ini.</div>
        @endforelse
    </div>

    @if($galleries->hasPages())
        <div class="p-4 bg-white rounded-2xl border border-[#E8DFD1]">
            {{ $galleries->links() }}
        </div>
    @endif

</div>
@endsection
