<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_penilaian', function (Blueprint $table) {
            $table->id('id_penilaian');
            $table->foreignId('id_tim')->constrained('tb_tim', 'id_tim')->onDelete('cascade');
            $table->foreignId('id_juri')->constrained('tb_juri', 'id_juri')->onDelete('cascade');
            $table->foreignId('id_kriteria')->constrained('tb_kriteria', 'id_kriteria')->onDelete('cascade');
            $table->integer('nilai')->nullable();
            $table->text('komentar')->nullable();
            $table->string('dokumen_pendukung')->nullable();
            $table->enum('status', ['draft', 'selesai'])->default('draft');
            $table->timestamps();
            
            $table->unique(['id_tim', 'id_juri', 'id_kriteria']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_penilaian');
    }
};