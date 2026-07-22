<?php

namespace Database\Factories;

use App\Models\Penduduk;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Penduduk>
 */
class PendudukFactory extends Factory
{
    protected $model = Penduduk::class;

    public function definition(): array
    {
        $jenisKelamin = $this->faker->randomElement(['L', 'P']);
        $usia = $this->weightedAge();
        $tanggalLahir = now()->subYears($usia)->subDays(random_int(0, 364));

        $statusKeluarga = $this->statusKeluargaFor($usia, $jenisKelamin);
        $pendidikan = $this->pendidikanFor($usia);
        $statusSekolah = in_array($pendidikan, ['pelajar_mahasiswa'])
            ? true
            : ($usia >= 4 && $usia <= 22 && $this->faker->boolean(70));

        return [
            'nama' => $jenisKelamin === 'L' ? $this->faker->firstNameMale().' '.$this->faker->lastName() : $this->faker->firstNameFemale().' '.$this->faker->lastName(),
            'nik' => $this->faker->unique()->numerify('################'),
            'jenis_kelamin' => $jenisKelamin,
            'tanggal_lahir' => $tanggalLahir,
            'dusun' => $this->faker->randomElement(Penduduk::DUSUN),
            'rt' => $this->faker->randomElement(Penduduk::RT),
            'status_keluarga' => $statusKeluarga,
            'status_ekonomi' => $this->faker->randomElement(['kurang_mampu', 'mampu', 'mampu', 'sangat_mampu']),
            'status_nikah' => $this->statusNikahFor($usia),
            'pendidikan_terakhir' => $pendidikan,
            'status_sekolah' => $statusSekolah,
            'penerima_bantuan' => $this->bantuanFor(),
            'alamat' => $this->faker->streetAddress(),
        ];
    }

    private function weightedAge(): int
    {
        // Sebaran usia kasar mengikuti piramida penduduk desa: banyak di usia produktif.
        $bucket = $this->faker->randomElement([
            [0, 5], [6, 11], [12, 16], [17, 25], [17, 25],
            [26, 35], [26, 35], [36, 45], [36, 45],
            [46, 55], [56, 65], [66, 85],
        ]);

        return random_int($bucket[0], $bucket[1]);
    }

    private function statusKeluargaFor(int $usia, string $jenisKelamin): string
    {
        if ($usia < 18) {
            return 'anak';
        }

        if ($jenisKelamin === 'P' && $this->faker->boolean(35)) {
            return 'ibu_rumah_tangga';
        }

        return $this->faker->boolean(45) ? 'kepala_keluarga' : 'anggota_lain';
    }

    private function statusNikahFor(int $usia): string
    {
        if ($usia < 18) {
            return 'belum_kawin';
        }

        return $this->faker->randomElement([
            'kawin', 'kawin', 'kawin', 'belum_kawin', 'belum_kawin', 'cerai_hidup', 'cerai_mati',
        ]);
    }

    private function pendidikanFor(int $usia): string
    {
        if ($usia <= 5) {
            return 'tidak_belum_sekolah';
        }

        if ($usia <= 22) {
            return 'pelajar_mahasiswa';
        }

        return $this->faker->randomElement([
            'tidak_belum_sekolah', 'tamat_sd_sederajat', 'tamat_sd_sederajat',
            'sltp_sederajat', 'slta_sederajat', 'slta_sederajat', 'strata_ii',
        ]);
    }

    private function bantuanFor(): ?array
    {
        if (! $this->faker->boolean(35)) {
            return null;
        }

        return $this->faker->randomElements(Penduduk::BANTUAN, random_int(1, 2));
    }
}
