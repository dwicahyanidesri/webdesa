@extends('layouts.admin')

@section('title', 'Program Kerja KKN')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
    <p class="text-sm text-emerald-900/50">Kelola daftar program kerja mahasiswa KKN.</p>
    <a href="{{ route('admin.program-kerja.create') }}" class="rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 text-sm font-medium text-center">+ Tambah Program</a>
</div>

@if ($programKerja->isEmpty())
    <div class="rounded-2xl border border-emerald-900/10 bg-white px-4 py-8 text-center text-sm text-emerald-900/40">Belum ada data.</div>
@else
    <!-- Kartu (mobile) -->
    <div class="md:hidden space-y-3">
        @foreach ($programKerja as $item)
            <div class="rounded-2xl border border-emerald-900/10 bg-white p-4">
                <div class="flex items-start justify-between gap-2 mb-2">
                    <p class="font-medium text-emerald-950">{{ $item->nama_program }}</p>
                    <span class="shrink-0 inline-block rounded-full px-2.5 py-1 text-xs font-medium {{ $item->statusColor() }}">{{ $item->statusLabel() }}</span>
                </div>
                <dl class="text-xs text-emerald-900/60 space-y-1 mb-3">
                    <div class="flex gap-1"><dt class="text-emerald-900/40">Bidang:</dt><dd>{{ $item->bidang ?? '-' }}</dd></div>
                    <div class="flex gap-1"><dt class="text-emerald-900/40">Penanggung Jawab:</dt><dd>{{ $item->penanggung_jawab ?? '-' }}</dd></div>
                    <div class="flex gap-1">
                        <dt class="text-emerald-900/40">Periode:</dt>
                        <dd>{{ optional($item->tanggal_mulai)->translatedFormat('d M Y') ?? '-' }} s/d {{ optional($item->tanggal_selesai)->translatedFormat('d M Y') ?? '-' }}</dd>
                    </div>
                </dl>
                <div class="flex gap-4 text-sm border-t border-emerald-900/10 pt-2">
                    <a href="{{ route('admin.program-kerja.edit', $item) }}" class="text-emerald-700 font-medium hover:underline">Edit</a>
                    <form method="POST" action="{{ route('admin.program-kerja.destroy', $item) }}" onsubmit="return confirm('Hapus program kerja ini?');">
                        @csrf @method('DELETE')
                        <button class="text-red-600 font-medium hover:underline">Hapus</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Tabel (desktop) -->
    <div class="hidden md:block overflow-x-auto rounded-2xl border border-emerald-900/10 bg-white">
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
            <tbody class="divide-y divide-emerald-900/5">
                @foreach ($programKerja as $item)
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
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection
