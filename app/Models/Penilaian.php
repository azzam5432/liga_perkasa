<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    protected $table = 'tb_penilaian';
    protected $primaryKey = 'id_penilaian';
    
    protected $fillable = [
        'id_tim',
        'id_juri',
        'id_kriteria',
        'nilai',
        'komentar',
        'dokumen_pendukung',
        'status'
    ];

    public function tim()
    {
        return $this->belongsTo(Tim::class, 'id_tim', 'id_tim');
    }

    public function juri()
    {
        return $this->belongsTo(Juri::class, 'id_juri', 'id_juri');
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'id_kriteria', 'id_kriteria');
    }

    public function getNilaiLabelAttribute()
    {
        if ($this->nilai === null) return 'Belum Dinilai';
        return $this->nilai . ' / ' . ($this->kriteria->skala_max ?? 100);
    }

    public function getStatusBadgeAttribute()
    {
        $status = $this->status ?? 'draft';
        $badges = [
            'draft' => 'warning',
            'selesai' => 'success'
        ];
        return $badges[$status] ?? 'secondary';
    }
}