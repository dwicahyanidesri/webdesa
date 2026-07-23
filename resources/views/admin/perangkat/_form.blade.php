<div>
    <label class="block text-sm font-medium text-emerald-950/80 mb-1">Nama</label>
    <input type="text" name="nama" value="{{ old('nama', $item->nama ?? '') }}" class="form-input" required>
</div>
<div>
    <label class="block text-sm font-medium text-emerald-950/80 mb-1">Jabatan</label>
    <input type="text" name="jabatan" value="{{ old('jabatan', $item->jabatan ?? '') }}" class="form-input" required>
</div>
<div>
    <label class="block text-sm font-medium text-emerald-950/80 mb-1">Atasan (Terhubung ke)</label>
    <p class="text-xs text-emerald-900/40 mb-1.5">Pilih siapa yang menjadi atasan langsung orang ini pada bagan. Kosongkan jika ini jabatan paling atas (mis. Kepala Desa / BPK).</p>
    @php $parentId = old('parent_id', $item->parent_id ?? ''); @endphp
    <select name="parent_id" class="form-input">
        <option value="">— Tidak ada (paling atas) —</option>
        @foreach ($parentOptions as $opt)
            <option value="{{ $opt->id }}" @selected((string) $parentId === (string) $opt->id)>{{ $opt->nama }} ({{ $opt->jabatan }})</option>
        @endforeach
    </select>
</div>
<div>
    <label class="block text-sm font-medium text-emerald-950/80 mb-1">Tingkat pada Bagan</label>
    @php $level = old('level', $item->level ?? 2); @endphp
    <select name="level" class="form-input">
        <option value="1" @selected($level == 1)>1 - Kepala Desa (paling atas)</option>
        <option value="2" @selected($level == 2)>2 - Sekretaris / Kaur / Kasi</option>
        <option value="3" @selected($level == 3)>3 - Kepala Dusun / Staf</option>
    </select>
</div>
<div>
    <label class="block text-sm font-medium text-emerald-950/80 mb-1">Urutan dalam Tingkat</label>
    <input type="number" name="urutan" value="{{ old('urutan', $item->urutan ?? 0) }}" min="0" class="form-input">
</div>
<div>
    <label class="block text-sm font-medium text-emerald-950/80 mb-1">Foto</label>
    @if (isset($item) && $item->foto)
        <img src="{{ asset('storage/'.$item->foto) }}" class="h-16 w-16 rounded-full object-cover mb-2">
    @endif
    <input type="file" name="foto" accept="image/*" class="form-file">
</div>
