<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tim;
use App\Models\Peserta;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index()
    {
        $dataPeserta = Tim::with(['pesertas' => function($query) {
            $query->select('id_tim', 'ketua_peserta', 'nama_peserta', 'prodi', 'no_telp');
        }])->withCount('pesertas')->select('id_tim', 'nama_tim')->latest()->paginate(10);
        $totalTim = Tim::count();
        $totalPeserta = Peserta::count();
        
        return view('admin.dashboard', compact('dataPeserta', 'totalTim', 'totalPeserta'));
    }
}
