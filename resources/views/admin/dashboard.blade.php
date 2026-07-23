@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-5">
    <div class="bg-white rounded-xl border border-emerald-900/10 px-4 py-3.5">
        <p class="text-xs text-emerald-900/50">Potensi Desa</p>
        <p class="text-2xl font-display font-semibold text-emerald-950 mt-0.5">{{ $stats['potensi'] }}</p>
    </div>
    <div class="bg-white rounded-xl border border-emerald-900/10 px-4 py-3.5">
        <p class="text-xs text-emerald-900/50">Perangkat Desa</p>
        <p class="text-2xl font-display font-semibold text-emerald-950 mt-0.5">{{ $stats['perangkat'] }}</p>
    </div>
    <div class="bg-white rounded-xl border border-emerald-900/10 px-4 py-3.5">
        <p class="text-xs text-emerald-900/50">Program Kerja KKN</p>
        <p class="text-2xl font-display font-semibold text-emerald-950 mt-0.5">{{ $stats['program_kerja'] }}</p>
    </div>
    <div class="bg-white rounded-xl border border-emerald-900/10 px-4 py-3.5">
        <p class="text-xs text-emerald-900/50">Berita Acara</p>
        <p class="text-2xl font-display font-semibold text-emerald-950 mt-0.5">{{ $stats['berita_acara'] }} <span class="text-xs font-sans font-normal text-emerald-600">({{ $stats['berita_visible'] }} tampil)</span></p>
    </div>
</div>

<div class="grid lg:grid-cols-2 gap-4 items-start">
    <div class="bg-white rounded-xl border border-emerald-900/10 p-4">
        <div class="flex items-center justify-between mb-3">
            <h2 class="font-semibold text-sm">Berita Acara Terbaru</h2>
            <a href="{{ route('admin.berita-acara.index') }}" class="text-xs text-emerald-700 hover:underline">Lihat semua</a>
        </div>
        <div class="space-y-2">
            @forelse ($beritaTerbaru as $b)
                <div class="flex items-center justify-between gap-2 text-sm border-b border-emerald-900/5 pb-1.5 last:border-0 last:pb-0">
                    <span class="truncate">{{ $b->judul }}</span>
                    <span class="shrink-0 text-xs rounded-full px-2 py-0.5 {{ $b->status ? 'bg-emerald-100 text-emerald-700' : 'bg-cream-100 text-emerald-900/50' }}">
                        {{ $b->status ? 'Visible' : 'Invisible' }}
                    </span>
                </div>
            @empty
                <p class="text-sm text-emerald-900/40">Belum ada data.</p>
            @endforelse
        </div>
    </div>

    <div class="bg-white rounded-xl border border-emerald-900/10 p-4">
        <div class="flex items-center justify-between mb-3">
            <h2 class="font-semibold text-sm">Program Kerja Terbaru</h2>
            <a href="{{ route('admin.program-kerja.index') }}" class="text-xs text-emerald-700 hover:underline">Lihat semua</a>
        </div>
        <div class="space-y-2">
            @forelse ($programTerbaru as $p)
                <div class="flex items-center justify-between gap-2 text-sm border-b border-emerald-900/5 pb-1.5 last:border-0 last:pb-0">
                    <span class="truncate">{{ $p->nama_program }}</span>
                    <span class="shrink-0 text-xs rounded-full px-2 py-0.5 {{ $p->statusColor() }}">{{ $p->statusLabel() }}</span>
                </div>
            @empty
                <p class="text-sm text-emerald-900/40">Belum ada data.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
