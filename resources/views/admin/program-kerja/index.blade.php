@extends('layouts.admin')

@section('title', 'Program Kerja KKN')

@section('content')
<div class="flex items-center justify-between mb-6">
    <p class="text-sm text-emerald-900/50">Kelola daftar program kerja mahasiswa KKN.</p>
    <a href="{{ route('admin.program-kerja.create') }}" class="rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 text-sm font-medium">+ Tambah Program</a>
</div>

<div class="overflow-x-auto rounded-2xl border border-emerald-900/10 bg-white">
    <table class="min-w-full text-sm">
        <thead class="bg-cream-50 text-emerald-900/50 uppercase text-xs">
            <tr>
                <th class="px-4 py-3 text-left">Nama Program</th>
                <th class="px-4 py-3 text-left">Bidang</th>
                <th class="px-4 py-3 text-left">Penanggung Jawab</th>
                <th class="px-4 py-3 text-left">Periode</th>
                <th class="px-4 py-3 text-left">Status</th>
                <th class="px-4 py-3 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse ($programKerja as $item)
                <tr>
                    <td class="px-4 py-3 font-medium">{{ $item->nama_program }}</td>
                    <td class="px-4 py-3 text-emerald-900/70">{{ $item->bidang ?? '-' }}</td>
                    <td class="px-4 py-3 text-emerald-900/70">{{ $item->penanggung_jawab ?? '-' }}</td>
                    <td class="px-4 py-3 text-emerald-900/70">
                        {{ optional($item->tanggal_mulai)->translatedFormat('d M Y') ?? '-' }} s/d {{ optional($item->tanggal_selesai)->translatedFormat('d M Y') ?? '-' }}
                    </td>
                    <td class="px-4 py-3">
                        <span class="inline-block rounded-full px-2.5 py-1 text-xs font-medium {{ $item->statusColor() }}">{{ $item->statusLabel() }}</span>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.program-kerja.edit', $item) }}" class="text-emerald-700 hover:underline">Edit</a>
                            <form method="POST" action="{{ route('admin.program-kerja.destroy', $item) }}" onsubmit="return confirm('Hapus program kerja ini?');">
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
