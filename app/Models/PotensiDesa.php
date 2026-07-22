<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['judul', 'kategori', 'deskripsi', 'gambar', 'urutan'])]
class PotensiDesa extends Model
{
    protected $table = 'potensi_desa';
}
