<?php
// app/Http/Controllers/PenilaianController.php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use App\Models\Tim;
use App\Models\Juri;
use App\Models\Kriteria;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class PenilaianController extends Controller
{
    // ==========================================
    // SUPER ADMIN: Lihat semua penilaian
    // ==========================================
    public function index(): View
    {
        $user = Auth::user();
        
        if ($user->isSuperAdmin()) {
            $penilaians = Penilaian::with(['tim', 'juri.user', 'kriteria'])
                ->latest()
                ->paginate(15);
        } else {
            $juri = Juri::where('user_id', $user->id)->first();
            if ($juri) {
                $penilaians = Penilaian::with(['tim', 'kriteria'])
                    ->where('id_juri', $juri->id_juri)
                    ->latest()
                    ->paginate(15);
            } else {
                $penilaians = collect();
            }
        }

        return view('penilaian.index', compact('penilaians'));
    }

    // ==========================================
    // SUPER ADMIN: Lihat detail penilaian
    // ==========================================
    public function show($id): View
    {
        $penilaian = Penilaian::with(['tim', 'juri.user', 'kriteria'])->findOrFail($id);
        return view('penilaian.show', compact('penilaian'));
    }

    // ==========================================
    // JURI: Form penilaian
    // ==========================================
    public function juriPenilaian()
    {
        $user = Auth::user();
        
        // ✅ PERBAIKAN: Cek apakah user adalah juri
        if (!$user->juri) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak terdaftar sebagai juri!');
        }
        
        $juri = $user->juri;
        
        if (!$juri) {
            return redirect()->route('dashboard')->with('error', 'Data juri tidak ditemukan!');
        }

        // ✅ PERBAIKAN: Ambil tim yang sudah dinilai
        $timSudahDinilai = Penilaian::where('id_juri', $juri->id_juri)
            ->pluck('id_tim')
            ->unique()
            ->toArray();

        $timBelumDinilai = Tim::whereNotIn('id_tim', $timSudahDinilai)->get();
        
        // ✅ PERBAIKAN: Ambil kriteria (semua kriteria aktif)
        $kriteria = Kriteria::where('is_active', true)->get();

        // ✅ PERBAIKAN: Ambil lomba yang ditugaskan ke juri
        $lombaDitugaskan = $juri->lomba()->where('status', 'open')->get();

        return view('penilaian.juri', compact('juri', 'timBelumDinilai', 'kriteria', 'lombaDitugaskan'));
    }

    // ==========================================
    // JURI: Simpan penilaian
    // ==========================================
    public function juriStore(Request $request): RedirectResponse
    {
        $request->validate([
            'penilaian' => 'required|array',
            'penilaian.*.id_tim' => 'required|exists:tb_tim,id_tim',
            'penilaian.*.id_kriteria' => 'required|exists:tb_kriteria,id_kriteria',
            'penilaian.*.nilai' => 'nullable|integer|min:0',
            'penilaian.*.komentar' => 'nullable|string',
        ]);

        $user = Auth::user();
        $juri = $user->juri;

        if (!$juri) {
            return redirect()->route('dashboard')->with('error', 'Data juri tidak ditemukan!');
        }

        foreach ($request->penilaian as $item) {
            // ✅ PERBAIKAN: Cek apakah sudah ada penilaian untuk tim dan kriteria ini
            $exists = Penilaian::where('id_tim', $item['id_tim'])
                ->where('id_juri', $juri->id_juri)
                ->where('id_kriteria', $item['id_kriteria'])
                ->exists();

            if (!$exists) {
                Penilaian::create([
                    'id_tim' => $item['id_tim'],
                    'id_juri' => $juri->id_juri,
                    'id_kriteria' => $item['id_kriteria'],
                    'nilai' => $item['nilai'] ?? null,
                    'komentar' => $item['komentar'] ?? null,
                    'status' => 'selesai',
                ]);
            }
        }

        return redirect()->route('penilaian.index')
            ->with('success', 'Penilaian berhasil disimpan!');
    }

    // ==========================================
    // SUPER ADMIN: Rekap Penilaian
    // ==========================================
    public function rekap(): View
    {
        $tim = Tim::with(['penilaians.kriteria', 'penilaians.juri.user'])->get();
        
        $rekap = [];
        foreach ($tim as $t) {
            $totalNilai = 0;
            $totalBobot = 0;
            $penilaians = $t->penilaians->groupBy('id_kriteria');
            
            foreach ($penilaians as $kriteriaId => $items) {
                $rataNilai = $items->avg('nilai');
                $kriteria = $items->first()->kriteria;
                $bobot = $kriteria->bobot ?? 0;
                $totalNilai += ($rataNilai / 100) * $bobot;
                $totalBobot += $bobot;
            }
            
            $rekap[] = [
                'tim' => $t,
                'total_nilai' => $totalNilai,
                'total_bobot' => $totalBobot,
                'rata_rata' => $totalBobot > 0 ? ($totalNilai / $totalBobot) * 100 : 0,
                'jml_penilaian' => $t->penilaians->count(),
            ];
        }

        usort($rekap, function ($a, $b) {
            return $b['rata_rata'] <=> $a['rata_rata'];
        });

        return view('penilaian.rekap', compact('rekap'));
    }

    // ==========================================
// REKAP PENILAIAN PER LOMBA
// ==========================================
public function rekapLomba($id_lomba): View
{
    $lomba = Lomba::with(['juri.user', 'finalis.tim'])->findOrFail($id_lomba);
    $rekap = $lomba->getRekapNilai();
    
    return view('penilaian.rekap_lomba', compact('lomba', 'rekap'));
}

// ==========================================
// TENTUKAN FINALIS OTOMATIS
// ==========================================
public function tentukanFinalis($id_lomba): RedirectResponse
{
    $lomba = Lomba::findOrFail($id_lomba);
    $finalisTerpilih = $lomba->tentukanFinalisOtomatis();
    
    // Hapus finalis lama
    Finalis::where('id_lomba', $id_lomba)->delete();
    
    // Simpan finalis baru
    foreach ($finalisTerpilih as $index => $item) {
        Finalis::create([
            'id_lomba' => $id_lomba,
            'id_tim' => $item['tim']->id_tim,
            'peringkat' => $index + 1,
            'catatan' => 'Finalis otomatis dari penyisihan',
        ]);
    }
    
    return redirect()->route('lomba.finalis', $id_lomba)
        ->with('success', 'Finalis berhasil ditentukan secara otomatis!');
}

    // ==========================================
    // AKUMULASI NILAI PER JURI
    // ==========================================
    public function akumulasiJuri($id_lomba): View
    {
        $lomba = Lomba::findOrFail($id_lomba);
        $juri = $lomba->juri()->with('user')->get();
        $tim = $lomba->getTimPeserta();
        
        $data = [];
        foreach ($juri as $j) {
            $juriData = [
                'juri' => $j,
                'penilaian' => []
            ];
            
            foreach ($tim as $t) {
                $nilai = Penilaian::where('id_tim', $t->id_tim)
                    ->where('id_juri', $j->id_juri)
                    ->whereHas('kriteria', function($q) use ($id_lomba) {
                        $q->where('id_lomba', $id_lomba);
                    })
                    ->sum('nilai');
                    
                $juriData['penilaian'][] = [
                    'tim' => $t,
                    'nilai' => $nilai,
                ];
            }
            
            $data[] = $juriData;
        }
        
        return view('penilaian.akumulasi_juri', compact('lomba', 'data', 'tim'));
    }
}