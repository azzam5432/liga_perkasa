<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tb_peserta', function (Blueprint $table) {
            $table->string('dosen_pembimbing')->nullable()->after('no_telp');
            $table->string('kakak_pembimbing')->nullable()->after('dosen_pembimbing');
        });
    }

    public function down(): void
    {
        Schema::table('tb_peserta', function (Blueprint $table) {
            $table->dropColumn(['dosen_pembimbing', 'kakak_pembimbing']);
        });
    }
};