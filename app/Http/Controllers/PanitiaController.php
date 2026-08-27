<?php
// app/Http/Controllers/PanitiaController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PanitiaController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::where('role', 'panitia');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('role') && in_array($request->role, ['super_admin', 'panitia'])) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status') && in_array($request->status, ['aktif', 'non-aktif'])) {
            $query->where('status', $request->status);
        }

        $panitias = $query->latest()->paginate(10);
        return view('admin.index', compact('panitias'));
    }

    public function create(): View
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'no_telp' => 'required|string|max:15',
            'jabatan' => 'required|string|max:255',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'instagram' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:500',
        ]);

        $data = $request->except(['password', 'foto_profil']);
        $data['password'] = Hash::make($request->password);
        $data['role'] = 'panitia';

        if ($request->hasFile('foto_profil')) {
            $file = $request->file('foto_profil');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/profil'), $fileName);
            $data['foto_profil'] = $fileName;
        }

        User::create($data);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Panitia berhasil ditambahkan!'
            ]);
        }

        return redirect()->route('admin.index')
            ->with('success', 'Panitia berhasil ditambahkan!');
    }

    public function show($id): View
    {
        $panitia = User::findOrFail($id);
        return view('admin.show', compact('panitia'));
    }

    public function edit($id): View
    {
        $panitia = User::findOrFail($id);
        return view('admin.edit', compact('panitia'));
    }

    public function update(Request $request, $id)
    {
        $panitia = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'no_telp' => 'required|string|max:15',
            'jabatan' => 'required|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:500',
        ]);

        $data = $request->except(['foto_profil', 'password']);

        $panitia->update($data);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Data panitia berhasil diupdate!'
            ]);
        }

        return redirect()->route('admin.index')
            ->with('success', 'Data panitia berhasil diupdate!');
    }

    public function destroy($id): RedirectResponse
    {
        $panitia = User::findOrFail($id);

        if ($panitia->foto_profil && file_exists(public_path('uploads/profil/' . $panitia->foto_profil))) {
            unlink(public_path('uploads/profil/' . $panitia->foto_profil));
        }

        $panitia->delete();

        return redirect()->route('admin.index')
            ->with('success', 'Panitia berhasil dihapus!');
    }
}