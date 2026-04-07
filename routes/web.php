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
use App\Http\Controllers\PdfController; 
use App\Http\Controllers\Admin\BarangController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\MenuController; 
use App\Http\Controllers\MidtransWebhookController;
use App\Http\Controllers\VendorOrderController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

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

// --- Rute POS (Point of Sale) ---
Route::get('/pos', function () {
    return view('pesanan.pos');
})->name('pos.index');

// --- Rute API AJAX untuk Menu & Vendor ---
Route::prefix('api')->group(function () {
    Route::get('/vendor', [MenuController::class, 'getAllVendor'])->name('api.vendor');
    Route::get('/menu/vendor/{idvendor}', [MenuController::class, 'getMenuByVendor'])->name('api.menu.vendor');
    Route::get('/menu/{idmenu}', [MenuController::class, 'getMenuDetail'])->name('api.menu.detail');
});

// --- Rute Pesanan untuk Guest (Tanpa Login) ---
Route::post('/pesanan/store-guest', [PesananController::class, 'storePesananGuest'])->name('pesanan.store-guest');
Route::get('/pesanan/{idpesanan}', [PesananController::class, 'getPesananDetail'])->name('pesanan.detail');
Route::put('/pesanan/{idpesanan}/status-bayar', [PesananController::class, 'updateStatusBayar'])->name('pesanan.update-status');
Route::post('/midtrans/notification', [MidtransWebhookController::class, 'handle'])
    ->withoutMiddleware([VerifyCsrfToken::class])
    ->name('midtrans.notification');

Route::prefix('vendor')->middleware(['auth', 'isVendor'])->group(function () {
    Route::get('/pesanan-lunas', [VendorOrderController::class, 'paidOrders'])->name('vendor.pesanan-lunas');
});

// --- Route Group Admin (Proteksi Ganda) ---

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

    // --- FITUR PDF GENERATOR ---
    Route::get('/cetak-sertifikat', [PdfController::class, 'generateSertifikat'])->name('pdf.sertifikat');
    Route::get('/cetak-pengumuman', [PdfController::class, 'generatePengumuman'])->name('pdf.pengumuman');

    // Rute Barang (Database)
    Route::resource('barang', BarangController::class);
    Route::post('/barang/cetak', [BarangController::class, 'cetak'])->name('barang.cetak');


    Route::get('/tabel-barang', function () {
        return view('admin.tabel_barang.index');
    })->name('tabel_barang.index');

    // Halaman Kedua: Menggunakan DataTables
    Route::get('/tabel-barang-dt', function () {
        return view('admin.tabel_barang.datatables');
    })->name('tabel_barang.dt');

    Route::get('/kota', function () {
        return view('admin.kota.index');
    })->name('kota.index');

    Route::prefix('admin/kasir')->group(function () {
        // Rute Tampilan
        Route::get('/ajax', [App\Http\Controllers\Admin\KasirController::class, 'indexAjax'])->name('kasir.ajax');
        Route::get('/axios', [App\Http\Controllers\Admin\KasirController::class, 'indexAxios'])->name('kasir.axios');

        // Rute API (Shared/Digunakan bersama)
        Route::post('/cek-barang', [App\Http\Controllers\Admin\KasirController::class, 'cekBarang'])->name('kasir.cekBarang');
        Route::post('/bayar', [App\Http\Controllers\Admin\KasirController::class, 'bayar'])->name('kasir.bayar');
    });

    Route::prefix('wilayah')->group(function () {
        Route::get('/ajax', [App\Http\Controllers\Admin\WilayahController::class, 'indexAjax'])->name('wilayah.ajax');
        Route::get('/axios', [App\Http\Controllers\Admin\WilayahController::class, 'indexAxios'])->name('wilayah.axios');
    });

});
