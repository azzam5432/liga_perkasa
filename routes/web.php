<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\LombaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TimController;
use App\Http\Controllers\PanitiaController;
use App\Http\Controllers\SuperAdminDashboardController;
use App\Http\Controllers\JuriController;
use App\Http\Controllers\JuriLombaController;
use App\Http\Controllers\FinalisController;
use App\Http\Controllers\NilaiController;
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
    Route::get('/lomba/{id}/detail', [LombaController::class, 'show'])->name('lomba.detail');
    
    Route::get('/nilai', [NilaiController::class, 'index'])->name('nilai.index');
    Route::get('/nilai/create/{id_lomba}', [NilaiController::class, 'create'])->name('nilai.create');
    Route::post('/nilai', [NilaiController::class, 'store'])->name('nilai.store');
});

// ==========================================
// ROUTE SUPER ADMIN (Middleware auth + super_admin)
// ==========================================
Route::middleware(['auth', 'super_admin'])->group(function () {
    
    // Dashboard Super Admin
    Route::get('/admin/dashboard', [SuperAdminDashboardController::class, 'index'])->name('admin.dashboard');
    
    // CRUD Panitia (Super Admin)
    Route::resource('admin', PanitiaController::class);
    
    // CRUD LOMBA (Super Admin: edit, update, destroy)
    Route::resource('lomba', LombaController::class)->only(['edit', 'update', 'destroy']);
    Route::get('/lomba/{id}/detail', [LombaController::class, 'show'])->name('lomba.detail');
    
    // ROUTE FINALIS
    Route::get('/finalis/{id_lomba}', [FinalisController::class, 'index'])->name('finalis.index');
    Route::post('/finalis/{id_lomba}/aktifkan-final', [FinalisController::class, 'aktifkanFinal'])->name('finalis.aktifkan-final');
    Route::get('/finalis/{id_lomba}/rekap', [FinalisController::class, 'rekap'])->name('finalis.rekap');

    // ✅ ROUTE JURI & PENUGASAN
    Route::resource('juri', JuriController::class);
    Route::resource('juri_lomba', JuriLombaController::class);
    Route::get('/get-juri-by-lomba/{id_lomba}', [JuriLombaController::class, 'getJuriByLomba'])->name('get.juri.by.lomba');
});

Route::middleware(['auth'])->group(function () {
    // ✅ RANKING PUBLIK
    Route::get('/ranking', [FinalisController::class, 'ranking'])->name('ranking');
});

// ==========================================
// REDIRECT ROOT
// ==========================================
Route::get('/', function () {
    
    return redirect()->route('login');
});