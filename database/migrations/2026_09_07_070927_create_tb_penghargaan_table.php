<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_penghargaan', function (Blueprint $table) {
            $table->id('id_penghargaan');
            $table->string('kategori');
            $table->decimal('bobot', 5, 2)->default(0);
            $table->foreignId('id_tim')->constrained('tb_tim', 'id_tim')->onDelete('cascade');
            $table->foreignId('id_juri')->nullable()->constrained('tb_juri', 'id_juri')->onDelete('set null');
            $table->timestamps();
            
            $table->unique('kategori');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_penghargaan');
    }
};