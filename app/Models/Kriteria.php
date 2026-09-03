<?php
// app/Models/Kriteria.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    protected $table = 'tb_kriteria';
    protected $primaryKey = 'id_kriteria';
    
    protected $fillable = [
        'id_lomba',
        'nama_kriteria',
        'deskripsi',
        'bobot',
        'tipe',
        'skala_min',
        'skala_max',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relasi ke Lomba
    public function lomba()
    {
        return $this->belongsTo(Lomba::class, 'id_lomba', 'id_lomba');
    }

    // ❌ HAPUS ATAU COMMENT - Karena Penilaian sudah dihapus
    // public function penilaians()
    // {
    //     return $this->hasMany(Penilaian::class, 'id_kriteria', 'id_kriteria');
    // }

    // Scope
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByLomba($query, $id_lomba)
    {
        return $query->where('id_lomba', $id_lomba);
    }
}