<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tim;
use App\Models\Peserta;
use App\Models\Lomba;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection; 

class SuperAdminDashboardController extends Controller
{
    public function index()
    {
        $totalPanitia = User::where('role', 'panitia')->count();
        $totalSuperAdmin = User::where('role', 'super_admin')->count();
        $totalTim = Tim::count();
        $totalPeserta = Peserta::count();
        $totalLomba = Lomba::count();

        // Pendaftaran Bulanan
        $pendaftaranBulanan = Tim::select(
            DB::raw('MONTH(created_at) as bulan'),
            DB::raw('YEAR(created_at) as tahun'),
            DB::raw('COUNT(*) as total')
        )
        ->where('created_at', '>=', now()->subMonths(6))
        ->groupBy('tahun', 'bulan')
        ->orderBy('tahun', 'asc')
        ->orderBy('bulan', 'asc')
        ->get()
        ->map(function ($item) {
            $namaBulan = [
                1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr',
                5 => 'Mei', 6 => 'Jun', 7 => 'Jul', 8 => 'Agu',
                9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
            ];
            return [
                'bulan' => $namaBulan[$item->bulan] . ' ' . $item->tahun,
                'total' => $item->total
            ];
        });

        $lombaPerKategori = Lomba::select('kategori', DB::raw('COUNT(*) as total'))
            ->groupBy('kategori')
            ->get();
            
        $timTerbaru = Tim::with('pesertas')->latest()->take(5)->get();
        $panitiaTerbaru = User::where('role', 'panitia')->latest()->take(5)->get();
        $aktivitasTerakhir = $this->getRecentActivities();

        $statistikRole = [
            'super_admin' => $totalSuperAdmin,
            'panitia' => $totalPanitia,
        ];

        $pertumbuhanBulanIni = $this->getGrowthPercentage();

        return view('admin.dashboard', compact(
            'totalPanitia',
            'totalSuperAdmin',
            'totalTim',
            'totalPeserta',
            'totalLomba',
            'pendaftaranBulanan',
            'lombaPerKategori',
            'timTerbaru',
            'panitiaTerbaru',
            'aktivitasTerakhir',
            'statistikRole',
            'pertumbuhanBulanIni'
        ));
    }

    private function getRecentActivities()
    {
        $activities = collect();

        $timBaru = Tim::with('pesertas')->latest()->take(3)->get()->map(function ($item) {
            return [
                'user' => $item->nama_tim,
                'action' => 'mendaftarkan tim',
                'time' => $item->created_at->diffForHumans(),
                'icon' => 'fa-users',
                'color' => 'primary'
            ];
        });

        $panitiaBaru = User::where('role', 'panitia')->latest()->take(2)->get()->map(function ($item) {
            return [
                'user' => $item->name,
                'action' => 'bergabung sebagai panitia',
                'time' => $item->created_at->diffForHumans(),
                'icon' => 'fa-user-plus',
                'color' => 'success'
            ];
        });

        // ✅ PERBAIKAN: Gabungkan dengan aman
        if ($timBaru->isNotEmpty()) {
            $activities = $activities->merge($timBaru);
        }
        
        if ($panitiaBaru->isNotEmpty()) {
            $activities = $activities->merge($panitiaBaru);
        }

        return $activities->sortByDesc('time')->take(5)->values();
    }

    private function getGrowthPercentage()
    {
        $bulanIni = now()->month;
        $bulanLalu = now()->subMonth()->month;
        $totalBulanIni = Tim::whereMonth('created_at', $bulanIni)->count();
        $totalBulanLalu = Tim::whereMonth('created_at', $bulanLalu)->count();

        if ($totalBulanLalu == 0) {
            return $totalBulanIni > 0 ? 100 : 0;
        }

        return round((($totalBulanIni - $totalBulanLalu) / $totalBulanLalu) * 100, 1);
    }
}