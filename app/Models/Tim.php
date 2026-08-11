<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tim extends Model
{
    protected $table = 'tb_tim';
    protected $primaryKey = 'id_tim';
    protected $fillable = ['nama_tim'];

    public function pesertas()
    {
        return $this->hasMany(Peserta::class, 'id_tim', 'id_tim');
    }
}