@extends('layouts.app')

@section('title', $article->title . ' — Edukasi Gumer')
@section('meta-description', $article->excerpt)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20 space-y-10">

    <div class="flex items-center gap-2 text-xs text-stone-500">
        <a href="{{ route('home') }}" class="hover:text-[#5C3317]">Beranda</a>
        <span>/</span>
        <a href="{{ route('public.articles') }}" class="hover:text-[#5C3317]">Wawasan Industri</a>
        <span>/</span>
        <span class="font-bold text-[#5C3317]">{{ $article->title }}</span>
    </div>

    <div class="space-y-5">
        <span class="px-3 py-1 rounded-full text-xs font-bold bg-[#FAF6EE] text-[#5C3317] border border-[#E8DFD1]">{{ $article->category }}</span>
        <h1 class="font-serif font-black text-3xl sm:text-5xl text-[#2C1810] leading-tight">{{ $article->title }}</h1>
        <div class="flex items-center gap-4 text-xs text-stone-500 pt-2 border-b border-[#E8DFD1] pb-4">
            <span>Ditulis oleh: <strong class="text-stone-800">{{ $article->author_name }}</strong></span>
            <span>•</span>
            <span>{{ $article->created_at->format('d F Y') }}</span>
            <span>•</span>
            <span>{{ $article->views_count }} Kali Dibaca</span>
        </div>
    </div>

    @if($article->cover_image)
        <div class="aspect-[16/9] rounded-3xl overflow-hidden bg-stone-100 border border-[#E8DFD1]">
            <img src="{{ asset('storage/' . $article->cover_image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
        </div>
    @endif

    <!-- Content -->
    <div class="prose max-w-none text-stone-800 text-sm sm:text-[15px] leading-relaxed font-sans whitespace-pre-line space-y-4">
        {{ $article->content }}
    </div>

    <!-- Related Articles -->
    @if($relatedArticles->isNotEmpty())
        <div class="pt-14 border-t border-[#E8DFD1] space-y-6">
            <h3 class="font-serif font-bold text-2xl text-[#2C1810]">Artikel Edukasi Terkait</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                @foreach($relatedArticles as $rel)
                    <a href="{{ route('public.articles.show', $rel->slug) }}" class="p-5 rounded-2xl bg-white border border-[#E8DFD1] hover:border-[#C87D20] transition group block">
                        <span class="text-[10px] font-bold text-[#C87D20] uppercase">{{ $rel->category }}</span>
                        <h4 class="font-serif font-bold text-sm text-[#2C1810] group-hover:text-[#C87D20] mt-1 line-clamp-2">{{ $rel->title }}</h4>
                        <span class="text-[10px] text-stone-400 mt-2 block">{{ $rel->created_at->format('d M Y') }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

</div>
@endsection
