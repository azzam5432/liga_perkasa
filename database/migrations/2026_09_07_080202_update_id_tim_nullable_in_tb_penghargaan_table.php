<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_penghargaan', function (Blueprint $table) {
            $table->foreignId('id_tim')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('tb_penghargaan', function (Blueprint $table) {
            $table->foreignId('id_tim')->nullable(false)->change();
        });
    }
};