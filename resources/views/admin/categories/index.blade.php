@extends('layouts.admin')

@section('title', 'Kelola Kategori')
@section('header-title', 'Kategori Produk Gula')
@section('header-subtitle', 'Kelola pengelompokan produk gula (Aren, Kelapa, Semut, Cair)')

@section('content')
<div class="space-y-6" x-data="{ 
    modalOpen: false, 
    isEdit: false, 
    actionUrl: '{{ route('admin.categories.store') }}',
    category: { id: '', name: '', description: '', is_active: true },
    openCreate() {
        this.isEdit = false;
        this.actionUrl = '{{ route('admin.categories.store') }}';
        this.category = { id: '', name: '', description: '', is_active: true };
        this.modalOpen = true;
    },
    openEdit(cat) {
        this.isEdit = true;
        this.actionUrl = '/admin/categories/' + cat.id;
        this.category = { id: cat.id, name: cat.name, description: cat.description || '', is_active: cat.is_active };
        this.modalOpen = true;
    }
}">

    <div class="flex items-center justify-between">
        <div>
            <h2 class="font-serif font-bold text-lg text-[#2C1810]">Daftar Kategori</h2>
            <p class="text-xs text-stone-500">Kategori digunakan sebagai filter katalog di website.</p>
        </div>
        <button type="button" @click="openCreate()" 
                class="px-4 py-2.5 rounded-xl bg-[#5C3317] hover:bg-[#2C1810] text-white text-xs font-semibold flex items-center gap-2 transition cursor-pointer shadow-xs">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <span>Tambah Kategori</span>
        </button>
    </div>

    <!-- Category Table Card -->
    <div class="bg-white rounded-2xl border border-[#E8DFD1] shadow-xs overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="bg-[#FAF6EE] border-b border-[#E8DFD1] text-[11px] font-bold uppercase tracking-wider text-stone-500">
                    <th class="py-3.5 px-6">Nama Kategori</th>
                    <th class="py-3.5 px-6">Deskripsi</th>
                    <th class="py-3.5 px-6">Jumlah Produk</th>
                    <th class="py-3.5 px-6">Status</th>
                    <th class="py-3.5 px-6 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-[#E8DFD1]">
                @forelse($categories as $cat)
                    <tr class="hover:bg-[#FAF6EE]/40 transition">
                        <td class="py-4 px-6">
                            <span class="font-bold text-[#2C1810]">{{ $cat->name }}</span>
                            <span class="block text-[11px] font-mono text-[#C87D20] mt-0.5">slug: {{ $cat->slug }}</span>
                        </td>
                        <td class="py-4 px-6 text-xs text-stone-600 max-w-md">
                            {{ $cat->description ?: '-' }}
                        </td>
                        <td class="py-4 px-6 text-xs font-semibold text-stone-700">
                            {{ $cat->products_count }} Produk
                        </td>
                        <td class="py-4 px-6 text-xs">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $cat->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-stone-200 text-stone-600' }}">
                                {{ $cat->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button type="button" @click="openEdit({{ json_encode($cat) }})" 
                                        class="p-2 rounded-lg bg-stone-100 hover:bg-[#5C3317] hover:text-white text-stone-700 transition" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>
                                <form id="delete-cat-{{ $cat->id }}" method="POST" action="{{ route('admin.categories.destroy', $cat->id) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete('delete-cat-{{ $cat->id }}', 'Hapus kategori {{ addslashes($cat->name) }}?')"
                                            class="p-2 rounded-lg bg-red-50 hover:bg-red-600 hover:text-white text-red-600 transition cursor-pointer" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center text-stone-400">Belum ada kategori produk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal Form Create / Edit Category -->
    <div x-show="modalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60" style="display: none;"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100">
        
        <div class="bg-white rounded-2xl border border-[#E8DFD1] shadow-2xl w-full max-w-lg overflow-hidden" @click.outside="modalOpen = false">
            <div class="px-6 py-4 border-b border-[#E8DFD1] bg-[#FAF6EE] flex items-center justify-between">
                <h3 class="font-serif font-bold text-base text-[#2C1810]" x-text="isEdit ? 'Edit Kategori Produk' : 'Tambah Kategori Baru'"></h3>
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
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-2">Nama Kategori *</label>
                    <input type="text" name="name" x-model="category.name" required placeholder="Contoh: Gula Semut Aren"
                           class="w-full px-4 py-2.5 text-sm rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-2">Deskripsi</label>
                    <textarea name="description" x-model="category.description" rows="3" placeholder="Keterangan singkat kategori..."
                              class="w-full px-4 py-2.5 text-sm rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]"></textarea>
                </div>

                <div class="flex items-center gap-2 pt-2">
                    <input type="checkbox" id="cat_is_active" name="is_active" value="1" x-model="category.is_active" class="rounded border-[#E8DFD1] text-[#C87D20] focus:ring-[#C87D20]">
                    <label for="cat_is_active" class="text-xs font-medium text-stone-700 cursor-pointer">Kategori Aktif & Tampil di Filter</label>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-[#E8DFD1]">
                    <button type="button" @click="modalOpen = false" class="px-4 py-2 text-xs font-bold text-stone-600 hover:bg-stone-100 rounded-xl transition">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-[#5C3317] hover:bg-[#2C1810] text-white text-xs font-bold rounded-xl transition shadow-xs">Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
