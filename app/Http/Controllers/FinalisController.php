<?php

namespace App\Http\Controllers;

use App\Models\Lomba;
use App\Models\Tim;
use App\Models\Finalis;
use App\Models\Nilai;
use App\Models\Penghargaan;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class FinalisController extends Controller
{
    public function index($id_lomba): View
    {
        $lomba = Lomba::with(['finalis.tim'])->findOrFail($id_lomba);

        $nilaiPerTim = Nilai::where('id_lomba', $id_lomba)
            ->where('babak', 'penyisihan')
            ->select('id_tim', 'nilai')
            ->get()
            ->groupBy('id_tim')
            ->map(function($items) {
                return $items->sum('nilai');
            })
            ->sortDesc();

        $finalis = $lomba->finalis()->with('tim')->orderBy('peringkat')->get();

        $timFinalisIds = $finalis->pluck('id_tim')->toArray();
        $timTersedia = Tim::whereNotIn('id_tim', $timFinalisIds)->get();

        $sudahAdaPenilaian = Nilai::where('id_lomba', $id_lomba)
            ->where('babak', 'penyisihan')
            ->exists();

        return view('finalis.index', compact('lomba', 'finalis', 'nilaiPerTim', 'timTersedia', 'sudahAdaPenilaian'));
    }

    public function store(Request $request, $id_lomba): RedirectResponse
    {
        $request->validate([
            'id_tim' => 'required|exists:tb_tim,id_tim',
            'peringkat' => 'nullable|integer|min:1',
        ]);

        $lomba = Lomba::findOrFail($id_lomba);

        $currentCount = $lomba->finalis()->count();
        if ($currentCount >= $lomba->jumlah_finalis) {
            return back()->with('error', 'Kuota finalis sudah penuh!');
        }

        $exists = Finalis::where('id_lomba', $id_lomba)
            ->where('id_tim', $request->id_tim)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Tim sudah menjadi finalis!');
        }

        Finalis::create([
            'id_lomba' => $id_lomba,
            'id_tim' => $request->id_tim,
            'peringkat' => $request->peringkat ?? ($currentCount + 1),
            'babak' => 'final',
            'catatan' => 'Finalis manual',
        ]);

        return redirect()->route('finalis.index', $id_lomba)
            ->with('success', 'Finalis berhasil ditambahkan!');
    }

    public function destroy($id_lomba, $id_finalis): RedirectResponse
    {
        $finalis = Finalis::where('id_lomba', $id_lomba)
            ->where('id_finalis', $id_finalis)
            ->firstOrFail();

        $finalis->delete();

        return redirect()->route('finalis.index', $id_lomba)
            ->with('success', 'Finalis berhasil dihapus!');
    }

    public function aktifkanFinal($id_lomba): RedirectResponse
    {
        $lomba = Lomba::findOrFail($id_lomba);

        if ($lomba->finalis()->count() == 0) {
            return back()->with('error', 'Belum ada finalis! Tambahkan finalis terlebih dahulu.');
        }

        $lomba->update([
            'is_final_active' => true,
        ]);

        return redirect()->route('finalis.index', $id_lomba)
            ->with('success', 'Babak final berhasil diaktifkan!');
    }

    public function ranking()
{
    $rekapTim = Tim::with(['nilai', 'penghargaan', 'pesertas', 'dosenPembimbing', 'kakakPembimbing'])
        ->get()
        ->map(function($tim) {
            return [
                'tim' => $tim,
                'total_nilai' => $tim->nilai->sum('nilai') + $tim->penghargaan->sum('bobot'),
                'jml_menang' => $tim->nilai->where('status', 'menang')->count(),
                'detail' => $tim->nilai->map(function($nilai) {
                    return [
                        'lomba' => $nilai->lomba->nama_lomba ?? '-',
                        'babak' => $nilai->babak ?? '-',
                        'nilai' => $nilai->nilai,
                    ];
                }),
                'penghargaan' => $tim->penghargaan->map(function($p) {
                    return [
                        'kategori' => $p->kategori,
                        'bobot' => $p->bobot,
                    ];
                }),
            ];
        })
        ->sortByDesc('total_nilai')
        ->values();

    return view('ranking', compact('rekapTim'));
}
}