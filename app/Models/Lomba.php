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
        'deskripsi',
        'kategori',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'jenis',
        'jumlah_finalis',
        'is_penyisihan_active',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'is_penyisihan_active' => 'boolean',
    ];

    // Relasi ke Juri
    public function juri()
    {
        return $this->belongsToMany(Juri::class, 'tb_juri_lomba', 'id_lomba', 'id_juri')
                    ->withPivot('status', 'catatan')
                    ->withTimestamps();
    }

    // Relasi ke Finalis
    public function finalis()
    {
        return $this->hasMany(Finalis::class, 'id_lomba', 'id_lomba');
    }

    // Relasi ke Tim melalui finalis
    public function timFinalis()
    {
        return $this->belongsToMany(Tim::class, 'tb_finalis', 'id_lomba', 'id_tim')
                    ->withPivot('peringkat', 'catatan')
                    ->withTimestamps();
    }

    // Relasi ke Kriteria
    public function kriterias()
    {
        return $this->hasMany(Kriteria::class, 'id_lomba', 'id_lomba');
    }

    // Helper
    public function getJenisLabelAttribute()
    {
        $labels = [
            'langsung' => 'Langsung',
            'penyisihan' => 'Penyisihan + Final',
            'final' => 'Final',
        ];
        return $labels[$this->jenis] ?? $this->jenis;
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'draft' => 'Draft',
            'open' => 'Open',
            'selesai' => 'Selesai',
            'closed' => 'Closed',
        ];
        return $labels[$this->status] ?? $this->status;
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'draft' => 'secondary',
            'open' => 'success',
            'selesai' => 'info',
            'closed' => 'danger',
        ];
        return $badges[$this->status] ?? 'secondary';
    }
}