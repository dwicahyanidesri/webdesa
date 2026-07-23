<?php

namespace App\Http\Controllers;

use App\Models\PerangkatDesa;
use App\Models\PotensiDesa;
use App\Models\ProfilDesa;
use Illuminate\Support\Collection;

class HomeController extends Controller
{
    public function index()
    {
        $profil = ProfilDesa::first();
        $potensi = PotensiDesa::orderBy('urutan')->get();

        $semuaPerangkat = PerangkatDesa::orderBy('level')->orderBy('urutan')->get();
        $perangkatTree = $this->buildPerangkatTree($semuaPerangkat);

        return view('home', compact('profil', 'potensi', 'perangkatTree'));
    }

    /**
     * Susun daftar perangkat desa (flat) menjadi struktur pohon bercabang
     * berdasarkan parent_id, supaya bagan di Beranda bisa menampilkan
     * hierarki yang lebih kompleks (mis. Kades punya beberapa anak buah,
     * yang masing-masing bisa punya anak buah lagi) namun tetap satu bagan
     * yang saling terhubung.
     */
    private function buildPerangkatTree(Collection $items, ?int $parentId = null): Collection
    {
        return $items
            ->where('parent_id', $parentId)
            ->map(function (PerangkatDesa $item) use ($items) {
                $item->setRelation('children', $this->buildPerangkatTree($items, $item->id));

                return $item;
            })
            ->values();
    }
}
