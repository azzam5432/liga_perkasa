<?php
// app/Models/Lomba.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lomba extends Model
{
    protected $table = 'tb_lomba';
    protected $primaryKey = 'id_lomba';
    
    protected $fillable = [
        'nama_lomba',
        'kategori',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'tempat',
        'status',
        'kuota_tim',
        'min_anggota',
        'max_anggota',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    // Relasi ke Tim
    public function tims()
    {
        return $this->hasMany(Tim::class, 'id_lomba', 'id_lomba');
    }

    public function pesertas()
    {
        return $this->hasManyThrough(Peserta::class, Tim::class, 'id_lomba', 'id_tim', 'id_lomba', 'id_tim');
    }
    
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'draft' => 'secondary',
            'open' => 'success',
            'closed' => 'danger',
            'selesai' => 'info',
        ];
        return $badges[$this->status] ?? 'secondary';
    }

    // Accessor untuk status label
    public function getStatusLabelAttribute()
    {
        $labels = [
            'draft' => 'Draft',
            'open' => 'Open',
            'closed' => 'Closed',
            'selesai' => 'Selesai',
        ];
        return $labels[$this->status] ?? $this->status;
    }

    public function getKuotaPersentaseAttribute()
    {
        if (!$this->kuota_tim || $this->kuota_tim == 0) return 0;
        $total = $this->tims()->count();
        return round(($total / $this->kuota_tim) * 100);
    }
}