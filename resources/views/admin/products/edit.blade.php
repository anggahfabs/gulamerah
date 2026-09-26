@extends('layouts.admin')

@section('title', 'Edit Produk — ' . $product->name)
@section('header-title', 'Edit Data Produk')
@section('header-subtitle', 'Perbarui spesifikasi laboratorium, pilihan kemasan, dan tabel tier harga')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <div class="flex items-center justify-between">
        <a href="{{ route('admin.products.index') }}" class="inline-flex items-center gap-2 text-xs font-bold text-stone-600 hover:text-[#5C3317] transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            <span>Kembali ke Daftar Produk</span>
        </a>
    </div>

    <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data" 
          x-data="{
              variants: {{ json_encode($product->variants->map(fn($v) => [
                  'packaging_name' => $v->packaging_name,
                  'packaging_type' => $v->packaging_type,
                  'unit_weight_kg' => (float)$v->unit_weight_kg,
                  'retail_price' => $v->retail_price ? (float)$v->retail_price : ''
              ])) }},
              price_tiers: {{ json_encode($product->priceTiers->map(fn($t) => [
                  'min_quantity_kg' => (float)$t->min_quantity_kg,
                  'max_quantity_kg' => $t->max_quantity_kg ? (float)$t->max_quantity_kg : '',
                  'price_per_kg' => (float)$t->price_per_kg,
                  'note' => $t->note ?? ''
              ])) }},
              addVariant() {
                  this.variants.push({ packaging_name: '', packaging_type: 'Retail', unit_weight_kg: 1.0, retail_price: '' });
              },
              removeVariant(index) {
                  this.variants.splice(index, 1);
              },
              addTier() {
                  this.price_tiers.push({ min_quantity_kg: '', max_quantity_kg: '', price_per_kg: '', note: '' });
              },
              removeTier(index) {
                  this.price_tiers.splice(index, 1);
              }
          }" 
          class="space-y-8">
        @csrf
        @method('PUT')

        <!-- 1. Master Data Section -->
        <div class="bg-white p-6 sm:p-8 rounded-2xl border border-[#E8DFD1] shadow-xs space-y-6">
            <div class="border-b border-[#E8DFD1] pb-4">
                <h3 class="font-serif font-bold text-lg text-[#2C1810]">1. Identitas & Informasi Master Produk</h3>
                <p class="text-xs text-stone-500">Nama produk, kategori, bahan baku, dan deskripsi utama.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-2">Nama Produk Gula *</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required 
                           class="w-full px-4 py-3 text-sm rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/40 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-2">Kategori Produk *</label>
                    <select name="category_id" required class="w-full px-4 py-3 text-sm rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/40 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-2">Bahan Baku Asal *</label>
                    <input type="text" name="raw_material" value="{{ old('raw_material', $product->raw_material) }}" required 
                           class="w-full px-4 py-3 text-sm rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/40 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-2">Bentuk Fisik Produk *</label>
                    <select name="product_form" required class="w-full px-4 py-3 text-sm rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/40 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
                        <option value="Semut / Granule" {{ old('product_form', $product->product_form) == 'Semut / Granule' ? 'selected' : '' }}>Semut / Kristal Granule</option>
                        <option value="Cetak / Balok" {{ old('product_form', $product->product_form) == 'Cetak / Balok' ? 'selected' : '' }}>Cetak / Balok Batok</option>
                        <option value="Cair / Liquid" {{ old('product_form', $product->product_form) == 'Cair / Liquid' ? 'selected' : '' }}>Cair / Liquid Palm Sugar</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-2">Ganti Foto Thumbnail</label>
                    <input type="file" name="thumbnail" accept="image/*" class="w-full text-xs text-stone-600 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#FAF6EE] file:text-[#5C3317] hover:file:bg-stone-200">
                    @if($product->thumbnail)
                        <div class="mt-2 flex items-center gap-2">
                            <span class="text-[11px] text-stone-500">Thumbnail saat ini:</span>
                            <img src="{{ asset('storage/' . $product->thumbnail) }}" alt="{{ $product->name }}" class="w-8 h-8 rounded object-cover border border-[#E8DFD1]">
                        </div>
                    @endif
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-2">Deskripsi Ringkas</label>
                    <textarea name="short_description" rows="2"
                              class="w-full px-4 py-3 text-sm rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/40 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">{{ old('short_description', $product->short_description) }}</textarea>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-2">Deskripsi Lengkap & Standar Mutu</label>
                    <textarea name="full_description" rows="4"
                              class="w-full px-4 py-3 text-sm rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/40 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">{{ old('full_description', $product->full_description) }}</textarea>
                </div>
            </div>
        </div>

        <!-- 2. Technical Lab Specifications -->
        <div class="bg-white p-6 sm:p-8 rounded-2xl border border-[#E8DFD1] shadow-xs space-y-6">
            <div class="border-b border-[#E8DFD1] pb-4">
                <h3 class="font-serif font-bold text-lg text-[#2C1810]">2. Spesifikasi Teknis & Hasil Uji Laboratorium</h3>
                <p class="text-xs text-stone-500">Data penting untuk calon pembeli B2B, pabrik makanan, dan barista cafe.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-5">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-2">Kadar Air (Moisture)</label>
                    <input type="text" name="moisture_content" value="{{ old('moisture_content', $product->moisture_content) }}"
                           class="w-full px-4 py-2.5 text-sm font-mono rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/40 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-2">Ukuran Ayakan (Mesh)</label>
                    <input type="text" name="mesh_size" value="{{ old('mesh_size', $product->mesh_size) }}"
                           class="w-full px-4 py-2.5 text-sm font-mono rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/40 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-2">Tingkat Brix (Untuk Cair)</label>
                    <input type="text" name="brix_content" value="{{ old('brix_content', $product->brix_content) }}"
                           class="w-full px-4 py-2.5 text-sm font-mono rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/40 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-2">Masa Simpan (Shelf Life)</label>
                    <input type="text" name="shelf_life" value="{{ old('shelf_life', $product->shelf_life) }}"
                           class="w-full px-4 py-2.5 text-sm rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/40 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-2">Rekomendasi Industri / Aplikasi</label>
                    <input type="text" name="recommendations" value="{{ old('recommendations', $product->recommendations) }}" 
                           class="w-full px-4 py-2.5 text-sm rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/40 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
                </div>

                <div class="sm:col-span-3">
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-2">Petunjuk Penyimpanan</label>
                    <input type="text" name="storage_instruction" value="{{ old('storage_instruction', $product->storage_instruction) }}" 
                           class="w-full px-4 py-2.5 text-sm rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/40 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
                </div>
            </div>
        </div>

        <!-- 3. Dynamic Packaging Variants Repeater -->
        <div class="bg-white p-6 sm:p-8 rounded-2xl border border-[#E8DFD1] shadow-xs space-y-6">
            <div class="flex items-center justify-between border-b border-[#E8DFD1] pb-4">
                <div>
                    <h3 class="font-serif font-bold text-lg text-[#2C1810]">3. Pilihan Kemasan & Harga Eceran (B2C & Sample)</h3>
                    <p class="text-xs text-stone-500">Format kemasan standing pouch, karung zak 25kg, jerigen, dll.</p>
                </div>
                <button type="button" @click="addVariant()" class="px-3.5 py-1.5 rounded-lg bg-[#FAF6EE] border border-[#E8DFD1] text-[#5C3317] hover:bg-stone-100 text-xs font-bold flex items-center gap-1.5 transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <span>Tambah Varian Kemasan</span>
                </button>
            </div>

            <div class="space-y-3">
                <template x-for="(variant, index) in variants" :key="index">
                    <div class="flex flex-col sm:flex-row items-center gap-3 p-3.5 rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30">
                        <div class="flex-1 w-full sm:w-auto">
                            <label class="block text-[10px] font-bold uppercase text-stone-500 mb-1">Nama Kemasan</label>
                            <input type="text" :name="'variants[' + index + '][packaging_name]'" x-model="variant.packaging_name" required
                                   class="w-full px-3 py-2 text-xs rounded-lg border border-[#E8DFD1] bg-white focus:ring-2 focus:ring-[#C87D20]">
                        </div>

                        <div class="w-full sm:w-32">
                            <label class="block text-[10px] font-bold uppercase text-stone-500 mb-1">Tipe</label>
                            <select :name="'variants[' + index + '][packaging_type]'" x-model="variant.packaging_type"
                                    class="w-full px-3 py-2 text-xs rounded-lg border border-[#E8DFD1] bg-white focus:ring-2 focus:ring-[#C87D20]">
                                <option value="Retail">Retail (Eceran)</option>
                                <option value="Bulk">Bulk (Industri)</option>
                            </select>
                        </div>

                        <div class="w-full sm:w-28">
                            <label class="block text-[10px] font-bold uppercase text-stone-500 mb-1">Berat (Kg)</label>
                            <input type="number" step="0.01" :name="'variants[' + index + '][unit_weight_kg]'" x-model="variant.unit_weight_kg" required
                                   class="w-full px-3 py-2 text-xs font-mono rounded-lg border border-[#E8DFD1] bg-white focus:ring-2 focus:ring-[#C87D20]">
                        </div>

                        <div class="w-full sm:w-36">
                            <label class="block text-[10px] font-bold uppercase text-stone-500 mb-1">Harga Retail (Rp)</label>
                            <input type="number" :name="'variants[' + index + '][retail_price]'" x-model="variant.retail_price"
                                   class="w-full px-3 py-2 text-xs font-mono rounded-lg border border-[#E8DFD1] bg-white focus:ring-2 focus:ring-[#C87D20]">
                        </div>

                        <div class="sm:pt-4">
                            <button type="button" @click="removeVariant(index)" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition" title="Hapus Varian">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- 4. Dynamic Volume Price Tiers Repeater (B2B) -->
        <div class="bg-white p-6 sm:p-8 rounded-2xl border border-[#E8DFD1] shadow-xs space-y-6">
            <div class="flex items-center justify-between border-b border-[#E8DFD1] pb-4">
                <div>
                    <h3 class="font-serif font-bold text-lg text-[#2C1810]">4. Tabel Tier Harga Volume (B2B & Industri)</h3>
                    <p class="text-xs text-stone-500">Harga per kg sesuai kuantiti pesanan buyer industri.</p>
                </div>
                <button type="button" @click="addTier()" class="px-3.5 py-1.5 rounded-lg bg-[#FAF6EE] border border-[#E8DFD1] text-[#5C3317] hover:bg-stone-100 text-xs font-bold flex items-center gap-1.5 transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <span>Tambah Level Tier</span>
                </button>
            </div>

            <div class="space-y-3">
                <template x-for="(tier, index) in price_tiers" :key="index">
                    <div class="flex flex-col sm:flex-row items-center gap-3 p-3.5 rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30">
                        <div class="w-full sm:w-32">
                            <label class="block text-[10px] font-bold uppercase text-stone-500 mb-1">Min. Kg</label>
                            <input type="number" :name="'price_tiers[' + index + '][min_quantity_kg]'" x-model="tier.min_quantity_kg" required
                                   class="w-full px-3 py-2 text-xs font-mono rounded-lg border border-[#E8DFD1] bg-white focus:ring-2 focus:ring-[#C87D20]">
                        </div>

                        <div class="w-full sm:w-32">
                            <label class="block text-[10px] font-bold uppercase text-stone-500 mb-1">Max. Kg</label>
                            <input type="number" :name="'price_tiers[' + index + '][max_quantity_kg]'" x-model="tier.max_quantity_kg"
                                   class="w-full px-3 py-2 text-xs font-mono rounded-lg border border-[#E8DFD1] bg-white focus:ring-2 focus:ring-[#C87D20]">
                        </div>

                        <div class="w-full sm:w-40">
                            <label class="block text-[10px] font-bold uppercase text-stone-500 mb-1">Harga / Kg (Rp)</label>
                            <input type="number" :name="'price_tiers[' + index + '][price_per_kg]'" x-model="tier.price_per_kg" required
                                   class="w-full px-3 py-2 text-xs font-mono font-bold text-emerald-800 rounded-lg border border-[#E8DFD1] bg-white focus:ring-2 focus:ring-[#C87D20]">
                        </div>

                        <div class="flex-1 w-full sm:w-auto">
                            <label class="block text-[10px] font-bold uppercase text-stone-500 mb-1">Catatan</label>
                            <input type="text" :name="'price_tiers[' + index + '][note]'" x-model="tier.note"
                                   class="w-full px-3 py-2 text-xs rounded-lg border border-[#E8DFD1] bg-white focus:ring-2 focus:ring-[#C87D20]">
                        </div>

                        <div class="sm:pt-4">
                            <button type="button" @click="removeTier(index)" class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition" title="Hapus Tier">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <!-- 5. Status Settings & Submit Button -->
        <div class="bg-white p-6 rounded-2xl border border-[#E8DFD1] shadow-xs flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-6">
                <label class="flex items-center gap-2 cursor-pointer text-xs font-semibold text-stone-700">
                    <input type="checkbox" name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }} class="rounded border-[#E8DFD1] text-[#C87D20] focus:ring-[#C87D20]">
                    <span>Publikasikan Produk di Website</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer text-xs font-semibold text-stone-700">
                    <input type="checkbox" name="is_featured" value="1" {{ $product->is_featured ? 'checked' : '' }} class="rounded border-[#E8DFD1] text-[#C87D20] focus:ring-[#C87D20]">
                    <span>Tampilkan sebagai Produk Unggulan</span>
                </label>
            </div>

            <div class="flex items-center gap-3 w-full sm:w-auto">
                <a href="{{ route('admin.products.index') }}" class="px-5 py-3 rounded-xl border border-[#E8DFD1] text-xs font-bold text-stone-600 hover:bg-stone-100 transition text-center w-full sm:w-auto">
                    Batal
                </a>
                <button type="submit" class="px-6 py-3 rounded-xl bg-[#5C3317] hover:bg-[#2C1810] text-white text-xs font-bold transition shadow-md hover:shadow-lg text-center w-full sm:w-auto cursor-pointer">
                    Perbarui Master Produk
                </button>
            </div>
        </div>

    </form>

</div>
@endsection
