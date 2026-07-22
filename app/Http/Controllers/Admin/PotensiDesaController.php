<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PotensiDesa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PotensiDesaController extends Controller
{
    public function index()
    {
        $potensiDesa = PotensiDesa::orderBy('urutan')->get();

        return view('admin.potensi.index', compact('potensiDesa'));
    }

    public function create()
    {
        return view('admin.potensi.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('potensi', 'public');
        }

        PotensiDesa::create($data);

        return redirect()->route('admin.potensi.index')->with('success', 'Potensi desa berhasil ditambahkan.');
    }

    public function edit(PotensiDesa $potensi)
    {
        return view('admin.potensi.edit', ['item' => $potensi]);
    }

    public function update(Request $request, PotensiDesa $potensi): RedirectResponse
    {
        $data = $this->validated($request);

        if ($request->hasFile('gambar')) {
            if ($potensi->gambar) {
                Storage::disk('public')->delete($potensi->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('potensi', 'public');
        }

        $potensi->update($data);

        return redirect()->route('admin.potensi.index')->with('success', 'Potensi desa berhasil diperbarui.');
    }

    public function destroy(PotensiDesa $potensi): RedirectResponse
    {
        if ($potensi->gambar) {
            Storage::disk('public')->delete($potensi->gambar);
        }
        $potensi->delete();

        return redirect()->route('admin.potensi.index')->with('success', 'Potensi desa berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'kategori' => ['nullable', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'urutan' => ['nullable', 'integer', 'min:0'],
            'gambar' => ['nullable', 'image', 'max:2048'],
        ]);
    }
}
