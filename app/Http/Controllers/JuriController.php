<?php

namespace App\Http\Controllers;

use App\Models\Juri;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class JuriController extends Controller
{
    public function index(Request $request)
    {
        $query = Juri::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        $juris = $query->latest()->paginate(10);
        $users = User::whereDoesntHave('juri')->where('role', 'panitia')->get();

        if ($request->ajax()) {
            return view('juri.index', compact('juris', 'users'));
        }

        return view('juri.index', compact('juris', 'users'));
    }

    public function create(): View
    {
        $users = User::whereDoesntHave('juri')->where('role', 'panitia')->get();
        return view('juri.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id|unique:tb_juri,user_id',
            'spesialisasi' => 'required|string|max:255',
        ]);

        $juri = Juri::create([
            'user_id' => $request->user_id,
            'spesialisasi' => $request->spesialisasi,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Juri berhasil ditambahkan!'
            ]);
        }

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

    public function update(Request $request, $id)
    {
        $juri = Juri::findOrFail($id);

        $request->validate([
            'spesialisasi' => 'required|string|max:255',
        ]);

        $juri->update([
            'spesialisasi' => $request->spesialisasi,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Data juri berhasil diupdate!'
            ]);
        }

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