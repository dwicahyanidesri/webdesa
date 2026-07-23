<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PerangkatDesa extends Model
{
    protected $table = 'perangkat_desa';

    protected $fillable = ['nama', 'jabatan', 'level', 'urutan', 'foto', 'parent_id'];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(PerangkatDesa::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(PerangkatDesa::class, 'parent_id')->orderBy('urutan');
    }
}
