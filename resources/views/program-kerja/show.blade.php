@extends('layouts.app')

@section('title', $program->nama_program)

@section('content')
<section class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14">
    <a href="{{ route('program-kerja.index') }}" class="text-sm text-emerald-700 hover:underline">&larr; Kembali ke Program Kerja KKN</a>

    <div class="flex items-center gap-2 mt-5 mb-2">
        <span class="inline-block rounded-full px-2.5 py-1 text-xs font-medium {{ $program->statusColor() }}">{{ $program->statusLabel() }}</span>
        @if ($program->bidang)
            <span class="text-xs text-emerald-900/40">&middot; {{ $program->bidang }}</span>
        @endif
    </div>

    <h1 class="font-display text-2xl sm:text-3xl font-semibold text-emerald-950 mb-2">{{ $program->nama_program }}</h1>
    <p class="text-sm text-emerald-900/50 mb-6">
        @if ($program->penanggung_jawab)
            Penanggung jawab <span class="font-medium text-emerald-900/70">{{ $program->penanggung_jawab }}</span>
            &middot;
        @endif
        {{ optional($program->tanggal_mulai)->translatedFormat('d F Y') ?? '-' }}
        @if ($program->tanggal_selesai)
            &ndash; {{ $program->tanggal_selesai->translatedFormat('d F Y') }}
        @endif
    </p>

    @if ($program->dokumentasi)
        <img src="{{ asset('storage/'.$program->dokumentasi) }}" alt="{{ $program->nama_program }}" class="w-full rounded-2xl border border-emerald-900/10 mb-8 object-cover max-h-[420px]">
    @endif

    @if ($program->lokasi)
        <div class="rounded-2xl bg-cream-100 px-5 py-4 mb-8 text-sm">
            <span class="text-emerald-900/50">Lokasi Kegiatan</span>
            <p class="font-medium text-emerald-950 mt-0.5">{{ $program->lokasi }}</p>
        </div>
    @endif

    <div class="prose max-w-none text-emerald-950/80 whitespace-pre-line leading-relaxed">{{ $program->deskripsi ?: 'Belum ada deskripsi untuk program kerja ini.' }}</div>

    @if ($lainnya->isNotEmpty())
        <div class="mt-10 sm:mt-14">
            <h2 class="font-display font-semibold text-lg text-emerald-950 mb-4">Program Kerja Lainnya</h2>
            <div class="grid sm:grid-cols-3 gap-4">
                @foreach ($lainnya as $item)
                    <a href="{{ route('program-kerja.show', $item) }}" class="block rounded-2xl border border-emerald-900/10 bg-white overflow-hidden hover:shadow-md transition">
                        @if ($item->dokumentasi)
                            <img src="{{ asset('storage/'.$item->dokumentasi) }}" class="h-28 w-full object-cover">
                        @else
                            <div class="h-28 w-full bg-emerald-50"></div>
                        @endif
                        <div class="p-3">
                            <p class="text-sm font-medium text-emerald-950 line-clamp-2">{{ $item->nama_program }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</section>
@endsection
