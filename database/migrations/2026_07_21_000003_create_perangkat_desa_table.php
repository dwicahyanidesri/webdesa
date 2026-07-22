<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perangkat_desa', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jabatan');
            $table->unsignedTinyInteger('level')->default(2)->comment('1=Kepala Desa,2=Sekretaris/Kasi/Kaur,3=Kadus/Staf');
            $table->unsignedInteger('urutan')->default(0);
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perangkat_desa');
    }
};
