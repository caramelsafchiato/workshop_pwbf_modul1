<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Site\SiteController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\GoogleController; 
use App\Http\Controllers\PdfController; // 1. IMPORT CONTROLLER PDF

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

// --- Rute Google Auth (Poin b) ---
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

// --- Rute Verifikasi OTP (Poin d) ---
Route::get('/verify-otp', [GoogleController::class, 'showOtpForm'])->name('otp.view');
Route::post('/verify-otp', [GoogleController::class, 'verifyOtp'])->name('otp.verify');

// --- Rute Halaman Depan ---
Route::get('/', [SiteController::class, 'index'])->name('site.home');
Route::get('/cek-koneksi', [SiteController::class, 'cekKoneksi'])->name('site.cek-koneksi');

// --- Route Group Admin (Proteksi Ganda) ---
Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {
    
    // Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CRUD Kategori & Buku
    Route::resource('kategori', KategoriController::class);
    Route::resource('buku', BukuController::class);

    // Fitur Profil
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // --- FITUR PDF GENERATOR (Studi Kasus 2) ---
    // Poin a: Format Landscape A4 (Sertifikat)
    Route::get('/cetak-sertifikat', [PdfController::class, 'generateSertifikat'])->name('pdf.sertifikat');

    // Poin b: Format Portrait A4 + Header (Pengumuman)
    Route::get('/cetak-pengumuman', [PdfController::class, 'generatePengumuman'])->name('pdf.pengumuman');
});