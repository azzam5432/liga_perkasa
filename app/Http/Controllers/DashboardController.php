<?php
// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tim;
use App\Models\Peserta;
use App\Models\Lomba;
use App\Models\Juri;
use App\Models\Nilai;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(): View
    {
        try {
            $user = Auth::user();
            
            // Data untuk Panitia
            $dataPeserta = Tim::with(['pesertas' => function($query) {
                $query->select('id_tim', 'ketua_peserta', 'nama_peserta', 'no_telp');
            }])->withCount('pesertas')->select('id_tim', 'nama_tim')->latest()->paginate(5);
            
            $totalTim = Tim::count();
            $totalPeserta = Peserta::count();
            
            // Data untuk Juri
            $juri = Juri::where('user_id', $user->id)->first();
            $lombaDitugaskan = collect();
            $totalLomba = 0;
            $totalTimSudahDinilai = 0;
            
            if ($juri) {
                $lombaDitugaskan = $juri->lomba()->get();
                $totalLomba = $lombaDitugaskan->count();
                
                $totalTimSudahDinilai = Nilai::where('id_juri', $juri->id_juri)
                    ->distinct('id_tim')
                    ->count('id_tim');
            }
            
            return view('panitia.dashboard', compact(
                'dataPeserta', 
                'totalTim', 
                'totalPeserta',
                'lombaDitugaskan',
                'totalLomba',
                'totalTimSudahDinilai',
                'juri'
            ));
            
        } catch (\Exception $e) {
            // Tampilkan error jika ada
            dd($e->getMessage(), $e->getFile(), $e->getLine());
        }
    }
}