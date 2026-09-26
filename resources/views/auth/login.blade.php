<!DOCTYPE html>
<html lang="id" class="h-full bg-[#FAF6EE]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — Gumer Pabrik Gula Merah</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600;1,700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased text-[#2C1810] flex items-center justify-center p-6 bg-[#FAF6EE]">

    <div class="w-full max-w-md">
        <!-- Logo Brand -->
        <div class="text-center mb-8">
            <div class="inline-flex w-16 h-16 rounded-2xl bg-gradient-to-br from-[#C87D20] to-[#5C3317] items-center justify-center text-white font-serif font-bold text-3xl shadow-lg mb-4">
                G
            </div>
            <h1 class="font-serif font-bold text-3xl text-[#2C1810] tracking-tight">GUMER</h1>
            <p class="text-xs uppercase tracking-widest text-[#C87D20] font-semibold mt-1">Pabrik Gula Merah & Aren Nusantara</p>
            <p class="text-sm text-stone-600 mt-2">Masuk ke panel manajemen konten & penawaran B2B</p>
        </div>

        <!-- Login Card -->
        <div class="bg-white rounded-2xl p-8 border border-[#E8DFD1] shadow-xl shadow-stone-900/5">
            @if ($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-xs font-medium">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-2">Email Admin</label>
                    <input type="email" id="email" name="email" value="{{ old('email', 'admin@gumer.id') }}" required autofocus
                           class="w-full px-4 py-3 rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20] text-sm text-[#2C1810] transition"
                           placeholder="nama@gumer.id">
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold uppercase tracking-wider text-stone-700 mb-2">Password</label>
                    <input type="password" id="password" name="password" required
                           class="w-full px-4 py-3 rounded-xl border border-[#E8DFD1] bg-[#FAF6EE]/50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-[#C87D20] text-sm text-[#2C1810] transition"
                           placeholder="••••••••">
                </div>

                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center gap-2 cursor-pointer text-stone-600">
                        <input type="checkbox" name="remember" class="rounded border-[#E8DFD1] text-[#C87D20] focus:ring-[#C87D20]">
                        <span>Ingat sesi saya</span>
                    </label>
                    <span class="text-stone-400">Default: password123</span>
                </div>

                <button type="submit" 
                        class="w-full py-3.5 px-4 bg-[#5C3317] hover:bg-[#2C1810] text-white font-semibold rounded-xl text-sm transition shadow-md hover:shadow-lg flex items-center justify-center gap-2 cursor-pointer">
                    <span>Masuk ke Admin Panel</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </button>
            </form>
        </div>

        <p class="text-center text-xs text-stone-500 mt-8">
            &copy; {{ date('Y') }} Gumer Agro Manufaktur. Dilindungi hak cipta.
        </p>
    </div>

</body>
</html>
