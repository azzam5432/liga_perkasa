<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    protected $table = 'tb_peserta';
    protected $primaryKey = 'id_peserta';
    
    protected $fillable = [
        'id_tim',
        'ketua_peserta',
        'nama_peserta',
        'prodi',
        'no_telp',
    ];

    public function tim()
    {
        return $this->belongsTo(Tim::class, 'id_tim', 'id_tim');
    }
}