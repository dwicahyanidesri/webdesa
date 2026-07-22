@php
    $bantuanTerpilih = old('penerima_bantuan', $item->penerima_bantuan ?? []);
@endphp

<div class="grid sm:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-emerald-950/80 mb-1">Nama Lengkap</label>
        <input type="text" name="nama" value="{{ old('nama', $item->nama ?? '') }}" class="form-input" required>
    </div>
    <div>
        <label class="block text-sm font-medium text-emerald-950/80 mb-1">NIK (opsional)</label>
        <input type="text" name="nik" value="{{ old('nik', $item->nik ?? '') }}" maxlength="20" class="form-input">
    </div>
    <div>
        <label class="block text-sm font-medium text-emerald-950/80 mb-1">Jenis Kelamin</label>
        @php $jk = old('jenis_kelamin', $item->jenis_kelamin ?? 'L'); @endphp
        <select name="jenis_kelamin" class="form-input">
            <option value="L" @selected($jk === 'L')>Laki-laki</option>
            <option value="P" @selected($jk === 'P')>Perempuan</option>
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-emerald-950/80 mb-1">Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', isset($item) && $item->tanggal_lahir ? $item->tanggal_lahir->format('Y-m-d') : '') }}" class="form-input">
    </div>
    <div>
        <label class="block text-sm font-medium text-emerald-950/80 mb-1">Dusun</label>
        @php $dusun = old('dusun', $item->dusun ?? ''); @endphp
        <select name="dusun" class="form-input">
            <option value="">- Pilih Dusun -</option>
            @foreach (\App\Models\Penduduk::DUSUN as $d)
                <option value="{{ $d }}" @selected($dusun === $d)>{{ $d }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-emerald-950/80 mb-1">RT</label>
        @php $rt = old('rt', $item->rt ?? ''); @endphp
        <select name="rt" class="form-input">
            <option value="">- Pilih RT -</option>
            @foreach (\App\Models\Penduduk::RT as $r)
                <option value="{{ $r }}" @selected($rt === $r)>{{ $r }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-emerald-950/80 mb-1">Status dalam Keluarga</label>
        @php $sk = old('status_keluarga', $item->status_keluarga ?? 'anggota_lain'); @endphp
        <select name="status_keluarga" class="form-input">
            @foreach (\App\Models\Penduduk::STATUS_KELUARGA as $key => $label)
                <option value="{{ $key }}" @selected($sk === $key)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-emerald-950/80 mb-1">Status Ekonomi</label>
        @php $se = old('status_ekonomi', $item->status_ekonomi ?? 'mampu'); @endphp
        <select name="status_ekonomi" class="form-input">
            @foreach (\App\Models\Penduduk::STATUS_EKONOMI as $key => $label)
                <option value="{{ $key }}" @selected($se === $key)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-emerald-950/80 mb-1">Status Pernikahan</label>
        @php $sn = old('status_nikah', $item->status_nikah ?? 'belum_kawin'); @endphp
        <select name="status_nikah" class="form-input">
            @foreach (\App\Models\Penduduk::STATUS_NIKAH as $key => $label)
                <option value="{{ $key }}" @selected($sn === $key)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-emerald-950/80 mb-1">Pendidikan Terakhir</label>
        @php $pd = old('pendidikan_terakhir', $item->pendidikan_terakhir ?? 'tidak_belum_sekolah'); @endphp
        <select name="pendidikan_terakhir" class="form-input">
            @foreach (\App\Models\Penduduk::PENDIDIKAN as $key => $label)
                <option value="{{ $key }}" @selected($pd === $key)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div class="sm:col-span-2">
        <label class="block text-sm font-medium text-emerald-950/80 mb-1">Alamat</label>
        <input type="text" name="alamat" value="{{ old('alamat', $item->alamat ?? '') }}" class="form-input">
    </div>
</div>

<div>
    <label class="inline-flex items-center gap-2 text-sm text-emerald-950/80">
        @php $sekolah = old('status_sekolah', $item->status_sekolah ?? false); @endphp
        <input type="checkbox" name="status_sekolah" value="1" class="form-checkbox" @checked($sekolah)>
        Sedang bersekolah
    </label>
</div>

<div>
    <label class="block text-sm font-medium text-emerald-950/80 mb-2">Penerima Bantuan</label>
    <div class="flex flex-wrap gap-3">
        @foreach (\App\Models\Penduduk::BANTUAN as $jenis)
            <label class="inline-flex items-center gap-2 text-sm rounded-lg border border-emerald-900/15 px-3 py-1.5">
                <input type="checkbox" name="penerima_bantuan[]" value="{{ $jenis }}" class="form-checkbox" @checked(in_array($jenis, $bantuanTerpilih ?? []))>
                {{ $jenis }}
            </label>
        @endforeach
    </div>
</div>
