<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profil_desa', function (Blueprint $table) {
            $table->id();
            $table->string('nama_desa');
            $table->string('kecamatan')->nullable();
            $table->string('kabupaten')->nullable();
            $table->string('provinsi')->nullable();
            $table->longText('sejarah')->nullable();
            $table->text('visi')->nullable();
            $table->longText('misi')->nullable();
            $table->string('luas_wilayah')->nullable();
            $table->string('jumlah_penduduk')->nullable();
            $table->string('logo')->nullable();
            $table->string('foto_desa')->nullable();
            $table->string('nama_kontak')->nullable();
            $table->string('jabatan_kontak')->nullable();
            $table->string('no_telepon')->nullable();
            $table->string('email')->nullable();
            $table->text('alamat_kantor')->nullable();
            $table->string('jam_pelayanan')->nullable();
            $table->text('link_maps')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profil_desa');
    }
};
