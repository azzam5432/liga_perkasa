<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Juri extends Model
{
    protected $table = 'tb_juri';
    protected $primaryKey = 'id_juri';
    
    protected $fillable = [
        'user_id',
        'spesialisasi',
        'institusi',
        'pengalaman',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function penilaians()
    {
        return $this->hasMany(Penilaian::class, 'id_juri', 'id_juri');
    }

    public function lomba()
    {
        return $this->belongsToMany(Lomba::class, 'tb_juri_lomba', 'id_juri', 'id_lomba')->withPivot('status', 'catatan')->withTimestamps();
    }

    public function isAssignedToLomba($id_lomba)
    {
        return $this->lomba()->where('id_lomba', $id_lomba)->exists();
    }

    public function getNamaAttribute()
    {
        return $this->user->name ?? 'Juri';
    }

    public function getFotoProfilUrlAttribute()
    {
        return $this->user->foto_profil_url ?? asset('img/default-avatar.png');
    }

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
}