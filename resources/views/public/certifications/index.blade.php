@extends('layouts.app')

@section('title', 'Standar Mutu, Uji Lab & Sertifikasi — Gumer')
@section('meta-description', 'Dokumen legalitas pabrik gula aren Gumer, sertifikat Halal BPJPH, P-IRT, dan Certificate of Analysis (COA) Sucofindo.')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-20 space-y-14">

    <!-- Header -->
    <div class="text-center max-w-2xl mx-auto space-y-4">
        <span class="text-xs font-bold uppercase tracking-wider text-[#C87D20]">{{ __('Audit & Quality Control') }}</span>
        <h1 class="font-serif font-black text-3xl sm:text-5xl text-[#2C1810]">{{ __('Standar Mutu & Sertifikasi') }}</h1>
        <p class="text-xs sm:text-sm text-stone-600 leading-relaxed">
            {{ __('Transparansi hasil uji parameter fisik dan kimia komoditas gula aren kami sebagai garansi keamanan pangan untuk industri F&B.') }}
        </p>
    </div>

    <!-- Parameter Benchmark Table -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 lg:p-10 border border-[#E8DFD1] shadow-xs space-y-4">
        <div>
            <span class="text-[10px] font-mono uppercase tracking-wider text-[#C87D20]">{{ __('SNI 01-3743-1995 & Sucofindo Benchmark') }}</span>
            <h3 class="font-serif font-bold text-2xl text-[#2C1810]">{{ __('Parameter Fisiko-Kimia Gula Semut Gumer') }}</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs font-mono">
                <thead class="bg-[#FAF6EE] text-[#5C3317] uppercase text-[11px] font-bold border-b border-[#E8DFD1]">
                    <tr>
                        <th class="px-6 py-4">{{ __('Parameter Pengujian') }}</th>
                        <th class="px-6 py-4">{{ __('Standar SNI / Regulasi') }}</th>
                        <th class="px-6 py-4">{{ __('Hasil Uji Lab Gumer') }}</th>
                        <th class="px-6 py-4">{{ __('Status Kelulusan') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E8DFD1]">
                    <tr>
                        <td class="px-6 py-3.5 font-bold text-stone-900">{{ __('Kadar Air (Moisture Content)') }}</td>
                        <td class="px-6 py-3.5 text-stone-500">{{ __('Maksimal 3.0%') }}</td>
                        <td class="px-6 py-3.5 font-bold text-[#5C3317]">0.8% - 1.2%</td>
                        <td class="px-6 py-3.5 text-emerald-700 font-bold">{{ __('MEMENUHI (Superior)') }}</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-3.5 font-bold text-stone-900">{{ __('Kadar Abu Total') }}</td>
                        <td class="px-6 py-3.5 text-stone-500">{{ __('Maksimal 2.0%') }}</td>
                        <td class="px-6 py-3.5 font-bold text-[#5C3317]">1.4%</td>
                        <td class="px-6 py-3.5 text-emerald-700 font-bold">{{ __('MEMENUHI') }}</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-3.5 font-bold text-stone-900">{{ __('Ukuran Butiran (Sieve Mesh 18)') }}</td>
                        <td class="px-6 py-3.5 text-stone-500">{{ __('Minimal 85% Lolos') }}</td>
                        <td class="px-6 py-3.5 font-bold text-[#5C3317]">96.4% Lolos</td>
                        <td class="px-6 py-3.5 text-emerald-700 font-bold">MEMENUHI</td>
                    </tr>
                    <tr>
                        <td class="px-6 py-3.5 font-bold text-stone-900">{{ __('Cemaran Logam Berat (Pb, Cd, As)') }}</td>
                        <td class="px-6 py-3.5 text-stone-500">{{ __('Di Bawah Batas BPOM') }}</td>
                        <td class="px-6 py-3.5 font-bold text-[#5C3317]">{{ __('Negatif / Tidak Terdeteksi') }}</td>
                        <td class="px-6 py-3.5 text-emerald-700 font-bold">{{ __('MEMENUHI (Aman)') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Official Certifications Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
        @foreach($certifications as $cert)
            <div class="p-6 sm:p-8 rounded-3xl bg-white border border-[#E8DFD1] shadow-xs flex flex-col justify-between space-y-4">
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="px-2.5 py-1 rounded-md text-[10px] font-mono font-bold bg-[#FAF6EE] text-[#5C3317] border border-[#E8DFD1]">
                            {{ $cert->issuer }}
                        </span>
                        <span class="text-xs font-bold text-emerald-700 flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            Terverifikasi Aktif
                        </span>
                    </div>

                    <h3 class="font-serif font-bold text-2xl text-[#2C1810]">{{ $cert->name }}</h3>
                    <p class="font-mono text-xs font-bold text-[#C87D20]">No. Registrasi: {{ $cert->cert_number }}</p>
                    <p class="text-xs text-stone-500 leading-relaxed">{{ $cert->description }}</p>
                </div>

                @if($cert->document_file)
                    <div class="pt-4 border-t border-[#E8DFD1]">
                        <a href="{{ asset('storage/' . $cert->document_file) }}" target="_blank"
                           class="py-2.5 px-4 bg-[#FAF6EE] hover:bg-[#5C3317] hover:text-white text-[#5C3317] border border-[#E8DFD1] text-xs font-bold rounded-xl transition text-center block">
                            {{ __('Buka Salinan Scan Dokumen Asli') }}
                        </a>
                    </div>
                @endif
            </div>
        @endforeach
    </div>

</div>
@endsection
