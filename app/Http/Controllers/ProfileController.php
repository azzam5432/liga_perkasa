<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Tim;
use App\Models\Peserta;
use App\Models\lomba;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $totalTim = Tim::count();
        $totalPeserta = Peserta::count();
        $totalLomba = Lomba::count();

        return view('profile.index', compact('user','totalTim', 'totalPeserta', 'totalLomba'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'no_telp' => 'nullable|string|max:15',
            'jabatan' => 'nullable|string|max:255',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'instagram' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:500',
        ]);

        $data = $request->except(['foto_profil']);

        // Upload foto profil
        if ($request->hasFile('foto_profil')) {
            if ($user->foto_profil && file_exists(public_path('uploads/profil/' . $user->foto_profil))) {
                unlink(public_path('uploads/profil/' . $user->foto_profil));
            }

            $file = $request->file('foto_profil');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/profil'), $fileName);
            $data['foto_profil'] = $fileName;
        }

        $user->update($data);

        return redirect()->route('profile.index')->with('success', 'Profile berhasil diupdate!');
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah!']);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('profile.index')->with('success', 'Password berhasil diupdate!');
    }
}