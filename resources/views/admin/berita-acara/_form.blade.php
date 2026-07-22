<div>
    <label class="block text-sm font-medium text-emerald-950/80 mb-1">Judul</label>
    <input type="text" name="judul" value="{{ old('judul', $item->judul ?? '') }}" class="form-input" required>
</div>
<div>
    <label class="block text-sm font-medium text-emerald-950/80 mb-1">Penulis</label>
    <input type="text" name="penulis" value="{{ old('penulis', $item->penulis ?? auth()->user()->name) }}" class="form-input">
</div>
<div>
    <label class="block text-sm font-medium text-emerald-950/80 mb-1">Isi / Deskripsi</label>
    <textarea name="isi" rows="6" class="form-input" required>{{ old('isi', $item->isi ?? '') }}</textarea>
</div>
<div x-data="{ preview: null }">
    <label class="block text-sm font-medium text-emerald-950/80 mb-1">Gambar (maks. 1 gambar)</label>
    <template x-if="preview">
        <img :src="preview" class="h-32 w-full max-w-xs object-cover mb-2 rounded-lg border border-emerald-900/10">
    </template>
    <template x-if="!preview">
        @if (isset($item) && $item->gambar)
            <img src="{{ asset('storage/'.$item->gambar) }}" class="h-32 w-full max-w-xs object-cover mb-2 rounded-lg border border-emerald-900/10">
        @endif
    </template>
    <input type="file" name="gambar" accept="image/*" class="form-file"
           @change="preview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null">
</div>
<div>
    <label class="inline-flex items-center gap-2 text-sm text-emerald-950/80">
        @php $status = old('status', $item->status ?? true); @endphp
        <input type="checkbox" name="status" value="1" class="form-checkbox" @checked($status)>
        Tampilkan ke pengunjung (visible)
    </label>
</div>
