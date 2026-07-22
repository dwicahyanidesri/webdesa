@extends('layouts.app')

@section('title', $berita->judul)

@section('content')
<section class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14">
    <a href="{{ route('berita-acara.index') }}" class="text-sm text-emerald-700 hover:underline">&larr; Kembali ke Berita Acara</a>

    <h1 class="font-display text-2xl sm:text-3xl font-semibold text-emerald-950 mt-4 mb-2">{{ $berita->judul }}</h1>
    <p class="text-sm text-emerald-900/50 mb-6">
        Ditulis oleh <span class="font-medium">{{ $berita->penulis ?? 'Admin Desa' }}</span>
        &middot; {{ $berita->created_at->translatedFormat('d F Y, H:i') }} WIB
    </p>

    @if ($berita->gambar)
        <img src="{{ asset('storage/'.$berita->gambar) }}" alt="{{ $berita->judul }}" class="w-full rounded-2xl border border-emerald-900/10 mb-8 object-cover max-h-[420px]">
    @endif

    <div class="prose max-w-none text-emerald-950/80 whitespace-pre-line leading-relaxed">{{ $berita->isi }}</div>

    @if ($lainnya->isNotEmpty())
        <div class="mt-10 sm:mt-14">
            <h2 class="font-semibold text-lg mb-4">Berita Acara Lainnya</h2>
            <div class="grid sm:grid-cols-3 gap-4">
                @foreach ($lainnya as $item)
                    <a href="{{ route('berita-acara.show', $item->slug) }}" class="block rounded-2xl border border-emerald-900/10 bg-white overflow-hidden hover:shadow-md transition">
                        @if ($item->gambar)
                            <img src="{{ asset('storage/'.$item->gambar) }}" class="h-28 w-full object-cover">
                        @else
                            <div class="h-28 w-full bg-emerald-50"></div>
                        @endif
                        <div class="p-3">
                            <p class="text-sm font-medium line-clamp-2">{{ $item->judul }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</section>
@endsection
