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

// ===== AUTH ROUTES =====
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ===== ROUTE PANITIA =====
Route::middleware(['auth', 'panitia'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    Route::resource('panitia', TimController::class);
    
    // ✅ HANYA index, create, store, show (untuk Panitia)
    Route::resource('lomba', LombaController::class)->only(['index', 'create', 'store', 'show']);
    
    Route::get('/juri/penilaian', [PenilaianController::class, 'juriPenilaian'])->name('juri.penilaian');
    Route::post('/juri/penilaian/store', [PenilaianController::class, 'juriStore'])->name('juri.penilaian.store');
});

// ===== ROUTE SUPER ADMIN =====
Route::middleware(['auth', 'super_admin'])->group(function () {
    Route::get('/admin/dashboard', [SuperAdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('admin', PanitiaController::class);
    
    // ✅ HANYA edit, update, destroy (untuk Super Admin)
    Route::resource('lomba', LombaController::class)->only(['edit', 'update', 'destroy']);
    
    Route::get('/lomba/{id}/finalis', [LombaController::class, 'finalisIndex'])->name('lomba.finalis');
    Route::post('/lomba/{id}/finalis', [LombaController::class, 'finalisStore'])->name('lomba.finalis.store');
    Route::delete('/lomba/{id}/finalis/{id_finalis}', [LombaController::class, 'finalisDestroy'])->name('lomba.finalis.destroy');
    Route::resource('kriteria', KriteriaController::class);
    Route::resource('juri', JuriController::class);
    Route::resource('juri_lomba', JuriLombaController::class);
    Route::resource('penilaian', PenilaianController::class);
    Route::get('/penilaian/rekap', [PenilaianController::class, 'rekap'])->name('penilaian.rekap');
    Route::get('/get-juri-by-lomba/{id_lomba}', [JuriLombaController::class, 'getJuriByLomba'])->name('get.juri.by.lomba');
});

// ===== ROUTE KRITERIA JURI =====
Route::middleware(['auth'])->group(function () {
    Route::get('/juri/lomba/{id}/kriteria', [LombaController::class, 'kriteriaJuri'])->name('juri.kriteria');
    Route::post('/juri/lomba/{id}/kriteria', [LombaController::class, 'kriteriaStore'])->name('juri.kriteria.store');
    Route::delete('/juri/lomba/{id}/kriteria/{id_kriteria}', [LombaController::class, 'kriteriaDestroy'])->name('juri.kriteria.destroy');
});

// ===== REDIRECT =====
Route::get('/', function () {
    return redirect()->route('login');
});