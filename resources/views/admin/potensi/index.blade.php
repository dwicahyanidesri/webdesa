@extends('layouts.admin')

@section('title', 'Potensi Desa')

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-sm text-emerald-900/50">Kelola data potensi desa yang tampil di halaman profil.</p>
    <a href="{{ route('admin.potensi.create') }}" class="rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 text-sm font-medium">+ Tambah Potensi</a>
</div>

<div class="overflow-x-auto rounded-2xl border border-emerald-900/10 bg-white">
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
        <tbody class="divide-y divide-gray-100">
            @forelse ($potensiDesa as $item)
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
            @empty
                <tr><td colspan="5" class="px-4 py-8 text-center text-emerald-900/40">Belum ada data.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
