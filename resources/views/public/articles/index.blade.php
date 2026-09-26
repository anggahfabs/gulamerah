@extends('layouts.app')

@section('title', 'Wawasan & Edukasi Industri Gula Aren — Gumer')
@section('meta-description', 'Kumpulan artikel riset, tips formulasi F&B, dan panduan standar mutu gula aren murni untuk pengusaha makanan dan minuman.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20 space-y-12">

    <div class="text-center max-w-2xl mx-auto space-y-4">
        <span class="text-xs font-bold uppercase tracking-wider text-[#C87D20]">{{ __('Pusat Pengetahuan Komoditas') }}</span>
        <h1 class="font-serif font-black text-3xl sm:text-5xl text-[#2C1810]">{{ __('Wawasan Industri & Edukasi') }}</h1>
        <p class="text-xs sm:text-sm text-stone-600 leading-relaxed">
            {{ __('Panduan teknis, riset keaslian nira, dan tips aplikasi gula aren kristal pada industri kopi, bakery, dan kecap.') }}
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
        @forelse($articles as $art)
            <div class="bg-white rounded-3xl border border-[#E8DFD1] shadow-xs overflow-hidden flex flex-col justify-between hover:border-[#C87D20] transition duration-300 group">
                <div>
                    <div class="aspect-[16/9] bg-stone-100 overflow-hidden border-b border-[#E8DFD1]">
                        @if($art->cover_image)
                            <img src="{{ asset('storage/' . $art->cover_image) }}" alt="{{ $art->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-stone-300 bg-[#FAF6EE]">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                            </div>
                        @endif
                    </div>
                    <div class="p-6 space-y-2">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-[#FAF6EE] text-[#5C3317] border border-[#E8DFD1]">{{ $art->category }}</span>
                        <h3 class="font-serif font-bold text-xl text-[#2C1810] group-hover:text-[#C87D20] transition leading-snug">
                            <a href="{{ route('public.articles.show', $art->slug) }}">{{ $art->title }}</a>
                        </h3>
                        <p class="text-xs text-stone-500 line-clamp-3 leading-relaxed">{{ $art->excerpt ?: strip_tags($art->content) }}</p>
                    </div>
                </div>
                <div class="px-6 pb-5 pt-4 flex items-center justify-between text-[11px] text-stone-400 border-t border-[#E8DFD1]/60">
                    <span>{{ $art->author_name }}</span>
                    <span>{{ $art->created_at->format('d M Y') }}</span>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center text-stone-400">Belum ada artikel edukasi.</div>
        @endforelse
    </div>

    @if($articles->hasPages())
        <div class="p-4 sm:p-5 bg-white rounded-2xl border border-[#E8DFD1]">
            {{ $articles->links() }}
        </div>
    @endif

</div>
@endsection
