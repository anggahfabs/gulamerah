@extends('layouts.admin')

@section('title', 'Kotak Masuk RFQ & Penawaran B2B - Gumer')
@section('header-title', 'Permintaan Penawaran & RFQ B2B')
@section('header-subtitle', 'Kelola inquiry pasokan industri, maklon OEM gula aren, dan permintaan sampel dari klien B2B.')

@section('content')
<div class="space-y-6">

    <!-- Status Stat Tabs -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
        @php
            $currentStatus = request('status', 'semua');
            $statTabs = [
                'semua' => ['label' => 'Semua RFQ', 'count' => $counts['total'], 'color' => 'text-stone-700 bg-stone-100'],
                'baru' => ['label' => 'Baru Masuk', 'count' => $counts['baru'], 'color' => 'text-amber-700 bg-amber-100'],
                'diproses' => ['label' => 'Sedang Diproses', 'count' => $counts['diproses'], 'color' => 'text-blue-700 bg-blue-100'],
                'selesai' => ['label' => 'Selesai / Deal', 'count' => $counts['selesai'], 'color' => 'text-emerald-700 bg-emerald-100'],
                'arsip' => ['label' => 'Diarsipkan', 'count' => $counts['arsip'], 'color' => 'text-stone-500 bg-stone-100'],
            ];
        @endphp

        @foreach($statTabs as $key => $tab)
            <a href="{{ route('admin.inquiries.index', array_merge(request()->except('page'), ['status' => $key])) }}" 
               class="p-4 rounded-2xl border transition flex items-center justify-between {{ $currentStatus === $key ? 'border-[#C87D20] bg-white ring-2 ring-[#C87D20]/20 shadow-xs' : 'border-[#E8DFD1] bg-white/70 hover:bg-white' }}">
                <div>
                    <span class="block text-[11px] font-bold uppercase tracking-wider text-stone-500">{{ $tab['label'] }}</span>
                    <span class="block font-serif text-2xl font-bold text-[#2C1810] mt-0.5">{{ $tab['count'] }}</span>
                </div>
                <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $tab['color'] }}">{{ $tab['count'] }}</span>
            </a>
        @endforeach
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white p-4 rounded-2xl border border-[#E8DFD1] shadow-xs flex flex-col sm:flex-row items-center justify-between gap-3">
        <form method="GET" action="{{ route('admin.inquiries.index') }}" class="flex items-center gap-3 w-full sm:w-auto flex-1 max-w-md">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <div class="relative w-full">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, perusahaan, nomor HP, email..."
                       class="w-full pl-10 pr-4 py-2 text-xs rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/40 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
                <svg class="w-4 h-4 text-stone-400 absolute left-3.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <button type="submit" class="px-3.5 py-2 text-xs font-semibold bg-[#FAF6EE] text-[#5C3317] border border-[#E8DFD1] rounded-xl hover:bg-stone-200 transition">Cari</button>
            @if(request('search'))
                <a href="{{ route('admin.inquiries.index', ['status' => request('status', 'semua')]) }}" class="text-xs text-stone-500 hover:text-stone-800 underline">Reset</a>
            @endif
        </form>
        <span class="text-xs text-stone-500 font-medium">Menampilkan {{ $inquiries->total() }} total permintaan</span>
    </div>

    <!-- Inquiries Table Card -->
    <div class="bg-white rounded-2xl border border-[#E8DFD1] shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-[#FAF6EE] text-[#5C3317] uppercase text-[11px] font-bold tracking-wider border-b border-[#E8DFD1]">
                    <tr>
                        <th class="px-6 py-4">Tgl & ID</th>
                        <th class="px-6 py-4">Calon Pembeli / Perusahaan</th>
                        <th class="px-6 py-4">Kontak Cepat</th>
                        <th class="px-6 py-4">Produk & Estimasi Volume</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E8DFD1]">
                    @forelse($inquiries as $inq)
                        <tr class="hover:bg-stone-50/80 transition {{ $inq->status === 'baru' ? 'bg-amber-50/20' : '' }}">
                            <!-- Date & Code -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-mono font-bold text-stone-900">#RFQ-{{ str_pad($inq->id, 4, '0', STR_PAD_LEFT) }}</div>
                                <div class="text-[11px] text-stone-400 mt-0.5">{{ $inq->created_at->format('d M Y, H:i') }}</div>
                            </td>

                            <!-- Company & Buyer -->
                            <td class="px-6 py-4">
                                <div class="font-bold text-stone-900 text-sm">{{ $inq->company_name ?: $inq->full_name }}</div>
                                <div class="text-[11px] text-stone-500 flex items-center gap-1.5 mt-0.5">
                                    <span>PIC: {{ $inq->full_name }}</span>
                                    @if($inq->inquiry_type)
                                        <span class="px-1.5 py-0.5 rounded bg-stone-100 text-stone-600 font-medium">{{ $inq->inquiry_type }}</span>
                                    @endif
                                </div>
                            </td>

                            <!-- Contacts -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $cleanPhone = preg_replace('/[^0-9]/', '', $inq->phone_number);
                                    if(str_starts_with($cleanPhone, '0')) {
                                        $cleanPhone = '62' . substr($cleanPhone, 1);
                                    }
                                @endphp
                                <div class="flex flex-col gap-1">
                                    <a href="https://wa.me/{{ $cleanPhone }}?text=Halo%20{{ urlencode($inq->full_name) }},%20kami%20dari%20Pabrik%20Gula%20Merah%20Gumer%20mengenai%20RFQ%20nomor%20%23RFQ-{{ str_pad($inq->id, 4, '0', STR_PAD_LEFT) }}" 
                                       target="_blank" class="inline-flex items-center gap-1.5 font-bold text-emerald-700 hover:text-emerald-900">
                                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                                        <span>{{ $inq->phone_number }}</span>
                                    </a>
                                    @if($inq->email)
                                        <a href="mailto:{{ $inq->email }}" class="text-[11px] text-stone-500 hover:text-stone-800 underline truncate max-w-[180px]">
                                            {{ $inq->email }}
                                        </a>
                                    @endif
                                </div>
                            </td>

                            <!-- Product & Volume -->
                            <td class="px-6 py-4">
                                <div class="font-semibold text-stone-800">{{ $inq->product_interest ?: 'Permintaan Khusus / Konsultasi' }}</div>
                                <div class="text-[11px] text-[#C87D20] font-bold mt-0.5">
                                    {{ $inq->estimated_volume ? 'Est. ' . $inq->estimated_volume : 'Volume Belum Ditentukan' }}
                                </div>
                            </td>

                            <!-- Status Badge -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($inq->status === 'baru')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[11px] font-bold rounded-full bg-amber-100 text-amber-800 border border-amber-300">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                        Baru Masuk
                                    </span>
                                @elseif($inq->status === 'diproses')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[11px] font-bold rounded-full bg-blue-100 text-blue-800 border border-blue-200">
                                        Diproses
                                    </span>
                                @elseif($inq->status === 'selesai')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[11px] font-bold rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        Selesai / Deal
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[11px] font-bold rounded-full bg-stone-100 text-stone-600 border border-stone-200">
                                        Arsip
                                    </span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <a href="{{ route('admin.inquiries.show', $inq->id) }}" 
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#5C3317] hover:bg-[#2C1810] text-white text-xs font-bold rounded-lg transition shadow-xs">
                                    <span>Tindak Lanjut</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-stone-400">
                                <svg class="w-12 h-12 mx-auto text-stone-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                <p class="font-medium text-stone-600">Tidak ada data permintaan RFQ dalam kategori ini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($inquiries->hasPages())
            <div class="p-4 border-t border-[#E8DFD1]">
                {{ $inquiries->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
