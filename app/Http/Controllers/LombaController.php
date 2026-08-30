<?php
// app/Http/Controllers/LombaController.php

namespace App\Http\Controllers;

use App\Models\Lomba;
use App\Models\Tim;
use App\Models\Juri;
use App\Models\Finalis;
use App\Models\Kriteria;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LombaController extends Controller
{
    public function index(Request $request): View
    {
        $query = Lomba::with(['juri.user', 'finalis.tim']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama_lomba', 'LIKE', "%{$search}%")
                  ->orWhere('kategori', 'LIKE', "%{$search}%");
        }

        if ($request->filled('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->filled('jenis') && $request->jenis != '') {
            $query->where('jenis', $request->jenis);
        }

        $lombas = $query->latest()->paginate(10);

        if ($request->ajax()) {
            return view('lomba.partials.table', compact('lombas'));
        }

        return view('lomba.index', compact('lombas'));
    }

    public function create(): View
    {
        return view('lomba.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_lomba' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kategori' => 'nullable|string|max:255',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'jenis' => 'required|in:langsung,penyisihan,final',
        ]);

        $data = $request->all();
        $data['status'] = 'draft';
        $data['is_penyisihan_active'] = false;

        Lomba::create($data);

        return redirect()->route('lomba.index')
            ->with('success', 'Lomba berhasil ditambahkan!');
    }

    public function show($id): View
    {
        $lomba = Lomba::with(['juri.user', 'finalis.tim', 'kriterias'])->findOrFail($id);
        return view('lomba.show', compact('lomba'));
    }

    public function edit($id): View
    {
        $lomba = Lomba::findOrFail($id);
        return view('lomba.edit', compact('lomba'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $lomba = Lomba::findOrFail($id);

        $request->validate([
            'nama_lomba' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kategori' => 'nullable|string|max:255',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:draft,open,selesai,closed',
            'jenis' => 'required|in:langsung,penyisihan,final',
        ]);

        $lomba->update($request->all());

        return redirect()->route('lomba.index')
            ->with('success', 'Lomba berhasil diupdate!');
    }

    public function destroy($id): RedirectResponse
    {
        $lomba = Lomba::findOrFail($id);
        $lomba->delete();

        return redirect()->route('lomba.index')
            ->with('success', 'Lomba berhasil dihapus!');
    }

    // ===== FINALIS =====
    public function finalisIndex($id_lomba): View
    {
        $lomba = Lomba::findOrFail($id_lomba);
        $tim = Tim::all();
        $finalis = $lomba->finalis()->with('tim')->get();
        
        return view('lomba.finalis', compact('lomba', 'tim', 'finalis'));
    }

    public function finalisStore(Request $request, $id_lomba): RedirectResponse
    {
        $request->validate([
            'id_tim' => 'required|exists:tb_tim,id_tim',
            'peringkat' => 'nullable|integer|min:1',
        ]);

        $lomba = Lomba::findOrFail($id_lomba);

        $exists = Finalis::where('id_lomba', $id_lomba)
            ->where('id_tim', $request->id_tim)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Tim sudah menjadi finalis!');
        }

        Finalis::create([
            'id_lomba' => $id_lomba,
            'id_tim' => $request->id_tim,
            'peringkat' => $request->peringkat,
        ]);

        return redirect()->route('lomba.finalis', $id_lomba)
            ->with('success', 'Finalis berhasil ditambahkan!');
    }

    public function finalisDestroy($id_lomba, $id_finalis): RedirectResponse
    {
        $finalis = Finalis::where('id_lomba', $id_lomba)
            ->where('id_finalis', $id_finalis)
            ->firstOrFail();
        
        $finalis->delete();

        return redirect()->route('lomba.finalis', $id_lomba)
            ->with('success', 'Finalis berhasil dihapus!');
    }

    // ===== KRITERIA JURI =====
    public function kriteriaJuri($id_lomba): View
    {
        $user = Auth::user();
        
        if (!$user->isJuri()) {
            abort(403, 'Anda bukan juri!');
        }
        
        $juri = Juri::where('user_id', $user->id)->first();
        $isAssigned = $juri && $juri->lomba()->where('id_lomba', $id_lomba)->exists();
        
        if (!$isAssigned) {
            abort(403, 'Anda tidak ditugaskan ke lomba ini!');
        }

        $lomba = Lomba::findOrFail($id_lomba);
        $kriterias = Kriteria::where('id_lomba', $id_lomba)->get();

        return view('juri.kriteria', compact('lomba', 'kriterias', 'juri'));
    }

    public function kriteriaStore(Request $request, $id_lomba): RedirectResponse
    {
        $user = Auth::user();
        
        if (!$user->isJuri()) {
            abort(403, 'Anda bukan juri!');
        }
        
        $juri = Juri::where('user_id', $user->id)->first();
        $isAssigned = $juri && $juri->lomba()->where('id_lomba', $id_lomba)->exists();
        
        if (!$isAssigned) {
            abort(403, 'Anda tidak ditugaskan ke lomba ini!');
        }

        $request->validate([
            'nama_kriteria' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'bobot' => 'required|integer|min:0|max:100',
        ]);

        Kriteria::create([
            'id_lomba' => $id_lomba,
            'nama_kriteria' => $request->nama_kriteria,
            'deskripsi' => $request->deskripsi,
            'bobot' => $request->bobot,
            'tipe' => 'skala',
            'skala_min' => 1,
            'skala_max' => 100,
            'is_active' => true,
        ]);

        return redirect()->route('juri.kriteria', $id_lomba)
            ->with('success', 'Kriteria berhasil ditambahkan!');
    }

    public function kriteriaDestroy($id_lomba, $id_kriteria): RedirectResponse
    {
        $user = Auth::user();
        
        if (!$user->isJuri()) {
            abort(403, 'Anda bukan juri!');
        }
        
        $kriteria = Kriteria::where('id_kriteria', $id_kriteria)
            ->where('id_lomba', $id_lomba)
            ->firstOrFail();
        
        $kriteria->delete();

        return redirect()->route('juri.kriteria', $id_lomba)
            ->with('success', 'Kriteria berhasil dihapus!');
    }
}