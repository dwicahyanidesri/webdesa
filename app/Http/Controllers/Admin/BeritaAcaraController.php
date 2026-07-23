<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BeritaAcara;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BeritaAcaraController extends Controller
{
    public function index()
    {
        $beritaAcara = BeritaAcara::orderByDesc('created_at')->get();

        return view('admin.berita-acara.index', compact('beritaAcara'));
    }

    public function create()
    {
        return view('admin.berita-acara.create');
    }

    public function store(Request $request): RedirectResponse
    {
        if ($redirect = $this->rejectFailedUploads($request, ['gambar'])) {
            return $redirect;
        }

        $data = $this->validated($request);
        $data['slug'] = BeritaAcara::generateUniqueSlug($data['judul']);
        $data['status'] = $request->boolean('status');

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        BeritaAcara::create($data);

        return redirect()->route('admin.berita-acara.index')->with('success', 'Berita acara berhasil ditambahkan.');
    }

    public function edit(BeritaAcara $berita_acara)
    {
        return view('admin.berita-acara.edit', ['item' => $berita_acara]);
    }

    public function update(Request $request, BeritaAcara $berita_acara): RedirectResponse
    {
        if ($redirect = $this->rejectFailedUploads($request, ['gambar'])) {
            return $redirect;
        }

        $data = $this->validated($request);
        $data['status'] = $request->boolean('status');

        if ($data['judul'] !== $berita_acara->judul) {
            $data['slug'] = BeritaAcara::generateUniqueSlug($data['judul'], $berita_acara->id);
        }

        if ($request->hasFile('gambar')) {
            if ($berita_acara->gambar) {
                Storage::disk('public')->delete($berita_acara->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('berita', 'public');
        }

        $berita_acara->update($data);

        return redirect()->route('admin.berita-acara.index')->with('success', 'Berita acara berhasil diperbarui.');
    }

    public function destroy(BeritaAcara $berita_acara): RedirectResponse
    {
        if ($berita_acara->gambar) {
            Storage::disk('public')->delete($berita_acara->gambar);
        }
        $berita_acara->delete();

        return redirect()->route('admin.berita-acara.index')->with('success', 'Berita acara berhasil dihapus.');
    }

    public function toggleStatus(BeritaAcara $berita_acara): RedirectResponse
    {
        $berita_acara->update(['status' => ! $berita_acara->status]);

        return back()->with('success', 'Status berita acara berhasil diubah.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'penulis' => ['nullable', 'string', 'max:255'],
            'isi' => ['required', 'string'],
            'gambar' => ['nullable', 'image', 'max:8192'],
        ], $this->maxFileSizeMessages(['gambar']));
    }
}
