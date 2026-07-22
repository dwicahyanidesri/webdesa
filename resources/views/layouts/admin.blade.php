<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') &middot; Desa Tanjung Agung</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-cream-100 text-emerald-950 antialiased" x-data="{ sidebar: false }">

    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside :class="sidebar ? 'translate-x-0' : '-translate-x-full'"
               class="fixed z-30 inset-y-0 left-0 w-64 bg-emerald-950 text-cream-100 transform transition-transform md:translate-x-0 md:static md:flex md:flex-col">
            <div class="h-16 flex items-center gap-2.5 px-5 border-b border-cream-50/10 font-display font-semibold text-cream-50">
                <span class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-gold-500 text-emerald-950 text-sm">TA</span>
                Admin Desa
            </div>
            <nav class="flex-1 px-3 py-5 space-y-6 text-sm overflow-y-auto">
                <div class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 rounded-lg px-3 py-2 transition {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-800 text-cream-50' : 'text-cream-200/70 hover:bg-cream-50/5 hover:text-cream-50' }}">
                        <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.profil.edit') }}" class="flex items-center gap-2.5 rounded-lg px-3 py-2 transition {{ request()->routeIs('admin.profil.*') ? 'bg-emerald-800 text-cream-50' : 'text-cream-200/70 hover:bg-cream-50/5 hover:text-cream-50' }}">
                        <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                        Profil Desa
                    </a>
                    <a href="{{ route('admin.potensi.index') }}" class="flex items-center gap-2.5 rounded-lg px-3 py-2 transition {{ request()->routeIs('admin.potensi.*') ? 'bg-emerald-800 text-cream-50' : 'text-cream-200/70 hover:bg-cream-50/5 hover:text-cream-50' }}">
                        <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" /></svg>
                        Potensi Desa
                    </a>
                    <a href="{{ route('admin.perangkat.index') }}" class="flex items-center gap-2.5 rounded-lg px-3 py-2 transition {{ request()->routeIs('admin.perangkat.*') ? 'bg-emerald-800 text-cream-50' : 'text-cream-200/70 hover:bg-cream-50/5 hover:text-cream-50' }}">
                        <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-5.13a4 4 0 11-4-4 4 4 0 014 4zm6 3a4 4 0 10-4-4" /></svg>
                        Pemerintahan Desa
                    </a>
                    <a href="{{ route('admin.program-kerja.index') }}" class="flex items-center gap-2.5 rounded-lg px-3 py-2 transition {{ request()->routeIs('admin.program-kerja.*') ? 'bg-emerald-800 text-cream-50' : 'text-cream-200/70 hover:bg-cream-50/5 hover:text-cream-50' }}">
                        <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
                        Program Kerja KKN
                    </a>
                    <a href="{{ route('admin.berita-acara.index') }}" class="flex items-center gap-2.5 rounded-lg px-3 py-2 transition {{ request()->routeIs('admin.berita-acara.*') ? 'bg-emerald-800 text-cream-50' : 'text-cream-200/70 hover:bg-cream-50/5 hover:text-cream-50' }}">
                        <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l6 6v8a2 2 0 01-2 2zM9 12h6m-6 4h4" /></svg>
                        Berita Acara
                    </a>
                </div>

                <div>
                    <p class="px-3 text-[11px] uppercase tracking-widest text-cream-200/40 mb-1.5">Data Penduduk</p>
                    <div class="space-y-1">
                        <a href="{{ route('admin.data-penduduk.index') }}" class="flex items-center gap-2.5 rounded-lg px-3 py-2 transition {{ request()->routeIs('admin.data-penduduk.index') ? 'bg-emerald-800 text-cream-50' : 'text-cream-200/70 hover:bg-cream-50/5 hover:text-cream-50' }}">
                            <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M11 3v18m6-13v13M5 13v8m-2 0h18M5 13l3-3 3 2 4-5 3 2" /></svg>
                            Dashboard Statistik
                        </a>
                        <a href="{{ route('admin.penduduk.index') }}" class="flex items-center gap-2.5 rounded-lg px-3 py-2 transition {{ request()->routeIs('admin.penduduk.*') ? 'bg-emerald-800 text-cream-50' : 'text-cream-200/70 hover:bg-cream-50/5 hover:text-cream-50' }}">
                            <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m6-5.13a4 4 0 11-4-4 4 4 0 014 4zm6 3a4 4 0 10-4-4" /></svg>
                            Kelola Data Penduduk
                        </a>
                    </div>
                </div>

                <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-2.5 rounded-lg px-3 py-2 text-cream-200/50 hover:text-cream-50 hover:bg-cream-50/5 transition">
                    <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                    Lihat Website
                </a>
            </nav>
            <div class="p-3 border-t border-cream-50/10">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full rounded-lg bg-cream-50/5 hover:bg-cream-50/10 px-3 py-2.5 text-sm text-left text-cream-100 transition">Logout ({{ auth()->user()->name }})</button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-w-0">
            <header class="h-16 bg-cream-50/80 backdrop-blur-md border-b border-emerald-900/10 flex items-center justify-between px-4 md:px-6 sticky top-0 z-20">
                <button class="md:hidden p-2 text-emerald-900" @click="sidebar = !sidebar">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <h1 class="font-display font-semibold text-lg text-emerald-950">@yield('title', 'Dashboard')</h1>
                <div></div>
            </header>

            <main class="flex-1 p-4 md:p-6">
                @if (session('success'))
                    <div class="mb-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 text-sm">
                        {{ session('success') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="mb-4 rounded-xl bg-red-50 border border-red-200 text-red-800 px-4 py-3 text-sm">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>
