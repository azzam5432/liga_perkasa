<?php

namespace App\Http\Controllers;

use App\Models\Lomba;
use App\Models\Tim;
use App\Models\Finalis;
use App\Models\Nilai;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class FinalisController extends Controller
{
    public function index($id_lomba): View
    {
        $lomba = Lomba::with(['finalis.tim'])->findOrFail($id_lomba);
        
        $finalis = $lomba->finalis()->with('tim')->orderBy('peringkat')->get();

        return view('finalis.index', compact('lomba', 'finalis'));
    }

    // ✅ Aktifkan babak final
    public function aktifkanFinal($id_lomba): RedirectResponse
    {
        $lomba = Lomba::findOrFail($id_lomba);
        
        if ($lomba->finalis()->count() == 0) {
            return back()->with('error', 'Belum ada finalis! Sistem belum menentukan finalis otomatis.');
        }

        $lomba->update([
            'is_final_active' => true,
        ]);

        return redirect()->route('finalis.index', $id_lomba)
            ->with('success', 'Babak final berhasil diaktifkan!');
    }

    // ✅ Lihat rekap per lomba
    public function rekap($id_lomba): View
    {
        $lomba = Lomba::with(['finalis.tim'])->findOrFail($id_lomba);
        
        $rekap = [];
        foreach ($lomba->finalis()->with('tim')->orderBy('peringkat')->get() as $finalis) {
            $rekap[] = [
                'tim' => $finalis->tim,
                'nilai_penyisihan' => $finalis->nilai_penyisihan,
                'nilai_final' => $finalis->nilai_final,
                'total_nilai' => $finalis->nilai_penyisihan + $finalis->nilai_final,
            ];
        }
        
        return view('finalis.rekap', compact('lomba', 'rekap'));
    }

    // ✅ RANKING PUBLIK (Semua role bisa akses)
    public function ranking(): View
    {
        $tim = Tim::all();
        
        $rekapTim = [];
        foreach ($tim as $t) {
            $totalNilai = 0;
            $jmlMenang = 0;
            $detailLomba = [];
            
            // Ambil semua nilai tim ini
            $nilaiList = Nilai::where('id_tim', $t->id_tim)->get();
            
            foreach ($nilaiList as $nilai) {
                $totalNilai += $nilai->nilai;
                $jmlMenang++;
                
                $lomba = Lomba::find($nilai->id_lomba);
                if ($lomba) {
                    $detailLomba[] = [
                        'lomba' => $lomba->nama_lomba,
                        'nilai' => $nilai->nilai,
                        'bobot' => $lomba->bobot,
                        'babak' => $nilai->babak,
                    ];
                }
            }
            
            $rekapTim[] = [
                'tim' => $t,
                'total_nilai' => $totalNilai,
                'jml_menang' => $jmlMenang,
                'detail' => $detailLomba,
            ];
        }

        // Urutkan dari total tertinggi
        usort($rekapTim, function($a, $b) {
            return $b['total_nilai'] <=> $a['total_nilai'];
        });

        return view('ranking', compact('rekapTim'));
    }
}