<?php
// app/Http/Controllers/JuriLombaController.php

namespace App\Http\Controllers;

use App\Models\Juri;
use App\Models\Lomba;
use App\Models\JuriLomba;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class JuriLombaController extends Controller
{
    public function index(Request $request)
    {
        $query = JuriLomba::with(['juri.user', 'lomba']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('juri.user', function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%");
            })->orWhereHas('lomba', function($q) use ($search) {
                $q->where('nama_lomba', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $penugasans = $query->latest()->paginate(15);

        $juri = Juri::with('user')->aktif()->get();
        $lomba = Lomba::all();

        if ($request->ajax()) {
            return view('juri_lomba.index', compact('penugasans', 'juri', 'lomba'));
        }

        return view('juri_lomba.index', compact('penugasans', 'juri', 'lomba'));
    }

    public function create(): View
    {
        $juri = Juri::with('user')->aktif()->get();
        $lomba = Lomba::all();
        
        return view('juri_lomba.create', compact('juri', 'lomba'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_juri' => 'required|exists:tb_juri,id_juri',
            'id_lomba' => 'required|exists:tb_lomba,id_lomba',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        // ✅ PERBAIKI: Spesifikkan tabel
        $exists = JuriLomba::where('id_juri', $request->id_juri)
            ->where('id_lomba', $request->id_lomba)
            ->exists();

        if ($exists) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Juri sudah ditugaskan ke lomba ini!'
                ], 422);
            }
            return back()->with('error', 'Juri sudah ditugaskan ke lomba ini!');
        }

        JuriLomba::create([
            'id_juri' => $request->id_juri,
            'id_lomba' => $request->id_lomba,
            'status' => $request->status,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Juri berhasil ditugaskan ke lomba!'
            ]);
        }

        return redirect()->route('juri_lomba.index')
            ->with('success', 'Juri berhasil ditugaskan ke lomba!');
    }

    public function show($id)
    {
        return redirect()->route('juri_lomba.index');
    }

    public function edit($id)
    {
        return redirect()->route('juri_lomba.index');
    }

    public function update(Request $request, $id)
    {
        $penugasan = JuriLomba::findOrFail($id);

        $request->validate([
            'id_juri' => 'required|exists:tb_juri,id_juri',
            'id_lomba' => 'required|exists:tb_lomba,id_lomba',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        // ✅ PERBAIKI: Spesifikkan tabel
        $exists = JuriLomba::where('id_juri', $request->id_juri)
            ->where('id_lomba', $request->id_lomba)
            ->where('id_juri_lomba', '!=', $id)
            ->exists();

        if ($exists) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Juri sudah ditugaskan ke lomba ini!'
                ], 422);
            }
            return back()->with('error', 'Juri sudah ditugaskan ke lomba ini!');
        }

        $penugasan->update([
            'id_juri' => $request->id_juri,
            'id_lomba' => $request->id_lomba,
            'status' => $request->status,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Penugasan juri berhasil diupdate!'
            ]);
        }

        return redirect()->route('juri_lomba.index')->with('success', 'Penugasan juri berhasil diupdate!');
    }

    public function destroy(Request $request, $id)
    {
        $penugasan = JuriLomba::findOrFail($id);
        $penugasan->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Penugasan juri berhasil dihapus!'
            ]);
        }

        return redirect()->route('juri_lomba.index')->with('success', 'Penugasan juri berhasil dihapus!');
    }

    // ✅ PERBAIKI: Method getJuriByLomba
    public function getJuriByLomba($id_lomba)
    {
        $lomba = Lomba::findOrFail($id_lomba);
        // ✅ Spesifikkan tabel
        $juriTerpilih = $lomba->juri()->pluck('tb_juri.id_juri')->toArray();
        
        $juri = Juri::with('user')
            ->aktif()
            ->whereNotIn('id_juri', $juriTerpilih)
            ->get();

        return response()->json($juri);
    }
}