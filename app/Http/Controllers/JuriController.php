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

    // ✅ CREATE - Redirect ke index karena pakai modal
    public function create()
    {
        return redirect()->route('juri.index');
    }

    // ✅ STORE - Simpan data dari modal
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

    // ✅ SHOW - Redirect ke index karena pakai modal
    public function show($id)
    {
        return redirect()->route('juri.index');
    }

    // ✅ EDIT - Redirect ke index karena pakai modal
    public function edit($id)
    {
        return redirect()->route('juri.index');
    }

    // ✅ UPDATE - Update data dari modal
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

    // ✅ DESTROY - Hapus data
    public function destroy($id)
    {
        $juri = Juri::findOrFail($id);
        $juri->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Juri berhasil dihapus!'
            ]);
        }

        return redirect()->route('juri.index')
            ->with('success', 'Juri berhasil dihapus!');
    }
}