<?php
// app/Models/Juri.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Juri extends Model
{
    protected $table = 'tb_juri';
    protected $primaryKey = 'id_juri';
    
    protected $fillable = [
        'user_id',
        'spesialisasi',
        'institusi',
        'pengalaman',
        'status'
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Relasi ke Lomba melalui tabel pivot
    public function lomba()
    {
        return $this->belongsToMany(Lomba::class, 'tb_juri_lomba', 'id_juri', 'id_lomba')
                    ->withPivot('status', 'catatan')
                    ->withTimestamps();
    }

    // ✅ PERBAIKI: Spesifikkan tabel untuk id_lomba
    public function isAssignedToLomba($id_lomba)
    {
        return $this->lomba()
                    ->where('tb_lomba.id_lomba', $id_lomba)  // ← TAMBAHKAN tb_lomba.
                    ->exists();
    }

    // ✅ PERBAIKI: Cek apakah juri aktif di lomba tertentu
    public function isActiveInLomba($id_lomba)
    {
        return $this->lomba()
                    ->where('tb_lomba.id_lomba', $id_lomba)  // ← TAMBAHKAN tb_lomba.
                    ->where('tb_juri_lomba.status', 'aktif')
                    ->exists();
    }

    // Scope
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    // Helper
    public function getNamaAttribute()
    {
        return $this->user->name ?? 'Juri';
    }

    public function getFotoProfilUrlAttribute()
    {
        return $this->user->foto_profil_url ?? asset('img/default-avatar.png');
    }
}