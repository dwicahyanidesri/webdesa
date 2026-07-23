<?php

namespace App\Models;

use Database\Factories\PendudukFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penduduk extends Model
{
    /** @use HasFactory<PendudukFactory> */
    use HasFactory;

    protected $table = 'penduduk';

    protected $fillable = [
        'nama', 'nik', 'jenis_kelamin', 'tanggal_lahir', 'dusun', 'rt',
        'status_keluarga', 'status_ekonomi', 'status_nikah', 'pendidikan_terakhir',
        'status_sekolah', 'penerima_bantuan', 'alamat',
    ];

    public const DUSUN = ['Sinar Maju', 'Tanjung Agung', 'Cikoak', 'Pematang'];

    public const RT = ['001', '002', '003', '004', '005', '006'];

    public const STATUS_KELUARGA = [
        'kepala_keluarga' => 'Kepala Keluarga',
        'ibu_rumah_tangga' => 'Ibu Rumah Tangga',
        'anak' => 'Anak',
        'anggota_lain' => 'Anggota Lain',
    ];

    public const STATUS_EKONOMI = [
        'kurang_mampu' => 'Kurang Mampu',
        'mampu' => 'Mampu',
        'sangat_mampu' => 'Sangat Mampu',
    ];

    public const STATUS_NIKAH = [
        'belum_kawin' => 'Belum Kawin',
        'kawin' => 'Kawin',
        'cerai_hidup' => 'Cerai Hidup',
        'cerai_mati' => 'Cerai Mati',
    ];

    public const PENDIDIKAN = [
        'tidak_belum_sekolah' => 'Tidak/Belum Sekolah',
        'tamat_sd_sederajat' => 'Tamat SD/Sederajat',
        'sltp_sederajat' => 'SLTP/Sederajat',
        'slta_sederajat' => 'SLTA/Sederajat',
        'strata_ii' => 'Strata II',
        'pelajar_mahasiswa' => 'Pelajar/Mahasiswa',
    ];

    public const BANTUAN = ['BLT', 'BPNT', 'Bantuan Pangan', 'Prakerja', 'KIP', 'PKH'];

    /** Kelompok usia dipakai untuk chart "Usia & Jenis Kelamin" */
    public const KELOMPOK_USIA = [
        '0-5' => [0, 5],
        '6-11' => [6, 11],
        '12-16' => [12, 16],
        '17-25' => [17, 25],
        '26-35' => [26, 35],
        '36-45' => [36, 45],
        '46-55' => [46, 55],
        '56-65' => [56, 65],
        '65+' => [66, 200],
    ];

    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
            'status_sekolah' => 'boolean',
            'penerima_bantuan' => 'array',
        ];
    }

    public function getUsiaAttribute(): ?int
    {
        return $this->tanggal_lahir?->age;
    }

    public function getKelompokUsiaAttribute(): ?string
    {
        $usia = $this->usia;

        if ($usia === null) {
            return null;
        }

        foreach (self::KELOMPOK_USIA as $label => [$min, $max]) {
            if ($usia >= $min && $usia <= $max) {
                return $label;
            }
        }

        return null;
    }

    public function statusKeluargaLabel(): string
    {
        return self::STATUS_KELUARGA[$this->status_keluarga] ?? $this->status_keluarga;
    }

    public function pendidikanLabel(): string
    {
        return self::PENDIDIKAN[$this->pendidikan_terakhir] ?? $this->pendidikan_terakhir;
    }
}
