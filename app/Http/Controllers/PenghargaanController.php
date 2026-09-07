<?php

namespace App\Http\Controllers;

use App\Models\Penghargaan;
use App\Models\Tim;
use App\Models\Juri;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class PenghargaanController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        
        if (!$user->isPanitia() && !$user->isSuperAdmin()) {
            abort(403, 'Akses ditolak! Hanya panitia dan admin.');
        }

        $tim = Tim::all();
        $penghargaan = Penghargaan::with('tim')->get();
        $juri = Juri::with('user')->aktif()->first();

        return view('penghargaan.index', compact('tim', 'penghargaan', 'juri'));
    }

    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();
        
        if (!$user->isPanitia() && !$user->isSuperAdmin()) {
            abort(403, 'Akses ditolak! Hanya panitia dan admin.');
        }

        $request->validate([
            'kategori' => 'required|string|max:255',
            'bobot' => 'required|numeric|min:0',
        ]);

        // Cek apakah kategori sudah ada
        $exists = Penghargaan::where('kategori', $request->kategori)->exists();

        if ($exists) {
            return back()->with('error', 'Kategori penghargaan sudah ada!');
        }

        Penghargaan::create([
            'kategori' => $request->kategori,
            'bobot' => $request->bobot,
            'id_tim' => null, // Belum ada tim
        ]);

        return redirect()->route('penghargaan.index')
            ->with('success', 'Penghargaan berhasil ditambahkan!');
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $user = Auth::user();
        
        if (!$user->isPanitia() && !$user->isSuperAdmin()) {
            abort(403, 'Akses ditolak! Hanya panitia dan admin.');
        }

        $penghargaan = Penghargaan::findOrFail($id);

        $request->validate([
            'kategori' => 'required|string|max:255',
            'bobot' => 'required|numeric|min:0',
        ]);

        $penghargaan->update([
            'kategori' => $request->kategori,
            'bobot' => $request->bobot,
        ]);

        return redirect()->route('penghargaan.index')
            ->with('success', 'Penghargaan berhasil diupdate!');
    }

    public function assignTim(Request $request, $id): RedirectResponse
    {
        $user = Auth::user();
        
        if (!$user->isPanitia() && !$user->isSuperAdmin()) {
            abort(403, 'Akses ditolak! Hanya panitia dan admin.');
        }

        $penghargaan = Penghargaan::findOrFail($id);

        $request->validate([
            'id_tim' => 'required|exists:tb_tim,id_tim',
        ]);

        $penghargaan->update([
            'id_tim' => $request->id_tim,
        ]);

        return redirect()->route('penghargaan.index')
            ->with('success', 'Tim berhasil dipilih untuk penghargaan ini!');
    }

    public function destroy($id): RedirectResponse
    {
        $user = Auth::user();
        
        if (!$user->isPanitia() && !$user->isSuperAdmin()) {
            abort(403, 'Akses ditolak! Hanya panitia dan admin.');
        }

        $penghargaan = Penghargaan::findOrFail($id);
        $penghargaan->delete();

        return redirect()->route('penghargaan.index')
            ->with('success', 'Penghargaan berhasil dihapus!');
    }
}