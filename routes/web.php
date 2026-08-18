<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\LombaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TimController;
use App\Http\Controllers\PanitiaController;
use App\Models\Peserta;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'super_admin'])->group(function () {
    Route::resource('admin', PanitiaController::class);
});

Route::middleware(['auth', 'panitia'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('panitia', TimController::class);

    // route profile
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/update-password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');

    // route lomba
    Route::resource('lomba', LombaController::class);
    Route::prefix('lomba')->name('lomba.')->group(function () {
        Route::post('/{id}/tim', [LombaController::class, 'tambahTim'])->name('tambah-tim');
        Route::delete('/{id}/tim/{id_tim}', [LombaController::class, 'hapusTim'])->name('hapus-tim');
    });
});


