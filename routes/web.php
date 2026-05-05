<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; 
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Site\SiteController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\GoogleController; 
use App\Http\Controllers\PdfController; 
use App\Http\Controllers\Admin\BarangController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\MenuController; 
use App\Http\Controllers\MidtransWebhookController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\VendorOrderController;
use App\Http\Controllers\Admin\ScannerController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

// --- PUBLIK ---
Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role == 'admin') {
            return redirect()->route('dashboard');
        } 
        if (Auth::user()->role == 'vendor' || Auth::user()->idvendor != null) {
            return redirect()->route('vendor.index');
        }
    }
    return view('index'); 
})->name('site.home');

Route::get('/cek-koneksi', [SiteController::class, 'cekKoneksi'])->name('site.cek-koneksi');

// --- AUTH MANUAL ---
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// --- GOOGLE AUTH & OTP ---
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
Route::get('/verify-otp', [GoogleController::class, 'showOtpForm'])->name('otp.view');
Route::post('/verify-otp', [GoogleController::class, 'verifyOtp'])->name('otp.verify');

// --- CUSTOMER (MODUL 7: AKSES KAMERA) ---
Route::get('/customer/create', [CustomerController::class, 'create'])->name('customer.create');
Route::post('/customer/store', [CustomerController::class, 'store'])->name('customer.store');

// --- KANTIN POS & API ---
Route::get('/pos', function () {
    $vendors = \App\Models\Vendor::all(); 
    return view('pesanan.pos', compact('vendors'));
})->name('pos.index');

Route::prefix('api')->group(function () {
    Route::get('/vendor', [MenuController::class, 'getAllVendor'])->name('api.vendor');
    Route::get('/menu/vendor/{idvendor}', [MenuController::class, 'getMenuByVendor'])->name('api.menu.vendor');
    Route::get('/menu/{idmenu}', [MenuController::class, 'getMenuDetail'])->name('api.menu.detail');
    
    // [MODUL 8] API Lookup untuk Scanner
    Route::get('/scanner/barang/{id}', [ScannerController::class, 'getBarangDetail'])->name('api.scanner.barang');
    Route::get('/scanner/pesanan/{id}', [ScannerController::class, 'getPesananDetail'])->name('api.scanner.pesanan');
});

Route::post('/pesanan/store-guest', [PesananController::class, 'storePesananGuest'])->name('pesanan.store-guest');
Route::get('/pesanan/detail/{idpesanan}', [PesananController::class, 'getPesananDetail'])->name('pesanan.detail');
Route::post('/pesanan/checkout', [PesananController::class, 'checkout'])->name('pesanan.checkout');
Route::post('/pesanan/simulasi', [PesananController::class, 'storePesananSimulasi'])->name('pesanan.simulasi');
Route::get('/pesanan/invoice/{id}', [PesananController::class, 'showInvoice'])->name('pesanan.invoice');

Route::post('/midtrans/notification', [MidtransWebhookController::class, 'handle'])
    ->withoutMiddleware([VerifyCsrfToken::class])
    ->name('midtrans.notification');


// --- VENDOR ---
Route::middleware(['auth', 'isVendor'])->group(function () {
    Route::get('/vendor/kelola-menu', [MenuController::class, 'index'])->name('vendor.index');
    Route::post('/vendor/menu/store', [MenuController::class, 'store'])->name('menu.store');
    Route::get('/vendor/menu/{id}', [MenuController::class, 'show'])->name('menu.show');
    Route::get('/vendor/menu/{id}/edit', [MenuController::class, 'edit'])->name('menu.edit');
    Route::put('/vendor/menu/{id}', [MenuController::class, 'update'])->name('menu.update');
    Route::delete('/vendor/menu/{id}', [MenuController::class, 'destroy'])->name('menu.destroy');
    Route::get('/vendor/pesanan-lunas', [VendorOrderController::class, 'paidOrders'])->name('vendor.pesanan-lunas');

    // [MODUL 8] Praktikum 2: Vendor Scan QR Customer
    Route::get('/vendor/scan-pesanan', [ScannerController::class, 'scanPesanan'])->name('vendor.scan');
});


// --- ADMIN ---
Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('kategori', KategoriController::class);
    Route::resource('buku', BukuController::class);

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/cetak-sertifikat', [PdfController::class, 'generateSertifikat'])->name('pdf.sertifikat');
    Route::get('/cetak-pengumuman', [PdfController::class, 'generatePengumuman'])->name('pdf.pengumuman');

    Route::resource('barang', BarangController::class);
    Route::post('/barang/cetak', [BarangController::class, 'cetak'])->name('barang.cetak');
    Route::get('/tabel-barang', function () { return view('admin.tabel_barang.index'); })->name('tabel_barang.index');
    Route::get('/tabel-barang-dt', function () { return view('admin.tabel_barang.datatables'); })->name('tabel_barang.dt');

    // [MODUL 8] Praktikum 1: Admin Scan Barcode Barang
    Route::get('/scan-barang', [ScannerController::class, 'scanBarang'])->name('admin.scan');

    Route::get('/kota', function () { return view('admin.kota.index'); })->name('kota.index');

    Route::prefix('kasir')->group(function () {
        Route::get('/ajax', [App\Http\Controllers\Admin\KasirController::class, 'indexAjax'])->name('kasir.ajax');
        Route::get('/axios', [App\Http\Controllers\Admin\KasirController::class, 'indexAxios'])->name('kasir.axios');
        Route::post('/cek-barang', [App\Http\Controllers\Admin\KasirController::class, 'cekBarang'])->name('kasir.cekBarang');
        Route::post('/bayar', [App\Http\Controllers\Admin\KasirController::class, 'bayar'])->name('kasir.bayar');
    });

    Route::prefix('wilayah')->group(function () {
        Route::get('/ajax', [App\Http\Controllers\Admin\WilayahController::class, 'indexAjax'])->name('wilayah.ajax');
        Route::get('/axios', [App\Http\Controllers\Admin\WilayahController::class, 'indexAxios'])->name('wilayah.axios');
    });

    Route::resource('user', UserController::class);
});