<?php
// database/migrations/xxxx_xx_xx_add_babak_to_finalis_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_finalis', function (Blueprint $table) {
            $table->enum('babak', ['penyisihan', 'final'])->default('penyisihan')->after('peringkat');
            $table->decimal('nilai_penyisihan', 5, 2)->default(0)->after('babak');
            $table->decimal('nilai_final', 5, 2)->default(0)->after('nilai_penyisihan');
        });
    }

    public function down(): void
    {
        Schema::table('tb_finalis', function (Blueprint $table) {
            $table->dropColumn(['babak', 'nilai_penyisihan', 'nilai_final']);
        });
    }
};