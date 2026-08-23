<?php

namespace App\Http\Controllers;

use App\Models\Juri;
use App\Models\Lomba;
use App\Models\JuriLomba;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class JuriLombaController extends Controller
{

    public function index(): View
    {
        $penugasans = JuriLomba::with(['juri.user', 'lomba'])->latest()->paginate(15);
            
        return view('juri_lomba.index', compact('penugasans'));
    }

    public function create(): View
    {
        $juri = Juri::with('user')->aktif()->get();
        $lomba = Lomba::where('status', 'open')->get();
        
        return view('juri_lomba.create', compact('juri', 'lomba'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'id_juri' => 'required|exists:tb_juri,id_juri',
            'id_lomba' => 'required|exists:tb_lomba,id_lomba',
            'status' => 'required|in:aktif,nonaktif',
            'catatan' => 'nullable|string|max:500',
        ]);

        // Cek apakah sudah ada
        $exists = JuriLomba::where('id_juri', $request->id_juri)->where('id_lomba', $request->id_lomba)->exists();

        if ($exists) {
            return back()->with('error', 'Juri sudah ditugaskan ke lomba ini!');
        }

        JuriLomba::create($request->all());

        return redirect()->route('juri_lomba.index')
            ->with('success', 'Juri berhasil ditugaskan ke lomba!');
    }

    public function show($id): View
    {
        $penugasan = JuriLomba::with(['juri.user', 'lomba'])->findOrFail($id);
        return view('juri_lomba.show', compact('penugasan'));
    }

    public function edit($id): View
    {
        $penugasan = JuriLomba::findOrFail($id);
        $juri = Juri::with('user')->aktif()->get();
        $lomba = Lomba::where('status', 'open')->get();
        
        return view('juri_lomba.edit', compact('penugasan', 'juri', 'lomba'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $penugasan = JuriLomba::findOrFail($id);

        $request->validate([
            'id_juri' => 'required|exists:tb_juri,id_juri',
            'id_lomba' => 'required|exists:tb_lomba,id_lomba',
            'status' => 'required|in:aktif,nonaktif',
            'catatan' => 'nullable|string|max:500',
        ]);

        // Cek duplikasi (kecuali dirinya sendiri)
        $exists = JuriLomba::where('id_juri', $request->id_juri)->where('id_lomba', $request->id_lomba)->where('id_juri_lomba', '!=', $id)->exists();

        if ($exists) {
            return back()->with('error', 'Juri sudah ditugaskan ke lomba ini!');
        }

        $penugasan->update($request->all());

        return redirect()->route('juri_lomba.index')
            ->with('success', 'Penugasan juri berhasil diupdate!');
    }

    public function destroy($id): RedirectResponse
    {
        $penugasan = JuriLomba::findOrFail($id);
        
        // Cek apakah sudah ada penilaian
        $hasPenilaian = $penugasan->juri->penilaians()
            ->where('id_lomba', $penugasan->id_lomba)
            ->exists();

        if ($hasPenilaian) {
            return back()->with('error', 'Penugasan tidak bisa dihapus karena juri sudah memberikan penilaian!');
        }

        $penugasan->delete();

        return redirect()->route('juri_lomba.index')
            ->with('success', 'Penugasan juri berhasil dihapus!');
    }

    public function getJuriByLomba($id_lomba)
    {
        $lomba = Lomba::findOrFail($id_lomba);
        $juriTerpilih = $lomba->juri->pluck('id_juri')->toArray();
        
        $juri = Juri::with('user')
            ->aktif()
            ->whereNotIn('id_juri', $juriTerpilih)
            ->get();

        return response()->json($juri);
    }
}