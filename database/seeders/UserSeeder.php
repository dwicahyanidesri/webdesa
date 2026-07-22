<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Akun superadmin tunggal. Tidak ada fitur register di aplikasi ini,
     * jadi kredensial login dibuat lewat seeder ini agar aman.
     * GANTI password ini setelah deploy pertama kali.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@tanjungagung.desa.id'],
            [
                'name' => 'Superadmin Desa Tanjung Agung',
                'password' => Hash::make('TanjungAgung#2026'),
                'email_verified_at' => now(),
            ]
        );
    }
}
