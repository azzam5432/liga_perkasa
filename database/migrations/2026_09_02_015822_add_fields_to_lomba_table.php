<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_lomba', function (Blueprint $table) {
            if (!Schema::hasColumn('tb_lomba', 'bobot')) {
                $table->decimal('bobot', 5, 1)->default(0)->after('jenis');
            }
            if (!Schema::hasColumn('tb_lomba', 'jumlah_finalis')) {
                $table->integer('jumlah_finalis')->default(0)->after('bobot');
            }
            if (!Schema::hasColumn('tb_lomba', 'is_final_active')) {
                $table->boolean('is_final_active')->default(false)->after('jumlah_finalis');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tb_lomba', function (Blueprint $table) {
            $table->dropColumn(array_filter(['bobot', 'jumlah_finalis', 'is_final_active'], function ($column) {
                return Schema::hasColumn('tb_lomba', $column);
            }));
        });
    }
};