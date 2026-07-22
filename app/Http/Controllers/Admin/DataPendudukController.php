<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penduduk;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class DataPendudukController extends Controller
{
    public function index()
    {
        return view('admin.data-penduduk.index', [
            'dusunList' => Penduduk::DUSUN,
            'rtList' => Penduduk::RT,
            'pendidikanList' => Penduduk::PENDIDIKAN,
            'totalTerdata' => Penduduk::count(),
        ]);
    }

    public function stats(Request $request): JsonResponse
    {
        $query = Penduduk::query()
            ->when($request->filled('rt') && $request->rt !== 'semua', fn ($q) => $q->where('rt', $request->rt))
            ->when($request->filled('dusun') && $request->dusun !== 'semua', fn ($q) => $q->where('dusun', $request->dusun))
            ->when($request->filled('pendidikan') && $request->pendidikan !== 'semua', fn ($q) => $q->where('pendidikan_terakhir', $request->pendidikan));

        /** @var Collection<int, Penduduk> $all */
        $all = $query->get();

        $total = $all->count();
        $perempuan = $all->where('jenis_kelamin', 'P')->count();
        $lakiLaki = $all->where('jenis_kelamin', 'L')->count();

        $bersekolah = $all->where('status_sekolah', true)->count();
        $persenBersekolah = $total > 0 ? round($bersekolah / $total * 100) : 0;

        $perDusun = collect(Penduduk::DUSUN)->map(fn ($dusun) => [
            'label' => $dusun,
            'total' => $all->where('dusun', $dusun)->count(),
        ])->values();

        $usiaJenisKelamin = collect(array_keys(Penduduk::KELOMPOK_USIA))->map(function ($label) use ($all) {
            $grup = $all->filter(fn ($p) => $p->kelompok_usia === $label);

            return [
                'label' => $label,
                'laki_laki' => $grup->where('jenis_kelamin', 'L')->count(),
                'perempuan' => $grup->where('jenis_kelamin', 'P')->count(),
            ];
        })->values();

        $statusEkonomi = collect(Penduduk::STATUS_EKONOMI)->map(fn ($label, $key) => [
            'label' => $label,
            'total' => $all->where('status_ekonomi', $key)->count(),
        ])->values();

        $statusNikah = collect(Penduduk::STATUS_NIKAH)->map(fn ($label, $key) => [
            'label' => $label,
            'total' => $all->where('status_nikah', $key)->count(),
        ])->values();

        $pendidikan = collect(Penduduk::PENDIDIKAN)->map(fn ($label, $key) => [
            'label' => $label,
            'total' => $all->where('pendidikan_terakhir', $key)->count(),
        ])->values();

        $penerimaBantuan = collect(Penduduk::BANTUAN)->map(fn ($jenis) => [
            'label' => $jenis,
            'total' => $all->filter(fn ($p) => in_array($jenis, $p->penerima_bantuan ?? []))->count(),
        ])->values();

        return response()->json([
            'total' => $total,
            'perempuan' => $perempuan,
            'laki_laki' => $lakiLaki,
            'persen_bersekolah' => $persenBersekolah,
            'jumlah_anak' => $all->where('status_keluarga', 'anak')->count(),
            'jumlah_ibu_rumah_tangga' => $all->where('status_keluarga', 'ibu_rumah_tangga')->count(),
            'jumlah_kepala_keluarga' => $all->where('status_keluarga', 'kepala_keluarga')->count(),
            'per_dusun' => $perDusun,
            'usia_jenis_kelamin' => $usiaJenisKelamin,
            'status_ekonomi' => $statusEkonomi,
            'status_nikah' => $statusNikah,
            'pendidikan' => $pendidikan,
            'penerima_bantuan' => $penerimaBantuan,
        ]);
    }
}
