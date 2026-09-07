<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penghargaan extends Model
{
    protected $table = 'tb_penghargaan';
    protected $primaryKey = 'id_penghargaan';
    
    protected $fillable = [
        'kategori',
        'bobot',
        'id_tim',
        'id_juri',
    ];

    public function tim()
    {
        return $this->belongsTo(Tim::class, 'id_tim', 'id_tim');
    }

    public function juri()
    {
        return $this->belongsTo(Juri::class, 'id_juri', 'id_juri');
    }
}