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
        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
        // route lain akan ditambahkan step berikutnya
    });

// ── Mahasiswa Routes ──────────────────────────────────────
Route::prefix('mahasiswa')
    ->name('mahasiswa.')
    ->middleware(['auth', 'role:mahasiswa'])
    ->group(function () {
        Route::get('/dashboard', [MahasiswaDashboard::class, 'index'])->name('dashboard');
        // route lain akan ditambahkan step berikutnya
    });