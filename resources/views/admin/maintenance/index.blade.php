@extends('layouts.admin')

@section('title', 'Pembersihan Data')

@section('content')
<div class="space-y-5">

    <p class="text-sm text-emerald-900/50 max-w-2xl">
        Setiap kali foto diganti atau data dihapus, berkas lamanya bisa tertinggal di penyimpanan server
        (termasuk setelah migrasi ulang database). Halaman ini membantu menemukan &amp; menghapus berkas yang
        sudah tidak dipakai lagi, serta membersihkan cache aplikasi.
    </p>

    <!-- Kartu ringkasan -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4">
        <div class="rounded-2xl bg-emerald-950 px-4 py-4 sm:px-6 sm:py-5">
            <p class="text-2xl sm:text-3xl font-display font-semibold text-gold-400">{{ $totalFiles }}</p>
            <p class="text-xs uppercase tracking-wide text-cream-200/60 mt-1">Total Berkas</p>
        </div>
        <div class="rounded-2xl bg-emerald-950 px-4 py-4 sm:px-6 sm:py-5">
            <p class="text-2xl sm:text-3xl font-display font-semibold text-gold-400">{{ $totalSizeFormatted }}</p>
            <p class="text-xs uppercase tracking-wide text-cream-200/60 mt-1">Total Ukuran</p>
        </div>
        <div class="rounded-2xl bg-white border border-emerald-900/10 px-4 py-4 sm:px-6 sm:py-5">
            <p class="text-2xl sm:text-3xl font-display font-semibold {{ $orphanCount > 0 ? 'text-red-600' : 'text-emerald-950' }}">{{ $orphanCount }}</p>
            <p class="text-xs uppercase tracking-wide text-emerald-900/50 mt-1">Berkas Tidak Terpakai</p>
        </div>
        <div class="rounded-2xl bg-white border border-emerald-900/10 px-4 py-4 sm:px-6 sm:py-5">
            <p class="text-2xl sm:text-3xl font-display font-semibold {{ $orphanCount > 0 ? 'text-red-600' : 'text-emerald-950' }}">{{ $orphanSizeFormatted }}</p>
            <p class="text-xs uppercase tracking-wide text-emerald-900/50 mt-1">Bisa Dihemat</p>
        </div>
    </div>

    <!-- Cache aplikasi -->
    <div class="rounded-2xl bg-white border border-emerald-900/10 p-5 sm:p-6 flex flex-col sm:flex-row sm:items-center gap-4 sm:justify-between">
        <div>
            <h2 class="font-display font-semibold text-emerald-950">Cache Aplikasi</h2>
            <p class="text-sm text-emerald-900/50 mt-0.5">Bersihkan cache config, route, view, &amp; data supaya perubahan terbaru selalu tampil.</p>
        </div>
        <form method="POST" action="{{ route('admin.maintenance.clear-cache') }}"
              onsubmit="return confirm('Bersihkan seluruh cache aplikasi sekarang?');" class="shrink-0">
            @csrf
            <button type="submit" class="w-full sm:w-auto rounded-lg bg-emerald-700 hover:bg-emerald-800 text-cream-50 px-5 py-2.5 text-sm font-medium transition-colors cursor-pointer">
                Bersihkan Cache
            </button>
        </form>
    </div>

    <!-- Semua berkas -->
    <div class="rounded-2xl bg-white border border-emerald-900/10 p-5 sm:p-6">
        <div class="flex flex-col sm:flex-row sm:items-center gap-4 sm:justify-between mb-5">
            <div>
                <h2 class="font-display font-semibold text-emerald-950">Semua Berkas</h2>
                <p class="text-sm text-emerald-900/50 mt-0.5">Kolom status menandakan apakah berkas masih dipakai data website atau tidak.</p>
            </div>
            @if ($orphanCount > 0)
                <form method="POST" action="{{ route('admin.maintenance.destroy-orphans') }}"
                      onsubmit="return confirm('Hapus semua {{ $orphanCount }} berkas tidak terpakai? Tindakan ini tidak bisa dibatalkan.');" class="shrink-0">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full sm:w-auto rounded-lg bg-red-600 hover:bg-red-700 text-white px-5 py-2.5 text-sm font-medium transition-colors cursor-pointer">
                        Hapus Semua yang Tidak Digunakan ({{ $orphanCount }})
                    </button>
                </form>
            @endif
        </div>

        @if ($files->isEmpty())
            <div class="rounded-xl bg-cream-100 text-emerald-900/60 px-4 py-4 text-sm text-center">
                Belum ada berkas di penyimpanan.
            </div>
        @else
            <!-- Mobile: kartu -->
            <div class="md:hidden space-y-3">
                @foreach ($files as $file)
                    <div class="rounded-xl border border-emerald-900/10 p-3.5 flex items-center gap-3">
                        @if ($file['is_image'])
                            <img src="{{ asset('storage/'.$file['path']) }}" class="h-12 w-12 rounded-lg object-cover shrink-0 border border-emerald-900/10">
                        @else
                            <div class="h-12 w-12 rounded-lg bg-cream-100 flex items-center justify-center shrink-0 text-emerald-900/30">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-emerald-950 truncate">{{ $file['path'] }}</p>
                            <p class="text-xs text-emerald-900/40 mt-0.5">{{ $file['size_formatted'] }} &middot; {{ $file['modified_formatted'] }}</p>
                            <span class="inline-flex items-center gap-1.5 mt-1.5 rounded-full px-2 py-0.5 text-[11px] font-medium {{ $file['is_used'] ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                <span class="h-1.5 w-1.5 rounded-full {{ $file['is_used'] ? 'bg-emerald-600' : 'bg-red-600' }}"></span>
                                {{ $file['status_label'] }}
                            </span>
                        </div>
                        @unless ($file['is_used'])
                            <form method="POST" action="{{ route('admin.maintenance.destroy-file') }}"
                                  onsubmit="return confirm('Hapus berkas ini?');" class="shrink-0">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="path" value="{{ $file['path'] }}">
                                <button type="submit" class="h-9 w-9 flex items-center justify-center rounded-lg text-red-600 hover:bg-red-50 transition-colors cursor-pointer" aria-label="Hapus">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3m-3 0h12" /></svg>
                                </button>
                            </form>
                        @endunless
                    </div>
                @endforeach
            </div>

            <!-- Desktop: tabel -->
            <div class="hidden md:block overflow-x-auto rounded-2xl border border-emerald-900/10">
                <table class="min-w-full text-sm">
                    <thead class="bg-cream-50 text-emerald-900/50 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-3 text-left">Berkas</th>
                            <th class="px-4 py-3 text-left">Lokasi</th>
                            <th class="px-4 py-3 text-left">Ukuran</th>
                            <th class="px-4 py-3 text-left">Terakhir Diubah</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-emerald-900/5">
                        @foreach ($files as $file)
                            <tr>
                                <td class="px-4 py-3">
                                    @if ($file['is_image'])
                                        <img src="{{ asset('storage/'.$file['path']) }}" class="h-10 w-10 rounded-lg object-cover border border-emerald-900/10">
                                    @else
                                        <div class="h-10 w-10 rounded-lg bg-cream-100 flex items-center justify-center text-emerald-900/30">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-emerald-900/50">{{ $file['path'] }}</td>
                                <td class="px-4 py-3 text-emerald-900/70">{{ $file['size_formatted'] }}</td>
                                <td class="px-4 py-3 text-emerald-900/70">{{ $file['modified_formatted'] }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-medium {{ $file['is_used'] ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                        <span class="h-1.5 w-1.5 rounded-full {{ $file['is_used'] ? 'bg-emerald-600' : 'bg-red-600' }}"></span>
                                        {{ $file['status_label'] }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-end">
                                        @unless ($file['is_used'])
                                            <form method="POST" action="{{ route('admin.maintenance.destroy-file') }}"
                                                  onsubmit="return confirm('Hapus berkas ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="path" value="{{ $file['path'] }}">
                                                <button type="submit" class="text-red-600 hover:underline cursor-pointer">Hapus</button>
                                            </form>
                                        @else
                                            <span class="text-emerald-900/30">&ndash;</span>
                                        @endunless
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
