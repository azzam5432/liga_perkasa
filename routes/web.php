<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\LombaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TimController;
use App\Models\Peserta;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('admin', TimController::class);
    Route::resource('lomba', LombaController::class);
    Route::prefix('lomba')->name('lomba.')->group(function () {
        Route::post('/{id}/tim', [LombaController::class, 'tambahTim'])->name('tambah-tim');
        Route::delete('/{id}/tim/{id_tim}', [LombaController::class, 'hapusTim'])->name('hapus-tim');
    });
});


