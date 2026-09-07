<?php

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
        $user = Auth::user();
        
        // Data untuk Panitia
        $dataPeserta = Tim::with(['pesertas' => function($query) {
            $query->select('id_tim', 'ketua_peserta', 'nama_peserta', 'no_telp');
        }])->withCount('pesertas')->select('id_tim', 'nama_tim')->latest()->paginate(5);
        
        $totalTim = Tim::count();
        $totalPeserta = Peserta::count();
        
        // **KUNCI UTAMA**: Data untuk Juri
        $juri = Juri::where('user_id', $user->id)->first();
        
        // Jika juri tidak ditemukan, BUAT OBJEK KOSONG agar tidak null
        if (!$juri) {
            $juri = new Juri();
            $juri->id_juri = 0; // Dummy ID
            $juri->lomba = collect(); // Relasi kosong
        }
        
        $lombaDitugaskan = $juri->lomba()->get();
        $totalLomba = $lombaDitugaskan->count();
        
        $totalTimSudahDinilai = 0;
        if ($juri->id_juri != 0) {
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
    }
}