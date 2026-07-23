<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PotensiDesa extends Model
{
    protected $table = 'potensi_desa';

    protected $fillable = ['judul', 'kategori', 'deskripsi', 'gambar', 'urutan'];
}
