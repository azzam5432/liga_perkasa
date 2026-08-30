<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Peserta;
use App\Models\Tim;
use Illuminate\View\View;

class TimController extends Controller
{
    public function index(): View
    {
        $tim = Tim::with(['pesertas' => function($query) {
            $query->select('id_tim', 'ketua_peserta', 'prodi', 'no_telp', 'id_peserta', 'nama_peserta');
        }])->withCount('pesertas')->select('id_tim', 'nama_tim', 'created_at')->latest()->paginate(10);
        
        return view('panitia.peserta', ['tim' => $tim]);
    }
    
    public function create(): View
    {
        return view('panitia.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nama_tim' => 'required|string|max:255',
            'ketua_peserta' => 'required|string|max:255',
            'prodi' => 'required|string|max:255',
            'no_telp' => 'required|string|max:15',
            'anggota' => 'required|array|min:4|max:19',
            'anggota.*' => 'required|string|max:255',
        ]);
        
        $tim = Tim::create([
            'nama_tim' => $request->nama_tim,
        ]);
        
        // Simpan Ketua
        Peserta::create([
            'id_tim' => $tim->id_tim,
            'ketua_peserta' => $request->ketua_peserta,
            'nama_peserta' => $request->ketua_peserta,
            'prodi' => $request->prodi,
            'no_telp' => $request->no_telp,
        ]);
        
        // Simpan Anggota
        foreach ($request->anggota as $nama) {
            if (!empty($nama)) {
                Peserta::create([
                    'id_tim' => $tim->id_tim,
                    'ketua_peserta' => null,
                    'nama_peserta' => $nama,
                    'prodi' => null,
                    'no_telp' => null,
                ]);
            }
        }
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Tim dan Peserta Berhasil Disimpan!'
            ]);
        }
        
        return redirect()->route('panitia.index')->with('success', 'Tim dan Peserta Berhasil Disimpan!');
    }

    public function show($id): View
    {
        $tim = Tim::with(['pesertas' => function($query) {
            $query->select('id_tim', 'ketua_peserta', 'nama_peserta', 'prodi', 'no_telp', 'id_peserta');
        }])->findOrFail($id);  
        
        return view('panitia.show', compact('tim'));
    }

    public function edit($id): View
    {
        $tim = Tim::with(['pesertas' => function($query) {
            $query->select('id_tim', 'ketua_peserta', 'nama_peserta', 'prodi', 'no_telp', 'id_peserta');
        }])->findOrFail($id);
        
        return view('panitia.edit', compact('tim'));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_tim' => 'required|string|max:255',
            'ketua_peserta' => 'required|string|max:255',
            'prodi' => 'required|string|max:255',
            'no_telp' => 'required|string|max:15',
            'edit_anggota' => 'required|array|min:4|max:19',
            'edit_anggota.*' => 'required|string|max:255',
        ]);
        
        $tim = Tim::findOrFail($id);
        $tim->update([
            'nama_tim' => $request->nama_tim,
        ]);
        
        // Hapus semua peserta lama
        Peserta::where('id_tim', $id)->delete();
        
        // Simpan Ketua baru
        Peserta::create([
            'id_tim' => $tim->id_tim,
            'ketua_peserta' => $request->ketua_peserta,
            'nama_peserta' => $request->ketua_peserta,
            'prodi' => $request->prodi,
            'no_telp' => $request->no_telp,
        ]);

        // Simpan Anggota baru
        foreach ($request->edit_anggota as $nama) {
            if (!empty($nama)) {
                Peserta::create([
                    'id_tim' => $tim->id_tim,
                    'ketua_peserta' => null,
                    'nama_peserta' => $nama,
                    'prodi' => null,
                    'no_telp' => null,
                ]);
            }
        }
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Diupdate!'
            ]);
        }
        
        return redirect()->route('panitia.index')->with('success', 'Data Berhasil Diupdate!');
    }

    public function destroy($id)
    {
        $tim = Tim::findOrFail($id);
        $tim->delete();
        
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Dihapus!'
            ]);
        }
        
        return redirect()->route('panitia.index')->with('success', 'Data Berhasil Dihapus!');
    }
}