<?php
// app/Http/Controllers/LombaController.php

namespace App\Http\Controllers;

use App\Models\Lomba;
use App\Models\Tim;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LombaController extends Controller
{
    
    public function index(): View
    {
        $lombas = Lomba::withCount('tims')->latest()->paginate(10);
        return view('lomba.index', compact('lombas'));
    }

    public function create(): View
    {
        $kategoris = [
            'Videografi & Sinematografi',
            'Desain Grafis & Branding',
            'Seni Pertunjukan & Musik',
            'Public Speaking & Bahasa',
            'Bisnis, Inovasi & Gagasan Ilmiah',
            'Teknologi Informasi & Konten Digital',
            'Olahraga & Game Kompetitif',
            'Pengembangan Karier & Profesionalitas',
            'Lainnya',
        ];
        
        return view('lomba.create', compact('kategoris'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama_lomba' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'tempat' => 'required|string|max:255',
            'status' => 'required|in:draft,open,closed,selesai',
            'kuota_tim' => 'required|integer|min:1',
            'min_anggota' => 'required|integer|min:1|max:20',
            'max_anggota' => 'required|integer|min:1|max:20|gte:min_anggota',
        ]);

        $lomba = Lomba::create($request->all());

        return redirect()->route('lomba.index')
                         ->with('success', 'Lomba "' . $lomba->nama_lomba . '" berhasil ditambahkan!');
    }

    public function show($id): View
{
    $lomba = Lomba::with(['tims' => function($query) {
        $query->withCount('pesertas')->with('pesertas');
    }])->withCount('tims')->findOrFail($id);
    $timTerdaftarIds = $lomba->tims->pluck('id_tim')->toArray();
    $timAvailable = Tim::whereNotIn('id_tim', $timTerdaftarIds)->whereNull('id_lomba') ->get();
    
    return view('lomba.show', compact('lomba', 'timAvailable'));
}

    public function edit($id): View
    {
        $lomba = Lomba::findOrFail($id);
        
        $kategoris = [
            'Videografi & Sinematografi',
            'Desain Grafis & Branding',
            'Seni Pertunjukan & Musik',
            'Public Speaking & Bahasa',
            'Bisnis, Inovasi & Gagasan Ilmiah',
            'Teknologi Informasi & Konten Digital',
            'Olahraga & Game Kompetitif',
            'Pengembangan Karier & Profesionalitas',
            'Lainnya',
        ];
        
        return view('lomba.edit', compact('lomba', 'kategoris'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'nama_lomba' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'tempat' => 'nullable|string|max:255',
            'status' => 'required|in:draft,open,closed,selesai',
            'kuota_tim' => 'nullable|integer|min:1',
            'min_anggota' => 'required|integer|min:1|max:20',
            'max_anggota' => 'required|integer|min:1|max:20|gte:min_anggota',
        ]);

        $lomba = Lomba::findOrFail($id);
        $lomba->update($request->all());

        return redirect()->route('lomba.index')
                         ->with('success', 'Lomba "' . $lomba->nama_lomba . '" berhasil diupdate!');
    }

    public function destroy($id): RedirectResponse
    {
        $lomba = Lomba::findOrFail($id);
        $nama = $lomba->nama_lomba;
        Tim::where('id_lomba', $id)->update(['id_lomba' => null]);    
        $lomba->delete();

        return redirect()->route('lomba.index')
                        ->with('success', 'Lomba "' . $nama . '" berhasil dihapus!');
    }

    public function tambahTim(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'id_tim' => 'required|exists:tb_tim,id_tim',
        ]);

        $lomba = Lomba::findOrFail($id);
        $tim = Tim::findOrFail($request->id_tim);

        if ($tim->id_lomba) {
            return back()->with('error', 'Tim "' . $tim->nama_tim . '" sudah terdaftar di lomba lain!');
        }
        
        if ($lomba->kuota_tim && $lomba->tims()->count() >= $lomba->kuota_tim) {
            return back()->with('error', 'Kuota tim untuk lomba ini sudah penuh!');
        }

        try {
            $tim->id_lomba = $lomba->id_lomba;
            $tim->save();
            return back()->with('success', 'Tim "' . $tim->nama_tim . '" berhasil ditambahkan ke lomba!');
            
        } 
        
        catch (\Exception $e) {
            return back()->with('error', 'Gagal menambahkan tim: ' . $e->getMessage());
        }
    }

    public function hapusTim($id, $id_tim): RedirectResponse
    {
        try {
            $tim = Tim::where('id_lomba', $id)->findOrFail($id_tim);
            $nama = $tim->nama_tim;
            $tim->id_lomba = null;
            $tim->save();
            
            return back()->with('success', 'Tim "' . $nama . '" berhasil dihapus dari lomba!');
            
        } 
        
        catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus tim: ' . $e->getMessage());
        }
    }
}