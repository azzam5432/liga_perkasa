<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tb_juri', function (Blueprint $table) {
            $table->id('id_juri');
            $table->foreignId('user_id')->constrained('users', 'id')->onDelete('cascade');
            $table->string('spesialisasi')->nullable();
            $table->string('institusi')->nullable();
            $table->text('pengalaman')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_juri');
    }
};