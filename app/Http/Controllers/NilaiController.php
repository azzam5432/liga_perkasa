<?php

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
    public function index(): View
    {
        $user = Auth::user();
        $juri = Juri::where('user_id', $user->id)->first();
        
        if (!$juri) {
            abort(403, 'Anda bukan juri!');
        }

        $lombas = $juri->lomba()
            ->with(['finalis.tim', 'nilai'])
            ->get();

        return view('nilai.index', compact('juri', 'lombas'));
    }

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
        
        $babak = $lomba->is_final_active ? 'final' : 'penyisihan';
        
        if ($lomba->is_final_active) {
            $timFinalis = $lomba->finalis()->with('tim')->orderBy('peringkat')->get();
            $tim = $timFinalis->pluck('tim');
            
            if ($tim->isEmpty()) {
                $tim = $this->tentukanFinalisOtomatis($lomba);
            }
        } else {
            $tim = Tim::all();
        }
        
        $nilaiExisting = Nilai::where('id_lomba', $id_lomba)
            ->where('id_juri', $juri->id_juri)
            ->where('babak', $babak)
            ->get()
            ->keyBy('id_tim');
            
        $sudahDinilai = Nilai::where('id_lomba', $id_lomba)
            ->where('id_juri', '!=', $juri->id_juri)
            ->where('babak', $babak)
            ->exists();
            
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

    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $juri = Juri::where('user_id', $user->id)->first();

        if (!$juri) {
            return redirect()->route('dashboard')->with('error', 'Data juri tidak ditemukan!');
        }

        $request->validate([
            'id_lomba' => 'required|exists:tb_lomba,id_lomba',
            'juara_1' => 'required|exists:tb_tim,id_tim',
            'juara_2' => 'required|exists:tb_tim,id_tim',
            'juara_3' => 'required|exists:tb_tim,id_tim',
        ]);

        $id_lomba = $request->id_lomba;
        $lomba = Lomba::findOrFail($id_lomba);

        $isAssigned = $juri->lomba()
            ->where('tb_lomba.id_lomba', $id_lomba)
            ->exists();
            
        if (!$isAssigned) {
            return back()->with('error', 'Anda tidak ditugaskan ke lomba ini!');
        }

        if ($request->juara_1 == $request->juara_2 || 
            $request->juara_1 == $request->juara_3 || 
            $request->juara_2 == $request->juara_3) {
            return back()->with('error', 'Juara 1, 2, dan 3 harus tim yang berbeda!');
        }

        $babak = $lomba->is_final_active ? 'final' : 'penyisihan';

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

        $bobot = (float) $lomba->bobot;
        $poinJuara1 = $bobot * 3;
        $poinJuara2 = $bobot * 2;
        $poinJuara3 = $bobot * 1;

        Nilai::create([
            'id_tim' => $request->juara_1,
            'id_lomba' => $id_lomba,
            'id_juri' => $juri->id_juri,
            'nilai' => $poinJuara1,
            'babak' => $babak,
        ]);

        Nilai::create([
            'id_tim' => $request->juara_2,
            'id_lomba' => $id_lomba,
            'id_juri' => $juri->id_juri,
            'nilai' => $poinJuara2,
            'babak' => $babak,
        ]);

        Nilai::create([
            'id_tim' => $request->juara_3,
            'id_lomba' => $id_lomba,
            'id_juri' => $juri->id_juri,
            'nilai' => $poinJuara3,
            'babak' => $babak,
        ]);

        if ($babak == 'penyisihan' && $lomba->jenis == 'penyisihan') {
            $this->tentukanFinalisOtomatis($lomba);
        }

        $this->updateFinalis($lomba, $request->juara_1, $babak, $poinJuara1);
        $this->updateFinalis($lomba, $request->juara_2, $babak, $poinJuara2);
        $this->updateFinalis($lomba, $request->juara_3, $babak, $poinJuara3);

        $namaJuara1 = Tim::find($request->juara_1)->nama_tim ?? 'Tim';

        return redirect()->route('dashboard')
            ->with('success', "Penilaian berhasil! {$namaJuara1} menjadi juara 1 di babak {$babak}.");
    }

    private function tentukanFinalisOtomatis(Lomba $lomba)
    {
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

        $lomba->finalis()->delete();

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

    private function updateFinalis(Lomba $lomba, $id_tim, $babak, $poin)
    {
        if ($babak == 'penyisihan') {
            $finalis = Finalis::where('id_lomba', $lomba->id_lomba)
                ->where('id_tim', $id_tim)
                ->first();
                
            if ($finalis) {
                $finalis->update(['nilai_penyisihan' => $poin]);
            } else {
                Finalis::create([
                    'id_lomba' => $lomba->id_lomba,
                    'id_tim' => $id_tim,
                    'nilai_penyisihan' => $poin,
                    'babak' => 'penyisihan',
                ]);
            }
        }

        if ($babak == 'final') {
            $finalis = Finalis::where('id_lomba', $lomba->id_lomba)
                ->where('id_tim', $id_tim)
                ->first();
                
            if ($finalis) {
                $finalis->update(['nilai_final' => $poin]);
            }
        }
    }
}