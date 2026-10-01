<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tim;
use App\Models\Peserta;
use App\Models\Lomba;
// use App\Models\Juri; // SISTEM JURI DINONAKTIFKAN: penilaian kini dikelola panitia
use App\Models\Nilai;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();

        // Kumpulkan data per kelas (A / B) supaya tab Reguler A & B menampilkan data terpisah
        $dataPerKelas = [];
        foreach (['A', 'B'] as $kelas) {
            $dataPerKelas[$kelas] = $this->buildDataKelas($user, $kelas);
        }

        return view('panitia.dashboard', [
            'dataPerKelas' => $dataPerKelas,
            // Default variabel lama (kompatibel dengan tampilan tab aktif pertama)
            'dataPeserta' => $dataPerKelas['A']['dataPeserta'],
            'totalTim' => $dataPerKelas['A']['totalTim'],
            'totalPeserta' => $dataPerKelas['A']['totalPeserta'],
            // SISTEM JURI DINONAKTIFKAN: penilaian kini dikelola panitia
            // 'lombaDitugaskan' => $dataPerKelas['A']['lombaDitugaskan'],
            // 'totalLomba' => $dataPerKelas['A']['totalLomba'],
            // 'totalTimSudahDinilai' => $dataPerKelas['A']['totalTimSudahDinilai'],
            // 'juri' => $dataPerKelas['A']['juri'],
        ]);
    }

    private function buildDataKelas($user, string $kelas): array
    {
        // Data untuk Panitia (tim & peserta di kelas ini)
        $dataPeserta = Tim::with(['pesertas' => function ($query) {
                $query->select('id_tim', 'ketua_peserta', 'nama_peserta', 'no_telp');
            }])
            ->withCount('pesertas')
            ->select('id_tim', 'nama_tim', 'kelas')
            ->where('kelas', $kelas)
            ->latest()
            ->paginate(5, ['*'], 'page_' . strtolower($kelas));

        $totalTim = Tim::where('kelas', $kelas)->count();
        $totalPeserta = Peserta::whereHas('tim', function ($q) use ($kelas) {
            $q->where('kelas', $kelas);
        })->count();

        // ===== SISTEM JURI DINONAKTIFKAN: penilaian kini dikelola panitia =====
        /*
        // Data untuk Juri (lomba di kelas ini)
        $juri = Juri::where('user_id', $user->id)->first();

        if (!$juri) {
            $juri = new Juri();
            $juri->id_juri = 0; // Dummy ID
            $juri->lomba = collect(); // Relasi kosong
        }

        $lombaDitugaskan = $juri->lomba()
            ->where('tb_lomba.kelas', $kelas)
            ->get();

        $totalLomba = $lombaDitugaskan->count();

        $totalTimSudahDinilai = 0;
        if ($juri->id_juri != 0) {
            $totalTimSudahDinilai = Nilai::where('id_juri', $juri->id_juri)
                ->whereHas('lomba', function ($q) use ($kelas) {
                    $q->where('kelas', $kelas);
                })
                ->distinct('id_tim')
                ->count('id_tim');
        }
        */

        return [
            'dataPeserta' => $dataPeserta,
            'totalTim' => $totalTim,
            'totalPeserta' => $totalPeserta,
            // 'lombaDitugaskan' => $lombaDitugaskan,
            // 'totalLomba' => $totalLomba,
            // 'totalTimSudahDinilai' => $totalTimSudahDinilai,
            // 'juri' => $juri,
        ];
    }
}
