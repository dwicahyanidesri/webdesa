@extends('layouts.admin')

@section('title', 'Pemerintahan Desa')

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-sm text-emerald-900/50">Kelola susunan perangkat desa untuk bagan struktur pemerintahan.</p>
    <a href="{{ route('admin.perangkat.create') }}" class="rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 text-sm font-medium">+ Tambah Perangkat</a>
</div>

<div class="overflow-x-auto rounded-2xl border border-emerald-900/10 bg-white">
    <table class="min-w-full text-sm">
        <thead class="bg-cream-50 text-emerald-900/50 uppercase text-xs">
            <tr>
                <th class="px-4 py-3 text-left">Foto</th>
                <th class="px-4 py-3 text-left">Nama</th>
                <th class="px-4 py-3 text-left">Jabatan</th>
                <th class="px-4 py-3 text-left">Tingkat</th>
                <th class="px-4 py-3 text-left">Urutan</th>
                <th class="px-4 py-3 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse ($perangkatDesa as $item)
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
                    <td class="px-4 py-3 text-emerald-900/70">
                        {{ ['1' => 'Kepala Desa', '2' => 'Sekretaris / Kaur / Kasi', '3' => 'Kadus / Staf'][$item->level] ?? $item->level }}
                    </td>
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
            @empty
                <tr><td colspan="6" class="px-4 py-8 text-center text-emerald-900/40">Belum ada data.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
