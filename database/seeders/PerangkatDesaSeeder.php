<?php

namespace Database\Seeders;

use App\Models\PerangkatDesa;
use Illuminate\Database\Seeder;

class PerangkatDesaSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['nama' => 'Nama Kepala Desa', 'jabatan' => 'Kepala Desa', 'level' => 1, 'urutan' => 1],
            ['nama' => 'Nama Sekretaris Desa', 'jabatan' => 'Sekretaris Desa', 'level' => 2, 'urutan' => 1],
            ['nama' => 'Nama Kaur Keuangan', 'jabatan' => 'Kaur Keuangan', 'level' => 2, 'urutan' => 2],
            ['nama' => 'Nama Kaur Umum', 'jabatan' => 'Kaur Umum & Perencanaan', 'level' => 2, 'urutan' => 3],
            ['nama' => 'Nama Kasi Pemerintahan', 'jabatan' => 'Kasi Pemerintahan', 'level' => 2, 'urutan' => 4],
            ['nama' => 'Nama Kadus 1', 'jabatan' => 'Kepala Dusun I', 'level' => 3, 'urutan' => 1],
            ['nama' => 'Nama Kadus 2', 'jabatan' => 'Kepala Dusun II', 'level' => 3, 'urutan' => 2],
        ];

        foreach ($items as $item) {
            PerangkatDesa::updateOrCreate(['nama' => $item['nama'], 'jabatan' => $item['jabatan']], $item);
        }
    }
}
