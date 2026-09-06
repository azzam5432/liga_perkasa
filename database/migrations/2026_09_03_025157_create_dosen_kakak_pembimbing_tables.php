<?php
// database/migrations/2026_09_03_000001_create_dosen_kakak_pembimbing_tables.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel Dosen Pembimbing
        Schema::create('tb_dosen_pembimbing', function (Blueprint $table) {
            $table->id('id_dosen');
            $table->foreignId('id_tim')->constrained('tb_tim', 'id_tim')->onDelete('cascade');
            $table->string('nama_dosen');
            $table->timestamps();
        });

        // Tabel Kakak Pembimbing
        Schema::create('tb_kakak_pembimbing', function (Blueprint $table) {
            $table->id('id_kakak');
            $table->foreignId('id_tim')->constrained('tb_tim', 'id_tim')->onDelete('cascade');
            $table->string('nama_kakak');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_dosen_pembimbing');
        Schema::dropIfExists('tb_kakak_pembimbing');
    }
};