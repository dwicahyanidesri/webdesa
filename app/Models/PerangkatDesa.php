<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama', 'jabatan', 'level', 'urutan', 'foto'])]
class PerangkatDesa extends Model
{
    protected $table = 'perangkat_desa';
}
