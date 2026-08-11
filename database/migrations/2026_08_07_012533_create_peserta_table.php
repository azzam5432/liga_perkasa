<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePesertaTable extends Migration
{
    public function up()
    {
        Schema::create('tb_peserta', function (Blueprint $table) {
            $table->id('id_peserta');
            $table->foreignId('id_tim')->constrained('tb_tim', 'id_tim')->onDelete('cascade');
            $table->string('ketua_peserta')->nullable();
            $table->string('nama_peserta');
            $table->string('prodi')->nullable();
            $table->string('no_telp', 15)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tb_peserta');
    }
}