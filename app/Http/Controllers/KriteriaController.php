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

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_kriteria' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'bobot' => 'required|integer|min:0|max:100',
            'tipe' => 'required|in:pilihan_ganda,skala,teks',
            'skala_min' => 'required_if:tipe,skala|integer',
            'skala_max' => 'required_if:tipe,skala|integer|gt:skala_min',
            'is_active' => 'boolean',
        ]);

        Kriteria::create($request->all());

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

    public function update(Request $request, $id): RedirectResponse
    {
        $kriteria = Kriteria::findOrFail($id);

        $request->validate([
            'nama_kriteria' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'bobot' => 'required|integer|min:0|max:100',
            'tipe' => 'required|in:pilihan_ganda,skala,teks',
            'skala_min' => 'required_if:tipe,skala|integer',
            'skala_max' => 'required_if:tipe,skala|integer|gt:skala_min',
            'is_active' => 'boolean',
        ]);

        $kriteria->update($request->all());

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