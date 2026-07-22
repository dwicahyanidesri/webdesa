@extends('layouts.app')

@section('title', 'Program Kerja KKN')

@section('content')
<section class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
    <p class="uppercase tracking-[0.2em] text-gold-600 text-xs font-medium mb-3">Kuliah Kerja Nyata</p>
    <h1 class="font-display text-3xl font-semibold text-emerald-950 mb-2">Program Kerja Mahasiswa KKN</h1>
    <p class="text-emerald-900/50 mb-8">Klik salah satu program untuk melihat detail lengkapnya.</p>

    @if ($programKerja->isEmpty())
        <p class="text-emerald-900/50 text-sm">Belum ada program kerja yang ditambahkan.</p>
    @else
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($programKerja as $item)
                <a href="{{ route('program-kerja.show', $item) }}" class="group block rounded-2xl bg-white border border-emerald-900/10 overflow-hidden hover:shadow-xl hover:shadow-emerald-900/10 transition">
                    @if ($item->dokumentasi)
                        <div class="h-44 overflow-hidden">
                            <img src="{{ asset('storage/'.$item->dokumentasi) }}" alt="{{ $item->nama_program }}" class="h-full w-full object-cover group-hover:scale-105 transition duration-500">
                        </div>
                    @else
                        <div class="h-44 w-full bg-emerald-800 flex items-center justify-center text-cream-100 font-display font-medium px-4 text-center">{{ $item->bidang ?? 'Program Kerja' }}</div>
                    @endif
                    <div class="p-5">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="inline-block rounded-full px-2.5 py-1 text-xs font-medium {{ $item->statusColor() }}">{{ $item->statusLabel() }}</span>
                            @if ($item->bidang)
                                <span class="text-xs text-emerald-900/40">&middot; {{ $item->bidang }}</span>
                            @endif
                        </div>
                        <h3 class="font-display font-semibold text-emerald-950 mb-1.5 line-clamp-2">{{ $item->nama_program }}</h3>
                        <p class="text-sm text-emerald-900/60 line-clamp-2 mb-3">{{ $item->deskripsi }}</p>
                        <p class="text-xs text-emerald-900/40">
                            {{ optional($item->tanggal_mulai)->translatedFormat('d M Y') ?? '-' }}
                            @if ($item->tanggal_selesai)
                                &ndash; {{ $item->tanggal_selesai->translatedFormat('d M Y') }}
                            @endif
                        </p>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $programKerja->links() }}
        </div>
    @endif
</section>
@endsection
