<?php
// app/Models/Tim.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tim extends Model
{
    protected $table = 'tb_tim';
    protected $primaryKey = 'id_tim';
    protected $fillable = ['nama_tim', 'id_lomba'];

    public function pesertas()
    {
        return $this->hasMany(Peserta::class, 'id_tim', 'id_tim');
    }

    public function lomba()
    {
        return $this->belongsTo(Lomba::class, 'id_lomba', 'id_lomba');
    }

    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'id_tim', 'id_tim');
    }

    public function getTotalNilaiAttribute()
    {
        return $this->nilai()->sum('nilai') ?? 0;
    }

    public function getRataNilaiAttribute()
    {
        $count = $this->nilai()->count();
        if ($count == 0) return 0;
        return $this->nilai()->sum('nilai') / $count;
    }
}