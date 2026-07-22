<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Desa Tanjung Agung')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-cream-50 text-emerald-950 antialiased min-h-screen flex flex-col">

    <header class="bg-cream-50/90 backdrop-blur-md border-b border-emerald-900/10 sticky top-0 z-40" x-data="{ open: false }">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 sm:gap-3 font-display font-semibold text-emerald-900 min-w-0">
                    <span class="inline-flex h-9 w-9 sm:h-10 sm:w-10 shrink-0 items-center justify-center rounded-full bg-emerald-700 text-cream-50 text-sm">TA</span>
                    <span class="leading-tight min-w-0 truncate">
                        <span class="block text-sm sm:text-base truncate">Desa Tanjung Agung</span>
                        <span class="hidden sm:block text-[11px] font-sans font-normal tracking-wide text-emerald-700/70">Website Resmi Pemerintah Desa</span>
                    </span>
                </a>

                <nav class="hidden lg:flex items-center gap-1 text-sm font-medium">
                    <a href="{{ route('home') }}#profil" class="rounded-full px-3.5 py-2 text-emerald-900/80 hover:bg-emerald-900/5 hover:text-emerald-900">Profil Desa</a>
                    <a href="{{ route('home') }}#potensi" class="rounded-full px-3.5 py-2 text-emerald-900/80 hover:bg-emerald-900/5 hover:text-emerald-900">Potensi Desa</a>
                    <a href="{{ route('home') }}#pemerintahan" class="rounded-full px-3.5 py-2 text-emerald-900/80 hover:bg-emerald-900/5 hover:text-emerald-900">Pemerintahan</a>
                    <a href="{{ route('program-kerja.index') }}" class="rounded-full px-3.5 py-2 text-emerald-900/80 hover:bg-emerald-900/5 hover:text-emerald-900">Program Kerja KKN</a>
                    <a href="{{ route('berita-acara.index') }}" class="rounded-full px-3.5 py-2 text-emerald-900/80 hover:bg-emerald-900/5 hover:text-emerald-900">Berita Acara</a>
                    <a href="{{ route('home') }}#kontak" class="rounded-full px-3.5 py-2 text-emerald-900/80 hover:bg-emerald-900/5 hover:text-emerald-900">Kontak</a>
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="ml-2 rounded-full bg-emerald-700 px-5 py-2 text-cream-50 hover:bg-emerald-800 transition">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="ml-2 rounded-full bg-emerald-900 px-5 py-2 text-cream-50 hover:bg-emerald-800 transition">Login</a>
                    @endauth
                </nav>

                <button class="lg:hidden p-2 text-emerald-900" @click="open = !open" aria-label="Menu">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <nav x-show="open" x-cloak class="lg:hidden pb-5 flex flex-col gap-1 text-sm font-medium">
                <a href="{{ route('home') }}#profil" class="rounded-lg px-3 py-2 hover:bg-emerald-900/5">Profil Desa</a>
                <a href="{{ route('home') }}#potensi" class="rounded-lg px-3 py-2 hover:bg-emerald-900/5">Potensi Desa</a>
                <a href="{{ route('home') }}#pemerintahan" class="rounded-lg px-3 py-2 hover:bg-emerald-900/5">Pemerintahan</a>
                <a href="{{ route('program-kerja.index') }}" class="rounded-lg px-3 py-2 hover:bg-emerald-900/5">Program Kerja KKN</a>
                <a href="{{ route('berita-acara.index') }}" class="rounded-lg px-3 py-2 hover:bg-emerald-900/5">Berita Acara</a>
                <a href="{{ route('home') }}#kontak" class="rounded-lg px-3 py-2 hover:bg-emerald-900/5">Kontak</a>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="rounded-lg px-3 py-2 font-semibold text-emerald-800">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="rounded-lg px-3 py-2 font-semibold text-emerald-800">Login</a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="flex-1">
        @if (session('success'))
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 text-sm">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-emerald-950 text-cream-200 mt-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-12 grid sm:grid-cols-3 gap-8 text-sm">
            <div>
                <div class="flex items-center gap-2 font-display text-cream-50 mb-3">
                    <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-emerald-700 text-cream-50 text-xs">TA</span>
                    Desa Tanjung Agung
                </div>
                <p class="text-cream-200/60 leading-relaxed">Website resmi profil, potensi, dan program kerja KKN Desa Tanjung Agung.</p>
            </div>
            <div>
                <p class="text-cream-50 font-medium mb-3">Jelajahi</p>
                <ul class="space-y-2 text-cream-200/70">
                    <li><a href="{{ route('home') }}#profil" class="hover:text-cream-50">Profil Desa</a></li>
                    <li><a href="{{ route('program-kerja.index') }}" class="hover:text-cream-50">Program Kerja KKN</a></li>
                    <li><a href="{{ route('berita-acara.index') }}" class="hover:text-cream-50">Berita Acara</a></li>
                </ul>
            </div>
            <div>
                <p class="text-cream-50 font-medium mb-3">Kontak</p>
                <p class="text-cream-200/70 leading-relaxed">Kantor Desa Tanjung Agung<br>Senin&ndash;Jumat, 08.00&ndash;15.00 WIB</p>
            </div>
        </div>
        <div class="border-t border-cream-50/10">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-5 text-xs text-cream-200/50 flex flex-col sm:flex-row items-center justify-between gap-2">
                <p>&copy; {{ date('Y') }} Pemerintah Desa Tanjung Agung. Seluruh hak cipta dilindungi.</p>
                <p>Dibangun untuk mendukung transparansi &amp; program kerja KKN.</p>
            </div>
        </div>
    </footer>

</body>
</html>
