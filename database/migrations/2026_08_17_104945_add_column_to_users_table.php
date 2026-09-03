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
        Schema::table('users', function (Blueprint $table) {
                $table->enum('role', ['super_admin', 'panitia'])->default('panitia');
                $table->string('no_telp')->nullable();
                $table->string('jabatan')->nullable();
                $table->string('foto_profil')->nullable();
                $table->string('instagram')->nullable();
                $table->string('facebook')->nullable();
                $table->string('twitter')->nullable();
                $table->string('linkedin')->nullable();
                $table->text('bio')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role', 
                'no_telp', 
                'jabatan', 
                'foto_profil', 
                'instagram', 
                'facebook', 
                'twitter', 
                'linkedin', 
                'bio'
            ]);
        });
    }
};
