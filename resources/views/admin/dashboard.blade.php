@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white rounded-2xl border border-emerald-900/10 p-5">
        <p class="text-sm text-emerald-900/50">Potensi Desa</p>
        <p class="text-3xl font-display font-semibold text-emerald-950">{{ $stats['potensi'] }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-emerald-900/10 p-5">
        <p class="text-sm text-emerald-900/50">Perangkat Desa</p>
        <p class="text-3xl font-display font-semibold text-emerald-950">{{ $stats['perangkat'] }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-emerald-900/10 p-5">
        <p class="text-sm text-emerald-900/50">Program Kerja KKN</p>
        <p class="text-3xl font-display font-semibold text-emerald-950">{{ $stats['program_kerja'] }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-emerald-900/10 p-5">
        <p class="text-sm text-emerald-900/50">Berita Acara</p>
        <p class="text-3xl font-display font-semibold text-emerald-950">{{ $stats['berita_acara'] }} <span class="text-sm font-sans font-normal text-emerald-600">({{ $stats['berita_visible'] }} tampil)</span></p>
    </div>
</div>

<div class="grid lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-2xl border border-emerald-900/10 p-5">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-semibold">Berita Acara Terbaru</h2>
            <a href="{{ route('admin.berita-acara.index') }}" class="text-sm text-emerald-700 hover:underline">Lihat semua</a>
        </div>
        <div class="space-y-3">
            @forelse ($beritaTerbaru as $b)
                <div class="flex items-center justify-between text-sm border-b border-emerald-900/5 pb-2 last:border-0">
                    <span class="truncate">{{ $b->judul }}</span>
                    <span class="text-xs rounded-full px-2 py-0.5 {{ $b->status ? 'bg-emerald-100 text-emerald-700' : 'bg-cream-100 text-emerald-900/50' }}">
                        {{ $b->status ? 'Visible' : 'Invisible' }}
                    </span>
                </div>
            @empty
                <p class="text-sm text-emerald-900/40">Belum ada data.</p>
            @endforelse
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-emerald-900/10 p-5">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-semibold">Program Kerja Terbaru</h2>
            <a href="{{ route('admin.program-kerja.index') }}" class="text-sm text-emerald-700 hover:underline">Lihat semua</a>
        </div>
        <div class="space-y-3">
            @forelse ($programTerbaru as $p)
                <div class="flex items-center justify-between text-sm border-b border-emerald-900/5 pb-2 last:border-0">
                    <span class="truncate">{{ $p->nama_program }}</span>
                    <span class="text-xs rounded-full px-2 py-0.5 {{ $p->statusColor() }}">{{ $p->statusLabel() }}</span>
                </div>
            @empty
                <p class="text-sm text-emerald-900/40">Belum ada data.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
