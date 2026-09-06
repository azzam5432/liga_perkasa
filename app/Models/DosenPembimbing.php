<?php
// app/Models/DosenPembimbing.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DosenPembimbing extends Model
{
    protected $table = 'tb_dosen_pembimbing';
    protected $primaryKey = 'id_dosen';
    
    protected $fillable = [
        'id_tim',
        'nama_dosen',
    ];

    public function tim()
    {
        return $this->belongsTo(Tim::class, 'id_tim', 'id_tim');
    }
}