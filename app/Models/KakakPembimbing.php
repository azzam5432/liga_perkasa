<?php
// app/Models/KakakPembimbing.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KakakPembimbing extends Model
{
    protected $table = 'tb_kakak_pembimbing';
    protected $primaryKey = 'id_kakak';
    
    protected $fillable = [
        'id_tim',
        'nama_kakak',
    ];

    public function tim()
    {
        return $this->belongsTo(Tim::class, 'id_tim', 'id_tim');
    }
}