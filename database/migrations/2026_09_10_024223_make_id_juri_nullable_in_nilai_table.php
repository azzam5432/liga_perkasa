<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tb_nilai', function (Blueprint $table) {
            // Ubah kolom id_juri menjadi nullable
            $table->unsignedBigInteger('id_juri')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('tb_nilai', function (Blueprint $table) {
            // Kembalikan ke NOT NULL (hati-hati jika ada data NULL)
            $table->unsignedBigInteger('id_juri')->nullable(false)->change();
        });
    }
};