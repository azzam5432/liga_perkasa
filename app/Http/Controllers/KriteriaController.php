<?php
// app/Http/Controllers/KriteriaController.php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Lomba;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class KriteriaController extends Controller
{
    // ✅ INDEX - Tampilkan kriteria per lomba (hanya untuk juri yang ditugaskan)
    public function index(Request $request): View
    {
        $user = Auth::user();
        $juri = \App\Models\Juri::where('user_id', $user->id)->first();
        
        // Ambil lomba yang ditugaskan ke juri ini
        $lombaDitugaskan = $juri ? $juri->lomba()->where('tb_juri_lomba.status', 'aktif')->get() : collect();
        
        // Ambil id lomba dari parameter, jika tidak ada ambil yang pertama
        $id_lomba = $request->get('id_lomba');
        
        // Jika tidak ada id_lomba dan ada lomba yang ditugaskan, ambil yang pertama
        if (!$id_lomba && $lombaDitugaskan->count() > 0) {
            $id_lomba = $lombaDitugaskan->first()->id_lomba;
        }
        
        // Query kriteria berdasarkan lomba
        $query = Kriteria::with('lomba');
        
        if ($id_lomba) {
            $query->where('id_lomba', $id_lomba);
        } elseif ($lombaDitugaskan->count() > 0) {
            // Jika tidak ada filter, tampilkan kriteria dari lomba pertama yang ditugaskan
            $query->where('id_lomba', $lombaDitugaskan->first()->id_lomba);
        }
        
        $kriterias = $query->latest()->paginate(10);
        
        return view('kriteria.index', compact('kriterias', 'lombaDitugaskan', 'id_lomba'));
    }

    // ✅ STORE - Simpan kriteria dengan id_lomba
    public function store(Request $request)
    {
        $request->validate([
            'id_lomba' => 'required|exists:tb_lomba,id_lomba',
            'nama_kriteria' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'bobot' => 'required|integer|min:0|max:100',
        ]);

        // ✅ CEK DUPLIKASI: Apakah kriteria dengan nama yang sama sudah ada di lomba yang sama?
        $exists = Kriteria::where('id_lomba', $request->id_lomba)
            ->where('nama_kriteria', $request->nama_kriteria)
            ->exists();

        if ($exists) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kriteria "' . $request->nama_kriteria . '" sudah ada di lomba ini!'
                ], 422);
            }
            return back()->with('error', 'Kriteria "' . $request->nama_kriteria . '" sudah ada di lomba ini!');
        }

        $data = $request->all();
        $data['tipe'] = 'skala';
        $data['skala_min'] = 1;
        $data['skala_max'] = 100;
        $data['is_active'] = true;

        Kriteria::create($data);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Kriteria berhasil ditambahkan!'
            ]);
        }

        return redirect()->route('kriteria.index', ['id_lomba' => $request->id_lomba])
            ->with('success', 'Kriteria berhasil ditambahkan!');
    }

    // ✅ UPDATE - Update kriteria
    public function update(Request $request, $id)
    {
        $kriteria = Kriteria::findOrFail($id);

        $request->validate([
            'id_lomba' => 'required|exists:tb_lomba,id_lomba',
            'nama_kriteria' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'bobot' => 'required|integer|min:0|max:100',
        ]);

        // ✅ CEK DUPLIKASI: Apakah kriteria dengan nama yang sama sudah ada di lomba yang sama (kecuali dirinya sendiri)
        $exists = Kriteria::where('id_lomba', $request->id_lomba)
            ->where('nama_kriteria', $request->nama_kriteria)
            ->where('id_kriteria', '!=', $id)
            ->exists();

        if ($exists) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kriteria "' . $request->nama_kriteria . '" sudah ada di lomba ini!'
                ], 422);
            }
            return back()->with('error', 'Kriteria "' . $request->nama_kriteria . '" sudah ada di lomba ini!');
        }

        $data = $request->all();
        $data['tipe'] = $kriteria->tipe;
        $data['skala_min'] = $kriteria->skala_min;
        $data['skala_max'] = $kriteria->skala_max;
        $data['is_active'] = $kriteria->is_active;

        $kriteria->update($data);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Kriteria berhasil diupdate!'
            ]);
        }

        return redirect()->route('kriteria.index', ['id_lomba' => $request->id_lomba])
            ->with('success', 'Kriteria berhasil diupdate!');
    }

    // ✅ DESTROY - Hapus kriteria
    public function destroy($id): RedirectResponse
    {
        $kriteria = Kriteria::findOrFail($id);
        
        $id_lomba = $kriteria->id_lomba;
        $kriteria->delete();

        return redirect()->route('kriteria.index', ['id_lomba' => $id_lomba])
            ->with('success', 'Kriteria berhasil dihapus!');
    }

    // ✅ GET KRITERIA BY LOMBA (untuk dropdown/filter)
    public function getByLomba($id_lomba)
    {
        $kriterias = Kriteria::where('id_lomba', $id_lomba)
            ->where('is_active', true)
            ->get();
            
        return response()->json($kriterias);
    }
}