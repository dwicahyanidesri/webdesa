<div>
    <label class="block text-sm font-medium text-emerald-950/80 mb-1">Nama</label>
    <input type="text" name="nama" value="{{ old('nama', $item->nama ?? '') }}" class="w-full rounded-lg border-emerald-900/20 text-sm" required>
</div>
<div>
    <label class="block text-sm font-medium text-emerald-950/80 mb-1">Jabatan</label>
    <input type="text" name="jabatan" value="{{ old('jabatan', $item->jabatan ?? '') }}" class="w-full rounded-lg border-emerald-900/20 text-sm" required>
</div>
<div>
    <label class="block text-sm font-medium text-emerald-950/80 mb-1">Tingkat pada Bagan</label>
    @php $level = old('level', $item->level ?? 2); @endphp
    <select name="level" class="w-full rounded-lg border-emerald-900/20 text-sm">
        <option value="1" @selected($level == 1)>1 - Kepala Desa (paling atas)</option>
        <option value="2" @selected($level == 2)>2 - Sekretaris / Kaur / Kasi</option>
        <option value="3" @selected($level == 3)>3 - Kepala Dusun / Staf</option>
    </select>
</div>
<div>
    <label class="block text-sm font-medium text-emerald-950/80 mb-1">Urutan dalam Tingkat</label>
    <input type="number" name="urutan" value="{{ old('urutan', $item->urutan ?? 0) }}" min="0" class="w-full rounded-lg border-emerald-900/20 text-sm">
</div>
<div>
    <label class="block text-sm font-medium text-emerald-950/80 mb-1">Foto</label>
    @if (isset($item) && $item->foto)
        <img src="{{ asset('storage/'.$item->foto) }}" class="h-16 w-16 rounded-full object-cover mb-2">
    @endif
    <input type="file" name="foto" accept="image/*" class="w-full text-sm">
</div>
