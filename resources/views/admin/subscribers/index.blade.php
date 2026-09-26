@extends('layouts.admin')

@section('title', 'Pelanggan Newsletter - Gumer')
@section('header-title', 'Pelanggan Newsletter & Kontak Prospek')
@section('header-subtitle', 'Daftar alamat email calon mitra dan pelanggan retail yang berlangganan kabar pasokan gula aren.')

@section('content')
<div class="space-y-6">

    <!-- Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-[#E8DFD1] shadow-xs">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-[#FAF6EE] border border-[#E8DFD1] flex items-center justify-center text-[#5C3317]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
            </div>
            <div>
                <h3 class="font-serif font-bold text-base text-[#2C1810]">Total {{ $subscribers->total() }} Pelanggan Terdaftar</h3>
                <p class="text-xs text-stone-500">Email yang didaftarkan melalui form footer website.</p>
            </div>
        </div>

        <a href="{{ route('admin.subscribers.export-csv') }}" 
           class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-[#5C3317] hover:bg-[#2C1810] text-white text-xs font-bold rounded-xl transition shadow-xs">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            <span>Download CSV Kontak</span>
        </a>
    </div>

    <!-- Subscribers Table -->
    <div class="bg-white rounded-2xl border border-[#E8DFD1] shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-[#FAF6EE] text-[#5C3317] uppercase text-[11px] font-bold tracking-wider border-b border-[#E8DFD1]">
                    <tr>
                        <th class="px-6 py-4">No</th>
                        <th class="px-6 py-4">Alamat Email</th>
                        <th class="px-6 py-4">Tanggal Mendaftar</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E8DFD1]">
                    @forelse($subscribers as $index => $sub)
                        <tr class="hover:bg-stone-50/80 transition">
                            <td class="px-6 py-4 text-stone-400 font-mono">
                                {{ $subscribers->firstItem() + $index }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-medium text-stone-900 text-sm">{{ $sub->email }}</span>
                            </td>
                            <td class="px-6 py-4 text-stone-500">
                                {{ $sub->created_at->format('d M Y, H:i') }} WIB
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-[11px] font-bold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                    Aktif
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form id="delete-sub-{{ $sub->id }}" method="POST" action="{{ route('admin.subscribers.destroy', $sub->id) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete('delete-sub-{{ $sub->id }}', 'Hapus email {{ addslashes($sub->email) }} dari daftar newsletter?')"
                                            class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-stone-400">
                                <p class="font-medium text-stone-600">Belum ada pelanggan newsletter yang terdaftar.</p>
                                <p class="text-[11px] text-stone-400 mt-1">Email pengunjung yang mendaftar di footer akan otomatis masuk ke sini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($subscribers->hasPages())
            <div class="p-4 border-t border-[#E8DFD1]">
                {{ $subscribers->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
