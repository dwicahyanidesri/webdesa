@extends('layouts.admin')

@section('title', 'Potensi Desa')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
    <p class="text-sm text-emerald-900/50">Kelola data potensi desa yang tampil di halaman profil.</p>
    <a href="{{ route('admin.potensi.create') }}" class="rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 text-sm font-medium text-center">+ Tambah Potensi</a>
</div>

@if ($potensiDesa->isEmpty())
    <div class="rounded-2xl border border-emerald-900/10 bg-white px-4 py-8 text-center text-sm text-emerald-900/40">Belum ada data.</div>
@else
    <!-- Kartu (mobile) -->
    <div class="md:hidden space-y-3">
        @foreach ($potensiDesa as $item)
            <div class="rounded-2xl border border-emerald-900/10 bg-white p-4 flex gap-3">
                @if ($item->gambar)
                    <img src="{{ asset('storage/'.$item->gambar) }}" class="h-14 w-14 shrink-0 rounded-lg object-cover">
                @else
                    <div class="h-14 w-14 shrink-0 rounded-lg bg-cream-100"></div>
                @endif
                <div class="min-w-0 flex-1">
                    <p class="font-medium text-emerald-950 truncate">{{ $item->judul }}</p>
                    <div class="flex flex-wrap items-center gap-x-2 gap-y-1 mt-1 text-xs text-emerald-900/50">
                        @if ($item->kategori)
                            <span class="rounded-full bg-cream-100 px-2 py-0.5">{{ $item->kategori }}</span>
                        @endif
                        <span>Urutan: {{ $item->urutan }}</span>
                    </div>
                    <div class="flex gap-4 mt-2 text-sm">
                        <a href="{{ route('admin.potensi.edit', $item) }}" class="text-emerald-700 font-medium hover:underline">Edit</a>
                        <form method="POST" action="{{ route('admin.potensi.destroy', $item) }}" onsubmit="return confirm('Hapus potensi ini?');">
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
                    <th class="px-4 py-3 text-left">Gambar</th>
                    <th class="px-4 py-3 text-left">Judul</th>
                    <th class="px-4 py-3 text-left">Kategori</th>
                    <th class="px-4 py-3 text-left">Urutan</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-emerald-900/5">
                @foreach ($potensiDesa as $item)
                    <tr>
                        <td class="px-4 py-3">
                            @if ($item->gambar)
                                <img src="{{ asset('storage/'.$item->gambar) }}" class="h-10 w-10 rounded object-cover">
                            @else
                                <div class="h-10 w-10 rounded bg-cream-100"></div>
                            @endif
                        </td>
                        <td class="px-4 py-3 font-medium">{{ $item->judul }}</td>
                        <td class="px-4 py-3 text-emerald-900/70">{{ $item->kategori ?? '-' }}</td>
                        <td class="px-4 py-3 text-emerald-900/70">{{ $item->urutan }}</td>
                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.potensi.edit', $item) }}" class="text-emerald-700 hover:underline">Edit</a>
                                <form method="POST" action="{{ route('admin.potensi.destroy', $item) }}" onsubmit="return confirm('Hapus potensi ini?');">
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
