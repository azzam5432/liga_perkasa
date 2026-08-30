<?php
// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tim;
use App\Models\Peserta;
use App\Models\Lomba;
use App\Models\Juri;
use App\Models\Penilaian;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        
        // Data untuk Panitia
        $dataPeserta = Tim::with(['pesertas' => function($query) {
            $query->select('id_tim', 'ketua_peserta', 'nama_peserta', 'prodi', 'no_telp');
        }])->withCount('pesertas')->select('id_tim', 'nama_tim')->latest()->paginate(5);
        
        $totalTim = Tim::count();
        $totalPeserta = Peserta::count();
        
        // Data untuk Juri
        $juri = Juri::where('user_id', $user->id)->first();
        $lombaDitugaskan = collect();
        $totalPenilaian = 0;
        $totalLomba = 0;
        
        if ($juri) {
            $lombaDitugaskan = $juri->lomba()
                ->wherePivot('status', 'aktif')
                ->get();
            
            $totalLomba = $lombaDitugaskan->count();
            $totalPenilaian = Penilaian::where('id_juri', $juri->id_juri)->count();
        }
        
        return view('panitia.dashboard', compact(
            'dataPeserta', 
            'totalTim', 
            'totalPeserta',
            'lombaDitugaskan',
            'totalLomba',
            'totalPenilaian',
            'juri'
        ));
    }
}