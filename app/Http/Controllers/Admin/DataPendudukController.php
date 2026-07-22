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
        $dusunAktif = $request->filled('dusun') && $request->dusun !== 'semua' ? $request->dusun : null;

        $query = Penduduk::query()
            ->when($request->filled('rt') && $request->rt !== 'semua', fn ($q) => $q->where('rt', $request->rt))
            ->when($dusunAktif, fn ($q) => $q->where('dusun', $dusunAktif))
            ->when($request->filled('pendidikan') && $request->pendidikan !== 'semua', fn ($q) => $q->where('pendidikan_terakhir', $request->pendidikan));

        /** @var Collection<int, Penduduk> $all */
        $all = $query->get();

        $total = $all->count();

        // Satu kali pass per dimensi (countBy) alih-alih banyak ->where()->count() berulang,
        // supaya perhitungan tetap ringan walau data penduduk bertambah banyak.
        $byJenisKelamin = $all->countBy('jenis_kelamin');
        $byStatusKeluarga = $all->countBy('status_keluarga');
        $byStatusEkonomi = $all->countBy('status_ekonomi');
        $byStatusNikah = $all->countBy('status_nikah');
        $byPendidikan = $all->countBy('pendidikan_terakhir');
        $byRt = $all->countBy('rt');
        $byDusun = $dusunAktif ? null : $all->countBy('dusun');

        $perempuan = $byJenisKelamin->get('P', 0);
        $lakiLaki = $byJenisKelamin->get('L', 0);
        $bersekolah = $all->where('status_sekolah', true)->count();
        $persenBersekolah = $total > 0 ? round($bersekolah / $total * 100) : 0;

        // Panel "Jumlah Penduduk Sesuai Dusun" menyesuaikan diri: kalau user sudah
        // memfilter ke satu dusun tertentu, tampilkan sebaran per RT di dusun itu
        // (lebih informatif) daripada menampilkan 3 batang kosong + 1 batang penuh.
        if ($dusunAktif) {
            $sebaran = collect(Penduduk::RT)->map(fn ($rt) => [
                'label' => 'RT '.$rt,
                'total' => $byRt->get($rt, 0),
            ])->values();
            $sebaranTitle = 'Jumlah Penduduk Sesuai RT — Dusun '.$dusunAktif;
        } else {
            $sebaran = collect(Penduduk::DUSUN)->map(fn ($dusun) => [
                'label' => $dusun,
                'total' => $byDusun->get($dusun, 0),
            ])->values();
            $sebaranTitle = 'Jumlah Penduduk Sesuai Dusun';
        }

        // Kelompok usia x jenis kelamin, dihitung dalam satu kali perulangan.
        $usiaCounts = [];
        foreach (array_keys(Penduduk::KELOMPOK_USIA) as $label) {
            $usiaCounts[$label] = ['laki_laki' => 0, 'perempuan' => 0];
        }
        foreach ($all as $p) {
            $label = $p->kelompok_usia;
            if (! isset($usiaCounts[$label])) {
                continue;
            }
            $usiaCounts[$label][$p->jenis_kelamin === 'P' ? 'perempuan' : 'laki_laki']++;
        }
        $usiaJenisKelamin = collect($usiaCounts)->map(fn ($v, $label) => [
            'label' => $label,
            'laki_laki' => $v['laki_laki'],
            'perempuan' => $v['perempuan'],
        ])->values();

        $statusEkonomi = collect(Penduduk::STATUS_EKONOMI)->map(fn ($label, $key) => [
            'label' => $label,
            'total' => $byStatusEkonomi->get($key, 0),
        ])->values();

        $statusNikah = collect(Penduduk::STATUS_NIKAH)->map(fn ($label, $key) => [
            'label' => $label,
            'total' => $byStatusNikah->get($key, 0),
        ])->values();

        $pendidikan = collect(Penduduk::PENDIDIKAN)->map(fn ($label, $key) => [
            'label' => $label,
            'total' => $byPendidikan->get($key, 0),
        ])->values();

        // Penerima bantuan: field array, dihitung dalam satu kali perulangan (flatMap + countBy).
        $bantuanCounts = $all->flatMap(fn ($p) => $p->penerima_bantuan ?? [])->countBy();
        $penerimaBantuan = collect(Penduduk::BANTUAN)->map(fn ($jenis) => [
            'label' => $jenis,
            'total' => $bantuanCounts->get($jenis, 0),
        ])->values();

        return response()->json([
            'total' => $total,
            'perempuan' => $perempuan,
            'laki_laki' => $lakiLaki,
            'persen_bersekolah' => $persenBersekolah,
            'jumlah_anak' => $byStatusKeluarga->get('anak', 0),
            'jumlah_ibu_rumah_tangga' => $byStatusKeluarga->get('ibu_rumah_tangga', 0),
            'jumlah_kepala_keluarga' => $byStatusKeluarga->get('kepala_keluarga', 0),
            'sebaran' => $sebaran,
            'sebaran_title' => $sebaranTitle,
            'usia_jenis_kelamin' => $usiaJenisKelamin,
            'status_ekonomi' => $statusEkonomi,
            'status_nikah' => $statusNikah,
            'pendidikan' => $pendidikan,
            'penerima_bantuan' => $penerimaBantuan,
        ]);
    }
}
