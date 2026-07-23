<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PerangkatDesa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PerangkatDesaController extends Controller
{
    public function index()
    {
        $perangkatDesa = PerangkatDesa::orderBy('level')->orderBy('urutan')->get();

        return view('admin.perangkat.index', compact('perangkatDesa'));
    }

    public function create()
    {
        return view('admin.perangkat.create');
    }

    public function store(Request $request): RedirectResponse
    {
        if ($redirect = $this->rejectFailedUploads($request, ['foto'])) {
            return $redirect;
        }

        $data = $this->validated($request);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('perangkat', 'public');
        }

        PerangkatDesa::create($data);

        return redirect()->route('admin.perangkat.index')->with('success', 'Perangkat desa berhasil ditambahkan.');
    }

    public function edit(PerangkatDesa $perangkat)
    {
        return view('admin.perangkat.edit', ['item' => $perangkat]);
    }

    public function update(Request $request, PerangkatDesa $perangkat): RedirectResponse
    {
        if ($redirect = $this->rejectFailedUploads($request, ['foto'])) {
            return $redirect;
        }

        $data = $this->validated($request);

        if ($request->hasFile('foto')) {
            if ($perangkat->foto) {
                Storage::disk('public')->delete($perangkat->foto);
            }
            $data['foto'] = $request->file('foto')->store('perangkat', 'public');
        }

        $perangkat->update($data);

        return redirect()->route('admin.perangkat.index')->with('success', 'Perangkat desa berhasil diperbarui.');
    }

    public function destroy(PerangkatDesa $perangkat): RedirectResponse
    {
        if ($perangkat->foto) {
            Storage::disk('public')->delete($perangkat->foto);
        }
        $perangkat->delete();

        return redirect()->route('admin.perangkat.index')->with('success', 'Perangkat desa berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'jabatan' => ['required', 'string', 'max:255'],
            'level' => ['required', 'integer', 'in:1,2,3'],
            'urutan' => ['nullable', 'integer', 'min:0'],
            'foto' => ['nullable', 'image', 'max:8192'],
        ], $this->maxFileSizeMessages(['foto']));
    }
}
