<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('program_kerja', function (Blueprint $table) {
            $table->id();
            $table->string('nama_program');
            $table->string('bidang')->nullable();
            $table->string('penanggung_jawab')->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->enum('status', ['belum_mulai', 'berjalan', 'selesai'])->default('belum_mulai');
            $table->string('lokasi')->nullable();
            $table->longText('deskripsi')->nullable();
            $table->string('dokumentasi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('program_kerja');
    }
};
