<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PerangkatDesa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PerangkatDesaController extends Controller
{
    public function index()
    {
        $perangkatDesa = PerangkatDesa::with('parent')->orderBy('level')->orderBy('urutan')->get();

        return view('admin.perangkat.index', compact('perangkatDesa'));
    }

    public function create()
    {
        $parentOptions = PerangkatDesa::orderBy('level')->orderBy('urutan')->get();

        return view('admin.perangkat.create', compact('parentOptions'));
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
        $excluded = $this->descendantIds($perangkat);
        $excluded[] = $perangkat->id;

        $parentOptions = PerangkatDesa::whereNotIn('id', $excluded)
            ->orderBy('level')->orderBy('urutan')->get();

        return view('admin.perangkat.edit', ['item' => $perangkat, 'parentOptions' => $parentOptions]);
    }

    public function update(Request $request, PerangkatDesa $perangkat): RedirectResponse
    {
        if ($redirect = $this->rejectFailedUploads($request, ['foto'])) {
            return $redirect;
        }

        $data = $this->validated($request, $perangkat);

        if ($request->hasFile('foto')) {
            if ($perangkat->foto) {
                Storage::disk('public')->delete($perangkat->foto);
            }
            $data['foto'] = $request->file('foto')->store('perangkat', 'public');
        }

        $perangkat->update($data);

        return redirect()->route('admin.perangkat.index')->with('success', 'Perangkat desa berhasil diperbarui.');
    }

    /**
     * Ambil semua id keturunan (anak, cucu, dst) dari sebuah perangkat,
     * supaya tidak bisa dijadikan atasan diri sendiri (mencegah loop tak berujung).
     */
    private function descendantIds(PerangkatDesa $perangkat): array
    {
        $ids = [];
        $queue = PerangkatDesa::where('parent_id', $perangkat->id)->pluck('id')->all();

        while (! empty($queue)) {
            $id = array_shift($queue);
            $ids[] = $id;
            $childIds = PerangkatDesa::where('parent_id', $id)->pluck('id')->all();
            array_push($queue, ...$childIds);
        }

        return $ids;
    }

    public function destroy(PerangkatDesa $perangkat): RedirectResponse
    {
        if ($perangkat->foto) {
            Storage::disk('public')->delete($perangkat->foto);
        }
        $perangkat->delete();

        return redirect()->route('admin.perangkat.index')->with('success', 'Perangkat desa berhasil dihapus.');
    }

    private function validated(Request $request, ?PerangkatDesa $perangkat = null): array
    {
        $forbiddenParentIds = [];
        if ($perangkat) {
            $forbiddenParentIds = $this->descendantIds($perangkat);
            $forbiddenParentIds[] = $perangkat->id;
        }

        return $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'jabatan' => ['required', 'string', 'max:255'],
            'level' => ['required', 'integer', 'in:1,2,3'],
            'urutan' => ['nullable', 'integer', 'min:0'],
            'foto' => ['nullable', 'image', 'max:8192'],
            'parent_id' => [
                'nullable',
                'integer',
                'exists:perangkat_desa,id',
                Rule::notIn($forbiddenParentIds),
            ],
        ], array_merge($this->maxFileSizeMessages(['foto']), [
            'parent_id.not_in' => 'Atasan tidak boleh diri sendiri atau bawahan sendiri.',
        ]));
    }
}
