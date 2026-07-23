<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramKerja;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProgramKerjaController extends Controller
{
    public function index()
    {
        $programKerja = ProgramKerja::orderByDesc('tanggal_mulai')->get();

        return view('admin.program-kerja.index', compact('programKerja'));
    }

    public function create()
    {
        return view('admin.program-kerja.create');
    }

    public function store(Request $request): RedirectResponse
    {
        if ($redirect = $this->rejectFailedUploads($request, ['dokumentasi'])) {
            return $redirect;
        }

        $data = $this->validated($request);

        if ($request->hasFile('dokumentasi')) {
            $data['dokumentasi'] = $request->file('dokumentasi')->store('program-kerja', 'public');
        }

        ProgramKerja::create($data);

        return redirect()->route('admin.program-kerja.index')->with('success', 'Program kerja berhasil ditambahkan.');
    }

    public function edit(ProgramKerja $program_kerja)
    {
        return view('admin.program-kerja.edit', ['item' => $program_kerja]);
    }

    public function update(Request $request, ProgramKerja $program_kerja): RedirectResponse
    {
        if ($redirect = $this->rejectFailedUploads($request, ['dokumentasi'])) {
            return $redirect;
        }

        $data = $this->validated($request);

        if ($request->hasFile('dokumentasi')) {
            if ($program_kerja->dokumentasi) {
                Storage::disk('public')->delete($program_kerja->dokumentasi);
            }
            $data['dokumentasi'] = $request->file('dokumentasi')->store('program-kerja', 'public');
        }

        $program_kerja->update($data);

        return redirect()->route('admin.program-kerja.index')->with('success', 'Program kerja berhasil diperbarui.');
    }

    public function destroy(ProgramKerja $program_kerja): RedirectResponse
    {
        if ($program_kerja->dokumentasi) {
            Storage::disk('public')->delete($program_kerja->dokumentasi);
        }
        $program_kerja->delete();

        return redirect()->route('admin.program-kerja.index')->with('success', 'Program kerja berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'nama_program' => ['required', 'string', 'max:255'],
            'bidang' => ['nullable', 'string', 'max:255'],
            'penanggung_jawab' => ['nullable', 'string', 'max:255'],
            'tanggal_mulai' => ['nullable', 'date'],
            'tanggal_selesai' => ['nullable', 'date', 'after_or_equal:tanggal_mulai'],
            'status' => ['required', 'in:belum_mulai,berjalan,selesai'],
            'lokasi' => ['nullable', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'dokumentasi' => ['nullable', 'image', 'max:8192'],
        ], $this->maxFileSizeMessages(['dokumentasi']));
    }
}
