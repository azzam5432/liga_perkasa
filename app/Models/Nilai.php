<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $table = 'tb_nilai';
    protected $primaryKey = 'id_nilai';
    
    protected $fillable = [
        'id_tim',
        'id_lomba',
        'id_juri',
        'nilai',
        'babak',
        'juara',
        'jumlah', // Tambahkan ini
    ];

    public function tim()
    {
        return $this->belongsTo(Tim::class, 'id_tim', 'id_tim');
    }

    public function lomba()
    {
        return $this->belongsTo(Lomba::class, 'id_lomba', 'id_lomba');
    }

    public function juri()
    {
        return $this->belongsTo(Juri::class, 'id_juri', 'id_juri');
    }

    public function scopePenyisihan($query)
    {
        return $query->where('babak', 'penyisihan');
    }

    public function scopeFinal($query)
    {
        return $query->where('babak', 'final');
    }
}