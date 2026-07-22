<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penduduk', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nik', 20)->nullable()->unique();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->date('tanggal_lahir')->nullable();
            $table->string('dusun');
            $table->string('rt', 5);
            $table->enum('status_keluarga', ['kepala_keluarga', 'ibu_rumah_tangga', 'anak', 'anggota_lain'])
                ->default('anggota_lain');
            $table->enum('status_ekonomi', ['kurang_mampu', 'mampu', 'sangat_mampu'])->default('mampu');
            $table->enum('status_nikah', ['belum_kawin', 'kawin', 'cerai_hidup', 'cerai_mati'])->default('belum_kawin');
            $table->enum('pendidikan_terakhir', [
                'tidak_belum_sekolah', 'tamat_sd_sederajat', 'sltp_sederajat',
                'slta_sederajat', 'strata_ii', 'pelajar_mahasiswa',
            ])->default('tidak_belum_sekolah');
            $table->boolean('status_sekolah')->default(false)->comment('sedang bersekolah / belum');
            $table->json('penerima_bantuan')->nullable()->comment('array: BLT, BPNT, Bantuan Pangan, Prakerja, KIP, PKH');
            $table->string('alamat')->nullable();
            $table->timestamps();

            $table->index(['dusun', 'rt']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penduduk');
    }
};
