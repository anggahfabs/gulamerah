@extends('layouts.app')

@section('title', 'Kontak, Alamat Pabrik & Gudang — Gumer')
@section('meta-description', 'Hubungi tim sales B2B pabrik gula aren Gumer. Alamat pabrik di Lebak Banten dan pusat distribusi logistik di Cikupa Tangerang.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20 space-y-16">

    <div class="text-center max-w-2xl mx-auto space-y-4">
        <span class="text-xs font-bold uppercase tracking-wider text-[#C87D20]">{{ __('Saluran Resmi Pabrik') }}</span>
        <h1 class="font-serif font-black text-3xl sm:text-5xl text-[#2C1810]">{{ __('Kontak & Fasilitas Pabrik') }}</h1>
        <p class="text-xs sm:text-sm text-stone-600 leading-relaxed">
            {{ __('Tim sales dan teknis laboratorium kami siap melayani kebutuhan konsultasi pasokan, pengiriman sampel, dan kunjungan pabrik.') }}
        </p>
    </div>

    <!-- Contact Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 sm:gap-6">
        <div class="p-5 sm:p-7 rounded-3xl bg-white border border-[#E8DFD1] shadow-xs space-y-2">
            <span class="block text-xs font-bold text-[#C87D20] uppercase font-mono">{{ __('Hotline WhatsApp') }}</span>
            <h3 class="font-serif font-bold text-xl text-[#2C1810]">{{ \App\Models\Setting::get('whatsapp_sales', '081234567890') }}</h3>
            <p class="text-xs text-stone-500">{{ __('Respons cepat untuk inquiry pasokan B2B & pengiriman sampel produk.') }}</p>
        </div>

        <div class="p-5 sm:p-7 rounded-3xl bg-white border border-[#E8DFD1] shadow-xs space-y-2">
            <span class="block text-xs font-bold text-[#C87D20] uppercase font-mono">{{ __('Email Resmi Sales') }}</span>
            <h3 class="font-serif font-bold text-xl text-[#2C1810]">{{ \App\Models\Setting::get('email_sales', 'sales@gumer.id') }}</h3>
            <p class="text-xs text-stone-500">{{ __('Kirimkan dokumen RFQ resmi korporasi, PO, atau permintaan audit vendor.') }}</p>
        </div>

        <div class="p-5 sm:p-7 rounded-3xl bg-white border border-[#E8DFD1] shadow-xs space-y-2">
            <span class="block text-xs font-bold text-[#C87D20] uppercase font-mono">{{ __('Jam Operasional') }}</span>
            <h3 class="font-serif font-bold text-xl text-[#2C1810]">{{ \App\Models\Setting::get('operating_hours', 'Senin - Sabtu') }}</h3>
            <p class="text-xs text-stone-500">{{ __('Layanan pengiriman ekspedisi armada pabrik dan kontainer pelabuhan.') }}</p>
        </div>
    </div>

    <!-- Factory Address & Dual Action RFQ Form -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-start">
        
        <!-- Left: Address & Facility Info -->
        <div class="space-y-6">
            <div class="p-6 sm:p-8 rounded-3xl bg-white border border-[#E8DFD1] shadow-xs space-y-4">
                <h3 class="font-serif font-bold text-2xl text-[#2C1810]">{{ __('Lokasi Fasilitas Pabrik') }}</h3>
                <div class="space-y-3 text-xs text-stone-600">
                    <div>
                        <strong class="block text-stone-900 text-sm">{{ __('Pabrik Pengolahan Utama:') }}</strong>
                        <p class="mt-0.5 leading-relaxed">{{ \App\Models\Setting::get('factory_address', 'Kawasan Agroindustri Aren, Lebak, Banten') }}</p>
                    </div>
                    <div class="pt-2 border-t border-[#E8DFD1]">
                        <strong class="block text-stone-900 text-sm">{{ __('Pusat Pergudangan & Distribusi Jabodetabek:') }}</strong>
                        <p class="mt-0.5 leading-relaxed">{{ \App\Models\Setting::get('warehouse_address', 'Pergudangan Cikupa, Tangerang') }}</p>
                    </div>
                </div>
            </div>

            <!-- Maps Placeholder / Embed -->
            <div class="aspect-video rounded-3xl bg-stone-100 overflow-hidden border border-[#E8DFD1] relative">
                @php $mapsEmbed = \App\Models\Setting::get('google_maps_embed'); @endphp
                @if($mapsEmbed)
                    <iframe src="{{ $mapsEmbed }}" class="w-full h-full border-0" allowfullscreen="" loading="lazy"></iframe>
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center p-6 text-center bg-[#FAF6EE]">
                        <svg class="w-12 h-12 text-[#5C3317] mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span class="font-serif font-bold text-[#2C1810]">{{ __('Peta Lokasi Pabrik Gumer') }}</span>
                        <span class="text-xs text-stone-500 mt-1">Lebak, Banten & Gudang Logistik Tangerang</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right: RFQ Form -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#E8DFD1] shadow-xs space-y-6"
             x-data="{
                 form: {
                     full_name: '',
                     company_name: '',
                     phone_number: '',
                     email: '',
                     inquiry_type: 'Kontrak Pasokan Industri Rutin',
                     product_interest: '{{ request('product') ?? 'Gula Semut Aren Kristal Organik' }}',
                     estimated_volume: '',
                     message: '{{ request('service') ? 'Konsultasi Layanan: ' . request('service') : '' }}'
                 },
                 submitting: false,
                 submit() {
                     this.submitting = true;
                     fetch('{{ route('public.rfq.submit') }}', {
                         method: 'POST',
                         headers: {
                             'Content-Type': 'application/json',
                             'X-CSRF-TOKEN': '{{ csrf_token() }}',
                             'Accept': 'application/json'
                         },
                         body: JSON.stringify(this.form)
                     })
                     .then(res => res.json())
                     .then(data => {
                         this.submitting = false;
                         window.Toast.fire({ icon: 'success', title: data.message });
                         if(data.redirect_url) {
                             setTimeout(() => window.open(data.redirect_url, '_blank'), 800);
                         }
                     })
                     .catch(() => {
                         this.submitting = false;
                         window.Toast.fire({ icon: 'error', title: 'Gagal mengirim form. Coba lagi.' });
                     });
                 }
             }">

            <div>
                <span class="text-xs font-bold text-[#C87D20] uppercase font-mono">{{ __('Formulir Pengadaan B2B') }}</span>
                <h3 class="font-serif font-bold text-2xl text-[#2C1810] mt-1">{{ __('Kirim Permintaan Pasokan') }}</h3>
            </div>

            <form @submit.prevent="submit()" class="space-y-5 text-xs">
                <div>
                    <label class="block font-bold uppercase text-stone-700 mb-1">{{ __('Nama Lengkap *') }}</label>
                    <input type="text" x-model="form.full_name" required placeholder="Budi Santoso"
                           class="w-full px-4 py-3 rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold uppercase text-stone-700 mb-1">{{ __('Perusahaan / Cafe') }}</label>
                        <input type="text" x-model="form.company_name" placeholder="PT Roastery Kopi"
                               class="w-full px-4 py-3 rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
                    </div>
                    <div>
                        <label class="block font-bold uppercase text-stone-700 mb-1">{{ __('No. WhatsApp *') }}</label>
                        <input type="text" x-model="form.phone_number" required placeholder="081234567890"
                               class="w-full px-4 py-3 rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
                    </div>
                </div>

                <div>
                    <label class="block font-bold uppercase text-stone-700 mb-1">Email</label>
                    <input type="email" x-model="form.email" placeholder="purchasing@company.com"
                           class="w-full px-4 py-3 rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold uppercase text-stone-700 mb-1">{{ __('Produk Diminati') }}</label>
                        <select x-model="form.product_interest" class="w-full px-4 py-2.5 rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
                            <option value="Gula Semut Aren Kristal Organik">Gula Semut Aren Kristal</option>
                            <option value="Gula Aren Cair (Brix 78°)">Gula Aren Cair (Brix 78°)</option>
                            <option value="Gula Aren Cetak Batok Murni">Gula Aren Cetak Batok</option>
                            <option value="Gula Kelapa Cetak Alami">Gula Kelapa Cetak</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold uppercase text-stone-700 mb-1">{{ __('Estimasi Volume') }}</label>
                        <input type="text" x-model="form.estimated_volume" placeholder="500 kg / bln"
                               class="w-full px-4 py-3 rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]">
                    </div>
                </div>

                <div>
                    <label class="block font-bold uppercase text-stone-700 mb-1">{{ __('Catatan Tambahan') }}</label>
                    <textarea x-model="form.message" rows="3" placeholder="Tuliskan spesifikasi khusus atau jadwal kirim sampel..."
                              class="w-full px-4 py-2.5 rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/30 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20]"></textarea>
                </div>

                <button type="submit" :disabled="submitting"
                        class="w-full py-3 bg-[#5C3317] hover:bg-[#2C1810] text-white font-bold rounded-xl transition shadow-xs flex items-center justify-center gap-2">
                    <span x-text="submitting ? '{{ __('Mengirim...') }}' : '{{ __('Kirim Form & Hubungkan ke WhatsApp Sales') }}'">{{ __('Kirim Form & Hubungkan ke WhatsApp Sales') }}</span>
                </button>
            </form>
        </div>

    </div>

</div>
@endsection
