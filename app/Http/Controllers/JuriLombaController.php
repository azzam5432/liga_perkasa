<?php
// app/Http/Controllers/JuriLombaController.php

namespace App\Http\Controllers;

use App\Models\Juri;
use App\Models\Lomba;
use App\Models\JuriLomba;
use App\Models\User;
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

        // ✅ AMBIL SEMUA PANITIA (bukan cuma yang belum jadi juri)
        $users = User::where('role', 'panitia')->get();

        $lomba = Lomba::all();

        if ($request->ajax()) {
            return view('juri_lomba.index', compact('penugasans', 'lomba', 'users'));
        }

        return view('juri_lomba.index', compact('penugasans', 'lomba', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'id_lomba' => 'required|exists:tb_lomba,id_lomba',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        // ✅ Buat data juri otomatis dari panitia
        $juri = Juri::where('user_id', $request->user_id)->first();
        
        if (!$juri) {
            $juri = Juri::create([
                'user_id' => $request->user_id,
                'spesialisasi' => 'Panitia',
                'status' => 'aktif',
            ]);
        }

        // ✅ CEK: Apakah juri sudah ditugaskan ke lomba ini?
        $exists = JuriLomba::where('id_juri', $juri->id_juri)
            ->where('id_lomba', $request->id_lomba)
            ->exists();

        if ($exists) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Panitia sudah ditugaskan ke lomba ini!'
                ], 422);
            }
            return back()->with('error', 'Panitia sudah ditugaskan ke lomba ini!');
        }

        JuriLomba::create([
            'id_juri' => $juri->id_juri,
            'id_lomba' => $request->id_lomba,
            'status' => $request->status,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Panitia berhasil ditugaskan sebagai juri!'
            ]);
        }

        return redirect()->route('juri_lomba.index')
            ->with('success', 'Panitia berhasil ditugaskan sebagai juri!');
    }

    public function update(Request $request, $id)
    {
        $penugasan = JuriLomba::findOrFail($id);

        $request->validate([
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $penugasan->update([
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
}