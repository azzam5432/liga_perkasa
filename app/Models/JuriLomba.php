<?php
// app/Models/JuriLomba.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JuriLomba extends Model
{
    protected $table = 'tb_juri_lomba';
    protected $primaryKey = 'id_juri_lomba';
    
    protected $fillable = [
        'id_juri',
        'id_lomba',
        'status',
        'catatan',
    ];

    // Relasi ke Juri
    public function juri()
    {
        return $this->belongsTo(Juri::class, 'id_juri', 'id_juri');
    }

    // Relasi ke Lomba
    public function lomba()
    {
        return $this->belongsTo(Lomba::class, 'id_lomba', 'id_lomba');
    }

    // Scope
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}