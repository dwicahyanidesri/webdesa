<?php

namespace App\Exports;

use App\Models\Penduduk;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PendudukTemplateExport implements FromArray, WithHeadings
{
    public function headings(): array
    {
        return [
            'Nama', 'NIK', 'Jenis Kelamin', 'Tanggal Lahir', 'Dusun', 'RT',
            'Status Keluarga', 'Status Ekonomi', 'Status Nikah', 'Pendidikan Terakhir',
            'Status Sekolah', 'Penerima Bantuan', 'Alamat',
        ];
    }

    public function array(): array
    {
        return [
            [
                'Contoh Nama Warga',
                '1671010101010001',
                'L',
                '17/08/1990',
                Penduduk::DUSUN[0],
                Penduduk::RT[0],
                'Kepala Keluarga',
                'Mampu',
                'Kawin',
                'SLTA/Sederajat',
                'Tidak',
                'BLT, PKH',
                'Jl. Contoh No. 1',
            ],
        ];
    }
}
