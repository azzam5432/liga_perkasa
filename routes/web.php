<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\LombaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TimController;
use App\Http\Controllers\PanitiaController;
use App\Http\Controllers\SuperAdminDashboardController;
use App\Http\Controllers\JuriLombaController;
use App\Http\Controllers\FinalisController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\PenghargaanController; 
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return redirect()->route('ranking');
});

Route::get('/ranking', [FinalisController::class, 'ranking'])->name('ranking');

Route::middleware(['auth'])->group(function () {
    
    Route::get('/dashboard/ranking', [FinalisController::class, 'ranking'])->name('dashboard.ranking');
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    
    Route::resource('panitia', TimController::class);
    
    // GANTI Route::resource dengan ini agar lebih jelas dan tidak bentrok
    Route::get('/lomba', [LombaController::class, 'index'])->name('lomba.index');
    Route::get('/lomba/create', [LombaController::class, 'create'])->name('lomba.create');
    Route::post('/lomba', [LombaController::class, 'store'])->name('lomba.store');
    Route::get('/lomba/{id}', [LombaController::class, 'show'])->name('lomba.show');
    Route::get('/lomba/{id}/edit', [LombaController::class, 'edit'])->name('lomba.edit');
    Route::put('/lomba/{id}', [LombaController::class, 'update'])->name('lomba.update');
    Route::delete('/lomba/{id}', [LombaController::class, 'destroy'])->name('lomba.destroy');
    
    Route::get('/finalis/{id_lomba}', [FinalisController::class, 'index'])->name('finalis.index');
    Route::post('/finalis/{id_lomba}', [FinalisController::class, 'store'])->name('finalis.store');
    Route::delete('/finalis/{id_lomba}/{id_finalis}', [FinalisController::class, 'destroy'])->name('finalis.destroy');
    Route::post('/finalis/{id_lomba}/aktifkan-final', [FinalisController::class, 'aktifkanFinal'])->name('finalis.aktifkan-final');
    
    Route::get('/nilai', [NilaiController::class, 'index'])->name('nilai.index');
    Route::get('/nilai/create/{id_lomba}', [NilaiController::class, 'create'])->name('nilai.create');
    Route::post('/nilai', [NilaiController::class, 'store'])->name('nilai.store');

    Route::get('/dashboard/penghargaan', [PenghargaanController::class, 'index'])->name('penghargaan.index');
    Route::post('/dashboard/penghargaan', [PenghargaanController::class, 'store'])->name('penghargaan.store');
    Route::put('/dashboard/penghargaan/{id}', [PenghargaanController::class, 'update'])->name('penghargaan.update');
    Route::post('/dashboard/penghargaan/{id}/assign-tim', [PenghargaanController::class, 'assignTim'])->name('penghargaan.assignTim');
    Route::delete('/dashboard/penghargaan/{id}', [PenghargaanController::class, 'destroy'])->name('penghargaan.destroy');
});

Route::middleware(['auth', 'super_admin'])->group(function () {
    
    Route::get('/admin/dashboard', [SuperAdminDashboardController::class, 'index'])->name('admin.dashboard');
    
    Route::resource('admin', PanitiaController::class);
    
    Route::resource('juri_lomba', JuriLombaController::class);
    Route::get('/get-juri-by-lomba/{id_lomba}', [JuriLombaController::class, 'getJuriByLomba'])->name('get.juri.by.lomba');
});