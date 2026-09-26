@extends('layouts.admin')

@section('title', 'Detail RFQ #RFQ-' . str_pad($inquiry->id, 4, '0', STR_PAD_LEFT) . ' - Gumer')
@section('header-title', 'Detail Permintaan Pasokan')
@section('header-subtitle', 'Informasi spesifikasi pesanan, kontak PIC, dan riwayat tindak lanjut tim sales.')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <!-- Back Button -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.inquiries.index') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-stone-500 hover:text-[#5C3317] transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span>Kembali ke Kotak Masuk RFQ</span>
        </a>

        <div class="flex items-center gap-2">
            <span class="text-xs text-stone-400 font-mono">Kode Referensi:</span>
            <span class="px-2.5 py-1 font-mono font-bold text-xs bg-[#FAF6EE] text-[#5C3317] border border-[#E8DFD1] rounded-lg">
                #RFQ-{{ str_pad($inquiry->id, 4, '0', STR_PAD_LEFT) }}
            </span>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Left 2 Cols: Buyer & Specs Details -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Lead Profile Card -->
            <div class="bg-white p-6 rounded-2xl border border-[#E8DFD1] shadow-xs space-y-5">
                <div class="flex items-center justify-between border-b border-[#E8DFD1] pb-4">
                    <div>
                        <span class="text-[11px] font-bold uppercase tracking-wider text-stone-400">Profil Pemohon & Instansi</span>
                        <h2 class="font-serif font-bold text-xl text-[#2C1810] mt-0.5">{{ $inquiry->company_name ?: $inquiry->full_name }}</h2>
                    </div>

                    @php
                        $cleanPhone = preg_replace('/[^0-9]/', '', $inquiry->phone_number);
                        if(str_starts_with($cleanPhone, '0')) {
                            $cleanPhone = '62' . substr($cleanPhone, 1);
                        }
                        $waText = urlencode("Halo Bapak/Ibu " . $inquiry->full_name . " (" . ($inquiry->company_name ?: 'Mitra Industri') . "), kami dari Tim Sales & B2B Pabrik Gula Merah Gumer ingin menindaklanjuti permintaan penawaran pasokan (RFQ #" . str_pad($inquiry->id, 4, '0', STR_PAD_LEFT) . ") untuk produk " . ($inquiry->product_interest ?: 'Gula Aren') . ". Apakah spesifikasi dan jadwal kirim sampel dapat kita diskusikan?");
                    @endphp

                    <a href="https://wa.me/{{ $cleanPhone }}?text={{ $waText }}" target="_blank" 
                       class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl transition shadow-xs">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                        <span>Chat WhatsApp PIC</span>
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                    <div class="p-3.5 rounded-xl bg-[#FAF6EE]/50 border border-[#E8DFD1]">
                        <span class="block text-[11px] font-bold text-stone-500 uppercase tracking-wider mb-1">Nama Lengkap PIC</span>
                        <span class="font-semibold text-stone-900 text-sm">{{ $inquiry->full_name }}</span>
                    </div>

                    <div class="p-3.5 rounded-xl bg-[#FAF6EE]/50 border border-[#E8DFD1]">
                        <span class="block text-[11px] font-bold text-stone-500 uppercase tracking-wider mb-1">Perusahaan / Brand</span>
                        <span class="font-semibold text-stone-900 text-sm">{{ $inquiry->company_name ?: '-' }}</span>
                    </div>

                    <div class="p-3.5 rounded-xl bg-[#FAF6EE]/50 border border-[#E8DFD1]">
                        <span class="block text-[11px] font-bold text-stone-500 uppercase tracking-wider mb-1">Nomor WhatsApp / HP</span>
                        <span class="font-mono font-bold text-stone-900 text-sm">{{ $inquiry->phone_number }}</span>
                    </div>

                    <div class="p-3.5 rounded-xl bg-[#FAF6EE]/50 border border-[#E8DFD1]">
                        <span class="block text-[11px] font-bold text-stone-500 uppercase tracking-wider mb-1">Email Perusahaan</span>
                        <span class="font-semibold text-stone-900 text-sm">{{ $inquiry->email ?: '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- RFQ Specifications Card -->
            <div class="bg-white p-6 rounded-2xl border border-[#E8DFD1] shadow-xs space-y-4">
                <h3 class="font-serif font-bold text-base text-[#2C1810] border-b border-[#E8DFD1] pb-3">Spesifikasi Permintaan Pasokan</h3>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div class="p-4 rounded-xl bg-[#FAF6EE] border border-[#E8DFD1]">
                        <span class="block text-[11px] font-bold text-stone-500 uppercase tracking-wider mb-1">Tipe Inquiry</span>
                        <span class="font-bold text-[#5C3317]">{{ $inquiry->inquiry_type ?: 'B2B Pasokan Rutin' }}</span>
                    </div>

                    <div class="p-4 rounded-xl bg-[#FAF6EE] border border-[#E8DFD1]">
                        <span class="block text-[11px] font-bold text-stone-500 uppercase tracking-wider mb-1">Produk Diminati</span>
                        <span class="font-bold text-[#5C3317]">{{ $inquiry->product_interest ?: 'Gula Aren Kristal' }}</span>
                    </div>

                    <div class="p-4 rounded-xl bg-[#FAF6EE] border border-[#E8DFD1]">
                        <span class="block text-[11px] font-bold text-stone-500 uppercase tracking-wider mb-1">Estimasi Volume</span>
                        <span class="font-bold text-[#C87D20] text-sm">{{ $inquiry->estimated_volume ?: 'Belum Disebutkan' }}</span>
                    </div>
                </div>

                <div class="pt-2">
                    <span class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-2">Pesan & Kebutuhan Spesifik Pembeli:</span>
                    <div class="p-4 rounded-xl border border-[#E8DFD1] bg-stone-50/50 text-xs text-stone-800 leading-relaxed font-sans whitespace-pre-wrap">{{ $inquiry->message ?: 'Tidak ada pesan atau catatan khusus dari calon pembeli.' }}</div>
                </div>
            </div>

        </div>

        <!-- Right 1 Col: Status & Action Pipeline -->
        <div class="space-y-6">

            <!-- Pipeline Status Card -->
            <div class="bg-white p-6 rounded-2xl border border-[#E8DFD1] shadow-xs space-y-5">
                <div class="flex items-center justify-between border-b border-[#E8DFD1] pb-3">
                    <h3 class="font-serif font-bold text-base text-[#2C1810]">Status Prospek</h3>
                    @if($inquiry->status === 'baru')
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800 border border-amber-300">Baru Masuk</span>
                    @elseif($inquiry->status === 'diproses')
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 text-blue-800 border border-blue-200">Diproses</span>
                    @elseif($inquiry->status === 'selesai')
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">Selesai / Deal</span>
                    @else
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-stone-100 text-stone-600 border border-stone-200">Arsip</span>
                    @endif
                </div>

                <form method="POST" action="{{ route('admin.inquiries.update-status', $inquiry->id) }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">Ubah Status RFQ *</label>
                        <select name="status" class="w-full px-4 py-2.5 text-xs rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20] font-semibold">
                            <option value="baru" {{ $inquiry->status === 'baru' ? 'selected' : '' }}>Baru Masuk</option>
                            <option value="diproses" {{ $inquiry->status === 'diproses' ? 'selected' : '' }}>Sedang Negosiasi / Kirim Sampel</option>
                            <option value="selesai" {{ $inquiry->status === 'selesai' ? 'selected' : '' }}>Selesai / PO Terbit (Deal)</option>
                            <option value="arsip" {{ $inquiry->status === 'arsip' ? 'selected' : '' }}>Diarsipkan (Tidak Lanjut)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">Catatan Tim Sales (Internal)</label>
                        <textarea name="admin_notes" rows="4" placeholder="Catat hasil negosiasi harga, tanggal pengiriman sampel uji lab, nomor resi kurir, dll..."
                                  class="w-full px-4 py-2.5 text-xs rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">{{ old('admin_notes', $inquiry->admin_notes) }}</textarea>
                    </div>

                    <button type="submit" class="w-full py-2.5 bg-[#5C3317] hover:bg-[#2C1810] text-white text-xs font-bold rounded-xl transition shadow-xs">
                        Perbarui Catatan & Status
                    </button>
                </form>
            </div>

            <!-- Meta Audit Card -->
            <div class="bg-white p-6 rounded-2xl border border-[#E8DFD1] shadow-xs space-y-3 text-xs">
                <h4 class="font-bold text-stone-800 border-b border-[#E8DFD1] pb-2">Informasi Waktu</h4>
                <div class="flex items-center justify-between text-stone-500">
                    <span>Diterima Sistem:</span>
                    <span class="font-mono font-medium text-stone-800">{{ $inquiry->created_at->format('d M Y, H:i') }}</span>
                </div>
                <div class="flex items-center justify-between text-stone-500">
                    <span>Terakhir Diubah:</span>
                    <span class="font-mono font-medium text-stone-800">{{ $inquiry->updated_at->format('d M Y, H:i') }}</span>
                </div>

                <div class="pt-3 border-t border-[#E8DFD1]">
                    <form id="delete-inquiry-form" method="POST" action="{{ route('admin.inquiries.destroy', $inquiry->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="confirmDelete('delete-inquiry-form', 'Hapus permanen data RFQ ini?')"
                                class="w-full py-2 text-xs font-bold text-red-600 hover:bg-red-50 rounded-xl transition border border-red-200">
                            Hapus Data RFQ Ini
                        </button>
                    </form>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
