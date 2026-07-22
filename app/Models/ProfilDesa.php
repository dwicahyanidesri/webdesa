<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'nama_desa', 'kecamatan', 'kabupaten', 'provinsi', 'sejarah', 'visi', 'misi',
    'luas_wilayah', 'jumlah_penduduk', 'logo', 'foto_desa', 'foto_hero',
    'nama_kontak', 'jabatan_kontak', 'no_telepon', 'email',
    'alamat_kantor', 'jam_pelayanan', 'link_maps',
])]
class ProfilDesa extends Model
{
    protected $table = 'profil_desa';
}
