@extends('layouts.admin')

@section('title', 'Kelola Data Penduduk')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
    <p class="text-sm text-emerald-900/50">Kelola data penduduk satu per satu. Data ini menjadi sumber Dashboard Statistik.</p>
    <a href="{{ route('admin.penduduk.create') }}" class="rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 text-sm font-medium whitespace-nowrap">+ Tambah Penduduk</a>
</div>

<form method="GET" class="bg-white rounded-2xl border border-emerald-900/10 p-4 mb-5 flex flex-wrap gap-3 items-end">
    <div class="flex-1 min-w-[180px]">
        <label class="block text-xs font-medium text-emerald-900/50 mb-1">Cari Nama / NIK</label>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari..." class="form-input">
    </div>
    <div class="min-w-[160px]">
        <label class="block text-xs font-medium text-emerald-900/50 mb-1">Dusun</label>
        <select name="dusun" class="form-input">
            <option value="">Semua Dusun</option>
            @foreach ($dusunList as $d)
                <option value="{{ $d }}" @selected(request('dusun') === $d)>{{ $d }}</option>
            @endforeach
        </select>
    </div>
    <div class="min-w-[130px]">
        <label class="block text-xs font-medium text-emerald-900/50 mb-1">RT</label>
        <select name="rt" class="form-input">
            <option value="">Semua RT</option>
            @foreach ($rtList as $rt)
                <option value="{{ $rt }}" @selected(request('rt') === $rt)>{{ $rt }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="rounded-lg bg-emerald-900 hover:bg-emerald-800 text-white px-4 py-2 text-sm font-medium">Filter</button>
    @if (request()->anyFilled(['search', 'dusun', 'rt']))
        <a href="{{ route('admin.penduduk.index') }}" class="text-sm text-emerald-900/50 hover:text-emerald-900 px-2 py-2">Reset</a>
    @endif
</form>

<div class="overflow-x-auto rounded-2xl border border-emerald-900/10 bg-white">
    <table class="min-w-full text-sm">
        <thead class="bg-cream-50 text-emerald-900/50 uppercase text-xs">
            <tr>
                <th class="px-4 py-3 text-left">Nama</th>
                <th class="px-4 py-3 text-left">L/P</th>
                <th class="px-4 py-3 text-left">Usia</th>
                <th class="px-4 py-3 text-left">Dusun / RT</th>
                <th class="px-4 py-3 text-left">Status Keluarga</th>
                <th class="px-4 py-3 text-left">Pendidikan</th>
                <th class="px-4 py-3 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-emerald-900/5">
            @forelse ($penduduk as $item)
                <tr>
                    <td class="px-4 py-3 font-medium text-emerald-950">{{ $item->nama }}</td>
                    <td class="px-4 py-3 text-emerald-900/70">{{ $item->jenis_kelamin }}</td>
                    <td class="px-4 py-3 text-emerald-900/70">{{ $item->usia ?? '-' }}</td>
                    <td class="px-4 py-3 text-emerald-900/70">{{ $item->dusun }} / RT {{ $item->rt }}</td>
                    <td class="px-4 py-3 text-emerald-900/70">{{ $item->statusKeluargaLabel() }}</td>
                    <td class="px-4 py-3 text-emerald-900/70">{{ $item->pendidikanLabel() }}</td>
                    <td class="px-4 py-3">
                        <div class="flex justify-end gap-2">
                            <a href="{{ route('admin.penduduk.edit', $item) }}" class="text-emerald-700 hover:underline">Edit</a>
                            <form method="POST" action="{{ route('admin.penduduk.destroy', $item) }}" onsubmit="return confirm('Hapus data penduduk ini?');">
                                @csrf @method('DELETE')
                                <button class="text-red-600 hover:underline">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="px-4 py-8 text-center text-emerald-900/40">Belum ada data penduduk.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $penduduk->links() }}
</div>
@endsection
