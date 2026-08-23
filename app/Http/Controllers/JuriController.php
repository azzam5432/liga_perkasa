<?php

namespace App\Http\Controllers;

use App\Models\Juri;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class JuriController extends Controller
{

    public function index(): View
    {
        $juris = Juri::with('user')->latest()->paginate(10);
        return view('juri.index', compact('juris'));
    }

    public function create(): View
    {
        $users = User::whereDoesntHave('juri')->where('role', 'panitia')->get();
        return view('juri.create', compact('users'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id|unique:tb_juri,user_id',
            'spesialisasi' => 'nullable|string|max:255',
            'institusi' => 'nullable|string|max:255',
            'pengalaman' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        Juri::create($request->all());

        return redirect()->route('juri.index')
            ->with('success', 'Juri berhasil ditambahkan!');
    }

    public function show($id): View
    {
        $juri = Juri::with('user', 'penilaians.tim')->findOrFail($id);
        return view('juri.show', compact('juri'));
    }

    public function edit($id): View
    {
        $juri = Juri::findOrFail($id);
        return view('juri.edit', compact('juri'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $juri = Juri::findOrFail($id);

        $request->validate([
            'spesialisasi' => 'nullable|string|max:255',
            'institusi' => 'nullable|string|max:255',
            'pengalaman' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $juri->update($request->all());

        return redirect()->route('juri.index')
            ->with('success', 'Data juri berhasil diupdate!');
    }

    public function destroy($id): RedirectResponse
    {
        $juri = Juri::findOrFail($id);
        
        if ($juri->penilaians()->count() > 0) {
            return back()->with('error', 'Juri tidak bisa dihapus karena sudah memberikan penilaian!');
        }
        
        $juri->delete();

        return redirect()->route('juri.index')
            ->with('success', 'Juri berhasil dihapus!');
    }
}