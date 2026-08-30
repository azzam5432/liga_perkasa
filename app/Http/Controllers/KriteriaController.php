<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class KriteriaController extends Controller
{

    public function index(): View
    {
        $kriterias = Kriteria::latest()->paginate(10);
        return view('kriteria.index', compact('kriterias'));
    }

    public function create(): View
    {
        return view('kriteria.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kriteria' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'bobot' => 'required|integer|min:0|max:100',
        ]);

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

        return redirect()->route('kriteria.index')
            ->with('success', 'Kriteria berhasil ditambahkan!');
    }

    public function show($id): View
    {
        $kriteria = Kriteria::findOrFail($id);
        return view('kriteria.show', compact('kriteria'));
    }

    public function edit($id): View
    {
        $kriteria = Kriteria::findOrFail($id);
        return view('kriteria.edit', compact('kriteria'));
    }

    public function update(Request $request, $id)
    {
        $kriteria = Kriteria::findOrFail($id);

        $request->validate([
            'nama_kriteria' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'bobot' => 'required|integer|min:0|max:100',
        ]);

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

        return redirect()->route('kriteria.index')
            ->with('success', 'Kriteria berhasil diupdate!');
    }

    public function destroy($id): RedirectResponse
    {
        $kriteria = Kriteria::findOrFail($id);
        
        if ($kriteria->penilaians()->count() > 0) {
            return back()->with('error', 'Kriteria tidak bisa dihapus karena sudah digunakan dalam penilaian!');
        }
        
        $kriteria->delete();

        return redirect()->route('kriteria.index')
            ->with('success', 'Kriteria berhasil dihapus!');
    }
}