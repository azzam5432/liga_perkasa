<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tb_nilai', function (Blueprint $table) {
            $table->integer('jumlah')->default(1)->after('juara');
        });
    }

    public function down()
    {
        Schema::table('tb_nilai', function (Blueprint $table) {
            $table->dropColumn('jumlah');
        });
    }
};