<?php
// app/Http/Controllers/TimController.php

namespace App\Http\Controllers;

use App\Models\Tim;
use App\Models\Peserta;
use App\Models\DosenPembimbing;
use App\Models\KakakPembimbing;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class TimController extends Controller
{
    public function index(Request $request): View
    {
        $query = Tim::with(['pesertas', 'dosenPembimbing', 'kakakPembimbing']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama_tim', 'LIKE', "%{$search}%");
        }

        // Filter kelas (default Reguler A)
        $kelas = $request->query('kelas', 'A');
        if (!in_array($kelas, ['A', 'B'])) {
            $kelas = 'A';
        }
        $query->where('kelas', $kelas);

        $tim = $query->withCount('pesertas')->orderBy('nama_tim', 'asc')->paginate(10)->appends($request->query());

        return view('panitia.peserta', compact('tim', 'kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_tim' => 'required|string|max:255',
            'ketua_peserta' => 'required|string|max:255',
            'anggota' => 'required|array|min:4',
            'anggota.*' => 'required|string|max:255',
            'dosen_pembimbing' => 'required|array|min:1',
            'dosen_pembimbing.*' => 'required|string|max:255',
            'kakak_pembimbing' => 'required|array|min:1',
            'kakak_pembimbing.*' => 'required|string|max:255',
            'kelas' => 'required|in:A,B',
        ]);

        // Buat Tim
        $tim = Tim::create([
            'nama_tim' => $request->nama_tim,
            'kelas' => $request->kelas,
        ]);

        // Buat Ketua
        Peserta::create([
            'id_tim' => $tim->id_tim,
            'ketua_peserta' => $request->ketua_peserta,
            'nama_peserta' => $request->ketua_peserta,
        ]);

        // Buat Anggota
        foreach ($request->anggota as $nama) {
            Peserta::create([
                'id_tim' => $tim->id_tim,
                'nama_peserta' => $nama,
            ]);
        }

        // Buat Dosen Pembimbing
        if ($request->has('dosen_pembimbing')) {
            foreach ($request->dosen_pembimbing as $nama_dosen) {
                if ($nama_dosen && trim($nama_dosen) !== '') {
                    DosenPembimbing::create([
                        'id_tim' => $tim->id_tim,
                        'nama_dosen' => $nama_dosen,
                    ]);
                }
            }
        }

        // Buat Kakak Pembimbing
        if ($request->has('kakak_pembimbing')) {
            foreach ($request->kakak_pembimbing as $nama_kakak) {
                if ($nama_kakak && trim($nama_kakak) !== '') {
                    KakakPembimbing::create([
                        'id_tim' => $tim->id_tim,
                        'nama_kakak' => $nama_kakak,
                    ]);
                }
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Tim berhasil ditambahkan!'
            ]);
        }

        return redirect()->route('panitia.index')
            ->with('success', 'Tim berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $tim = Tim::findOrFail($id);

        $request->validate([
            'nama_tim' => 'required|string|max:255',
            'ketua_peserta' => 'required|string|max:255',
            'anggota' => 'required|array|min:4',
            'anggota.*' => 'required|string|max:255',
            'dosen_pembimbing' => 'required|array|min:1',
            'dosen_pembimbing.*' => 'required|string|max:255',
            'kakak_pembimbing' => 'required|array|min:1',
            'kakak_pembimbing.*' => 'required|string|max:255',
            'kelas' => 'required|in:A,B',
        ]);

        // Update Tim
        $tim->update([
            'nama_tim' => $request->nama_tim,
            'kelas' => $request->kelas,
        ]);

        // Hapus semua peserta lama
        $tim->pesertas()->delete();
        $tim->dosenPembimbing()->delete();
        $tim->kakakPembimbing()->delete();

        // Buat Ketua baru
        Peserta::create([
            'id_tim' => $tim->id_tim,
            'ketua_peserta' => $request->ketua_peserta,
            'nama_peserta' => $request->ketua_peserta,
        ]);

        // Buat Anggota baru
        foreach ($request->anggota as $nama) {
            Peserta::create([
                'id_tim' => $tim->id_tim,
                'nama_peserta' => $nama,
            ]);
        }

        // Buat Dosen Pembimbing baru
        foreach ($request->dosen_pembimbing as $nama_dosen) {
            if ($nama_dosen && trim($nama_dosen) !== '') {
                DosenPembimbing::create([
                    'id_tim' => $tim->id_tim,
                    'nama_dosen' => $nama_dosen,
                ]);
            }
        }

        // Buat Kakak Pembimbing baru
        foreach ($request->kakak_pembimbing as $nama_kakak) {
            if ($nama_kakak && trim($nama_kakak) !== '') {
                KakakPembimbing::create([
                    'id_tim' => $tim->id_tim,
                    'nama_kakak' => $nama_kakak,
                ]);
            }
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Tim berhasil diupdate!'
            ]);
        }

        return redirect()->route('panitia.index')
            ->with('success', 'Tim berhasil diupdate!');
    }

    public function destroy($id)
    {
        $tim = Tim::findOrFail($id);
        $tim->delete();

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Tim berhasil dihapus!'
            ]);
        }

        return redirect()->route('panitia.index')
            ->with('success', 'Tim berhasil dihapus!');
    }
}