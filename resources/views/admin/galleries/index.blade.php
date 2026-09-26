@extends('layouts.admin')

@section('title', 'Dokumentasi Fasilitas & Produksi - Gumer')
@section('header-title', 'Galeri Fasilitas & Produksi')
@section('header-subtitle', 'Dokumentasi visual kebun aren, proses pengolahan kristal, laboratorium uji mutu, dan gudang distribusi.')

@section('content')
<div x-data="{
    modalOpen: false,
    isEdit: false,
    actionUrl: '',
    gallery: { id: null, title: '', category: 'Pemrosesan Kristal', caption: '', is_active: true },
    openCreate() {
        this.isEdit = false;
        this.actionUrl = '{{ route('admin.galleries.store') }}';
        this.gallery = { id: null, title: '', category: 'Pemrosesan Kristal', caption: '', is_active: true };
        this.modalOpen = true;
    },
    openEdit(item) {
        this.isEdit = true;
        this.actionUrl = '{{ url('admin/galleries') }}/' + item.id;
        this.gallery = {
            id: item.id,
            title: item.title,
            category: item.category,
            caption: item.caption || '',
            is_active: item.is_active ? true : false
        };
        this.modalOpen = true;
    }
}" class="space-y-6">

    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-2xl border border-[#E8DFD1] shadow-xs">
        <!-- Category Filter Pills -->
        <div class="flex items-center gap-2 overflow-x-auto pb-1 sm:pb-0">
            @php
                $activeCategory = request('category', '');
                $categories = [
                    '' => 'Semua Kategori',
                    'Kebun Aren' => 'Kebun Aren',
                    'Pemrosesan Kristal' => 'Pemrosesan Kristal',
                    'Pengemasan & Lab' => 'Pengemasan & Lab',
                    'Gudang & Pengiriman' => 'Gudang & Logistik'
                ];
            @endphp
            @foreach($categories as $key => $label)
                <a href="{{ route('admin.galleries.index', $key ? ['category' => $key] : []) }}" 
                   class="px-3.5 py-1.5 rounded-xl text-xs font-semibold whitespace-nowrap transition {{ $activeCategory === $key ? 'bg-[#5C3317] text-white shadow-xs' : 'bg-[#FAF6EE] text-[#5C3317] hover:bg-stone-200/70 border border-[#E8DFD1]' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <button type="button" @click="openCreate()" 
                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-[#C87D20] hover:bg-[#a96615] text-white text-xs font-bold rounded-xl transition shadow-xs">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <span>Tambah Foto Fasilitas</span>
        </button>
    </div>

    <!-- Gallery Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($galleries as $item)
            <div class="bg-white rounded-2xl border border-[#E8DFD1] shadow-xs overflow-hidden flex flex-col hover:border-[#C87D20] transition group">
                <!-- Image Container -->
                <div class="relative aspect-video bg-stone-100 overflow-hidden">
                    @if($item->image_path)
                        <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-stone-300">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                    <div class="absolute top-3 left-3">
                        <span class="px-2.5 py-1 text-[11px] font-bold rounded-lg bg-black/60 backdrop-blur-md text-white border border-white/20">
                            {{ $item->category }}
                        </span>
                    </div>
                    <div class="absolute top-3 right-3">
                        @if($item->is_active)
                            <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-emerald-500/90 text-white backdrop-blur-xs">Aktif</span>
                        @else
                            <span class="px-2 py-0.5 text-[10px] font-bold rounded-full bg-stone-600/90 text-white backdrop-blur-xs">Draft</span>
                        @endif
                    </div>
                </div>

                <!-- Content -->
                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="font-serif font-bold text-base text-[#2C1810] mb-1.5 line-clamp-1">{{ $item->title }}</h3>
                        <p class="text-xs text-stone-500 line-clamp-2 leading-relaxed">{{ $item->caption ?: 'Tidak ada keterangan tambahan.' }}</p>
                    </div>

                    <div class="mt-4 pt-4 border-t border-[#E8DFD1] flex items-center justify-between text-xs">
                        <span class="text-[11px] text-stone-400">{{ $item->created_at->format('d M Y') }}</span>
                        
                        <div class="flex items-center gap-1.5">
                            <button type="button" @click="openEdit({{ json_encode($item) }})" 
                                    class="p-2 text-stone-600 hover:text-[#5C3317] hover:bg-[#FAF6EE] rounded-lg transition" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>
                            <form id="delete-gallery-{{ $item->id }}" method="POST" action="{{ route('admin.galleries.destroy', $item->id) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete('delete-gallery-{{ $item->id }}', 'Hapus dokumentasi foto ini?')" 
                                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-dashed border-[#E8DFD1] text-stone-400">
                <svg class="w-12 h-12 mx-auto text-stone-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                <p class="font-medium text-stone-600">Belum ada dokumentasi foto fasilitas.</p>
                <p class="text-xs mt-1">Tambahkan foto kebun aren atau lini pengolahan pabrik.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($galleries->hasPages())
        <div class="p-4 bg-white rounded-2xl border border-[#E8DFD1]">
            {{ $galleries->links() }}
        </div>
    @endif

    <!-- Alpine Modal Form -->
    <div x-show="modalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60" style="display: none;"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100">
        
        <div class="bg-white rounded-2xl border border-[#E8DFD1] shadow-2xl w-full max-w-lg overflow-hidden" @click.outside="modalOpen = false">
            <div class="px-6 py-4 border-b border-[#E8DFD1] bg-[#FAF6EE] flex items-center justify-between">
                <h3 class="font-serif font-bold text-base text-[#2C1810]" x-text="isEdit ? 'Edit Foto Dokumentasi' : 'Tambah Foto Fasilitas Baru'"></h3>
                <button type="button" @click="modalOpen = false" class="text-stone-400 hover:text-stone-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form :action="actionUrl" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                @csrf
                <template x-if="isEdit">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">Judul / Aktivitas Fasilitas *</label>
                    <input type="text" name="title" x-model="gallery.title" required placeholder="Contoh: Mesin Kristalisasi Granulasi Otomatis"
                           class="w-full px-4 py-2.5 text-sm rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">Kategori Fasilitas *</label>
                    <select name="category" x-model="gallery.category" required
                            class="w-full px-4 py-2.5 text-sm rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
                        <option value="Kebun Aren">Kebun Aren & Petani Mitra</option>
                        <option value="Pemrosesan Kristal">Pemrosesan Kristal & Pemasakan Nira</option>
                        <option value="Pengemasan & Lab">Pengemasan Steril & Laboratorium Mutu</option>
                        <option value="Gudang & Pengiriman">Gudang Distribusi & Kontainer Ekspor</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">Keterangan / Caption Singkat</label>
                    <textarea name="caption" x-model="gallery.caption" rows="2" placeholder="Uraian singkat tentang higienitas, kapasitas, atau standar operasional..."
                              class="w-full px-4 py-2.5 text-sm rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">
                        <span x-text="isEdit ? 'Ganti Foto (Kosongkan bila tidak diganti)' : 'Upload File Foto (Max 4MB) *'"></span>
                    </label>
                    <input type="file" name="image" accept="image/*" :required="!isEdit"
                           class="w-full text-xs text-stone-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#FAF6EE] file:text-[#5C3317] hover:file:bg-stone-200">
                </div>

                <div class="flex items-center gap-2 pt-2">
                    <input type="checkbox" id="gallery_is_active" name="is_active" value="1" x-model="gallery.is_active" class="rounded border-[#E8DFD1] text-[#C87D20] focus:ring-[#C87D20]">
                    <label for="gallery_is_active" class="text-xs font-medium text-stone-700 cursor-pointer">Tampilkan di Galeri Website</label>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-[#E8DFD1]">
                    <button type="button" @click="modalOpen = false" class="px-4 py-2 text-xs font-bold text-stone-600 hover:bg-stone-100 rounded-xl transition">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-[#5C3317] hover:bg-[#2C1810] text-white text-xs font-bold rounded-xl transition shadow-xs">Simpan Foto</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
