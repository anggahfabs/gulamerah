@extends('layouts.admin')

@section('title', 'Sertifikasi & Uji Lab')
@section('header-title', 'Kelola Sertifikasi & Legalitas')
@section('header-subtitle', 'Sertifikat Halal BPJPH, BPOM RI / P-IRT, hasil uji lab Sucofindo, dan dokumen legalitas pabrik')

@section('content')
<div class="space-y-6" x-data="{
    modalOpen: false,
    isEdit: false,
    actionUrl: '{{ route('admin.certifications.store') }}',
    cert: { id: '', name: '', issuer: '', cert_number: '', valid_until: '', description: '', is_active: true },
    openCreate() {
        this.isEdit = false;
        this.actionUrl = '{{ route('admin.certifications.store') }}';
        this.cert = { id: '', name: '', issuer: '', cert_number: '', valid_until: '', description: '', is_active: true };
        this.modalOpen = true;
    },
    openEdit(c) {
        this.isEdit = true;
        this.actionUrl = '/admin/certifications/' + c.id;
        this.cert = {
            id: c.id,
            name: c.name,
            issuer: c.issuer,
            cert_number: c.cert_number,
            valid_until: c.valid_until || '',
            description: c.description || '',
            is_active: c.is_active
        };
        this.modalOpen = true;
    }
}">

    <div class="flex items-center justify-between">
        <div>
            <h2 class="font-serif font-bold text-lg text-[#2C1810]">Dokumen & Badge Sertifikasi</h2>
            <p class="text-xs text-stone-500">Membangun kredibilitas tinggi di mata buyer industri dan pasar ekspor.</p>
        </div>
        <button type="button" @click="openCreate()" 
                class="px-4 py-2.5 rounded-xl bg-[#5C3317] hover:bg-[#2C1810] text-white text-xs font-semibold flex items-center gap-2 transition cursor-pointer shadow-xs">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            <span>Tambah Dokumen Sertifikat</span>
        </button>
    </div>

    <!-- Certification Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($certifications as $cert)
            <div class="bg-white p-6 rounded-2xl border border-[#E8DFD1] shadow-xs flex flex-col justify-between gumer-card-hover relative">
                <div>
                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-800 flex items-center justify-center shrink-0 border border-emerald-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138z"></path></svg>
                            </div>
                            <div>
                                <h3 class="font-serif font-bold text-base text-[#2C1810]">{{ $cert->name }}</h3>
                                <p class="text-xs text-stone-500 font-medium">{{ $cert->issuer }}</p>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $cert->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-stone-200 text-stone-600' }}">
                            {{ $cert->is_active ? 'Aktif' : 'Nonaktif' }}
                        </span>
                    </div>

                    <div class="mt-4 p-3.5 rounded-xl bg-[#FAF6EE]/50 border border-[#E8DFD1] space-y-1 font-mono text-xs">
                        <div class="text-stone-700">Nomor: <span class="font-bold text-[#2C1810]">{{ $cert->cert_number }}</span></div>
                        @if($cert->valid_until)
                            <div class="text-stone-500">Masa Berlaku: {{ $cert->valid_until }}</div>
                        @endif
                    </div>

                    @if($cert->description)
                        <p class="text-xs text-stone-600 mt-3">{{ $cert->description }}</p>
                    @endif
                </div>

                <div class="mt-6 pt-4 border-t border-[#E8DFD1] flex items-center justify-between">
                    <div>
                        @if($cert->document_file)
                            <a href="{{ asset('storage/' . $cert->document_file) }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#C87D20] hover:text-[#5C3317] transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                <span>Lihat Scan Dokumen</span>
                            </a>
                        @else
                            <span class="text-[11px] text-stone-400 italic">Scan dokumen belum diupload</span>
                        @endif
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="button" @click="openEdit({{ json_encode($cert) }})" class="p-2 text-stone-600 hover:text-[#5C3317] hover:bg-stone-100 rounded-lg transition" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </button>
                        <form id="delete-cert-{{ $cert->id }}" method="POST" action="{{ route('admin.certifications.destroy', $cert->id) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmDelete('delete-cert-{{ $cert->id }}', 'Hapus sertifikat {{ addslashes($cert->name) }}?')" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center text-stone-400">Belum ada sertifikasi yang ditambahkan.</div>
        @endforelse
    </div>

    <!-- Modal Form Certification -->
    <div x-show="modalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60" style="display: none;"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100">
        
        <div class="bg-white rounded-2xl border border-[#E8DFD1] shadow-2xl w-full max-w-lg overflow-hidden" @click.outside="modalOpen = false">
            <div class="px-6 py-4 border-b border-[#E8DFD1] bg-[#FAF6EE] flex items-center justify-between">
                <h3 class="font-serif font-bold text-base text-[#2C1810]" x-text="isEdit ? 'Edit Dokumen Sertifikasi' : 'Tambah Dokumen Sertifikasi Baru'"></h3>
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
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">Nama Sertifikasi *</label>
                    <input type="text" name="name" x-model="cert.name" required placeholder="Contoh: Sertifikat Halal BPJPH"
                           class="w-full px-4 py-2.5 text-sm rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">Penerbit *</label>
                        <input type="text" name="issuer" x-model="cert.issuer" required placeholder="e.g. BPJPH Kemenag RI"
                               class="w-full px-4 py-2.5 text-sm rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">Nomor Registrasi *</label>
                        <input type="text" name="cert_number" x-model="cert.cert_number" required placeholder="e.g. ID3311000..."
                               class="w-full px-4 py-2.5 text-sm font-mono rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">Masa Berlaku</label>
                    <input type="text" name="valid_until" x-model="cert.valid_until" placeholder="e.g. Berlaku Selamanya / 2028"
                           class="w-full px-4 py-2.5 text-sm rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">Deskripsi Singkat</label>
                    <textarea name="description" x-model="cert.description" rows="2" placeholder="Uraian ruang lingkup sertifikasi..."
                              class="w-full px-4 py-2.5 text-sm rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-1.5">Upload Scan Dokumen (PDF / Gambar Max 5MB)</label>
                    <input type="file" name="document_file" accept=".pdf,image/*" class="w-full text-xs text-stone-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#FAF6EE] file:text-[#5C3317] hover:file:bg-stone-200">
                </div>

                <div class="flex items-center gap-2 pt-2">
                    <input type="checkbox" id="cert_is_active" name="is_active" value="1" x-model="cert.is_active" class="rounded border-[#E8DFD1] text-[#C87D20] focus:ring-[#C87D20]">
                    <label for="cert_is_active" class="text-xs font-medium text-stone-700 cursor-pointer">Tampilkan Badge & Dokumen di Website</label>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-[#E8DFD1]">
                    <button type="button" @click="modalOpen = false" class="px-4 py-2 text-xs font-bold text-stone-600 hover:bg-stone-100 rounded-xl transition">Batal</button>
                    <button type="submit" class="px-5 py-2.5 bg-[#5C3317] hover:bg-[#2C1810] text-white text-xs font-bold rounded-xl transition shadow-xs">Simpan Sertifikasi</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
