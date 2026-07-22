<?php

namespace Database\Seeders;

use App\Models\PotensiDesa;
use Illuminate\Database\Seeder;

class PotensiDesaSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['judul' => 'Pertanian Padi', 'kategori' => 'Pertanian', 'deskripsi' => 'Lahan persawahan menjadi salah satu sumber mata pencaharian utama warga desa.', 'urutan' => 1],
            ['judul' => 'UMKM Olahan Pangan', 'kategori' => 'UMKM', 'deskripsi' => 'Berbagai usaha rumahan mengolah hasil bumi menjadi produk bernilai jual.', 'urutan' => 2],
            ['judul' => 'Wisata Alam', 'kategori' => 'Wisata', 'deskripsi' => 'Potensi alam desa yang dapat dikembangkan menjadi destinasi wisata.', 'urutan' => 3],
        ];

        foreach ($items as $item) {
            PotensiDesa::updateOrCreate(['judul' => $item['judul']], $item);
        }
    }
}
