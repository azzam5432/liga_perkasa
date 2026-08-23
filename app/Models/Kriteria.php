<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kriteria extends Model
{
    protected $table = 'tb_kriteria';
    protected $primaryKey = 'id_kriteria';
    
    protected $fillable = [
        'nama_kriteria',
        'deskripsi',
        'bobot',
        'tipe',
        'skala_min',
        'skala_max',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function penilaians()
    {
        return $this->hasMany(Penilaian::class, 'id_kriteria', 'id_kriteria');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}