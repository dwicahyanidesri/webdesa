<div>
    <label class="block text-sm font-medium text-emerald-950/80 mb-1">Judul</label>
    <input type="text" name="judul" value="{{ old('judul', $item->judul ?? '') }}" class="w-full rounded-lg border-emerald-900/20 text-sm" required>
</div>
<div>
    <label class="block text-sm font-medium text-emerald-950/80 mb-1">Kategori</label>
    <input type="text" name="kategori" value="{{ old('kategori', $item->kategori ?? '') }}" placeholder="Pertanian, UMKM, Wisata, dll." class="w-full rounded-lg border-emerald-900/20 text-sm">
</div>
<div>
    <label class="block text-sm font-medium text-emerald-950/80 mb-1">Deskripsi</label>
    <textarea name="deskripsi" rows="4" class="w-full rounded-lg border-emerald-900/20 text-sm">{{ old('deskripsi', $item->deskripsi ?? '') }}</textarea>
</div>
<div>
    <label class="block text-sm font-medium text-emerald-950/80 mb-1">Urutan Tampil</label>
    <input type="number" name="urutan" value="{{ old('urutan', $item->urutan ?? 0) }}" min="0" class="w-full rounded-lg border-emerald-900/20 text-sm">
</div>
<div>
    <label class="block text-sm font-medium text-emerald-950/80 mb-1">Gambar</label>
    @if (isset($item) && $item->gambar)
        <img src="{{ asset('storage/'.$item->gambar) }}" class="h-16 mb-2 rounded">
    @endif
    <input type="file" name="gambar" accept="image/*" class="w-full text-sm">
</div>
