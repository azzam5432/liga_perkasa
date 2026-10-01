<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ===== SISTEM KRITERIA DINONAKTIFKAN: penilaian kini dikelola panitia =====
// Tabel tb_kriteria tidak lagi digunakan (tidak ada model/controller/view).
return new class extends Migration
{
    public function up(): void
    {
        /*
        Schema::create('tb_kriteria', function (Blueprint $table) {
            $table->id('id_kriteria');
            $table->string('nama_kriteria');
            $table->text('deskripsi')->nullable();
            $table->integer('bobot')->default(0);
            $table->enum('tipe', ['pilihan_ganda', 'skala', 'teks'])->default('skala');
            $table->integer('skala_min')->default(1);
            $table->integer('skala_max')->default(100);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        */
    }

    public function down(): void
    {
        // Schema::dropIfExists('tb_kriteria');
    }
};
