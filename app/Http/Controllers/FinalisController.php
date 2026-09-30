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

    public function ranking(Request $request)
    {
        [$rekapTim, $kelas] = $this->buildRekapTim($request);

        return view('ranking', compact('rekapTim', 'kelas'));
    }

    public function getRankingData(Request $request)
    {
        [$rekapTim] = $this->buildRekapTim($request);

        return response()->json($rekapTim);
    }

    /**
     * Rekap ranking tim, difilter per kelas (A/B).
     * Ranking Reguler B = tim kelas B, total nilai diambil dari lomba kelas B.
     *
     * @return array{0: \Illuminate\Support\Collection, 1: string} [rekapTim, kelas]
     */
    private function buildRekapTim(Request $request): array
    {
        // Filter kelas (default Reguler A)
        $kelas = $request->query('kelas', 'A');
        if (!in_array($kelas, ['A', 'B'])) {
            $kelas = 'A';
        }

        $query = Tim::with(['nilai.lomba', 'pesertas', 'dosenPembimbing', 'kakakPembimbing'])
            ->where('kelas', $kelas);

        $rekapTim = $query
            ->get()
            ->map(function ($tim) {
                // Nilai hanya dihitung dari lomba yang kelasnya sama dengan kelas tim
                $nilaiKelasSama = $tim->nilai->filter(function ($nilai) use ($tim) {
                    return !$nilai->lomba || $nilai->lomba->kelas === $tim->kelas;
                });

                $totalNilai = $nilaiKelasSama->sum('nilai');

                $emas = 0;
                $perak = 0;
                $perunggu = 0;

                foreach ($nilaiKelasSama as $nilai) {
                    if ($nilai->juara == 1) {
                        $emas += $nilai->jumlah;
                    } elseif ($nilai->juara == 2) {
                        $perak += $nilai->jumlah;
                    } elseif ($nilai->juara == 3) {
                        $perunggu += $nilai->jumlah;
                    }
                }

                return [
                    'tim' => $tim,
                    'total_nilai' => $totalNilai,
                    'emas' => $emas,
                    'perak' => $perak,
                    'perunggu' => $perunggu,
                    'jml_menang' => $nilaiKelasSama->count(),
                    'detail' => $nilaiKelasSama->map(function ($nilai) {
                        $babak = ($nilai->lomba && $nilai->lomba->jenis === 'langsung')
                            ? 'langsung'
                            : ($nilai->babak ?? '-');

                        return [
                            'lomba' => $nilai->lomba->nama_lomba ?? '-',
                            'babak' => $babak,
                            'nilai' => $nilai->nilai,
                            'juara' => $nilai->juara ?? null,
                            'jumlah' => $nilai->jumlah ?? 1,
                        ];
                    }),
                ];
            })
            ->sort(function ($a, $b) {
                if ($a['total_nilai'] == $b['total_nilai']) {
                    return strcasecmp($a['tim']->nama_tim, $b['tim']->nama_tim);
                }
                return $b['total_nilai'] <=> $a['total_nilai'];
            })
            ->values();

        return [$rekapTim, $kelas];
    }
}