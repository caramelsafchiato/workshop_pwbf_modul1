<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Site\SiteController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- Rute Autentikasi Manual ---
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// --- Rute Halaman Depan ---
Route::get('/', [SiteController::class, 'index'])->name('site.home');
Route::get('/cek-koneksi', [SiteController::class, 'cekKoneksi'])->name('site.cek-koneksi');

// --- Route Group Admin (Proteksi Ganda) ---
// 1. 'auth' memastikan user sudah login.
// 2. 'isAdmin' memastikan user memiliki role 'admin'.
Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {
    
    // Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CRUD Kategori
    Route::resource('kategori', KategoriController::class);

    // CRUD Buku
    Route::resource('buku', BukuController::class);

    // Fitur Profil
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});