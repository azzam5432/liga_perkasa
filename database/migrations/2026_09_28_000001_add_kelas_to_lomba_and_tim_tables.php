<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Kelas lomba: Reguler A / Reguler B
        Schema::table('tb_lomba', function (Blueprint $table) {
            if (!Schema::hasColumn('tb_lomba', 'kelas')) {
                $table->enum('kelas', ['A', 'B'])->default('A')->after('nama_lomba');
            }
        });

        // Kelas tim: timReguler A / Reguler B
        Schema::table('tb_tim', function (Blueprint $table) {
            if (!Schema::hasColumn('tb_tim', 'kelas')) {
                $table->enum('kelas', ['A', 'B'])->default('A')->after('id_lomba');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tb_lomba', function (Blueprint $table) {
            if (Schema::hasColumn('tb_lomba', 'kelas')) {
                $table->dropColumn('kelas');
            }
        });

        Schema::table('tb_tim', function (Blueprint $table) {
            if (Schema::hasColumn('tb_tim', 'kelas')) {
                $table->dropColumn('kelas');
            }
        });
    }
};
