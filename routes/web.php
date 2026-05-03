<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Mahasiswa\DashboardController as MahasiswaDashboard;
use Illuminate\Support\Facades\Route;

// ── Root: redirect ke login ───────────────────────────────
Route::get('/', fn() => redirect()->route('login'));

// ── Auth Routes ───────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});

Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ── Admin Routes ──────────────────────────────────────────
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

        // Manajemen Admin (FR-02)
        Route::resource('manajemen-admin', \App\Http\Controllers\Admin\ManajemenAdminController::class);

        // Pengaturan Sistem
        Route::get('/pengaturan', [\App\Http\Controllers\Admin\PengaturanController::class, 'index'])->name('pengaturan.index');
        Route::post('/pengaturan', [\App\Http\Controllers\Admin\PengaturanController::class, 'update'])->name('pengaturan.update');

        // Kelola Kriteria (FR-03, FR-04)
        Route::resource('kriteria', \App\Http\Controllers\Admin\KriteriaController::class);

        // Kelola Sub Kriteria (FR-05)
        Route::resource('sub-kriteria', \App\Http\Controllers\Admin\SubKriteriaController::class);

        // Data Pendaftar (FR-06, FR-07)
        Route::resource('pendaftar', \App\Http\Controllers\Admin\PendaftarController::class);
        Route::post('/pendaftar/{pendaftar}/verifikasi', [\App\Http\Controllers\Admin\PendaftarController::class, 'verifikasi'])->name('pendaftar.verifikasi');
        Route::post('/pendaftar/{pendaftar}/tolak', [\App\Http\Controllers\Admin\PendaftarController::class, 'tolak'])->name('pendaftar.tolak');

        // Eksekusi SAW (FR-08 s/d FR-11)
        Route::get('/saw', [\App\Http\Controllers\Admin\SawController::class, 'index'])->name('saw.index');
        Route::post('/saw/hitung', [\App\Http\Controllers\Admin\SawController::class, 'hitung'])->name('saw.hitung');
        Route::get('/saw/hasil', [\App\Http\Controllers\Admin\SawController::class, 'hasil'])->name('saw.hasil');

        // Laporan (FR-12)
        Route::get('/laporan', [\App\Http\Controllers\Admin\LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/cetak', [\App\Http\Controllers\Admin\LaporanController::class, 'cetak'])->name('laporan.cetak');
        Route::get('/laporan/export-pdf', [\App\Http\Controllers\Admin\LaporanController::class, 'exportPdf'])->name('laporan.export-pdf');

    });

// ── Mahasiswa Routes ──────────────────────────────────────
Route::prefix('mahasiswa')
    ->name('mahasiswa.')
    ->middleware(['auth', 'role:mahasiswa'])
    ->group(function () {
        Route::get('/dashboard', [MahasiswaDashboard::class, 'index'])->name('dashboard');
        Route::get('/pengumuman', [\App\Http\Controllers\Mahasiswa\PengumumanController::class, 'index'])->name('pengumuman');
    });