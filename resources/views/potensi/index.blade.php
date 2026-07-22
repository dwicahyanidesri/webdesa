@extends('layouts.app')

@section('title', 'Potensi Desa')

@section('content')
<section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14">
    <p class="uppercase tracking-[0.2em] text-gold-600 text-xs font-medium mb-3">Unggulan</p>
    <h1 class="font-display text-2xl sm:text-3xl font-semibold text-emerald-950 mb-2">Potensi Desa</h1>
    <p class="text-emerald-900/50 mb-8">Sumber daya dan potensi unggulan yang dimiliki Desa Tanjung Agung.</p>

    @if ($potensi->isEmpty())
        <p class="text-emerald-900/50 text-sm">Belum ada data potensi desa.</p>
    @else
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($potensi as $item)
                <div class="group rounded-2xl bg-white border border-emerald-900/10 overflow-hidden hover:shadow-xl hover:shadow-emerald-900/10 transition">
                    @if ($item->gambar)
                        <div class="h-44 overflow-hidden">
                            <img src="{{ asset('storage/'.$item->gambar) }}" alt="{{ $item->judul }}" class="h-full w-full object-cover group-hover:scale-105 transition duration-500">
                        </div>
                    @else
                        <div class="h-44 w-full bg-emerald-800 flex items-center justify-center text-cream-100 font-display font-medium px-4 text-center">{{ $item->kategori ?? 'Potensi' }}</div>
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

        <div class="mt-10">
            {{ $potensi->links() }}
        </div>
    @endif
</section>
@endsection
