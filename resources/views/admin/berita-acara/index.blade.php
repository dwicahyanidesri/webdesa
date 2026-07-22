@extends('layouts.admin')

@section('title', 'Berita Acara')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
    <p class="text-sm text-emerald-900/50">Kelola berita acara yang ditampilkan kepada pengunjung.</p>
    <a href="{{ route('admin.berita-acara.create') }}" class="rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 text-sm font-medium text-center">+ Tambah Berita Acara</a>
</div>

@if ($beritaAcara->isEmpty())
    <div class="rounded-2xl border border-emerald-900/10 bg-white px-4 py-8 text-center text-sm text-emerald-900/40">Belum ada data.</div>
@else
    <!-- Kartu (mobile) -->
    <div class="md:hidden space-y-3">
        @foreach ($beritaAcara as $item)
            <div class="rounded-2xl border border-emerald-900/10 bg-white p-4 flex gap-3">
                @if ($item->gambar)
                    <img src="{{ asset('storage/'.$item->gambar) }}" class="h-14 w-14 shrink-0 rounded-lg object-cover">
                @else
                    <div class="h-14 w-14 shrink-0 rounded-lg bg-cream-100"></div>
                @endif
                <div class="min-w-0 flex-1">
                    <div class="flex items-start justify-between gap-2">
                        <a href="{{ route('berita-acara.show', $item->slug) }}" target="_blank" class="font-medium text-emerald-950 hover:underline line-clamp-2">{{ $item->judul }}</a>
                    </div>
                    <p class="text-xs text-emerald-900/50 mt-1">{{ $item->penulis ?? '-' }} &middot; {{ $item->created_at->translatedFormat('d M Y, H:i') }}</p>

                    <div class="flex items-center justify-between mt-3">
                        <form method="POST" action="{{ route('admin.berita-acara.toggle-status', $item) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="inline-block rounded-full px-2.5 py-1 text-xs font-medium {{ $item->status ? 'bg-emerald-100 text-emerald-700' : 'bg-cream-100 text-emerald-900/50' }}">
                                {{ $item->status ? 'Visible' : 'Invisible' }}
                            </button>
                        </form>
                        <div class="flex gap-4 text-sm">
                            <a href="{{ route('admin.berita-acara.edit', $item) }}" class="text-emerald-700 font-medium hover:underline">Edit</a>
                            <form method="POST" action="{{ route('admin.berita-acara.destroy', $item) }}" onsubmit="return confirm('Hapus berita acara ini?');">
                                @csrf @method('DELETE')
                                <button class="text-red-600 font-medium hover:underline">Hapus</button>
                            </form>
                        </div>
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
                    <th class="px-4 py-3 text-left">Penulis</th>
                    <th class="px-4 py-3 text-left">Dibuat</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-emerald-900/5">
                @foreach ($beritaAcara as $item)
                    <tr>
                        <td class="px-4 py-3">
                            @if ($item->gambar)
                                <img src="{{ asset('storage/'.$item->gambar) }}" class="h-10 w-10 rounded object-cover">
                            @else
                                <div class="h-10 w-10 rounded bg-cream-100"></div>
                            @endif
                        </td>
                        <td class="px-4 py-3 font-medium">
                            <a href="{{ route('berita-acara.show', $item->slug) }}" target="_blank" class="hover:underline">{{ $item->judul }}</a>
                        </td>
                        <td class="px-4 py-3 text-emerald-900/70">{{ $item->penulis ?? '-' }}</td>
                        <td class="px-4 py-3 text-emerald-900/70">{{ $item->created_at->translatedFormat('d M Y, H:i') }}</td>
                        <td class="px-4 py-3">
                            <form method="POST" action="{{ route('admin.berita-acara.toggle-status', $item) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="inline-block rounded-full px-2.5 py-1 text-xs font-medium {{ $item->status ? 'bg-emerald-100 text-emerald-700' : 'bg-cream-100 text-emerald-900/50' }}">
                                    {{ $item->status ? 'Visible' : 'Invisible' }}
                                </button>
                            </form>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.berita-acara.edit', $item) }}" class="text-emerald-700 hover:underline">Edit</a>
                                <form method="POST" action="{{ route('admin.berita-acara.destroy', $item) }}" onsubmit="return confirm('Hapus berita acara ini?');">
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
