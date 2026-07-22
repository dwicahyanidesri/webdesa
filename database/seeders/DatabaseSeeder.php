<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ProfilDesaSeeder::class,
            PotensiDesaSeeder::class,
            PerangkatDesaSeeder::class,
            ProgramKerjaSeeder::class,
            BeritaAcaraSeeder::class,
            PendudukSeeder::class,
        ]);
    }
}
