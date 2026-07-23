@extends('layouts.admin')

@section('title', 'Import Data Penduduk')

@section('content')
<div class="space-y-5 max-w-4xl">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <p class="text-sm text-emerald-900/50">Import data penduduk langsung dari file Excel/CSV, tanpa input satu per satu.</p>
        <a href="{{ route('admin.penduduk.index') }}" class="text-sm text-emerald-700 hover:underline shrink-0">&larr; Kembali ke Kelola Data Penduduk</a>
    </div>

    @if (session('importResult'))
        @php $result = session('importResult'); @endphp
        <div class="rounded-2xl bg-emerald-950 text-cream-100 p-5 sm:p-6">
            <h2 class="font-display font-semibold text-gold-400 mb-4">Hasil Import</h2>
            <div class="grid grid-cols-3 gap-3 sm:gap-4">
                <div class="rounded-xl bg-cream-50/5 px-4 py-3 text-center">
                    <p class="text-2xl font-display font-semibold text-emerald-300">{{ $result['imported'] }}</p>
                    <p class="text-xs text-cream-200/60 mt-1">Berhasil Ditambahkan</p>
                </div>
                <div class="rounded-xl bg-cream-50/5 px-4 py-3 text-center">
                    <p class="text-2xl font-display font-semibold text-gold-400">{{ $result['duplicates_total'] }}</p>
                    <p class="text-xs text-cream-200/60 mt-1">Duplikat Dilewati</p>
                </div>
                <div class="rounded-xl bg-cream-50/5 px-4 py-3 text-center">
                    <p class="text-2xl font-display font-semibold text-red-400">{{ $result['failed_total'] }}</p>
                    <p class="text-xs text-cream-200/60 mt-1">Baris Gagal</p>
                </div>
            </div>
        </div>

        @if (! empty($result['duplicates']))
            <div class="rounded-2xl bg-white border border-emerald-900/10 p-5 sm:p-6">
                <h3 class="font-display font-semibold text-emerald-950 mb-1">Data Duplikat yang Dilewati</h3>
                <p class="text-xs text-emerald-900/40 mb-4">
                    Menampilkan {{ count($result['duplicates']) }} dari {{ $result['duplicates_total'] }} baris duplikat.
                </p>
                <div class="overflow-x-auto rounded-xl border border-emerald-900/10">
                    <table class="min-w-full text-sm">
                        <thead class="bg-cream-50 text-emerald-900/50 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-2.5 text-left">Baris</th>
                                <th class="px-4 py-2.5 text-left">Nama</th>
                                <th class="px-4 py-2.5 text-left">Alasan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-emerald-900/5">
                            @foreach ($result['duplicates'] as $dup)
                                <tr>
                                    <td class="px-4 py-2.5 text-emerald-900/50">{{ $dup['row'] }}</td>
                                    <td class="px-4 py-2.5 font-medium text-emerald-950">{{ $dup['nama'] }}</td>
                                    <td class="px-4 py-2.5">
                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-gold-400/10 text-gold-600 px-2.5 py-1 text-xs font-medium">{{ $dup['alasan'] }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        @if (! empty($result['failed']))
            <div class="rounded-2xl bg-white border border-emerald-900/10 p-5 sm:p-6">
                <h3 class="font-display font-semibold text-emerald-950 mb-1">Baris yang Gagal Diproses</h3>
                <p class="text-xs text-emerald-900/40 mb-4">
                    Menampilkan {{ count($result['failed']) }} dari {{ $result['failed_total'] }} baris gagal. Perbaiki data lalu import ulang khusus baris tersebut.
                </p>
                <div class="overflow-x-auto rounded-xl border border-emerald-900/10">
                    <table class="min-w-full text-sm">
                        <thead class="bg-cream-50 text-emerald-900/50 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-2.5 text-left">Baris</th>
                                <th class="px-4 py-2.5 text-left">Pesan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-emerald-900/5">
                            @foreach ($result['failed'] as $fail)
                                <tr>
                                    <td class="px-4 py-2.5 text-emerald-900/50">{{ $fail['row'] }}</td>
                                    <td class="px-4 py-2.5 text-red-600">{{ $fail['pesan'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    @endif

    <!-- Form upload -->
    <div class="rounded-2xl bg-white border border-emerald-900/10 p-5 sm:p-6">
        <h2 class="font-display font-semibold text-emerald-950 mb-1">Upload Berkas</h2>
        <p class="text-sm text-emerald-900/50 mb-5">Format yang didukung: .xlsx, .xls, .csv (maks. 20MB). Baris pertama harus berisi judul kolom.</p>

        <form method="POST" action="{{ route('admin.penduduk.import.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <input type="file" name="file" accept=".xlsx,.xls,.csv" required class="form-file">
            </div>
            <button type="submit" class="rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 text-sm font-medium transition-colors cursor-pointer">
                Import Sekarang
            </button>
        </form>
    </div>

    <!-- Panduan format -->
    <div class="rounded-2xl bg-cream-100 p-5 sm:p-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
            <h2 class="font-display font-semibold text-emerald-950">Format Kolom yang Dibutuhkan</h2>
            <a href="{{ route('admin.penduduk.import.template') }}" class="inline-flex items-center justify-center gap-1.5 rounded-lg bg-emerald-700 hover:bg-emerald-800 text-cream-50 px-4 py-2 text-sm font-medium transition-colors shrink-0">
                Unduh Template Excel
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v13m0 0l-4-4m4 4l4-4M5 21h14" /></svg>
            </a>
        </div>

        <div class="overflow-x-auto rounded-xl border border-emerald-900/10 bg-white">
            <table class="min-w-full text-sm">
                <thead class="bg-cream-50 text-emerald-900/50 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-2.5 text-left">Kolom</th>
                        <th class="px-4 py-2.5 text-left">Wajib</th>
                        <th class="px-4 py-2.5 text-left">Contoh Isi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-emerald-900/5 text-emerald-900/70">
                    <tr><td class="px-4 py-2.5 font-medium text-emerald-950">Nama</td><td class="px-4 py-2.5">Ya</td><td class="px-4 py-2.5">Budi Santoso</td></tr>
                    <tr><td class="px-4 py-2.5 font-medium text-emerald-950">NIK</td><td class="px-4 py-2.5">Tidak</td><td class="px-4 py-2.5">16 digit, boleh dikosongkan</td></tr>
                    <tr><td class="px-4 py-2.5 font-medium text-emerald-950">Jenis Kelamin</td><td class="px-4 py-2.5">Ya</td><td class="px-4 py-2.5">L / P / Laki-laki / Perempuan</td></tr>
                    <tr><td class="px-4 py-2.5 font-medium text-emerald-950">Tanggal Lahir</td><td class="px-4 py-2.5">Tidak</td><td class="px-4 py-2.5">17/08/1990</td></tr>
                    <tr><td class="px-4 py-2.5 font-medium text-emerald-950">Dusun</td><td class="px-4 py-2.5">Ya</td><td class="px-4 py-2.5">{{ implode(' / ', \App\Models\Penduduk::DUSUN) }}</td></tr>
                    <tr><td class="px-4 py-2.5 font-medium text-emerald-950">RT</td><td class="px-4 py-2.5">Ya</td><td class="px-4 py-2.5">001, 002, dst. (boleh tulis "1")</td></tr>
                    <tr><td class="px-4 py-2.5 font-medium text-emerald-950">Status Keluarga</td><td class="px-4 py-2.5">Tidak</td><td class="px-4 py-2.5">{{ implode(' / ', \App\Models\Penduduk::STATUS_KELUARGA) }}</td></tr>
                    <tr><td class="px-4 py-2.5 font-medium text-emerald-950">Status Ekonomi</td><td class="px-4 py-2.5">Tidak</td><td class="px-4 py-2.5">{{ implode(' / ', \App\Models\Penduduk::STATUS_EKONOMI) }}</td></tr>
                    <tr><td class="px-4 py-2.5 font-medium text-emerald-950">Status Nikah</td><td class="px-4 py-2.5">Tidak</td><td class="px-4 py-2.5">{{ implode(' / ', \App\Models\Penduduk::STATUS_NIKAH) }}</td></tr>
                    <tr><td class="px-4 py-2.5 font-medium text-emerald-950">Pendidikan Terakhir</td><td class="px-4 py-2.5">Tidak</td><td class="px-4 py-2.5">{{ implode(' / ', \App\Models\Penduduk::PENDIDIKAN) }}</td></tr>
                    <tr><td class="px-4 py-2.5 font-medium text-emerald-950">Status Sekolah</td><td class="px-4 py-2.5">Tidak</td><td class="px-4 py-2.5">Ya / Tidak</td></tr>
                    <tr><td class="px-4 py-2.5 font-medium text-emerald-950">Penerima Bantuan</td><td class="px-4 py-2.5">Tidak</td><td class="px-4 py-2.5">BLT, PKH (pisahkan koma)</td></tr>
                    <tr><td class="px-4 py-2.5 font-medium text-emerald-950">Alamat</td><td class="px-4 py-2.5">Tidak</td><td class="px-4 py-2.5">Jl. Contoh No. 1</td></tr>
                </tbody>
            </table>
        </div>

        <div class="mt-5 rounded-xl bg-white border border-emerald-900/10 px-4 py-3.5">
            <p class="text-xs font-medium text-emerald-900/70 mb-1">Cara pengecekan duplikat:</p>
            <p class="text-xs text-emerald-900/50 leading-relaxed">
                Sistem mengecek <strong>NIK</strong> terlebih dahulu &mdash; kalau NIK sudah ada di database, baris dilewati.
                Kalau NIK kosong atau tidak cocok, sistem mengecek kombinasi <strong>Nama &amp; Tanggal Lahir</strong>;
                kalau kombinasi itu sudah ada, baris tetap dilewati supaya data tidak tercatat dua kali.
            </p>
        </div>
    </div>
</div>
@endsection
