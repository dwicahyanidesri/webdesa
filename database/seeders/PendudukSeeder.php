<?php

namespace Database\Seeders;

use App\Models\Penduduk;
use Illuminate\Database\Seeder;

class PendudukSeeder extends Seeder
{
    /**
     * Data sintetis untuk mengisi dashboard statistik demo.
     * Silakan ganti/lengkapi dengan data penduduk sebenarnya lewat menu
     * "Kelola Data Penduduk" di panel admin.
     */
    public function run(): void
    {
        if (Penduduk::count() > 0) {
            return;
        }

        Penduduk::factory()->count(600)->create();
    }
}
