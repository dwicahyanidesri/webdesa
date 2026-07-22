<?php

namespace App\Http\Controllers;

use App\Models\ProgramKerja;

class ProgramKerjaController extends Controller
{
    public function index()
    {
        $programKerja = ProgramKerja::orderByDesc('tanggal_mulai')->paginate(6);

        return view('program-kerja.index', compact('programKerja'));
    }

    public function show(ProgramKerja $program_kerja)
    {
        $lainnya = ProgramKerja::where('id', '!=', $program_kerja->id)
            ->orderByDesc('tanggal_mulai')
            ->limit(3)
            ->get();

        return view('program-kerja.show', ['program' => $program_kerja, 'lainnya' => $lainnya]);
    }
}
