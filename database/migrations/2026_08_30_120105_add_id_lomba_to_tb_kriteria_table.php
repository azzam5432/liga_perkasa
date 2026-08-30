<?php
// database/migrations/xxxx_xx_xx_add_id_lomba_to_tb_kriteria_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_kriteria', function (Blueprint $table) {
            $table->foreignId('id_lomba')->nullable()->constrained('tb_lomba', 'id_lomba')->onDelete('cascade')->after('id_kriteria');
        });
    }

    public function down(): void
    {
        Schema::table('tb_kriteria', function (Blueprint $table) {
            $table->dropForeign(['id_lomba']);
            $table->dropColumn('id_lomba');
        });
    }
};