<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('tb_nilai', function (Blueprint $table) {
            $table->integer('juara')->nullable()->after('nilai'); // Kolom juara (1, 2, 3, atau null)
        });
    }

    public function down()
    {
        Schema::table('tb_nilai', function (Blueprint $table) {
            $table->dropColumn('juara');
        });
    }
};