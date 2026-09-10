<?php

namespace App\Http\Controllers;

use App\Models\Nilai;
use App\Models\Tim;
use App\Models\Lomba;
use App\Models\Finalis;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class NilaiController extends Controller
{
    // Menampilkan daftar lomba yang bisa dinilai (semua lomba)
    public function index(): View
    {
        $user = Auth::user();
        
        // Ambil semua lomba (tanpa filter juri)
        $lombas = Lomba::with(['finalis.tim', 'nilai'])->get();

        return view('nilai.index', compact('lombas'));
    }

    // Menampilkan form penilaian untuk lomba tertentu
    public function create($id_lomba): View
    {
        $user = Auth::user();
        $lomba = Lomba::findOrFail($id_lomba);
        
        // Tentukan babak
        $babak = $lomba->is_final_active ? 'final' : 'penyisihan';
        
        // Ambil semua tim
        $tim = Tim::all();

        // Cek apakah babak ini sudah dinilai (filter by babak!)
        $sudahDinilai = Nilai::where('id_lomba', $id_lomba)
            ->where('babak', $babak)
            ->exists();
        
        $nilaiExisting = Nilai::where('id_lomba', $id_lomba)
            ->where('babak', $babak)
            ->get()
            ->keyBy('id_tim');
        
        return view('nilai.create', compact('lomba', 'tim', 'nilaiExisting', 'sudahDinilai', 'babak'));
    }

    // Menyimpan penilaian
    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'id_lomba' => 'required|exists:tb_lomba,id_lomba',
            'juara_1' => 'required|exists:tb_tim,id_tim',
            'juara_2' => 'required|exists:tb_tim,id_tim',
            'juara_3' => 'required|array|min:1',
            'juara_3.*' => 'exists:tb_tim,id_tim',
        ]);

        $id_lomba = $request->id_lomba;
        $lomba = Lomba::findOrFail($id_lomba);

        // Cek duplikat juara
        if ($request->juara_1 == $request->juara_2 || 
            in_array($request->juara_1, $request->juara_3 ?? []) || 
            in_array($request->juara_2, $request->juara_3 ?? [])) {
            return back()->with('error', 'Juara 1, 2, dan 3 harus tim yang berbeda!');
        }

        // Tentukan babak
        $babak = $lomba->is_final_active ? 'final' : 'penyisihan';

        // Cek apakah lomba sudah dinilai DI BABAK YANG SAMA
        $sudahDinilai = Nilai::where('id_lomba', $id_lomba)
            ->where('babak', $babak)
            ->exists();

        if ($sudahDinilai) {
            return back()->with('error', "Lomba ini sudah dinilai di babak {$babak}!");
        }

        $bobot = (float) $lomba->bobot;
        $poinJuara1 = round($bobot * 3, 2);
        $poinJuara2 = round($bobot * 2, 2);
        $poinJuara3 = round($bobot * 1, 2);

        // Simpan Juara 1
        Nilai::create([
            'id_tim' => $request->juara_1,
            'id_lomba' => $id_lomba,
            'nilai' => $poinJuara1,
            'babak' => $babak,
            'juara' => 1,
            'jumlah' => 1,
        ]);

        // Simpan Juara 2
        Nilai::create([
            'id_tim' => $request->juara_2,
            'id_lomba' => $id_lomba,
            'nilai' => $poinJuara2,
            'babak' => $babak,
            'juara' => 2,
            'jumlah' => 1,
        ]);

        // Simpan Juara 3 (bisa lebih dari 1 tim)
        foreach ($request->juara_3 ?? [] as $id_tim) {
            $jumlah = $request->input('jumlah_perunggu_' . $id_tim, 1);
            
            Nilai::create([
                'id_tim' => $id_tim,
                'id_lomba' => $id_lomba,
                'nilai' => $poinJuara3 * $jumlah,
                'babak' => $babak,
                'juara' => 3,
                'jumlah' => $jumlah,
            ]);
        }

        // Update Finalis
        $this->updateFinalis($lomba, $request->juara_1, $babak, $poinJuara1);
        $this->updateFinalis($lomba, $request->juara_2, $babak, $poinJuara2);
        foreach ($request->juara_3 ?? [] as $id_tim) {
            $this->updateFinalis($lomba, $id_tim, $babak, $poinJuara3);
        }

        $namaJuara1 = Tim::find($request->juara_1)->nama_tim ?? 'Tim';

        return redirect()->route('dashboard')
            ->with('success', "Penilaian berhasil! {$namaJuara1} menjadi juara 1 di babak {$babak}.");
    }

    // Fungsi untuk menentukan finalis otomatis
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

    // Fungsi untuk update data finalis
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