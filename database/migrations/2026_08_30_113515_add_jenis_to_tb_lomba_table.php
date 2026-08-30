<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_lomba', function (Blueprint $table) {
            $table->enum('jenis', ['langsung', 'penyisihan', 'final'])->default('langsung')->after('status');
            $table->integer('jumlah_finalis')->nullable()->after('jenis');
            $table->boolean('is_penyisihan_active')->default(false)->after('jumlah_finalis');
        });
    }

    public function down(): void
    {
        Schema::table('tb_lomba', function (Blueprint $table) {
            $table->dropColumn(['jenis', 'jumlah_finalis', 'is_penyisihan_active']);
        });
    }
};