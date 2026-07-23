@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

    @php
        $heroImage = $profil && $profil->foto_hero ? asset('storage/'.$profil->foto_hero) : asset('img/kerja-kerja.jpg');
    @endphp

    <!-- Hero -->
    <section class="relative bg-hero-image min-h-[460px] sm:min-h-[560px] lg:min-h-[600px] flex items-end" style="background-image: url('{{ $heroImage }}');">
        <div class="absolute inset-0 bg-gradient-to-t from-emerald-950 via-emerald-950/70 to-emerald-950/20"></div>
        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 sm:pt-32 lg:pt-40 pb-10 sm:pb-16 w-full">
            <p class="inline-flex items-center gap-2 uppercase tracking-[0.2em] text-gold-400 text-[11px] sm:text-xs font-medium mb-3 sm:mb-4">
                <span class="h-px w-8 bg-gold-400"></span>
                Website Resmi Pemerintah Desa
            </p>
            <h1 class="font-display text-3xl sm:text-4xl md:text-6xl font-semibold text-cream-50 text-shadow-sm mb-3 sm:mb-4 max-w-2xl">
                Desa {{ $profil->nama_desa ?? 'Tanjung Agung' }}
            </h1>
            <p class="max-w-xl text-cream-100/90 text-sm sm:text-base md:text-lg mb-6 sm:mb-8">
                {{ $profil->kecamatan ?? '' }}{{ $profil->kabupaten ? ', '.$profil->kabupaten : '' }}{{ $profil->provinsi ? ', '.$profil->provinsi : '' }}
            </p>
            <div class="flex flex-col sm:flex-row flex-wrap gap-3">
                <a href="#profil" class="rounded-full bg-cream-50 text-emerald-900 px-6 py-3 font-medium text-center hover:bg-cream-100 transition">Jelajahi Profil Desa</a>
                <a href="{{ route('program-kerja.index') }}" class="rounded-full border border-cream-50/50 text-cream-50 px-6 py-3 font-medium text-center hover:bg-cream-50/10 transition">Program Kerja KKN</a>
            </div>

            @if ($profil && ($profil->luas_wilayah || $profil->jumlah_penduduk))
                <div class="mt-8 sm:mt-14 grid grid-cols-2 sm:grid-cols-3 gap-3 sm:gap-4 max-w-xl">
                    @if ($profil->jumlah_penduduk)
                        <div class="rounded-2xl bg-cream-50/10 backdrop-blur-sm border border-cream-50/20 px-5 py-4">
                            <p class="text-2xl font-display font-semibold text-gold-400">{{ $profil->jumlah_penduduk }}</p>
                            <p class="text-xs text-cream-100/80 mt-1">Jumlah Penduduk</p>
                        </div>
                    @endif
                    @if ($profil->luas_wilayah)
                        <div class="rounded-2xl bg-cream-50/10 backdrop-blur-sm border border-cream-50/20 px-5 py-4">
                            <p class="text-2xl font-display font-semibold text-gold-400">{{ $profil->luas_wilayah }}</p>
                            <p class="text-xs text-cream-100/80 mt-1">Luas Wilayah</p>
                        </div>
                    @endif
                    <div class="rounded-2xl bg-cream-50/10 backdrop-blur-sm border border-cream-50/20 px-5 py-4">
                        <p class="text-2xl font-display font-semibold text-gold-400">{{ $potensi->count() }}</p>
                        <p class="text-xs text-cream-100/80 mt-1">Potensi Unggulan</p>
                    </div>
                </div>
            @endif
        </div>
    </section>

    <!-- Profil Desa -->
    <section id="profil" class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-20 scroll-mt-20">
        <div class="max-w-xl mb-10">
            <p class="uppercase tracking-[0.2em] text-gold-600 text-xs font-medium mb-3">Profil Desa</p>
            <h2 class="font-display text-3xl font-semibold text-emerald-950 mb-3">Sejarah, Visi &amp; Misi</h2>
            <p class="text-emerald-900/60">Mengenal lebih dekat Desa {{ $profil->nama_desa ?? 'Tanjung Agung' }} dan arah pembangunannya.</p>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            <div class="lg:col-span-3 space-y-5">
                <div class="bg-white rounded-2xl border border-emerald-900/10 p-5 sm:p-7">
                    <h3 class="font-display font-semibold text-lg text-emerald-950 mb-3">Sejarah Desa</h3>
                    <p class="text-emerald-900/70 leading-relaxed whitespace-pre-line">{{ $profil->sejarah ?? '-' }}</p>
                </div>
                <div class="grid sm:grid-cols-2 gap-5">
                    <div class="bg-emerald-900 rounded-2xl p-5 sm:p-7 text-cream-100">
                        <h3 class="font-display font-semibold text-lg text-cream-50 mb-2">Visi</h3>
                        <p class="text-cream-100/80 leading-relaxed text-sm">{{ $profil->visi ?? '-' }}</p>
                    </div>
                    <div class="bg-white rounded-2xl border border-emerald-900/10 p-5 sm:p-7">
                        <h3 class="font-display font-semibold text-lg text-emerald-950 mb-2">Misi</h3>
                        <p class="text-emerald-900/70 leading-relaxed whitespace-pre-line text-sm">{{ $profil->misi ?? '-' }}</p>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Potensi Desa -->
    <section id="potensi" class="bg-cream-100 scroll-mt-20">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-20">
            <div class="max-w-xl mb-10">
                <p class="uppercase tracking-[0.2em] text-gold-600 text-xs font-medium mb-3">Unggulan</p>
                <h2 class="font-display text-3xl font-semibold text-emerald-950 mb-3">Potensi Desa</h2>
                <p class="text-emerald-900/60">Sumber daya dan potensi unggulan yang dimiliki desa.</p>
            </div>

            @if ($potensi->isEmpty())
                <p class="text-emerald-900/50 text-sm">Belum ada data potensi desa.</p>
            @else
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($potensi->take(6) as $item)
                        <div class="group rounded-2xl bg-white overflow-hidden hover:shadow-xl hover:shadow-emerald-900/10 transition">
                            @if ($item->gambar)
                                <div class="h-44 overflow-hidden">
                                    <img src="{{ asset('storage/'.$item->gambar) }}" alt="{{ $item->judul }}" class="h-full w-full object-cover group-hover:scale-105 transition duration-500">
                                </div>
                            @else
                                <div class="h-44 w-full bg-emerald-800 flex items-center justify-center text-cream-100 font-display font-medium">{{ $item->kategori ?? 'Potensi' }}</div>
                            @endif
                            <div class="p-6">
                                @if ($item->kategori)
                                    <span class="inline-block text-xs font-medium text-gold-600 bg-gold-400/10 rounded-full px-2.5 py-1 mb-3">{{ $item->kategori }}</span>
                                @endif
                                <h3 class="font-display font-semibold text-emerald-950 mb-1.5">{{ $item->judul }}</h3>
                                <p class="text-sm text-emerald-900/60 line-clamp-3">{{ $item->deskripsi }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

                @if ($potensi->count() > 6)
                    <div class="mt-8 text-center">
                        <a href="{{ route('potensi.index') }}" class="inline-flex items-center gap-2 rounded-full bg-emerald-700 hover:bg-emerald-800 text-cream-50 px-6 py-2.5 text-sm font-medium transition-colors">
                            Lihat Semua Potensi Desa
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>
                @endif
            @endif
        </div>
    </section>

    <!-- Pemerintahan Desa -->
    <section id="pemerintahan" class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-20 scroll-mt-20">
        <div class="max-w-xl mb-10 sm:mb-14">
            <p class="uppercase tracking-[0.2em] text-gold-600 text-xs font-medium mb-3">Struktur Organisasi</p>
            <h2 class="font-display text-3xl font-semibold text-emerald-950 mb-3">Pemerintahan Desa</h2>
            <p class="text-emerald-900/60">Bagan susunan perangkat Desa Tanjung Agung.</p>
        </div>

        @if ($perangkatTree->isEmpty())
            <p class="text-emerald-900/50 text-sm">Belum ada data perangkat desa.</p>
        @else
            <div
                class="org-chart-scroller relative -mx-4 px-4 sm:mx-0 sm:px-0 overflow-x-auto no-scrollbar pb-2"
                x-data="{
                    down: false, startX: 0, scrollLeft: 0, dragged: false,
                    start(e) {
                        this.down = true; this.dragged = false;
                        this.$el.classList.add('cursor-grabbing');
                        this.startX = e.pageX - this.$el.offsetLeft;
                        this.scrollLeft = this.$el.scrollLeft;
                    },
                    move(e) {
                        if (!this.down) return;
                        const walk = e.pageX - this.$el.offsetLeft - this.startX;
                        if (Math.abs(walk) > 4) this.dragged = true;
                        this.$el.scrollLeft = this.scrollLeft - walk;
                    },
                    end() { this.down = false; this.$el.classList.remove('cursor-grabbing'); },
                }"
                @mousedown="start"
                @mousemove="move"
                @mouseup="end"
                @mouseleave="end"
                @click.capture="if (dragged) { $event.stopPropagation(); dragged = false; }"
            >
                <ul class="org-chart cursor-grab select-none">
                    @foreach ($perangkatTree as $root)
                        @include('partials.org-node', ['node' => $root])
                    @endforeach
                </ul>
                <p class="sm:hidden text-center text-[11px] text-emerald-900/40 mt-2">← geser untuk lihat semua →</p>
            </div>
        @endif
    </section>

@endsection
