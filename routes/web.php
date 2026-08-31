<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\LombaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TimController;
use App\Http\Controllers\PanitiaController;
use App\Http\Controllers\SuperAdminDashboardController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\JuriController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\JuriLombaController;
use Illuminate\Support\Facades\Route;

// ==========================================
// AUTH ROUTES
// ==========================================
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ==========================================
// ROUTE PANITIA (Middleware auth + panitia)
// ==========================================
Route::middleware(['auth', 'panitia'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    
    // CRUD Tim (Panitia)
    Route::resource('panitia', TimController::class);
    
    // CRUD Lomba (Panitia: index, create, store, show)
    Route::resource('lomba', LombaController::class)->only(['index', 'create', 'store', 'show']);
    
    // ✅ TAMBAHKAN: Route tambahan untuk lomba (panitia)
    Route::get('/lomba/{id}/detail', [LombaController::class, 'show'])->name('lomba.detail');
    
    // Penilaian Juri
    Route::get('/juri/penilaian', [PenilaianController::class, 'juriPenilaian'])->name('juri.penilaian');
    Route::post('/juri/penilaian/store', [PenilaianController::class, 'juriStore'])->name('juri.penilaian.store');
});

// ==========================================
// ROUTE SUPER ADMIN (Middleware auth + super_admin)
// ==========================================
Route::middleware(['auth', 'super_admin'])->group(function () {
    
    // Dashboard Super Admin
    Route::get('/admin/dashboard', [SuperAdminDashboardController::class, 'index'])->name('admin.dashboard');
    
    // CRUD Panitia (Super Admin)
    Route::resource('admin', PanitiaController::class);
    
    // ==========================================
    // CRUD LOMBA (Super Admin: edit, update, destroy)
    // ==========================================
    Route::resource('lomba', LombaController::class)->only(['edit', 'update', 'destroy']);
    
    // ✅ TAMBAHKAN: Route tambahan untuk lomba (super admin)
    Route::get('/lomba/{id}/detail', [LombaController::class, 'show'])->name('lomba.detail');
    
    // ==========================================
    // ROUTE FINALIS
    // ==========================================
    Route::get('/lomba/{id}/finalis', [LombaController::class, 'finalisIndex'])->name('lomba.finalis');
    Route::post('/lomba/{id}/finalis', [LombaController::class, 'finalisStore'])->name('lomba.finalis.store');
    Route::delete('/lomba/{id}/finalis/{id_finalis}', [LombaController::class, 'finalisDestroy'])->name('lomba.finalis.destroy');
    
    // ==========================================
    // ROUTE PENILAIAN (Super Admin)
    // ==========================================
    Route::resource('kriteria', KriteriaController::class);
    Route::resource('juri', JuriController::class);
    Route::resource('juri_lomba', JuriLombaController::class);
    Route::resource('penilaian', PenilaianController::class);
    
    // ✅ TAMBAHKAN: Route rekap dan akumulasi
    Route::get('/penilaian/rekap', [PenilaianController::class, 'rekap'])->name('penilaian.rekap');
    Route::get('/penilaian/rekap-lomba/{id_lomba}', [PenilaianController::class, 'rekapLomba'])->name('penilaian.rekap-lomba');
    Route::post('/penilaian/tentukan-finalis/{id_lomba}', [PenilaianController::class, 'tentukanFinalis'])->name('penilaian.tentukan-finalis');
    Route::get('/penilaian/akumulasi-juri/{id_lomba}', [PenilaianController::class, 'akumulasiJuri'])->name('penilaian.akumulasi-juri');
    
    // ✅ TAMBAHKAN: Route untuk get juri by lomba
    Route::get('/get-juri-by-lomba/{id_lomba}', [JuriLombaController::class, 'getJuriByLomba'])->name('get.juri.by.lomba');
});

// ==========================================
// ROUTE KRITERIA JURI (Middleware auth)
// ==========================================
Route::middleware(['auth'])->group(function () {
    Route::get('/juri/lomba/{id}/kriteria', [LombaController::class, 'kriteriaJuri'])->name('juri.kriteria');
    Route::post('/juri/lomba/{id}/kriteria', [LombaController::class, 'kriteriaStore'])->name('juri.kriteria.store');
    Route::put('/juri/lomba/{id}/kriteria/{id_kriteria}', [LombaController::class, 'kriteriaUpdate'])->name('juri.kriteria.update');
    Route::delete('/juri/lomba/{id}/kriteria/{id_kriteria}', [LombaController::class, 'kriteriaDestroy'])->name('juri.kriteria.destroy');
});

// ==========================================
// REDIRECT ROOT
// ==========================================
Route::get('/', function () {
    return redirect()->route('login');
});

// Route::fallback(function () {
//     return redirect()->route('dashboard');
// });