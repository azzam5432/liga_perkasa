<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_finalis', function (Blueprint $table) {
            $table->id('id_finalis');
            $table->foreignId('id_lomba')->constrained('tb_lomba', 'id_lomba')->onDelete('cascade');
            $table->foreignId('id_tim')->constrained('tb_tim', 'id_tim')->onDelete('cascade');
            $table->integer('peringkat')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
            
            $table->unique(['id_lomba', 'id_tim']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_finalis');
    }
};