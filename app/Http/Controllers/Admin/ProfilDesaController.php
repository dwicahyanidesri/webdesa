<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfilDesa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfilDesaController extends Controller
{
    public function edit()
    {
        $profil = ProfilDesa::firstOrCreate(['id' => 1], ['nama_desa' => 'Tanjung Agung']);

        return view('admin.profil.edit', compact('profil'));
    }

    public function update(Request $request): RedirectResponse
    {
        $profil = ProfilDesa::firstOrCreate(['id' => 1], ['nama_desa' => 'Tanjung Agung']);

        $data = $request->validate([
            'nama_desa' => ['required', 'string', 'max:255'],
            'kecamatan' => ['nullable', 'string', 'max:255'],
            'kabupaten' => ['nullable', 'string', 'max:255'],
            'provinsi' => ['nullable', 'string', 'max:255'],
            'sejarah' => ['nullable', 'string'],
            'visi' => ['nullable', 'string'],
            'misi' => ['nullable', 'string'],
            'luas_wilayah' => ['nullable', 'string', 'max:255'],
            'jumlah_penduduk' => ['nullable', 'string', 'max:255'],
            'nama_kontak' => ['nullable', 'string', 'max:255'],
            'jabatan_kontak' => ['nullable', 'string', 'max:255'],
            'no_telepon' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'alamat_kantor' => ['nullable', 'string'],
            'jam_pelayanan' => ['nullable', 'string', 'max:255'],
            'link_maps' => ['nullable', 'string'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'foto_desa' => ['nullable', 'image', 'max:2048'],
            'foto_hero' => ['nullable', 'image', 'max:4096'],
        ]);

        if ($request->hasFile('logo')) {
            if ($profil->logo) {
                Storage::disk('public')->delete($profil->logo);
            }
            $data['logo'] = $request->file('logo')->store('profil', 'public');
        }

        if ($request->hasFile('foto_desa')) {
            if ($profil->foto_desa) {
                Storage::disk('public')->delete($profil->foto_desa);
            }
            $data['foto_desa'] = $request->file('foto_desa')->store('profil', 'public');
        }

        if ($request->hasFile('foto_hero')) {
            if ($profil->foto_hero) {
                Storage::disk('public')->delete($profil->foto_hero);
            }
            $data['foto_hero'] = $request->file('foto_hero')->store('profil', 'public');
        }

        $profil->update($data);

        return redirect()->route('admin.profil.edit')->with('success', 'Profil desa berhasil diperbarui.');
    }
}
