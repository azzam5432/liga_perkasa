<?php
// database/migrations/2026_09_03_000000_create_nilai_table_with_babak.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_nilai', function (Blueprint $table) {
            $table->id('id_nilai');
            $table->foreignId('id_tim')->constrained('tb_tim', 'id_tim')->onDelete('cascade');
            $table->foreignId('id_lomba')->constrained('tb_lomba', 'id_lomba')->onDelete('cascade');
            $table->foreignId('id_juri')->constrained('tb_juri', 'id_juri')->onDelete('cascade');
            $table->integer('nilai')->nullable();
            $table->enum('babak', ['penyisihan', 'final'])->default('penyisihan');
            $table->timestamps();
            
            // Unique constraint lengkap
            $table->unique(['id_tim', 'id_lomba', 'id_juri', 'babak'], 'unique_tim_lomba_juri_babak');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_nilai');
    }
};