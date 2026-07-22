<?php

namespace Database\Seeders;

use App\Models\ProgramKerja;
use Illuminate\Database\Seeder;

class ProgramKerjaSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'nama_program' => 'Sosialisasi Stunting',
                'bidang' => 'Kesehatan',
                'penanggung_jawab' => 'Tim KKN Kesehatan',
                'tanggal_mulai' => '2026-07-01',
                'tanggal_selesai' => '2026-07-03',
                'status' => 'selesai',
                'lokasi' => 'Balai Desa',
                'deskripsi' => 'Kegiatan sosialisasi pencegahan stunting kepada ibu-ibu dan kader posyandu.',
            ],
            [
                'nama_program' => 'Pelatihan Digital Marketing UMKM',
                'bidang' => 'Ekonomi',
                'penanggung_jawab' => 'Tim KKN Ekonomi',
                'tanggal_mulai' => '2026-07-15',
                'tanggal_selesai' => '2026-07-16',
                'status' => 'berjalan',
                'lokasi' => 'Rumah Warga / Sentra UMKM',
                'deskripsi' => 'Pelatihan pemasaran produk UMKM desa melalui media sosial dan marketplace.',
            ],
            [
                'nama_program' => 'Kerja Bakti Lingkungan',
                'bidang' => 'Lingkungan',
                'penanggung_jawab' => 'Tim KKN Lingkungan',
                'tanggal_mulai' => '2026-08-01',
                'tanggal_selesai' => '2026-08-01',
                'status' => 'belum_mulai',
                'lokasi' => 'Seluruh Dusun',
                'deskripsi' => 'Kegiatan gotong royong membersihkan lingkungan desa bersama warga.',
            ],
        ];

        foreach ($items as $item) {
            ProgramKerja::updateOrCreate(['nama_program' => $item['nama_program']], $item);
        }
    }
}
