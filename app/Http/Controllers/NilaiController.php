<?php
// app/Http/Controllers/NilaiController.php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Tim;
use App\Models\Lomba;
use App\Models\Juri;
use App\Models\Finalis;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{
    // ==========================================
    // DASHBOARD JURI - DAFTAR LOMBA
    // ==========================================
    public function index(): View
    {
        $user = Auth::user();
        $juri = Juri::where('user_id', $user->id)->first();
        
        if (!$juri) {
            abort(403, 'Anda bukan juri!');
        }

        // Lomba yang ditugaskan ke juri ini
        $lombas = $juri->lomba()
            ->with(['finalis.tim', 'nilai'])
            ->get();

        return view('nilai.index', compact('juri', 'lombas'));
    }

    // ==========================================
    // FORM PENILAIAN (Penyisihan / Final)
    // ==========================================
    public function create($id_lomba): View
    {
        $user = Auth::user();
        $juri = Juri::where('user_id', $user->id)->first();
        
        if (!$juri) {
            abort(403, 'Anda bukan juri!');
        }

        $isAssigned = $juri->lomba()
            ->where('tb_lomba.id_lomba', $id_lomba)
            ->exists();
            
        if (!$isAssigned) {
            abort(403, 'Anda tidak ditugaskan ke lomba ini!');
        }

        $lomba = Lomba::findOrFail($id_lomba);
        
        // ✅ Tentukan babak
        $babak = $lomba->is_final_active ? 'final' : 'penyisihan';
        
        // ✅ Ambil tim sesuai babak
        if ($lomba->is_final_active) {
            // Final: ambil finalis yang sudah ditentukan otomatis
            $timFinalis = $lomba->finalis()->with('tim')->orderBy('peringkat')->get();
            $tim = $timFinalis->pluck('tim');
            
            // Jika belum ada finalis, buat otomatis dari nilai penyisihan
            if ($tim->isEmpty()) {
                $tim = $this->tentukanFinalisOtomatis($lomba);
            }
        } else {
            // Penyisihan: tampilkan semua tim
            $tim = Tim::all();
        }
        
        // ✅ Ambil nilai yang sudah ada dari juri ini
        $nilaiExisting = Nilai::where('id_lomba', $id_lomba)
            ->where('id_juri', $juri->id_juri)
            ->where('babak', $babak)
            ->get()
            ->keyBy('id_tim');
            
        // ✅ CEK: Apakah sudah ada juri lain yang menilai?
        $sudahDinilai = Nilai::where('id_lomba', $id_lomba)
            ->where('id_juri', '!=', $juri->id_juri)
            ->where('babak', $babak)
            ->exists();
            
        // ✅ Ambil juri yang sudah menilai (untuk info)
        $juriYangMenilai = null;
        if ($sudahDinilai) {
            $juriYangMenilai = Nilai::where('id_lomba', $id_lomba)
                ->where('id_juri', '!=', $juri->id_juri)
                ->where('babak', $babak)
                ->first()
                ->juri ?? null;
        }

        return view('nilai.create', compact(
            'juri', 
            'lomba', 
            'tim', 
            'nilaiExisting', 
            'sudahDinilai', 
            'juriYangMenilai'
        ));
    }

    // ==========================================
    // SIMPAN PENILAIAN (Pilih 1 Tim Menang)
    // ==========================================
    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $juri = Juri::where('user_id', $user->id)->first();

        if (!$juri) {
            return redirect()->route('dashboard')->with('error', 'Data juri tidak ditemukan!');
        }

        $request->validate([
            'id_lomba' => 'required|exists:tb_lomba,id_lomba',
            'id_tim' => 'required|exists:tb_tim,id_tim',
        ]);

        $id_lomba = $request->id_lomba;
        $lomba = Lomba::findOrFail($id_lomba);
        $id_tim = $request->id_tim;

        $isAssigned = $juri->lomba()
            ->where('tb_lomba.id_lomba', $id_lomba)
            ->exists();
            
        if (!$isAssigned) {
            return back()->with('error', 'Anda tidak ditugaskan ke lomba ini!');
        }

        // ✅ Tentukan babak (penyisihan atau final)
        $babak = $lomba->is_final_active ? 'final' : 'penyisihan';

        // ✅ CEK: Apakah lomba sudah dinilai oleh juri lain di babak yang sama?
        $sudahDinilai = Nilai::where('id_lomba', $id_lomba)
            ->where('babak', $babak)
            ->exists();

        if ($sudahDinilai) {
            $juriYangMenilai = Nilai::where('id_lomba', $id_lomba)
                ->where('babak', $babak)
                ->first()
                ->juri->user->name ?? 'Juri lain';
                
            return redirect()->route('dashboard')->with('error', "Lomba ini sudah dinilai oleh {$juriYangMenilai} di babak {$babak}!");
        }

        // ✅ Simpan nilai = bobot lomba
        Nilai::create([
            'id_tim' => $id_tim,
            'id_lomba' => $id_lomba,
            'id_juri' => $juri->id_juri,
            'nilai' => $lomba->bobot,
            'babak' => $babak,
        ]);

        // ✅ OTOMATIS TENTUKAN FINALIS SETELAH PENYISIHAN
        if ($babak == 'penyisihan' && $lomba->jenis == 'penyisihan') {
            $this->tentukanFinalisOtomatis($lomba);
        }

        // ✅ Update data finalis jika perlu
        $this->updateFinalis($lomba, $id_tim, $babak);

        $namaTim = Tim::find($id_tim)->nama_tim ?? 'Tim';

        return redirect()->route('dashboard')
            ->with('success', "Penilaian berhasil! Tim {$namaTim} mendapat {$lomba->bobot} poin di babak {$babak}.");
    }

    // ==========================================
    // TENTUKAN FINALIS OTOMATIS
    // ==========================================
    private function tentukanFinalisOtomatis(Lomba $lomba)
    {
        // Ambil nilai penyisihan per tim
        $nilaiPerTim = Nilai::where('id_lomba', $lomba->id_lomba)
            ->where('babak', 'penyisihan')
            ->select('id_tim', 'nilai')
            ->get()
            ->groupBy('id_tim')
            ->map(function($items) {
                return $items->sum('nilai');
            })
            ->sortDesc()
            ->take($lomba->jumlah_finalis);

        // Hapus finalis lama
        $lomba->finalis()->delete();

        // Simpan finalis baru
        $peringkat = 1;
        foreach ($nilaiPerTim as $id_tim => $totalNilai) {
            Finalis::create([
                'id_lomba' => $lomba->id_lomba,
                'id_tim' => $id_tim,
                'peringkat' => $peringkat,
                'babak' => 'final',
                'nilai_penyisihan' => $totalNilai,
                'catatan' => 'Finalis otomatis dari penyisihan',
            ]);
            $peringkat++;
        }

        return $lomba->finalis()->with('tim')->orderBy('peringkat')->get()->pluck('tim');
    }

    // ==========================================
    // UPDATE DATA FINALIS
    // ==========================================
    private function updateFinalis(Lomba $lomba, $id_tim, $babak)
    {
        if ($babak == 'penyisihan') {
            // Update atau buat finalis dengan nilai penyisihan
            $finalis = Finalis::where('id_lomba', $lomba->id_lomba)
                ->where('id_tim', $id_tim)
                ->first();
                
            if ($finalis) {
                $finalis->update(['nilai_penyisihan' => $lomba->bobot]);
            } else {
                Finalis::create([
                    'id_lomba' => $lomba->id_lomba,
                    'id_tim' => $id_tim,
                    'nilai_penyisihan' => $lomba->bobot,
                    'babak' => 'penyisihan',
                ]);
            }
        }

        if ($babak == 'final') {
            // Update nilai final di finalis
            $finalis = Finalis::where('id_lomba', $lomba->id_lomba)
                ->where('id_tim', $id_tim)
                ->first();
                
            if ($finalis) {
                $finalis->update(['nilai_final' => $lomba->bobot]);
            }
        }
    }

    // ==========================================
    // CEK STATUS PENILAIAN
    // ==========================================
    public function cekStatus($id_lomba)
    {
        $lomba = Lomba::findOrFail($id_lomba);
        
        $sudahDinilai = Nilai::where('id_lomba', $id_lomba)->exists();
        $jumlahFinalis = $lomba->finalis()->count();
        $bobot = $lomba->bobot;
        
        return response()->json([
            'sudah_dinilai' => $sudahDinilai,
            'jumlah_finalis' => $jumlahFinalis,
            'bobot' => $bobot,
            'jenis' => $lomba->jenis,
            'is_final_active' => $lomba->is_final_active,
        ]);
    }
}