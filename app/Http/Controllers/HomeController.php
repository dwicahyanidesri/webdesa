<?php

namespace App\Http\Controllers;

use App\Models\PerangkatDesa;
use App\Models\PotensiDesa;
use App\Models\ProfilDesa;

class HomeController extends Controller
{
    public function index()
    {
        $profil = ProfilDesa::first();
        $potensi = PotensiDesa::orderBy('urutan')->get();
        $perangkat = PerangkatDesa::orderBy('level')->orderBy('urutan')->get()->groupBy('level');

        return view('home', compact('profil', 'potensi', 'perangkat'));
    }
}
