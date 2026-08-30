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
    public function index(): View
    {
        $user = Auth::user();
        
        if ($user->isSuperAdmin()) {
            $penilaians = Penilaian::with(['tim', 'juri.user', 'kriteria'])->latest()->paginate(15);
        } else {
            $juri = Juri::where('user_id', $user->id)->first();
            if ($juri) {
                $penilaians = Penilaian::with(['tim', 'kriteria'])->where('id_juri', $juri->id_juri)->latest()->paginate(15);
            } else {
                $penilaians = collect();
            }
        }

        return view('penilaian.index', compact('penilaians'));
    }

    public function create(): View
    {
        $tim = Tim::all();
        $juri = Juri::with('user')->aktif()->get();
        $kriteria = Kriteria::active()->get();
        
        return view('penilaian.create', compact('tim', 'juri', 'kriteria'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'id_tim' => 'required|exists:tb_tim,id_tim',
            'id_juri' => 'required|exists:tb_juri,id_juri',
            'id_kriteria' => 'required|exists:tb_kriteria,id_kriteria',
            'nilai' => 'nullable|integer|min:0',
            'komentar' => 'nullable|string',
            'dokumen_pendukung' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
            'status' => 'required|in:draft,selesai',
        ]);

        $data = $request->except(['dokumen_pendukung']);

        if ($request->hasFile('dokumen_pendukung')) {
            $file = $request->file('dokumen_pendukung');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/penilaian'), $fileName);
            $data['dokumen_pendukung'] = $fileName;
        }

        Penilaian::create($data);

        return redirect()->route('penilaian.index')
            ->with('success', 'Penilaian berhasil ditambahkan!');
    }

    public function show($id): View
    {
        $penilaian = Penilaian::with(['tim', 'juri.user', 'kriteria'])->findOrFail($id);
        return view('penilaian.show', compact('penilaian'));
    }

    public function edit($id): View
    {
        $penilaian = Penilaian::findOrFail($id);
        $tim = Tim::all();
        $juri = Juri::with('user')->aktif()->get();
        $kriteria = Kriteria::active()->get();
        
        return view('penilaian.edit', compact('penilaian', 'tim', 'juri', 'kriteria'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $penilaian = Penilaian::findOrFail($id);

        $request->validate([
            'id_tim' => 'required|exists:tb_tim,id_tim',
            'id_juri' => 'required|exists:tb_juri,id_juri',
            'id_kriteria' => 'required|exists:tb_kriteria,id_kriteria',
            'nilai' => 'nullable|integer|min:0',
            'komentar' => 'nullable|string',
            'dokumen_pendukung' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:2048',
            'status' => 'required|in:draft,selesai',
        ]);

        $data = $request->except(['dokumen_pendukung']);

        if ($request->hasFile('dokumen_pendukung')) {
            if ($penilaian->dokumen_pendukung && file_exists(public_path('uploads/penilaian/' . $penilaian->dokumen_pendukung))) {
                unlink(public_path('uploads/penilaian/' . $penilaian->dokumen_pendukung));
            }

            $file = $request->file('dokumen_pendukung');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/penilaian'), $fileName);
            $data['dokumen_pendukung'] = $fileName;
        }

        $penilaian->update($data);

        return redirect()->route('penilaian.index')
            ->with('success', 'Penilaian berhasil diupdate!');
    }

    public function destroy($id): RedirectResponse
    {
        $penilaian = Penilaian::findOrFail($id);
        
        if ($penilaian->dokumen_pendukung && file_exists(public_path('uploads/penilaian/' . $penilaian->dokumen_pendukung))) {
            unlink(public_path('uploads/penilaian/' . $penilaian->dokumen_pendukung));
        }
        
        $penilaian->delete();

        return redirect()->route('penilaian.index')
            ->with('success', 'Penilaian berhasil dihapus!');
    }

    // ✅ PERBAIKAN: Hapus return type :View
    public function juriPenilaian()
    {
        $user = Auth::user();
        $juri = Juri::where('user_id', $user->id)->first();
        
        if (!$juri) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak terdaftar sebagai juri!');
        }

        $timSudahDinilai = Penilaian::where('id_juri', $juri->id_juri)
            ->pluck('id_tim')
            ->unique();

        $timBelumDinilai = Tim::whereNotIn('id_tim', $timSudahDinilai)->get();
        $kriteria = Kriteria::active()->get();

        return view('penilaian.juri', compact('juri', 'timBelumDinilai', 'kriteria'));
    }

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
        $juri = Juri::where('user_id', $user->id)->first();

        foreach ($request->penilaian as $item) {
            Penilaian::create([
                'id_tim' => $item['id_tim'],
                'id_juri' => $juri->id_juri,
                'id_kriteria' => $item['id_kriteria'],
                'nilai' => $item['nilai'] ?? null,
                'komentar' => $item['komentar'] ?? null,
                'status' => 'selesai',
            ]);
        }

        return redirect()->route('penilaian.index')
            ->with('success', 'Penilaian berhasil disimpan!');
    }

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
}