<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// ===== SISTEM JURI DINONAKTIFKAN: penilaian kini dikelola panitia =====
// Tabel pivot tb_juri_lomba (penugasan juri ke lomba) tidak lagi digunakan.
// CATATAN: migrasi tb_juri TETAP AKTIF karena kolom id_juri di tb_nilai
// (yang masih dipakai) memiliki foreign key ke tb_juri.
return new class extends Migration
{
    public function up(): void
    {
        /*
        Schema::create('tb_juri_lomba', function (Blueprint $table) {
            $table->id('id_juri_lomba');
            $table->foreignId('id_juri')->constrained('tb_juri', 'id_juri')->onDelete('cascade');
            $table->foreignId('id_lomba')->constrained('tb_lomba', 'id_lomba')->onDelete('cascade');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->text('catatan')->nullable();
            $table->timestamps();
            
            $table->unique(['id_juri', 'id_lomba']);
        });
        */
    }

    public function down(): void
    {
        // Schema::dropIfExists('tb_juri_lomba');
    }
};
