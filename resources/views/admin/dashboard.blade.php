@extends('layouts.admin')

@section('title', 'Dashboard Overview')
@section('header-title', 'Ringkasan Dashboard')
@section('header-subtitle', 'Pantau aktivitas katalog, penawaran B2B, dan leads pabrik gula')

@section('content')
<div class="space-y-8">

    <!-- Stat Cards Bento Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <!-- Stat 1: Produk -->
        <div class="bg-white p-6 rounded-2xl border border-[#E8DFD1] shadow-xs relative overflow-hidden gumer-card-hover">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-stone-500">Katalog Produk</span>
                <div class="w-10 h-10 rounded-xl bg-[#FAF6EE] text-[#5C3317] flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
                <span class="font-serif font-bold text-3xl text-[#2C1810]">{{ $stats['products_count'] }}</span>
                <span class="text-xs text-stone-500">Produk</span>
            </div>
            <div class="mt-2 flex items-center gap-1.5 text-xs text-emerald-700 font-medium">
                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                <span>{{ $stats['products_active'] }} Produk Aktif di Web</span>
            </div>
        </div>

        <!-- Stat 2: Inquiries RFQ -->
        <div class="bg-white p-6 rounded-2xl border border-[#E8DFD1] shadow-xs relative overflow-hidden gumer-card-hover">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-stone-500">Inquiry & RFQ B2B</span>
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-[#C87D20] flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                </div>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
                <span class="font-serif font-bold text-3xl text-[#2C1810]">{{ $stats['inquiries_count'] }}</span>
                <span class="text-xs text-stone-500">Total Masuk</span>
            </div>
            <div class="mt-2 flex items-center gap-1.5 text-xs {{ $stats['inquiries_new'] > 0 ? 'text-amber-800 font-bold' : 'text-stone-500' }}">
                @if($stats['inquiries_new'] > 0)
                    <span class="px-2 py-0.5 rounded-full bg-amber-500 text-[#2C1810] text-[10px] font-bold animate-pulse">{{ $stats['inquiries_new'] }} Baru</span>
                    <span>Menunggu Tindak Lanjut</span>
                @else
                    <span>Semua sudah ditindaklanjuti</span>
                @endif
            </div>
        </div>

        <!-- Stat 3: Newsletter Subscribers -->
        <div class="bg-white p-6 rounded-2xl border border-[#E8DFD1] shadow-xs relative overflow-hidden gumer-card-hover">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-stone-500">Leads Komoditas</span>
                <div class="w-10 h-10 rounded-xl bg-stone-100 text-stone-700 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                </div>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
                <span class="font-serif font-bold text-3xl text-[#2C1810]">{{ $stats['subscribers_count'] }}</span>
                <span class="text-xs text-stone-500">Subscribers</span>
            </div>
            <p class="mt-2 text-xs text-stone-500">Update harga komoditas nira</p>
        </div>

        <!-- Stat 4: Legalitas & Uji Lab -->
        <div class="bg-white p-6 rounded-2xl border border-[#E8DFD1] shadow-xs relative overflow-hidden gumer-card-hover">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-stone-500">Sertifikasi & Lab</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-800 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                </div>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
                <span class="font-serif font-bold text-3xl text-[#2C1810]">{{ $stats['certifications_count'] }}</span>
                <span class="text-xs text-stone-500">Dokumen</span>
            </div>
            <p class="mt-2 text-xs text-emerald-700 font-medium">Halal, BPOM, Sucofindo, Organik</p>
        </div>
    </div>

    <!-- Quick Action Bar -->
    <div class="bg-gradient-to-r from-[#5C3317] to-[#2C1810] rounded-2xl p-6 text-white flex flex-col md:flex-row items-center justify-between gap-4 shadow-md">
        <div>
            <h2 class="font-serif font-bold text-lg">Aksi Cepat Manajemen Pabrik</h2>
            <p class="text-xs text-stone-300 mt-1">Perbarui stok tonase, tambah varian kemasan baru, atau hubungi calon buyer industri.</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('admin.products.create') }}" class="px-4 py-2.5 rounded-xl bg-[#C87D20] hover:bg-amber-600 text-white font-semibold text-xs transition flex items-center gap-2 shadow-xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>Tambah Produk Baru</span>
            </a>
            <a href="{{ route('admin.inquiries.index') }}" class="px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-semibold text-xs transition flex items-center gap-2 border border-white/10">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                <span>Buka Kotak Masuk RFQ</span>
            </a>
            <a href="{{ route('admin.settings.index') }}" class="px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-white font-semibold text-xs transition flex items-center gap-2 border border-white/10">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
                <span>Edit Kontak & Hotline</span>
            </a>
        </div>
    </div>

    <!-- 2 Column Section: Latest Inquiries & Products -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left 2 Cols: Latest RFQ Inquiries -->
        <div class="lg:col-span-2 bg-white rounded-2xl border border-[#E8DFD1] p-6 shadow-xs">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="font-serif font-bold text-lg text-[#2C1810]">Permintaan Penawaran (RFQ) Terbaru</h2>
                    <p class="text-xs text-stone-500">Leads calon buyer B2B industri & permintaan sample</p>
                </div>
                <a href="{{ route('admin.inquiries.index') }}" class="text-xs font-bold text-[#C87D20] hover:text-[#5C3317] transition flex items-center gap-1">
                    <span>Lihat Semua</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>

            @if($recentInquiries->isEmpty())
                <div class="py-12 text-center text-stone-400">
                    <svg class="w-12 h-12 mx-auto text-stone-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                    <p class="text-sm font-medium">Belum ada pesan RFQ masuk.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="border-b border-[#E8DFD1] text-[11px] font-bold uppercase tracking-wider text-stone-400">
                                <th class="pb-3">Pengirim / Usaha</th>
                                <th class="pb-3">Kebutuhan</th>
                                <th class="pb-3">Estimasi Volume</th>
                                <th class="pb-3">Status</th>
                                <th class="pb-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#E8DFD1]/60">
                            @foreach($recentInquiries as $inq)
                                <tr class="hover:bg-[#FAF6EE]/50 transition">
                                    <td class="py-3.5 pr-3">
                                        <div class="font-semibold text-[#2C1810]">{{ $inq->full_name }}</div>
                                        <div class="text-xs text-stone-500">{{ $inq->company_name ?: 'Perorangan / UMKM' }}</div>
                                    </td>
                                    <td class="py-3.5 px-3">
                                        <span class="inline-block px-2.5 py-1 rounded-md text-[11px] font-medium bg-stone-100 text-stone-800">
                                            {{ $inq->inquiry_type }}
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-3 text-xs font-mono font-medium text-stone-700">
                                        {{ $inq->estimated_volume ?: '-' }}
                                    </td>
                                    <td class="py-3.5 px-3">
                                        @if($inq->status === 'baru')
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">Baru</span>
                                        @elseif($inq->status === 'diproses')
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800">Diproses</span>
                                        @elseif($inq->status === 'selesai')
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">Selesai</span>
                                        @else
                                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-stone-100 text-stone-600">Arsip</span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 pl-3 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            @php
                                                $waPhone = preg_replace('/[^0-9]/', '', $inq->phone_number);
                                                if (str_starts_with($waPhone, '0')) {
                                                    $waPhone = '62' . substr($waPhone, 1);
                                                }
                                                $waText = urlencode("Halo Bapak/Ibu {$inq->full_name} dari {$inq->company_name}, terima kasih telah menghubungi Gumer Pabrik Gula Merah. Menindaklanjuti permintaan penawaran Anda...");
                                            @endphp
                                            <a href="https://wa.me/{{ $waPhone }}?text={{ $waText }}" target="_blank" title="Balas via WhatsApp" class="p-1.5 rounded-lg bg-emerald-50 text-emerald-700 hover:bg-emerald-100 transition">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                            </a>
                                            <a href="{{ route('admin.inquiries.show', $inq->id) }}" class="p-1.5 rounded-lg bg-stone-100 text-stone-700 hover:bg-stone-200 transition" title="Detail Pesan">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Right 1 Col: Quick Products Overview -->
        <div class="bg-white rounded-2xl border border-[#E8DFD1] p-6 shadow-xs flex flex-col justify-between">
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-serif font-bold text-lg text-[#2C1810]">Varian Produk</h2>
                    <a href="{{ route('admin.products.index') }}" class="text-xs font-bold text-[#C87D20] hover:text-[#5C3317] transition">Semua</a>
                </div>

                <div class="space-y-3.5">
                    @foreach($recentProducts as $prod)
                        <div class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-[#FAF6EE] transition border border-transparent hover:border-[#E8DFD1]">
                            <div class="w-12 h-12 rounded-lg bg-stone-100 flex items-center justify-center font-bold text-[#5C3317] overflow-hidden border border-[#E8DFD1] shrink-0">
                                @if($prod->thumbnail)
                                    <img src="{{ asset('storage/' . $prod->thumbnail) }}" alt="{{ $prod->name }}" class="w-full h-full object-cover">
                                @else
                                    <span class="text-xs">GUMER</span>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <h3 class="text-xs font-bold text-[#2C1810] truncate">{{ $prod->name }}</h3>
                                <p class="text-[11px] text-stone-500 truncate">{{ $prod->category->name ?? 'Gula Murni' }}</p>
                                <span class="inline-block text-[10px] font-mono text-[#C87D20] font-semibold mt-0.5">
                                    {{ $prod->raw_material }} • {{ $prod->product_form }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-6 pt-4 border-t border-[#E8DFD1] text-xs text-stone-500 text-center">
                <span>Terhubung dengan WhatsApp Hotline Sales Pabrik</span>
            </div>
        </div>

    </div>

</div>
@endsection
