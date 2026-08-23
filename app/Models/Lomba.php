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

    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    // Scope untuk lomba yang selesai
    public function scopeSelesai($query)
    {
        return $query->where('status', 'selesai');
    }

    // Scope untuk lomba yang masih draft
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    // Scope untuk lomba yang closed
    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }

    // Scope untuk lomba yang bisa dinilai (open atau selesai)
    public function scopeDapatDinilai($query)
    {
        return $query->whereIn('status', ['open', 'selesai']);
    }

    // Helper status badge
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

    // Helper status label
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

    // Relasi ke Tim
    public function tims()
    {
        return $this->hasMany(Tim::class, 'id_lomba', 'id_lomba');
    }

    public function juri()
    {
        return $this->belongsToMany(Juri::class, 'tb_juri_lomba', 'id_lomba', 'id_juri')->withPivot('status', 'catatan')->withTimestamps();
    }

    public function hasJuri()
    {
        return $this->juri()->count() > 0;
    }

    public function getJumlahJuriAttribute()
    {
        return $this->juri()->count();
    }

    public function pesertas()
    {
        return $this->hasManyThrough(Peserta::class, Tim::class, 'id_lomba', 'id_tim', 'id_lomba', 'id_tim');
    }
    
    public function getKuotaPersentaseAttribute()
    {
        if (!$this->kuota_tim || $this->kuota_tim == 0) return 0;
        $total = $this->tims()->count();
        return round(($total / $this->kuota_tim) * 100);
    }
}