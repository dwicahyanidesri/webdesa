<?php

namespace App\Http\Controllers\Admin;

use App\Exports\PendudukTemplateExport;
use App\Http\Controllers\Controller;
use App\Imports\PendudukImport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PendudukImportController extends Controller
{
    public function create()
    {
        return view('admin.penduduk.import');
    }

    public function store(Request $request): RedirectResponse
    {
        if ($redirect = $this->rejectFailedUploads($request, ['file'])) {
            return $redirect;
        }

        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:8192'],
        ], $this->maxFileSizeMessages(['file']));

        // Import ribuan baris bisa makan waktu lebih dari batas default PHP, jangan sampai terpotong.
        set_time_limit(0);

        $import = new PendudukImport();
        Excel::import($import, $request->file('file'));

        // Batasi jumlah baris yang ditampilkan di layar (tetap simpan totalnya) supaya
        // halaman tidak berat kalau ada ribuan duplikat/gagal sekaligus.
        $maxTampil = 200;

        return redirect()->route('admin.penduduk.import')
            ->with('importResult', [
                'imported' => $import->imported,
                'duplicates' => array_slice($import->duplicates, 0, $maxTampil),
                'duplicates_total' => count($import->duplicates),
                'failed' => array_slice($import->failed, 0, $maxTampil),
                'failed_total' => count($import->failed),
            ]);
    }

    public function template()
    {
        return Excel::download(new PendudukTemplateExport(), 'template-data-penduduk.xlsx');
    }
}
