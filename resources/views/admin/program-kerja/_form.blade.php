<div>
    <label class="block text-sm font-medium text-emerald-950/80 mb-1">Nama Program</label>
    <input type="text" name="nama_program" value="{{ old('nama_program', $item->nama_program ?? '') }}" class="form-input" required>
</div>
<div>
    <label class="block text-sm font-medium text-emerald-950/80 mb-1">Bidang</label>
    <input type="text" name="bidang" value="{{ old('bidang', $item->bidang ?? '') }}" placeholder="Pendidikan, Kesehatan, Ekonomi, Lingkungan, dll." class="form-input">
</div>
<div>
    <label class="block text-sm font-medium text-emerald-950/80 mb-1">Penanggung Jawab</label>
    <input type="text" name="penanggung_jawab" value="{{ old('penanggung_jawab', $item->penanggung_jawab ?? '') }}" class="form-input">
</div>
<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-emerald-950/80 mb-1">Tanggal Mulai</label>
        <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', isset($item) && $item->tanggal_mulai ? $item->tanggal_mulai->format('Y-m-d') : '') }}" class="form-input">
    </div>
    <div>
        <label class="block text-sm font-medium text-emerald-950/80 mb-1">Tanggal Selesai</label>
        <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai', isset($item) && $item->tanggal_selesai ? $item->tanggal_selesai->format('Y-m-d') : '') }}" class="form-input">
    </div>
</div>
<div>
    <label class="block text-sm font-medium text-emerald-950/80 mb-1">Status</label>
    @php $status = old('status', $item->status ?? 'belum_mulai'); @endphp
    <select name="status" class="form-input">
        <option value="belum_mulai" @selected($status === 'belum_mulai')>Belum Mulai</option>
        <option value="berjalan" @selected($status === 'berjalan')>Berjalan</option>
        <option value="selesai" @selected($status === 'selesai')>Selesai</option>
    </select>
</div>
<div>
    <label class="block text-sm font-medium text-emerald-950/80 mb-1">Lokasi</label>
    <input type="text" name="lokasi" value="{{ old('lokasi', $item->lokasi ?? '') }}" class="form-input">
</div>
<div>
    <label class="block text-sm font-medium text-emerald-950/80 mb-1">Deskripsi</label>
    <textarea name="deskripsi" rows="4" class="form-input">{{ old('deskripsi', $item->deskripsi ?? '') }}</textarea>
</div>
<div x-data="{ preview: null }">
    <label class="block text-sm font-medium text-emerald-950/80 mb-1">Dokumentasi (gambar)</label>
    <p class="text-xs text-emerald-900/40 mb-2">Gambar ini tampil di kartu &amp; halaman detail program kerja pada website.</p>
    <template x-if="preview">
        <img :src="preview" class="h-32 w-full max-w-xs object-cover mb-2 rounded-lg border border-emerald-900/10">
    </template>
    <template x-if="!preview">
        @if (isset($item) && $item->dokumentasi)
            <img src="{{ asset('storage/'.$item->dokumentasi) }}" class="h-32 w-full max-w-xs object-cover mb-2 rounded-lg border border-emerald-900/10">
        @endif
    </template>
    <input type="file" name="dokumentasi" accept="image/*" class="form-file"
           @change="preview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null">
</div>
