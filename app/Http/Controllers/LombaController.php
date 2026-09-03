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

        $lombas = $query->latest()->paginate(10);

        if ($request->ajax()) {
            return view('lomba.partials.table', compact('lombas'));
        }

        return view('lomba.index', compact('lombas'));
    }

    // ✅ CREATE - Redirect ke index (karena pakai modal)
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

        // Jika jenis bukan penyisihan, set jumlah_finalis ke 0
        if ($request->jenis !== 'penyisihan') {
            $data['jumlah_finalis'] = 0;
        }

        Lomba::create($data);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Lomba berhasil ditambahkan!'
            ]);
        }

        return redirect()->route('lomba.index')
            ->with('success', 'Lomba berhasil ditambahkan!');
    }

    // ✅ EDIT - Ambil data untuk modal edit
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
            'status' => 'required|in:draft,open,selesai,closed',
            'jenis' => 'required|in:langsung,penyisihan,final',
            'bobot' => 'required|numeric|min:0|max:100',
            'jumlah_finalis' => 'nullable|integer|min:0',
        ]);

        $data = $request->all();
        
        // ❌ HAPUS INI
        // $data['is_penyisihan_active'] = false;
        
        // Jika jenis bukan penyisihan, set jumlah_finalis ke 0
        if ($request->jenis !== 'penyisihan') {
            $data['jumlah_finalis'] = 0;
        }

        $lomba->update($data);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Lomba berhasil diupdate!'
            ]);
        }

        return redirect()->route('lomba.index')
            ->with('success', 'Lomba berhasil diupdate!');
    }

    // ✅ DESTROY - Hapus lomba
    public function destroy($id)
    {
        $lomba = Lomba::findOrFail($id);
        $lomba->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Lomba berhasil dihapus!'
            ]);
        }

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

    public function tentukanFinalisOtomatis($id_lomba): RedirectResponse
    {
        $lomba = Lomba::findOrFail($id_lomba);
        
        // Ambil nilai penyisihan per tim
        $nilaiPerTim = Nilai::where('id_lomba', $id_lomba)
            ->where('babak', 'penyisihan')
            ->select('id_tim', 'nilai')
            ->get()
            ->groupBy('id_tim')
            ->map(function($items) {
                return $items->sum('nilai');
            })
            ->sortDesc()
            ->take($lomba->jumlah_finalis);

        // Hapus finalis lama
        $lomba->finalis()->delete();

        // Simpan finalis baru
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

        return redirect()->route('lomba.show', $id_lomba)
            ->with('success', 'Finalis otomatis berhasil ditentukan!');
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

    public function kriteriaUpdate(Request $request, $id_lomba, $id_kriteria): RedirectResponse
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

        $kriteria = Kriteria::where('id_kriteria', $id_kriteria)
            ->where('id_lomba', $id_lomba)
            ->firstOrFail();

        $request->validate([
            'nama_kriteria' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'bobot' => 'required|integer|min:0|max:100',
        ]);

        $kriteria->update([
            'nama_kriteria' => $request->nama_kriteria,
            'deskripsi' => $request->deskripsi,
            'bobot' => $request->bobot,
        ]);

        return redirect()->route('juri.kriteria', $id_lomba)
            ->with('success', 'Kriteria berhasil diupdate!');
    }

    public function kriteriaDestroy($id_lomba, $id_kriteria): RedirectResponse
    {
        $user = Auth::user();
        
        if (!$user->isJuri()) {
            abort(403, 'Anda bukan juri!');
        }
        
        $kriteria = Kriteria::where('id_kriteria', $id_kriteria)->where('id_lomba', $id_lomba)->firstOrFail();

        $kriteria->delete();

        return redirect()->route('juri.kriteria', $id_lomba)
            ->with('success', 'Kriteria berhasil dihapus!');
    }
}