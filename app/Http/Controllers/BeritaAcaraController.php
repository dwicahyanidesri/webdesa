<?php

namespace App\Http\Controllers;

use App\Models\BeritaAcara;

class BeritaAcaraController extends Controller
{
    public function index()
    {
        $beritaAcara = BeritaAcara::where('status', true)
            ->orderByDesc('created_at')
            ->paginate(9);

        return view('berita-acara.index', compact('beritaAcara'));
    }

    public function show(string $slug)
    {
        $berita = BeritaAcara::where('slug', $slug)->where('status', true)->firstOrFail();

        $lainnya = BeritaAcara::where('status', true)
            ->where('id', '!=', $berita->id)
            ->orderByDesc('created_at')
            ->limit(3)
            ->get();

        return view('berita-acara.show', compact('berita', 'lainnya'));
    }
}
