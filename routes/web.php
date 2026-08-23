<?php
// routes/web.php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\LombaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TimController;
use App\Http\Controllers\PanitiaController;
use App\Http\Controllers\SuperAdminDashboardController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\JuriController;
use App\Http\Controllers\JuriLombaController;
use App\Http\Controllers\PenilaianController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'super_admin'])->group(function () {
    Route::get('/admin/dashboard', [SuperAdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('admin', PanitiaController::class);
    Route::resource('kriteria', KriteriaController::class);
    Route::resource('juri', JuriController::class);    
    Route::resource('penilaian', PenilaianController::class);
    Route::resource('juri_lomba', JuriLombaController::class);
    Route::get('/get-juri-by-lomba/{id_lomba}', [JuriLombaController::class, 'getJuriByLomba'])->name('get.juri.by.lomba');
    Route::get('/penilaian/rekap', [PenilaianController::class, 'rekap'])->name('penilaian.rekap');
});

Route::middleware(['auth', 'panitia'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
    Route::resource('panitia', TimController::class);
    Route::resource('lomba', LombaController::class);
    Route::post('/lomba/{id}/tim', [LombaController::class, 'tambahTim'])->name('lomba.tambah-tim');
    Route::delete('/lomba/{id}/tim/{id_tim}', [LombaController::class, 'hapusTim'])->name('lomba.hapus-tim');
    Route::get('/juri/penilaian', [PenilaianController::class, 'juriPenilaian'])->name('juri.penilaian');
    Route::post('/juri/penilaian/store', [PenilaianController::class, 'juriStore'])->name('juri.penilaian.store');
});
