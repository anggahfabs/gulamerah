@extends('layouts.admin')

@section('title', 'Layanan B2B & Maklon')
@section('header-title', 'Kelola Layanan B2B & Maklon')
@section('header-subtitle', 'Pasokan kontrak rutin industri pangan, jasa OEM private label, dan kemitraan petani')

@section('content')
<div class="space-y-6" x-data="{
    modalOpen: false,
    isEdit: false,
    actionUrl: '{{ route('admin.services.store') }}',
    service: { id: '', title: '', subtitle: '', badge_text: '', description: '', features: '', is_active: true },
    openCreate() {
        this.isEdit = false;
        this.actionUrl = '{{ route('admin.services.store') }}';
        this.service = { id: '', title: '', subtitle: '', badge_text: '', description: '', features: '', is_active: true };
        this.modalOpen = true;
    },
    openEdit(s) {
        this.isEdit = true;
        this.actionUrl = '/admin/services/' + s.id;
        this.service = {
            id: s.id,
            title: s.title,
            subtitle: s.subtitle || '',
            badge_text: s.badge_text || '',
            description: s.description,
            features: s.features ? s.features.join('\n') : '',
            is_active: s.is_active
        };
        this.modalOpen = true;
    }
}">

    <div class="flex items-center justify-between">
        <div>
            <h2 class="font-serif font-bold text-lg text-[#2C1810]">Daftar Layanan Industri</h2>
            <p class="text-xs text-stone-500">Informasi kapasitas, MOQ, dan solusi kemitraan untuk buyer B2B.</p>
        </div>
        <button type="button" @click="openCreate()" 
                class="px-4 py-2.5 rounded-xl bg-[#5C3317] hover:bg-[#2C1810] text-white text-xs font-semibold flex items-center gap-2 transition cursor-pointer shadow-xs">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <span>Tambah Layanan B2B</span>
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($services as $srv)
            <div class="bg-white p-6 rounded-2xl border border-[#E8DFD1] shadow-xs flex flex-col justify-between gumer-card-hover relative">
                <div>
                    <div class="flex items-start justify-between gap-2 mb-3">
                        <span class="px-2.5 py-1 rounded-md text-[10px] font-bold bg-[#FAF6EE] text-[#C87D20] border border-[#E8DFD1]">
                            {{ $srv->badge_text ?: 'Layanan Pabrik' }}
                        </span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $srv->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-stone-200 text-stone-600' }}">
                            {{ $srv->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>

                    <h3 class="font-serif font-bold text-base text-[#2C1810]">{{ $srv->title }}</h3>
                    <p class="text-xs text-stone-500 font-medium mt-1">{{ $srv->subtitle ?: 'Kemitraan pasokan gula murni' }}</p>
                    <p class="text-xs text-stone-600 mt-3 line-clamp-3">{{ $srv->description }}</p>

                    @if(!empty($srv->features))
                        <div class="mt-4 pt-3 border-t border-[#E8DFD1] space-y-1.5">
                            @foreach($srv->features as $feat)
                                <div class="flex items-center gap-2 text-xs text-stone-700">
                                    <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span class="truncate">{{ $feat }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="mt-6 pt-4 border-t border-[#E8DFD1] flex items-center justify-end gap-2">
                    <button type="button" @click="openEdit({{ json_encode($srv) }})" class="p-2 text-stone-600 hover:text-[#5C3317] hover:bg-stone-100 rounded-lg transition" title="Edit">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </button>
                    <form id="delete-service-{{ $srv->id }}" method="POST" action="{{ route('admin.services.destroy', $srv->id) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="confirmDelete('delete-service-{{ $srv->id }}', 'Hapus layanan {{ addslashes($srv->title) }}?')" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center text-stone-400">Belum ada layanan B2B yang ditambahkan.</div>
        @endforelse
    </div>

    <!-- Modal Form Service -->
    <div x-show="modalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60" style="display: none;"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100">
        
        <div class="bg-white rounded-2xl border border-[#E8DFD1] shadow-2xl w-full max-w-xl overflow-hidden" @click.outside="modalOpen = false">
            <div class="px-6 py-4 border-b border-[#E8DFD1] bg-[#FAF6EE] flex items-center justify-between">
                <h3 class="font-serif font-bold text-base text-[#2C1810]" x-text="isEdit ? 'Edit Layanan B2B' : 'Tambah Layanan B2B Baru'"></h3>
                <button type="button" @click="modalOpen = false" class="text-stone-400 hover:text-stone-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form :action="actionUrl" method="POST" class="p-6 space-y-4">
                @csrf
                <template x-if="isEdit">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">Judul Layanan *</label>
                    <input type="text" name="title" x-model="service.title" required placeholder="Contoh: Jasa Maklon & OEM Private Label"
                           class="w-full px-4 py-2.5 text-sm rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">Subjudul / Tagline</label>
                        <input type="text" name="subtitle" x-model="service.subtitle" placeholder="e.g. Solusi kemasan merk sendiri"
                               class="w-full px-4 py-2.5 text-sm rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">Badge Teks</label>
                        <input type="text" name="badge_text" x-model="service.badge_text" placeholder="e.g. MOQ Mulai 500 Kg"
                               class="w-full px-4 py-2.5 text-sm rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">Deskripsi Lengkap *</label>
                    <textarea name="description" x-model="service.description" rows="3" required placeholder="Uraikan detail penawaran kerja sama..."
                              class="w-full px-4 py-2.5 text-sm rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">Poin Keunggulan / Fitur (1 per baris)</label>
                    <textarea name="features" x-model="service.features" rows="4" placeholder="Jadwal pengiriman terjadwal&#10;Certificate of Analysis per batch&#10;Harga kontrak volume stabil"
                              class="w-full px-4 py-2.5 text-xs font-mono rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]"></textarea>
                </div>

                <div class="flex items-center gap-2 pt-2">
                    <input type="checkbox" id="srv_is_active" name="is_active" value="1" x-model="service.is_active" class="rounded border-[#E8DFD1] text-[#C87D20] focus:ring-[#C87D20]">
                    <label for="srv_is_active" class="text-xs font-medium text-stone-700 cursor-pointer">Layanan Aktif & Tampil di Website</label>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-[#E8DFD1]">
                    <button type="button" @click="modalOpen = false" class="px-4 py-2 text-xs font-bold text-stone-600 hover:bg-stone-100 rounded-xl transition">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-[#5C3317] hover:bg-[#2C1810] text-white text-xs font-bold rounded-xl transition shadow-xs">Simpan Layanan</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
