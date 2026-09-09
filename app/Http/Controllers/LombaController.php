<?php

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
            $query->where(function($q) use ($search) {
                $q->where('nama_lomba', 'LIKE', "%{$search}%")
                  ->orWhere('kategori', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->filled('jenis') && $request->jenis != '') {
            $query->where('jenis', $request->jenis);
        }

        $lombas = $query->orderByRaw("CASE WHEN jenis = 'penyisihan' THEN 0 ELSE 1 END")
            ->orderBy('nama_lomba', 'asc')
            ->paginate(10);

        return view('lomba.index', compact('lombas'));
    }

    public function create()
    {
        return redirect()->route('lomba.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lomba' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kategori' => 'nullable|string|max:255',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'jenis' => 'required|in:langsung,penyisihan',
            'bobot' => 'required|numeric|min:0|max:100',
            'jumlah_finalis' => 'nullable|integer|min:0',
        ]);

        $data = $request->all();
        $data['status'] = 'draft';
        $data['is_final_active'] = false;

        if ($request->jenis !== 'penyisihan') {
            $data['jumlah_finalis'] = 0;
        }

        Lomba::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Lomba berhasil ditambahkan!'
        ]);
    }

    public function show($id)
    {
        $lomba = Lomba::with(['juri.user', 'finalis.tim'])->findOrFail($id);
        
        if (request()->ajax()) {
            $juriList = $lomba->juri->map(function($juri) {
                return $juri->user->name ?? 'Juri';
            });
            
            // HAPUS KriteriaCount
            return response()->json([
                'lomba' => $lomba,
                'juri_list' => $juriList,
                'juri_count' => $lomba->juri->count(),
                'finalis_count' => $lomba->finalis->count(),
            ]);
        }
        
        return view('lomba.show', compact('lomba'));
    }

    public function edit($id)
    {
        $lomba = Lomba::findOrFail($id);
        
        if (request()->ajax()) {
            return response()->json($lomba);
        }
        
        return view('lomba.edit', compact('lomba'));
    }

    public function update(Request $request, $id)
    {
        $lomba = Lomba::findOrFail($id);

        $request->validate([
            'nama_lomba' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kategori' => 'nullable|string|max:255',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'jenis' => 'required|in:langsung,penyisihan',
            'bobot' => 'required|numeric|min:0|max:100',
            'jumlah_finalis' => 'nullable|integer|min:0',
        ]);

        $data = $request->all();

        if ($request->jenis !== 'penyisihan') {
            $data['jumlah_finalis'] = 0;
        }

        $lomba->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Lomba berhasil diupdate!'
        ]);
    }

    public function destroy($id)
    {
        $lomba = Lomba::findOrFail($id);
        $lomba->delete();

        return response()->json([
            'success' => true,
            'message' => 'Lomba berhasil dihapus!'
        ]);
    }
    public function publicIndex()
    {
        $lombas = Lomba::with(['finalis.tim', 'nilai'])
            ->orderBy('nama_lomba', 'asc')
            ->get()
            ->map(function($lomba) {
                // Ambil juara 1, 2, 3 dari tabel nilai (juara = 1, 2, 3)
                $juara1 = $lomba->nilai->where('juara', 1)->first();
                $juara2 = $lomba->nilai->where('juara', 2)->first();
                $juara3 = $lomba->nilai->where('juara', 3)->first();

                return [
                    'lomba' => $lomba,
                    'juara1' => $juara1 ? $juara1->tim : null,
                    'juara2' => $juara2 ? $juara2->tim : null,
                    'juara3' => $juara3 ? $juara3->tim : null,
                    'bobot' => $lomba->bobot,
                ];
            });

        return view('lomba.publik', compact('lombas'));
    }
}