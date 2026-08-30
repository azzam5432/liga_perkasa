<?php
// app/Models/Finalis.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Finalis extends Model
{
    protected $table = 'tb_finalis';
    protected $primaryKey = 'id_finalis';
    
    protected $fillable = [
        'id_lomba',
        'id_tim',
        'peringkat',
        'catatan',
    ];

    public function lomba()
    {
        return $this->belongsTo(Lomba::class, 'id_lomba', 'id_lomba');
    }

    public function tim()
    {
        return $this->belongsTo(Tim::class, 'id_tim', 'id_tim');
    }
}