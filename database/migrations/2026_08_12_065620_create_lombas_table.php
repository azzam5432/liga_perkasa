<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_lomba', function (Blueprint $table) {
            $table->id('id_lomba');
            $table->string('nama_lomba');
            $table->string('kategori')->nullable();
            $table->text('deskripsi')->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->string('tempat')->nullable();
            $table->enum('status', ['draft', 'open', 'closed', 'selesai'])->default('draft');
            $table->integer('kuota_tim')->nullable();
            $table->integer('min_anggota')->default(5);
            $table->integer('max_anggota')->default(20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_lomba');
    }
};
