<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penduduk;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PendudukController extends Controller
{
    public function index(Request $request)
    {
        $penduduk = Penduduk::query()
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->where(function ($q) use ($request) {
                    $q->where('nama', 'ilike', '%'.$request->search.'%')
                        ->orWhere('nik', 'ilike', '%'.$request->search.'%');
                });
            })
            ->when($request->filled('dusun'), fn ($q) => $q->where('dusun', $request->dusun))
            ->when($request->filled('rt'), fn ($q) => $q->where('rt', $request->rt))
            ->orderBy('nama')
            ->paginate(15)
            ->withQueryString();

        return view('admin.penduduk.index', [
            'penduduk' => $penduduk,
            'dusunList' => Penduduk::DUSUN,
            'rtList' => Penduduk::RT,
        ]);
    }

    public function create()
    {
        return view('admin.penduduk.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Penduduk::create($this->validated($request));

        return redirect()->route('admin.penduduk.index')->with('success', 'Data penduduk berhasil ditambahkan.');
    }

    public function edit(Penduduk $penduduk)
    {
        return view('admin.penduduk.edit', ['item' => $penduduk]);
    }

    public function update(Request $request, Penduduk $penduduk): RedirectResponse
    {
        $penduduk->update($this->validated($request, $penduduk));

        return redirect()->route('admin.penduduk.index')->with('success', 'Data penduduk berhasil diperbarui.');
    }

    public function destroy(Penduduk $penduduk): RedirectResponse
    {
        $penduduk->delete();

        return redirect()->route('admin.penduduk.index')->with('success', 'Data penduduk berhasil dihapus.');
    }

    private function validated(Request $request, ?Penduduk $penduduk = null): array
    {
        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nik' => ['nullable', 'string', 'max:20', 'unique:penduduk,nik'.($penduduk ? ','.$penduduk->id : '')],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'tanggal_lahir' => ['nullable', 'date'],
            'dusun' => ['required', 'string', 'max:255'],
            'rt' => ['required', 'string', 'max:5'],
            'status_keluarga' => ['required', 'in:'.implode(',', array_keys(Penduduk::STATUS_KELUARGA))],
            'status_ekonomi' => ['required', 'in:'.implode(',', array_keys(Penduduk::STATUS_EKONOMI))],
            'status_nikah' => ['required', 'in:'.implode(',', array_keys(Penduduk::STATUS_NIKAH))],
            'pendidikan_terakhir' => ['required', 'in:'.implode(',', array_keys(Penduduk::PENDIDIKAN))],
            'status_sekolah' => ['nullable', 'boolean'],
            'penerima_bantuan' => ['nullable', 'array'],
            'penerima_bantuan.*' => ['in:'.implode(',', Penduduk::BANTUAN)],
            'alamat' => ['nullable', 'string', 'max:255'],
        ]);

        $data['status_sekolah'] = $request->boolean('status_sekolah');

        return $data;
    }
}
