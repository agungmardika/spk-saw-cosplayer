<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CosplayerController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\PenilaianController;
use App\Http\Controllers\SawController;

// Autentikasi
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Profil & Pengaturan Akun
    Route::get('/profil', [AuthController::class, 'profile'])->name('profile');
    Route::put('/profil', [AuthController::class, 'updateProfile'])->name('profile.update');

    // Master Data Cosplayer
    Route::resource('cosplayer', CosplayerController::class)->except(['show']);

    // Master Data Kriteria
    Route::get('/kriteria', [KriteriaController::class, 'index'])->name('kriteria.index');
    Route::get('/kriteria/{kriteria}/edit', [KriteriaController::class, 'edit'])->name('kriteria.edit');
    Route::put('/kriteria/{kriteria}', [KriteriaController::class, 'update'])->name('kriteria.update');
    Route::post('/kriteria/reset-default', [KriteriaController::class, 'resetDefault'])->name('kriteria.reset');

    // Penilaian Juri
    Route::get('/penilaian', [PenilaianController::class, 'index'])->name('penilaian.index');
    Route::post('/penilaian', [PenilaianController::class, 'storeOrUpdate'])->name('penilaian.store');
    Route::get('/penilaian/{cosplayer}/edit', [PenilaianController::class, 'edit'])->name('penilaian.edit');
    Route::put('/penilaian/{cosplayer}', [PenilaianController::class, 'update'])->name('penilaian.update');

    // Perhitungan Metode SAW
    Route::get('/perhitungan-saw', [SawController::class, 'index'])->name('saw.index');
    Route::post('/perhitungan-saw/hitung', [SawController::class, 'recalculate'])->name('saw.recalculate');

    // Hasil Perangkingan (Sesuai Gambar 3.11 Skripsi)
    Route::get('/hasil-perangkingan', [SawController::class, 'perangkingan'])->name('saw.ranking');

    // Laporan Hasil Keputusan
    Route::get('/laporan', [SawController::class, 'laporan'])->name('saw.laporan');
});
