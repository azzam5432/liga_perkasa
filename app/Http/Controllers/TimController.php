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
        $query->select('id_tim', 'ketua_peserta', 'prodi', 'no_telp', 'id_peserta');
    }])->withCount('pesertas')->select('id_tim', 'nama_tim', 'created_at')->latest()->paginate(10);
        $total_tim = Tim::count();
        return view('admin.peserta', ['tim' => $tim]);
    }
    
    public function create(): View
    {
        return view('admin.create');
    }
    
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_tim' => 'required|string|max:255',
            'ketua_peserta' => 'required|string|max:255',
            'prodi' => 'required|string|max:255',
            'no_telp' => 'required|string|max:15',
            'nama_peserta' => 'required|array',
            'nama_peserta.*' => 'required|string|max:255',
        ]);
        
        $totalPeserta = 1 + count($request->nama_peserta);
        if ($totalPeserta < 5) {
            return back()->withErrors([
                'nama_peserta' => 'Minimal total peserta 5 orang (1 ketua + minimal 4 anggota)'
            ])->withInput();
        }
        
        if ($totalPeserta > 20) {
            return back()->withErrors([
                'nama_peserta' => 'Maksimal total peserta 20 orang (1 ketua + maksimal 19 anggota)'
            ])->withInput();
        }
        
        $tim = Tim::create([
            'nama_tim' => $request->nama_tim,
        ]);
        
        Peserta::create([
            'id_tim' => $tim->id_tim,
            'ketua_peserta' => $request->ketua_peserta,
            'nama_peserta' => $request->ketua_peserta,
            'prodi' => $request->prodi,
            'no_telp' => $request->no_telp,
        ]);
        
        foreach ($request->nama_peserta as $nama) {
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
        
        return redirect()->route('admin.index')->with('success', 'Tim dan Peserta Berhasil Disimpan!');
    }

    public function show($id): View
    {
        $tim = Tim::with(['pesertas' => function($query) {
        $query->select('id_tim', 'ketua_peserta', 'nama_peserta', 'prodi', 'no_telp', 'id_peserta');}])->findOrFail($id);  
        return view('admin.show', compact('tim'));
    }

    public function edit($id): View
    {
        $tim = Tim::with(['pesertas' => function($query) {
            $query->select('id_tim', 'ketua_peserta', 'nama_peserta', 'prodi', 'no_telp', 'id_peserta');
        }])->findOrFail($id);
        
        return view('admin.edit', compact('tim'));
    }
    
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'nama_tim' => 'required|string|max:255',
            'ketua_peserta' => 'required|string|max:255',
            'nama_peserta' => 'required|array',
            'nama_peserta.*' => 'required|string|max:255',
            'prodi' => 'required|string|max:255',
            'no_telp' => 'required|string|max:15',
        ]);
        
        $totalPeserta = 1 + count($request->nama_peserta);
        if ($totalPeserta < 5) {
            return back()->withErrors([
                'nama_peserta' => 'Minimal total peserta 5 orang (1 ketua + minimal 4 anggota)'
            ])->withInput();
        }
        
        if ($totalPeserta > 20) {
            return back()->withErrors([
                'nama_peserta' => 'Maksimal total peserta 20 orang (1 ketua + maksimal 19 anggota)'
            ])->withInput();
        }
        
        $tim = Tim::findOrFail($id);
        $tim->update([
            'nama_tim' => $request->nama_tim,
        ]);
        
        Peserta::where('id_tim', $id)->delete();
        
        Peserta::create([
            'id_tim' => $tim->id_tim,
            'ketua_peserta' => $request->ketua_peserta,
            'nama_peserta' => $request->ketua_peserta,
            'prodi' => $request->prodi,
            'no_telp' => $request->no_telp,
        ]);

        foreach ($request->nama_peserta as $nama) {
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
        
        return redirect()->route('admin.index')->with('success', 'Data Berhasil Diupdate!');
    }

    public function destroy($id): RedirectResponse
    {
        $tim = Tim::findOrFail($id);
        $tim->delete();
        
        return redirect()->route('admin.index')->with('success', 'Data Berhasil Dihapus!');
    }
}