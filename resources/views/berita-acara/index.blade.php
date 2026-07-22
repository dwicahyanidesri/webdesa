@extends('layouts.app')

@section('title', 'Berita Acara')

@section('content')
<section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
    <p class="uppercase tracking-[0.2em] text-gold-600 text-xs font-medium mb-3">Dokumentasi</p>
    <h1 class="font-display text-3xl font-semibold text-emerald-950 mb-2">Berita Acara</h1>
    <p class="text-emerald-900/50 mb-8">Dokumentasi kegiatan dan berita acara resmi Desa Tanjung Agung.</p>

    @if ($beritaAcara->isEmpty())
        <p class="text-emerald-900/50 text-sm">Belum ada berita acara yang dipublikasikan.</p>
    @else
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($beritaAcara as $berita)
                <a href="{{ route('berita-acara.show', $berita->slug) }}" class="block rounded-2xl border border-emerald-900/10 bg-white overflow-hidden hover:shadow-md transition">
                    @if ($berita->gambar)
                        <img src="{{ asset('storage/'.$berita->gambar) }}" alt="{{ $berita->judul }}" class="h-44 w-full object-cover">
                    @else
                        <div class="h-44 w-full bg-emerald-50 flex items-center justify-center text-emerald-600 font-medium">Berita Acara</div>
                    @endif
                    <div class="p-5">
                        <p class="text-xs text-emerald-900/40 mb-1">{{ $berita->created_at->translatedFormat('d F Y') }} &middot; {{ $berita->penulis ?? 'Admin Desa' }}</p>
                        <h3 class="font-semibold mb-2 line-clamp-2">{{ $berita->judul }}</h3>
                        <p class="text-sm text-emerald-900/70 line-clamp-3">{{ \Illuminate\Support\Str::limit(strip_tags($berita->isi), 120) }}</p>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $beritaAcara->links() }}
        </div>
    @endif
</section>
@endsection
