<?php
// app/Models/Penilaian.php

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

    // ✅ TAMBAHKAN: Ambil rata-rata nilai per tim dari semua juri
    public static function getRataRataTim($id_tim, $id_lomba = null)
    {
        $query = self::where('id_tim', $id_tim);
        
        if ($id_lomba) {
            $query->whereHas('kriteria', function($q) use ($id_lomba) {
                $q->where('id_lomba', $id_lomba);
            });
        }
        
        return $query->avg('nilai') ?? 0;
    }

    // ✅ TAMBAHKAN: Ambil total nilai per tim dari semua juri
    public static function getTotalNilaiTim($id_tim, $id_lomba = null)
    {
        $query = self::where('id_tim', $id_tim);
        
        if ($id_lomba) {
            $query->whereHas('kriteria', function($q) use ($id_lomba) {
                $q->where('id_lomba', $id_lomba);
            });
        }
        
        return $query->sum('nilai') ?? 0;
    }

    // ✅ TAMBAHKAN: Ambil nilai per kriteria untuk tim
    public static function getNilaiPerKriteria($id_tim, $id_lomba = null)
    {
        $query = self::with('kriteria')->where('id_tim', $id_tim);
        
        if ($id_lomba) {
            $query->whereHas('kriteria', function($q) use ($id_lomba) {
                $q->where('id_lomba', $id_lomba);
            });
        }
        
        $results = $query->get()->groupBy('id_kriteria');
        $data = [];
        
        foreach ($results as $kriteriaId => $items) {
            $kriteria = $items->first()->kriteria;
            $data[] = [
                'kriteria' => $kriteria->nama_kriteria ?? 'Kriteria',
                'bobot' => $kriteria->bobot ?? 0,
                'nilai' => $items->avg('nilai') ?? 0,
                'jml_juri' => $items->groupBy('id_juri')->count(),
            ];
        }
        
        return $data;
    }

    public static function isTimSelesaiDinilai($id_tim, $id_lomba)
    {
        $juriCount = JuriLomba::where('id_lomba', $id_lomba)
            ->where('status', 'aktif')
            ->count();
            
        $penilaianCount = self::where('id_tim', $id_tim)
            ->whereHas('kriteria', function($q) use ($id_lomba) {
                $q->where('id_lomba', $id_lomba);
            })
            ->groupBy('id_juri')
            ->count();
            
        return $juriCount > 0 && $penilaianCount >= $juriCount;
    }
}