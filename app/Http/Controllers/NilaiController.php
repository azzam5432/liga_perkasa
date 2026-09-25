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
use Illuminate\Support\Facades\DB;

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
        return $this->renderForm($id_lomba, false);
    }

    // Menampilkan form edit penilaian yang sudah tersimpan
    public function edit($id_lomba): View
    {
        return $this->renderForm($id_lomba, true);
    }

    private function renderForm($id_lomba, bool $isEdit): View
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
        
        // Satu tim bisa dapat beberapa gelar sekaligus, jadi kumpulkan per tim
        $nilaiExisting = Nilai::where('id_lomba', $id_lomba)
            ->where('babak', $babak)
            ->get()
            ->groupBy('id_tim');
        
        return view('nilai.create', compact('lomba', 'tim', 'nilaiExisting', 'sudahDinilai', 'babak', 'isEdit'));
    }

    // Menyimpan penilaian
    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'id_lomba' => 'required|exists:tb_lomba,id_lomba',
            'gelar' => 'required|array',
        ]);

        $id_lomba = $request->id_lomba;
        $lomba = Lomba::findOrFail($id_lomba);

        // Parse input gelar: Juara 1 & 2 tepat 1 tim (tim sama boleh pegang keduanya),
        // Juara 3 bebas: bisa beberapa tim, dan 1 tim bisa lebih dari satu kali.
        $parsed = $this->parseGelar($request);
        if (is_string($parsed)) {
            return back()->with('error', $parsed)->withInput();
        }

        // Tentukan babak
        $babak = $lomba->is_final_active ? 'final' : 'penyisihan';

        // Cek apakah lomba sudah dinilai DI BABAK YANG SAMA
        $sudahDinilai = Nilai::where('id_lomba', $id_lomba)
            ->where('babak', $babak)
            ->exists();

        if ($sudahDinilai) {
            return redirect()->route('nilai.edit', $id_lomba)
                ->with('error', "Lomba ini sudah dinilai di babak {$babak}. Silakan ubah melalui menu Edit Nilai.");
        }

        $bobot = (float) $lomba->bobot;

        $this->simpanGelar($id_lomba, $babak, $bobot, $parsed);

        // Sinkronkan rekap finalis dengan total nilai per tim di babak ini
        $this->syncFinalis($lomba, $babak);

        $namaJuara1 = Tim::find($parsed[1][0]['id_tim'])->nama_tim ?? 'Tim';

        return redirect()->route('dashboard')
            ->with('success', "Penilaian berhasil! {$namaJuara1} menjadi juara 1 di babak {$babak}.");
    }

    // Mengubah penilaian yang sudah tersimpan
    public function update(Request $request, $id_lomba): RedirectResponse
    {
        $request->validate([
            'gelar' => 'required|array',
        ]);

        $lomba = Lomba::findOrFail($id_lomba);

        // Parse input gelar: Juara 1 & 2 tepat 1 tim (tim sama boleh pegang keduanya),
        // Juara 3 bebas: bisa beberapa tim, dan 1 tim bisa lebih dari satu kali.
        $parsed = $this->parseGelar($request);
        if (is_string($parsed)) {
            return back()->with('error', $parsed)->withInput();
        }

        // Tentukan babak
        $babak = $lomba->is_final_active ? 'final' : 'penyisihan';

        DB::transaction(function () use ($lomba, $babak, $parsed) {
            // Hapus & tulis ulang nilai babak ini sesuai input terbaru
            $bobot = (float) $lomba->bobot;

            Nilai::where('id_lomba', $lomba->id_lomba)
                ->where('babak', $babak)
                ->delete();

            $this->simpanGelar($lomba->id_lomba, $babak, $bobot, $parsed);

            // Sinkronkan rekap finalis dengan nilai terbaru
            $this->syncFinalis($lomba, $babak);
        });

        $namaJuara1 = Tim::find($parsed[1][0]['id_tim'])->nama_tim ?? 'Tim';

        return redirect()->route('nilai.index')
            ->with('success', "Penilaian babak {$babak} berhasil diperbarui! {$namaJuara1} menjadi juara 1.");
    }

    // Parse input form "gelar[tim_id][]" menjadi daftar baris nilai per gelar.
    // Aturan: Juara 1 & 2 tepat 1 tim (boleh tim yang sama), Juara 3 bebas
    // (bisa beberapa tim, dan satu tim bisa lebih dari satu kali via kolom jumlah).
    private function parseGelar(Request $request)
    {
        $input = $request->input('gelar', []);

        $juara1 = [];
        $juara2 = [];
        $juara3 = [];

        foreach ($input as $id_tim => $gelars) {
            $gelars = array_unique((array) $gelars);

            foreach ($gelars as $gelar) {
                if ($gelar == 1) {
                    $juara1[] = $id_tim;
                } elseif ($gelar == 2) {
                    $juara2[] = $id_tim;
                } elseif ($gelar == 3) {
                    $jumlah = max(1, (int) $request->input('jumlah_j3_' . $id_tim, 1));

                    // Satu tim bisa mendapat Juara 3 lebih dari satu kali
                    for ($i = 0; $i < $jumlah; $i++) {
                        $juara3[] = ['id_tim' => $id_tim, 'jumlah' => 1];
                    }
                }
            }
        }

        if (count($juara1) !== 1 || count($juara2) !== 1) {
            return 'Juara 1 dan Juara 2 harus dipilih tepat 1 tim (tim yang sama boleh memegang keduanya)!';
        }

        if (count($juara3) === 0) {
            return 'Pilih minimal 1 tim untuk Juara 3!';
        }

        foreach (array_merge($juara1, $juara2, array_column($juara3, 'id_tim')) as $id_tim) {
            if (!Tim::find($id_tim)) {
                return 'Tim tidak ditemukan!';
            }
        }

        return [
            1 => [['id_tim' => $juara1[0], 'jumlah' => 1]],
            2 => [['id_tim' => $juara2[0], 'jumlah' => 1]],
            3 => $juara3,
        ];
    }

    // Simpan semua baris nilai dari hasil parseGelar
    private function simpanGelar($id_lomba, string $babak, float $bobot, array $parsed): void
    {
        $poin = [1 => $bobot * 3, 2 => $bobot * 2, 3 => $bobot];

        foreach ($parsed as $gelar => $rows) {
            foreach ($rows as $row) {
                Nilai::create([
                    'id_tim' => $row['id_tim'],
                    'id_lomba' => $id_lomba,
                    'nilai' => round($poin[$gelar] * $row['jumlah'], 2),
                    'babak' => $babak,
                    'juara' => $gelar,
                    'jumlah' => $row['jumlah'],
                ]);
            }
        }
    }

    // Sinkronkan tabel finalis dengan nilai terbaru pada babak yang diedit
    private function syncFinalis(Lomba $lomba, string $babak): void
    {
        $totalPerTim = Nilai::where('id_lomba', $lomba->id_lomba)
            ->where('babak', $babak)
            ->select('id_tim', DB::raw('SUM(nilai) as total'))
            ->groupBy('id_tim')
            ->pluck('total', 'id_tim');

        foreach ($totalPerTim as $id_tim => $total) {
            $finalis = Finalis::where('id_lomba', $lomba->id_lomba)
                ->where('id_tim', $id_tim)
                ->first();

            if ($babak == 'penyisihan') {
                if ($finalis) {
                    $finalis->update(['nilai_penyisihan' => round((float) $total, 2)]);
                } else {
                    Finalis::create([
                        'id_lomba' => $lomba->id_lomba,
                        'id_tim' => $id_tim,
                        'nilai_penyisihan' => round((float) $total, 2),
                        'babak' => 'penyisihan',
                    ]);
                }
            }

            if ($babak == 'final' && $finalis) {
                $finalis->update(['nilai_final' => round((float) $total, 2)]);
            }
        }
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