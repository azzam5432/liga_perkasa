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
        Schema::table('tb_tim', function (Blueprint $table) {
            $table->foreignId('id_lomba')->nullable()->after('id_tim')->constrained('tb_lomba', 'id_lomba')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tb_tim', function (Blueprint $table) {
            $table->dropForeign(['id_lomba']);
            $table->dropColumn('id_lomba');
        });
    }
};