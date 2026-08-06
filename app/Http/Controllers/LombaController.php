<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Peserta;
use Illuminate\View\View;

class LombaController extends Controller
{
    public function index(): View
    {
        $peserta = Peserta::latest()->paginate(10);
        return view('admin.peserta', compact('peserta'));
    }
    public function create(): View
    {
        return view('admin.create');
    }
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_peserta' => 'required|min:3|max:255',
            'no_telp'      => 'required|min:10|max:15',
        ]);
        Peserta::create([
            'nama_peserta' => $request->nama_peserta,
            'no_telp'      => $request->no_telp,
        ]);
        return redirect()->route('admin.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }
    public function show(string $id): View
    {
        $peserta = Peserta::findOrFail($id);
        return view('admin.show', compact('peserta'));
    }

    public function edit(string $id): View
    {
        $peserta = Peserta::findOrFail($id);
        return view('admin.edit', compact('peserta'));
    }
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'nama_peserta' => 'required|min:3|max:255',
            'no_telp'      => 'required|min:10|max:15',
        ]);
        $peserta = Peserta::findOrFail($id);
        $peserta->update([
            'nama_peserta' => $request->nama_peserta,
            'no_telp'      => $request->no_telp,
        ]);

        return redirect()->route('admin.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy($id): RedirectResponse
    {
        $peserta = Peserta::findOrFail($id);
        $peserta->delete();
        
        return redirect()->route('admin.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}