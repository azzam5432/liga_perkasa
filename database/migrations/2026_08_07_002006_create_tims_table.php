<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_tim', function (Blueprint $table) {
            $table->id('id_tim');
            $table->foreignId('id_lomba')->nullable()->constrained('tb_lomba', 'id_lomba')->onDelete('set null');
            $table->string('nama_tim');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_tim');
    }
};
