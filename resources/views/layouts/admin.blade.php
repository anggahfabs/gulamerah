<!DOCTYPE html>
<html lang="id" class="h-full bg-[#FAF6EE]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') — Gumer Pabrik Gula Merah</title>

    <!-- Google Fonts: Fraunces & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600;1,700&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full text-[#2C1810] font-sans antialiased bg-[#FAF6EE]" x-data="{ sidebarOpen: false }">

    <div class="min-h-full flex">
        <!-- Mobile Sidebar Backdrop -->
        <div x-show="sidebarOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-40 bg-black/60 lg:hidden" 
             @click="sidebarOpen = false" 
             style="display: none;"></div>

        <!-- Sidebar Navigation -->
        <aside class="fixed inset-y-0 left-0 z-50 w-72 bg-[#2C1810] text-[#FAF6EE] flex flex-col justify-between transition-transform duration-300 lg:translate-x-0"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">
            
            <div>
                <!-- Brand Logo / Header -->
                <div class="h-20 flex items-center justify-between px-6 border-b border-white/10">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#C87D20] to-[#5C3317] flex items-center justify-center text-white font-serif font-bold text-xl shadow-md">
                            G
                        </div>
                        <div>
                            <span class="font-serif font-bold text-xl tracking-wide text-white block">GUMER</span>
                            <span class="text-[10px] tracking-widest uppercase text-[#C87D20] font-semibold block">CMS Pabrik Gula</span>
                        </div>
                    </a>
                    <button @click="sidebarOpen = false" class="lg:hidden text-stone-400 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Navigation Links -->
                <nav class="px-4 py-6 space-y-1.5 overflow-y-auto max-h-[calc(100vh-160px)]">
                    <p class="px-3 text-[11px] font-semibold uppercase tracking-wider text-stone-400 mb-2">Utama</p>
                    
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-[#C87D20] text-white shadow-sm' : 'text-stone-300 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Dashboard
                    </a>

                    <p class="px-3 text-[11px] font-semibold uppercase tracking-wider text-stone-400 mt-6 mb-2">Katalog & Produksi</p>

                    <a href="{{ route('admin.products.index') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.products.*') ? 'bg-[#C87D20] text-white shadow-sm' : 'text-stone-300 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        Kelola Produk & Varian
                    </a>

                    <a href="{{ route('admin.categories.index') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.categories.*') ? 'bg-[#C87D20] text-white shadow-sm' : 'text-stone-300 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                        Kelola Kategori
                    </a>

                    <a href="{{ route('admin.services.index') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.services.*') ? 'bg-[#C87D20] text-white shadow-sm' : 'text-stone-300 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        Layanan B2B & Maklon
                    </a>

                    <a href="{{ route('admin.certifications.index') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.certifications.*') ? 'bg-[#C87D20] text-white shadow-sm' : 'text-stone-300 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                        Sertifikasi & Uji Lab
                    </a>

                    <a href="{{ route('admin.galleries.index') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.galleries.*') ? 'bg-[#C87D20] text-white shadow-sm' : 'text-stone-300 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Galeri Fasilitas Pabrik
                    </a>

                    <a href="{{ route('admin.articles.index') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.articles.*') ? 'bg-[#C87D20] text-white shadow-sm' : 'text-stone-300 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                        Artikel & Edukasi
                    </a>

                    <p class="px-3 text-[11px] font-semibold uppercase tracking-wider text-stone-400 mt-6 mb-2">Komunikasi & Leads</p>

                    <a href="{{ route('admin.inquiries.index') }}" 
                       class="flex items-center justify-between px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.inquiries.*') ? 'bg-[#C87D20] text-white shadow-sm' : 'text-stone-300 hover:bg-white/5 hover:text-white' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                            <span>Kotak Masuk RFQ</span>
                        </div>
                        @php $newInquiries = \App\Models\Inquiry::where('status', 'baru')->count(); @endphp
                        @if($newInquiries > 0)
                            <span class="px-2 py-0.5 text-xs font-bold rounded-full bg-amber-500 text-[#2C1810]">{{ $newInquiries }}</span>
                        @endif
                    </a>

                    <a href="{{ route('admin.subscribers.index') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.subscribers.*') ? 'bg-[#C87D20] text-white shadow-sm' : 'text-stone-300 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                        Pelanggan Newsletter
                    </a>

                    <a href="{{ route('admin.settings.index') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.settings.*') ? 'bg-[#C87D20] text-white shadow-sm' : 'text-stone-300 hover:bg-white/5 hover:text-white' }}">
                        <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Pengaturan Website & Kontak
                    </a>
                </nav>
            </div>

            <!-- User Info & Logout -->
            <div class="p-4 border-t border-white/10 bg-black/20">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-[#5C3317] border border-[#C87D20] flex items-center justify-center font-bold text-white text-sm">
                            {{ substr(auth()->user()->name ?? 'Admin', 0, 1) }}
                        </div>
                        <div class="overflow-hidden">
                            <p class="text-xs font-semibold text-white truncate">{{ auth()->user()->name ?? 'Super Admin' }}</p>
                            <p class="text-[10px] text-stone-400 truncate">{{ auth()->user()->email ?? 'admin@gumer.id' }}</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" title="Logout" class="p-2 text-stone-400 hover:text-red-400 hover:bg-white/5 rounded-lg transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 lg:pl-72">
            <!-- Top Navbar -->
            <header class="h-20 bg-white border-b border-[#E8DFD1] flex items-center justify-between px-6 lg:px-10 sticky top-0 z-30 shadow-xs">
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="lg:hidden p-2 text-stone-600 hover:text-stone-900 rounded-lg border border-[#E8DFD1]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                    <div>
                        <h1 class="font-serif font-bold text-xl text-[#2C1810]">@yield('header-title', 'Dashboard')</h1>
                        <p class="text-xs text-stone-500 hidden sm:block">@yield('header-subtitle', 'Panel Kontrol Resmi Pabrik Gula Merah Gumer')</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <!-- Quick View Website -->
                    <a href="{{ url('/') }}" target="_blank" class="inline-flex items-center gap-2 px-3.5 py-1.5 text-xs font-semibold text-[#5C3317] bg-[#FAF6EE] border border-[#E8DFD1] rounded-lg hover:bg-stone-100 transition">
                        <span>Lihat Website</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </a>
                </div>
            </header>

            <!-- Page Body Content -->
            <main class="flex-1 p-6 lg:p-10">
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="py-4 px-6 lg:px-10 border-t border-[#E8DFD1] text-xs text-stone-500 flex flex-col sm:flex-row items-center justify-between gap-2">
                <span>&copy; {{ date('Y') }} Gumer — Modern Brown Sugar Factory CMS. All rights reserved.</span>
                <span>Standar Mutu Uji Lab & Organik</span>
            </footer>
        </div>
    </div>

    <!-- SweetAlert2 Flash Notifications -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            @if(session('success'))
                window.Toast.fire({
                    icon: 'success',
                    title: '{{ session('success') }}'
                });
            @endif

            @if(session('error'))
                window.Toast.fire({
                    icon: 'error',
                    title: '{{ session('error') }}'
                });
            @endif

            @if($errors->any())
                window.Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian!',
                    html: '{!! implode("<br>", $errors->all()) !!}',
                    confirmButtonColor: '#C87D20',
                    background: '#FAF6EE',
                    color: '#2C1810',
                });
            @endif
        });

        function confirmDelete(formId, message = 'Data yang dihapus tidak dapat dikembalikan!') {
            window.Swal.fire({
                title: 'Apakah Anda yakin?',
                text: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#B91C1C',
                cancelButtonColor: '#7A695C',
                confirmButtonText: 'Ya, Hapus Data',
                cancelButtonText: 'Batal',
                background: '#FAF6EE',
                color: '#2C1810',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }
    </script>

    @stack('scripts')
</body>
</html>
