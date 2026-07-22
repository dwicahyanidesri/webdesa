<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BeritaAcara;
use App\Models\PerangkatDesa;
use App\Models\PotensiDesa;
use App\Models\ProgramKerja;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'potensi' => PotensiDesa::count(),
            'perangkat' => PerangkatDesa::count(),
            'program_kerja' => ProgramKerja::count(),
            'berita_acara' => BeritaAcara::count(),
            'berita_visible' => BeritaAcara::where('status', true)->count(),
        ];

        $beritaTerbaru = BeritaAcara::orderByDesc('created_at')->limit(5)->get();
        $programTerbaru = ProgramKerja::orderByDesc('created_at')->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'beritaTerbaru', 'programTerbaru'));
    }
}
