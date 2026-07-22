<?php

namespace Database\Seeders;

use App\Models\ProfilDesa;
use Illuminate\Database\Seeder;

class ProfilDesaSeeder extends Seeder
{
    public function run(): void
    {
        ProfilDesa::updateOrCreate(
            ['id' => 1],
            [
                'nama_desa' => 'Tanjung Agung',
                'kecamatan' => 'Kecamatan Tanjung Agung',
                'kabupaten' => 'Kabupaten',
                'provinsi' => 'Provinsi',
                'sejarah' => 'Desa Tanjung Agung merupakan salah satu desa yang memiliki sejarah panjang dalam perkembangan wilayahnya. Silakan lengkapi narasi sejarah desa melalui menu admin.',
                'visi' => 'Mewujudkan Desa Tanjung Agung yang mandiri, sejahtera, dan berbudaya.',
                'misi' => "1. Meningkatkan kualitas sumber daya manusia.\n2. Mengembangkan potensi ekonomi desa secara berkelanjutan.\n3. Meningkatkan pelayanan publik yang transparan dan akuntabel.\n4. Menjaga kelestarian lingkungan dan budaya lokal.",
                'luas_wilayah' => '± 0 Ha',
                'jumlah_penduduk' => '0 Jiwa',
                'nama_kontak' => 'Kepala Desa Tanjung Agung',
                'jabatan_kontak' => 'Kepala Desa',
                'no_telepon' => '0800-0000-0000',
                'email' => 'desa.tanjungagung@example.id',
                'alamat_kantor' => 'Kantor Desa Tanjung Agung',
                'jam_pelayanan' => 'Senin - Jumat, 08.00 - 15.00 WIB',
                'link_maps' => null,
            ]
        );
    }
}
