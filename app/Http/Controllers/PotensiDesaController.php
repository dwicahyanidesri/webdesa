<?php

namespace App\Http\Controllers;

use App\Models\PotensiDesa;

class PotensiDesaController extends Controller
{
    public function index()
    {
        $potensi = PotensiDesa::orderBy('urutan')->paginate(6);

        return view('potensi.index', compact('potensi'));
    }
}
