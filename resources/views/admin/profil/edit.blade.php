@extends('layouts.admin')

@section('title', 'Profil Desa')

@section('content')
<form method="POST" action="{{ route('admin.profil.update') }}" enctype="multipart/form-data" class="space-y-6 max-w-3xl">
    @csrf
    @method('PUT')

    <div class="bg-white rounded-2xl border border-emerald-900/10 p-6 space-y-4">
        <h2 class="font-semibold">Data Umum</h2>
        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-emerald-950/80 mb-1">Nama Desa</label>
                <input type="text" name="nama_desa" value="{{ old('nama_desa', $profil->nama_desa) }}" class="form-input" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-emerald-950/80 mb-1">Kecamatan</label>
                <input type="text" name="kecamatan" value="{{ old('kecamatan', $profil->kecamatan) }}" class="form-input">
            </div>
            <div>
                <label class="block text-sm font-medium text-emerald-950/80 mb-1">Kabupaten</label>
                <input type="text" name="kabupaten" value="{{ old('kabupaten', $profil->kabupaten) }}" class="form-input">
            </div>
            <div>
                <label class="block text-sm font-medium text-emerald-950/80 mb-1">Provinsi</label>
                <input type="text" name="provinsi" value="{{ old('provinsi', $profil->provinsi) }}" class="form-input">
            </div>
            <div>
                <label class="block text-sm font-medium text-emerald-950/80 mb-1">Luas Wilayah</label>
                <input type="text" name="luas_wilayah" value="{{ old('luas_wilayah', $profil->luas_wilayah) }}" class="form-input">
            </div>
            <div>
                <label class="block text-sm font-medium text-emerald-950/80 mb-1">Jumlah Penduduk</label>
                <input type="text" name="jumlah_penduduk" value="{{ old('jumlah_penduduk', $profil->jumlah_penduduk) }}" class="form-input">
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-emerald-900/10 p-6 space-y-4">
        <h2 class="font-semibold">Sejarah &amp; Visi Misi</h2>
        <div>
            <label class="block text-sm font-medium text-emerald-950/80 mb-1">Sejarah</label>
            <textarea name="sejarah" rows="4" class="form-input">{{ old('sejarah', $profil->sejarah) }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-emerald-950/80 mb-1">Visi</label>
            <textarea name="visi" rows="2" class="form-input">{{ old('visi', $profil->visi) }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-emerald-950/80 mb-1">Misi</label>
            <textarea name="misi" rows="4" class="form-input">{{ old('misi', $profil->misi) }}</textarea>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-emerald-900/10 p-6 space-y-5">
        <h2 class="font-semibold">Foto</h2>
        <div>
            <label class="block text-sm font-medium text-emerald-950/80 mb-1">Logo Desa</label>
            <p class="text-xs text-emerald-900/40 mb-2">Tampil di header &amp; footer website sebagai pengganti lencana singkatan "TA".</p>
            @if ($profil->logo)
                <img src="{{ asset('storage/'.$profil->logo) }}" class="h-16 w-16 object-cover mb-2 rounded-full border border-emerald-900/10">
            @endif
            <input type="file" name="logo" accept="image/*" class="form-file">
        </div>
        <div>
            <label class="block text-sm font-medium text-emerald-950/80 mb-1">Foto Latar Belakang Beranda (Hero)</label>
            <p class="text-xs text-emerald-900/40 mb-2">Gambar ini tampil sebagai latar belakang penuh di halaman utama. Jika kosong, sistem memakai gambar contoh bawaan.</p>
            @if ($profil->foto_hero)
                <img src="{{ asset('storage/'.$profil->foto_hero) }}" class="h-24 w-full max-w-md object-cover mb-2 rounded-lg">
            @else
                <img src="{{ asset('img/kerja-kerja.jpg') }}" class="h-24 w-full max-w-md object-cover mb-2 rounded-lg opacity-70">
            @endif
            <input type="file" name="foto_hero" accept="image/*" class="form-file">
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-emerald-900/10 p-6 space-y-4">
        <h2 class="font-semibold">Kontak Person</h2>
        <div class="grid sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-emerald-950/80 mb-1">Nama Kontak</label>
                <input type="text" name="nama_kontak" value="{{ old('nama_kontak', $profil->nama_kontak) }}" class="form-input">
            </div>
            <div>
                <label class="block text-sm font-medium text-emerald-950/80 mb-1">Jabatan</label>
                <input type="text" name="jabatan_kontak" value="{{ old('jabatan_kontak', $profil->jabatan_kontak) }}" class="form-input">
            </div>
            <div>
                <label class="block text-sm font-medium text-emerald-950/80 mb-1">No. Telepon</label>
                <input type="text" name="no_telepon" value="{{ old('no_telepon', $profil->no_telepon) }}" class="form-input">
            </div>
            <div>
                <label class="block text-sm font-medium text-emerald-950/80 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $profil->email) }}" class="form-input">
            </div>
            <div class="sm:col-span-2">
                <label class="block text-sm font-medium text-emerald-950/80 mb-1">Alamat Kantor</label>
                <textarea name="alamat_kantor" rows="2" class="form-input">{{ old('alamat_kantor', $profil->alamat_kantor) }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-emerald-950/80 mb-1">Jam Pelayanan</label>
                <input type="text" name="jam_pelayanan" value="{{ old('jam_pelayanan', $profil->jam_pelayanan) }}" class="form-input">
            </div>
            <div>
                <label class="block text-sm font-medium text-emerald-950/80 mb-1">Link Google Maps (opsional)</label>
                <input type="text" name="link_maps" value="{{ old('link_maps', $profil->link_maps) }}" class="form-input">
            </div>
        </div>
    </div>

    <button type="submit" class="rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 font-medium">Simpan Perubahan</button>
</form>
@endsection
