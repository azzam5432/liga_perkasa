<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\LombaController;
use App\Http\Controllers\DashboardController;
use App\Models\Peserta;
use Illuminate\Support\Facades\Route;

// route untuk login logout
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
});

Route::resource('admin', LombaController::class);
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('peserta', LombaController::class);
