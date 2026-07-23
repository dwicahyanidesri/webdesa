<?php

namespace App\Imports;

use App\Models\Penduduk;
use Carbon\Carbon;
use Illuminate\Support\Collection as BaseCollection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class PendudukImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    use Importable;

    public int $imported = 0;

    /** @var array<int, array{row: int, nama: string, alasan: string}> */
    public array $duplicates = [];

    /** @var array<int, array{row: int, pesan: string}> */
    public array $failed = [];

    /** NIK yang sudah ada di database, dipakai untuk cek duplikasi tanpa query berulang. */
    private BaseCollection $existingNiks;

    /** Kombinasi "nama|tanggal_lahir" yang sudah ada di database. */
    private BaseCollection $existingNamaTanggal;

    public function __construct()
    {
        $this->existingNiks = Penduduk::query()->whereNotNull('nik')->pluck('nik')->map(fn ($v) => strtolower(trim($v)))->flip();

        $this->existingNamaTanggal = Penduduk::query()
            ->get(['nama', 'tanggal_lahir'])
            ->map(fn ($p) => $this->namaTanggalKey($p->nama, $p->tanggal_lahir?->format('Y-m-d')))
            ->flip();
    }

    public function collection(BaseCollection $rows)
    {
        $batch = [];
        $rowNumber = 1; // baris 1 = heading, jadi data dimulai dari baris 2

        foreach ($rows as $row) {
            $rowNumber++;

            try {
                $data = $this->mapRow($row);
            } catch (\Throwable $e) {
                $this->failed[] = ['row' => $rowNumber, 'pesan' => $e->getMessage()];

                continue;
            }

            if ($data === null) {
                continue;
            }

            $nik = $data['nik'] ? strtolower(trim($data['nik'])) : null;
            $namaTanggalKey = $this->namaTanggalKey($data['nama'], $data['tanggal_lahir']);

            if ($nik !== null && $this->existingNiks->has($nik)) {
                $this->duplicates[] = ['row' => $rowNumber, 'nama' => $data['nama'], 'alasan' => 'NIK sudah terdaftar'];

                continue;
            }

            if ($nik === null && $this->existingNamaTanggal->has($namaTanggalKey)) {
                $this->duplicates[] = ['row' => $rowNumber, 'nama' => $data['nama'], 'alasan' => 'Nama & tanggal lahir sudah terdaftar'];

                continue;
            }

            // Tandai sebagai "sudah ada" supaya baris lain di file yang sama juga kebaca sebagai duplikat.
            if ($nik !== null) {
                $this->existingNiks->put($nik, true);
            }
            $this->existingNamaTanggal->put($namaTanggalKey, true);

            $data['created_at'] = now();
            $data['updated_at'] = now();
            $batch[] = $data;
            $this->imported++;

            if (count($batch) >= 500) {
                Penduduk::insert($batch);
                $batch = [];
            }
        }

        if (! empty($batch)) {
            Penduduk::insert($batch);
        }
    }

    /**
     * @return array<string, mixed>|null null berarti baris dilewati (nama kosong / tidak valid)
     */
    private function mapRow(BaseCollection $row): ?array
    {
        $nama = trim((string) ($row['nama'] ?? ''));

        if ($nama === '') {
            throw new \RuntimeException('Kolom Nama kosong.');
        }

        $dusun = $this->matchFromList(trim((string) ($row['dusun'] ?? '')), Penduduk::DUSUN);
        if ($dusun === null) {
            throw new \RuntimeException('Dusun "'.($row['dusun'] ?? '-').'" tidak dikenali.');
        }

        $rt = $this->normalizeRt((string) ($row['rt'] ?? ''));
        if ($rt === null || ! in_array($rt, Penduduk::RT, true)) {
            throw new \RuntimeException('RT "'.($row['rt'] ?? '-').'" tidak dikenali.');
        }

        $jenisKelamin = $this->normalizeJenisKelamin((string) ($row['jenis_kelamin'] ?? ''));
        if ($jenisKelamin === null) {
            throw new \RuntimeException('Jenis Kelamin "'.($row['jenis_kelamin'] ?? '-').'" harus L/P atau Laki-laki/Perempuan.');
        }

        $statusKeluarga = $this->matchFromLabels($row['status_keluarga'] ?? null, Penduduk::STATUS_KELUARGA) ?? 'anggota_lain';
        $statusEkonomi = $this->matchFromLabels($row['status_ekonomi'] ?? null, Penduduk::STATUS_EKONOMI) ?? 'mampu';
        $statusNikah = $this->matchFromLabels($row['status_nikah'] ?? null, Penduduk::STATUS_NIKAH) ?? 'belum_kawin';
        $pendidikan = $this->matchFromLabels($row['pendidikan_terakhir'] ?? null, Penduduk::PENDIDIKAN) ?? 'tidak_belum_sekolah';

        $tanggalLahir = $this->parseTanggalLahir($row['tanggal_lahir'] ?? null);

        return [
            'nama' => $nama,
            'nik' => $this->cleanNik($row['nik'] ?? null),
            'jenis_kelamin' => $jenisKelamin,
            'tanggal_lahir' => $tanggalLahir,
            'dusun' => $dusun,
            'rt' => $rt,
            'status_keluarga' => $statusKeluarga,
            'status_ekonomi' => $statusEkonomi,
            'status_nikah' => $statusNikah,
            'pendidikan_terakhir' => $pendidikan,
            'status_sekolah' => $this->parseBoolean($row['status_sekolah'] ?? null),
            'penerima_bantuan' => json_encode($this->parseBantuan($row['penerima_bantuan'] ?? null)),
            'alamat' => trim((string) ($row['alamat'] ?? '')) ?: null,
        ];
    }

    private function namaTanggalKey(?string $nama, ?string $tanggalLahir): string
    {
        return strtolower(trim((string) $nama)).'|'.($tanggalLahir ?: '-');
    }

    private function cleanNik(mixed $value): ?string
    {
        $value = trim((string) $value);
        // NIK sering ke-load Excel sebagai angka float ("1234...E+15" atau berakhiran ".0"), rapikan.
        if ($value === '' || $value === '0') {
            return null;
        }
        if (str_ends_with($value, '.0')) {
            $value = substr($value, 0, -2);
        }

        return $value;
    }

    private function matchFromList(string $value, array $list): ?string
    {
        foreach ($list as $item) {
            if (strcasecmp($item, $value) === 0) {
                return $item;
            }
        }

        return null;
    }

    private function matchFromLabels(mixed $value, array $keyToLabel): ?string
    {
        $value = trim((string) $value);
        if ($value === '') {
            return null;
        }

        // Cocokkan dengan key ("kepala_keluarga") atau label ("Kepala Keluarga"), tidak peka huruf besar/kecil.
        foreach ($keyToLabel as $key => $label) {
            if (strcasecmp($key, $value) === 0 || strcasecmp($label, $value) === 0) {
                return $key;
            }
        }

        return null;
    }

    private function normalizeRt(string $value): ?string
    {
        $value = trim($value);
        if ($value === '') {
            return null;
        }
        // Terima "1", "01", "001", "RT 001", "RT01" dst -> dipadatkan jadi 3 digit.
        $digits = preg_replace('/\D/', '', $value) ?? '';

        return $digits === '' ? null : str_pad($digits, 3, '0', STR_PAD_LEFT);
    }

    private function normalizeJenisKelamin(string $value): ?string
    {
        $value = strtolower(trim($value));

        return match (true) {
            in_array($value, ['l', 'laki-laki', 'laki laki', 'pria', 'male'], true) => 'L',
            in_array($value, ['p', 'perempuan', 'wanita', 'female'], true) => 'P',
            default => null,
        };
    }

    private function parseBoolean(mixed $value): bool
    {
        $value = strtolower(trim((string) $value));

        return in_array($value, ['ya', 'yes', '1', 'true', 'sudah', 'sedang bersekolah'], true);
    }

    private function parseBantuan(mixed $value): array
    {
        $value = trim((string) $value);
        if ($value === '') {
            return [];
        }

        $parts = array_map('trim', explode(',', $value));
        $result = [];

        foreach ($parts as $part) {
            foreach (Penduduk::BANTUAN as $jenis) {
                if (strcasecmp($jenis, $part) === 0) {
                    $result[] = $jenis;

                    break;
                }
            }
        }

        return array_values(array_unique($result));
    }

    private function parseTanggalLahir(mixed $value): ?string
    {
        if ($value === null || trim((string) $value) === '') {
            return null;
        }

        // Excel kadang menyimpan tanggal sebagai serial number.
        if (is_numeric($value)) {
            try {
                return ExcelDate::excelToDateTimeObject((float) $value)->format('Y-m-d');
            } catch (\Throwable) {
                return null;
            }
        }

        $value = trim((string) $value);
        $formats = ['d/m/Y', 'd-m-Y', 'Y-m-d', 'd F Y', 'd M Y', 'Y/m/d'];

        foreach ($formats as $format) {
            try {
                $date = Carbon::createFromFormat($format, $value);
                if ($date !== false) {
                    return $date->format('Y-m-d');
                }
            } catch (\Throwable) {
                // coba format berikutnya
            }
        }

        try {
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Throwable) {
            return null;
        }
    }
}
