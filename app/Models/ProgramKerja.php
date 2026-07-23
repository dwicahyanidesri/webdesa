<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramKerja extends Model
{
    protected $table = 'program_kerja';

    protected $fillable = [
        'nama_program', 'bidang', 'penanggung_jawab', 'tanggal_mulai', 'tanggal_selesai',
        'status', 'lokasi', 'deskripsi', 'dokumentasi',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'date',
            'tanggal_selesai' => 'date',
        ];
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'belum_mulai' => 'Belum Mulai',
            'berjalan' => 'Berjalan',
            'selesai' => 'Selesai',
            default => $this->status,
        };
    }

    public function statusColor(): string
    {
        return match ($this->status) {
            'belum_mulai' => 'bg-gray-100 text-gray-700',
            'berjalan' => 'bg-amber-100 text-amber-700',
            'selesai' => 'bg-emerald-100 text-emerald-700',
            default => 'bg-gray-100 text-gray-700',
        };
    }
}
