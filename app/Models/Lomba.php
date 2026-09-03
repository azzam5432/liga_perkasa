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
        'bobot',           
        'jumlah_finalis',  
        'is_final_active', 
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'is_final_active' => 'boolean',
        'bobot' => 'decimal:1',
    ];

    // ✅ TAMBAHKAN RELASI INI
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

    // Relasi ke Nilai
    public function nilai()
    {
        return $this->hasMany(Nilai::class, 'id_lomba', 'id_lomba');
    }

    // ✅ TAMBAHKAN: Ambil nilai penyisihan
    public function nilaiPenyisihan()
    {
        return $this->hasMany(Nilai::class, 'id_lomba', 'id_lomba')->where('babak', 'penyisihan');
    }

    // ✅ TAMBAHKAN: Ambil nilai final
    public function nilaiFinal()
    {
        return $this->hasMany(Nilai::class, 'id_lomba', 'id_lomba')->where('babak', 'final');
    }

    public function getJenisLabelAttribute()
    {
        $labels = [
            'langsung' => 'Tanpa Babak',
            'penyisihan' => 'Penyisihan + Final',
        ];
        return $labels[$this->jenis] ?? $this->jenis;
    }

    public function hasFinal()
    {
        return $this->jenis === 'penyisihan' && $this->jumlah_finalis > 0;
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