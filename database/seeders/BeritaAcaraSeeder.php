<?php

namespace Database\Seeders;

use App\Models\BeritaAcara;
use Illuminate\Database\Seeder;

class BeritaAcaraSeeder extends Seeder
{
    public function run(): void
    {
        $judul = 'Rapat Koordinasi Program Kerja KKN';

        BeritaAcara::updateOrCreate(
            ['judul' => $judul],
            [
                'judul' => $judul,
                'slug' => BeritaAcara::generateUniqueSlug($judul),
                'penulis' => 'Admin Desa',
                'isi' => 'Telah dilaksanakan rapat koordinasi antara perangkat desa dan mahasiswa KKN untuk membahas rencana program kerja selama masa pengabdian di Desa Tanjung Agung.',
                'status' => true,
            ]
        );
    }
}
