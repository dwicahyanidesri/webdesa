@extends('layouts.admin')

@section('title', 'Pemerintahan Desa')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
    <p class="text-sm text-emerald-900/50">Kelola susunan perangkat desa untuk bagan struktur pemerintahan.</p>
    <a href="{{ route('admin.perangkat.create') }}" class="rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 text-sm font-medium text-center">+ Tambah Perangkat</a>
</div>

@php
    $levelLabel = ['1' => 'Kepala Desa', '2' => 'Sekretaris / Kaur / Kasi', '3' => 'Kadus / Staf'];
@endphp

@if ($perangkatDesa->isEmpty())
    <div class="rounded-2xl border border-emerald-900/10 bg-white px-4 py-8 text-center text-sm text-emerald-900/40">Belum ada data.</div>
@else
    <!-- Kartu (mobile) -->
    <div class="md:hidden space-y-3">
        @foreach ($perangkatDesa as $item)
            <div class="rounded-2xl border border-emerald-900/10 bg-white p-4 flex gap-3">
                @if ($item->foto)
                    <img src="{{ asset('storage/'.$item->foto) }}" class="h-14 w-14 shrink-0 rounded-full object-cover">
                @else
                    <div class="h-14 w-14 shrink-0 rounded-full bg-cream-100"></div>
                @endif
                <div class="min-w-0 flex-1">
                    <p class="font-medium text-emerald-950 truncate">{{ $item->nama }}</p>
                    <p class="text-xs text-emerald-900/60 mt-0.5">{{ $item->jabatan }}</p>
                    <div class="flex flex-wrap items-center gap-x-2 gap-y-1 mt-1.5 text-xs text-emerald-900/50">
                        <span class="rounded-full bg-cream-100 px-2 py-0.5">{{ $levelLabel[$item->level] ?? $item->level }}</span>
                        <span>Urutan: {{ $item->urutan }}</span>
                        <span>Atasan: {{ $item->parent->nama ?? '—' }}</span>
                    </div>
                    <div class="flex gap-4 mt-2 text-sm">
                        <a href="{{ route('admin.perangkat.edit', $item) }}" class="text-emerald-700 font-medium hover:underline">Edit</a>
                        <form method="POST" action="{{ route('admin.perangkat.destroy', $item) }}" onsubmit="return confirm('Hapus data ini?');">
                            @csrf @method('DELETE')
                            <button class="text-red-600 font-medium hover:underline">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Tabel (desktop) -->
    <div class="hidden md:block overflow-x-auto rounded-2xl border border-emerald-900/10 bg-white">
        <table class="min-w-full text-sm">
            <thead class="bg-cream-50 text-emerald-900/50 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">Foto</th>
                    <th class="px-4 py-3 text-left">Nama</th>
                    <th class="px-4 py-3 text-left">Jabatan</th>
                    <th class="px-4 py-3 text-left">Atasan</th>
                    <th class="px-4 py-3 text-left">Tingkat</th>
                    <th class="px-4 py-3 text-left">Urutan</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-emerald-900/5">
                @foreach ($perangkatDesa as $item)
                    <tr>
                        <td class="px-4 py-3">
                            @if ($item->foto)
                                <img src="{{ asset('storage/'.$item->foto) }}" class="h-10 w-10 rounded-full object-cover">
                            @else
                                <div class="h-10 w-10 rounded-full bg-cream-100"></div>
                            @endif
                        </td>
                        <td class="px-4 py-3 font-medium">{{ $item->nama }}</td>
                        <td class="px-4 py-3 text-emerald-900/70">{{ $item->jabatan }}</td>
                        <td class="px-4 py-3 text-emerald-900/70">{{ $item->parent->nama ?? '—' }}</td>
                        <td class="px-4 py-3 text-emerald-900/70">{{ $levelLabel[$item->level] ?? $item->level }}</td>
                        <td class="px-4 py-3 text-emerald-900/70">{{ $item->urutan }}</td>
                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.perangkat.edit', $item) }}" class="text-emerald-700 hover:underline">Edit</a>
                                <form method="POST" action="{{ route('admin.perangkat.destroy', $item) }}" onsubmit="return confirm('Hapus data ini?');">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection
