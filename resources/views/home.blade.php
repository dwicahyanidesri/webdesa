@extends('layouts.app')

@section('title', 'Beranda')

@section('content')

    @php
        $heroImage = $profil && $profil->foto_hero ? asset('storage/'.$profil->foto_hero) : asset('img/kerja-kerja.jpg');
    @endphp

    <!-- Hero -->
    <section class="relative bg-hero-image min-h-[600px] flex items-end" style="background-image: url('{{ $heroImage }}');">
        <div class="absolute inset-0 bg-gradient-to-t from-emerald-950 via-emerald-950/70 to-emerald-950/20"></div>
        <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-40 pb-16 w-full">
            <p class="inline-flex items-center gap-2 uppercase tracking-[0.2em] text-gold-400 text-xs font-medium mb-4">
                <span class="h-px w-8 bg-gold-400"></span>
                Website Resmi Pemerintah Desa
            </p>
            <h1 class="font-display text-4xl md:text-6xl font-semibold text-cream-50 text-shadow-sm mb-4 max-w-2xl">
                Desa {{ $profil->nama_desa ?? 'Tanjung Agung' }}
            </h1>
            <p class="max-w-xl text-cream-100/90 text-base md:text-lg mb-8">
                {{ $profil->kecamatan ?? '' }}{{ $profil->kabupaten ? ', '.$profil->kabupaten : '' }}{{ $profil->provinsi ? ', '.$profil->provinsi : '' }}
            </p>
            <div class="flex flex-wrap gap-3">
                <a href="#profil" class="rounded-full bg-cream-50 text-emerald-900 px-6 py-3 font-medium hover:bg-cream-100 transition">Jelajahi Profil Desa</a>
                <a href="{{ route('program-kerja.index') }}" class="rounded-full border border-cream-50/50 text-cream-50 px-6 py-3 font-medium hover:bg-cream-50/10 transition">Program Kerja KKN</a>
            </div>

            @if ($profil && ($profil->luas_wilayah || $profil->jumlah_penduduk))
                <div class="mt-14 grid grid-cols-2 sm:grid-cols-3 gap-4 max-w-xl">
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
    <section id="profil" class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-20 scroll-mt-20">
        <div class="max-w-xl mb-10">
            <p class="uppercase tracking-[0.2em] text-gold-600 text-xs font-medium mb-3">Profil Desa</p>
            <h2 class="font-display text-3xl font-semibold text-emerald-950 mb-3">Sejarah, Visi &amp; Misi</h2>
            <p class="text-emerald-900/60">Mengenal lebih dekat Desa {{ $profil->nama_desa ?? 'Tanjung Agung' }} dan arah pembangunannya.</p>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-5">
                <div class="bg-white rounded-2xl border border-emerald-900/10 p-7">
                    <h3 class="font-display font-semibold text-lg text-emerald-950 mb-3">Sejarah Desa</h3>
                    <p class="text-emerald-900/70 leading-relaxed whitespace-pre-line">{{ $profil->sejarah ?? '-' }}</p>
                </div>
                <div class="grid sm:grid-cols-2 gap-5">
                    <div class="bg-emerald-900 rounded-2xl p-7 text-cream-100">
                        <h3 class="font-display font-semibold text-lg text-cream-50 mb-2">Visi</h3>
                        <p class="text-cream-100/80 leading-relaxed text-sm">{{ $profil->visi ?? '-' }}</p>
                    </div>
                    <div class="bg-white rounded-2xl border border-emerald-900/10 p-7">
                        <h3 class="font-display font-semibold text-lg text-emerald-950 mb-2">Misi</h3>
                        <p class="text-emerald-900/70 leading-relaxed whitespace-pre-line text-sm">{{ $profil->misi ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="space-y-5">
                <div class="bg-cream-100 rounded-2xl p-6">
                    <dl class="space-y-4 text-sm">
                        <div class="flex justify-between gap-4">
                            <dt class="text-emerald-900/50">Luas Wilayah</dt>
                            <dd class="font-medium text-emerald-950 text-right">{{ $profil->luas_wilayah ?? '-' }}</dd>
                        </div>
                        <div class="flex justify-between gap-4">
                            <dt class="text-emerald-900/50">Jumlah Penduduk</dt>
                            <dd class="font-medium text-emerald-950 text-right">{{ $profil->jumlah_penduduk ?? '-' }}</dd>
                        </div>
                        <div class="flex justify-between gap-4">
                            <dt class="text-emerald-900/50">Kecamatan</dt>
                            <dd class="font-medium text-emerald-950 text-right">{{ $profil->kecamatan ?? '-' }}</dd>
                        </div>
                        <div class="flex justify-between gap-4">
                            <dt class="text-emerald-900/50">Kabupaten</dt>
                            <dd class="font-medium text-emerald-950 text-right">{{ $profil->kabupaten ?? '-' }}</dd>
                        </div>
                    </dl>
                </div>
                @if ($profil && $profil->foto_desa)
                    <img src="{{ asset('storage/'.$profil->foto_desa) }}" alt="Foto Desa" class="rounded-2xl w-full object-cover aspect-[4/3]">
                @endif
            </div>
        </div>
    </section>

    <!-- Potensi Desa -->
    <section id="potensi" class="bg-cream-100 scroll-mt-20">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="max-w-xl mb-10">
                <p class="uppercase tracking-[0.2em] text-gold-600 text-xs font-medium mb-3">Unggulan</p>
                <h2 class="font-display text-3xl font-semibold text-emerald-950 mb-3">Potensi Desa</h2>
                <p class="text-emerald-900/60">Sumber daya dan potensi unggulan yang dimiliki desa.</p>
            </div>

            @if ($potensi->isEmpty())
                <p class="text-emerald-900/50 text-sm">Belum ada data potensi desa.</p>
            @else
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($potensi as $item)
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
            @endif
        </div>
    </section>

    <!-- Pemerintahan Desa -->
    <section id="pemerintahan" class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-20 scroll-mt-20">
        <div class="max-w-xl mb-14">
            <p class="uppercase tracking-[0.2em] text-gold-600 text-xs font-medium mb-3">Struktur Organisasi</p>
            <h2 class="font-display text-3xl font-semibold text-emerald-950 mb-3">Pemerintahan Desa</h2>
            <p class="text-emerald-900/60">Bagan susunan perangkat Desa Tanjung Agung.</p>
        </div>

        @if ($perangkat->isEmpty())
            <p class="text-emerald-900/50 text-sm">Belum ada data perangkat desa.</p>
        @else
            <div class="flex flex-col items-center gap-2">
                @foreach ([1, 2, 3] as $level)
                    @if (isset($perangkat[$level]))
                        <div class="w-full flex flex-col items-center">
                            @if ($level > 1)
                                <div class="h-10 w-px bg-emerald-900/15"></div>
                            @endif
                            <div class="flex flex-wrap justify-center gap-5">
                                @foreach ($perangkat[$level] as $orang)
                                    <div class="w-48 rounded-2xl border border-emerald-900/10 bg-white p-5 text-center hover:border-emerald-700/30 transition">
                                        @if ($orang->foto)
                                            <img src="{{ asset('storage/'.$orang->foto) }}" alt="{{ $orang->nama }}" class="h-16 w-16 rounded-full object-cover mx-auto mb-3 ring-4 ring-cream-100">
                                        @else
                                            <div class="h-16 w-16 rounded-full bg-emerald-100 text-emerald-700 mx-auto mb-3 flex items-center justify-center font-display font-semibold ring-4 ring-cream-100">
                                                {{ strtoupper(substr($orang->nama, 0, 1)) }}
                                            </div>
                                        @endif
                                        <p class="font-medium text-sm text-emerald-950">{{ $orang->nama }}</p>
                                        <p class="text-xs text-emerald-900/50 mt-0.5">{{ $orang->jabatan }}</p>
                                    </div>
                                @endforeach
                            </div>
                            <div class="h-10 w-px bg-emerald-900/15"></div>
                        </div>
                    @endif
                @endforeach
            </div>
        @endif
    </section>

    <!-- Kontak -->
    <section id="kontak" class="bg-emerald-950 text-white scroll-mt-20">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="max-w-xl mb-12">
                <p class="uppercase tracking-[0.2em] text-gold-400 text-xs font-medium mb-3">Hubungi Kami</p>
                <h2 class="font-display text-3xl font-semibold text-cream-50 mb-3">Kontak Person</h2>
                <p class="text-cream-100/60">Kami siap membantu untuk informasi lebih lanjut seputar desa.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <div class="rounded-2xl bg-cream-50/5 border border-cream-50/10 p-6">
                    <p class="text-xs uppercase tracking-wide text-gold-400 mb-2">Narahubung</p>
                    <p class="font-display font-semibold text-lg text-cream-50">{{ $profil->nama_kontak ?? '-' }}</p>
                    <p class="text-cream-100/60 text-sm mt-0.5">{{ $profil->jabatan_kontak ?? '-' }}</p>
                </div>
                <div class="rounded-2xl bg-cream-50/5 border border-cream-50/10 p-6">
                    <p class="text-xs uppercase tracking-wide text-gold-400 mb-2">Telepon &amp; Email</p>
                    <p class="font-medium text-cream-50">{{ $profil->no_telepon ?? '-' }}</p>
                    <p class="text-cream-100/60 text-sm mt-0.5">{{ $profil->email ?? '-' }}</p>
                </div>
                <div class="rounded-2xl bg-cream-50/5 border border-cream-50/10 p-6">
                    <p class="text-xs uppercase tracking-wide text-gold-400 mb-2">Jam Pelayanan</p>
                    <p class="font-medium text-cream-50">{{ $profil->jam_pelayanan ?? '-' }}</p>
                </div>
                <div class="md:col-span-3 rounded-2xl bg-cream-50/5 border border-cream-50/10 p-6">
                    <p class="text-xs uppercase tracking-wide text-gold-400 mb-2">Alamat Kantor Desa</p>
                    <p class="text-cream-100/80">{{ $profil->alamat_kantor ?? '-' }}</p>
                </div>
            </div>
        </div>
    </section>

@endsection
