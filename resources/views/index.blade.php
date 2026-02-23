<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang - Sistem Informasi Koleksi Buku</title>
    
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    
    <style>
        /* Tambahan CSS agar konten tepat di tengah layar */
        .full-height {
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: linear-gradient(to right, #da8ee7, #844fc1); /* Warna gradien ungu */
        }
    </style>
</head>
<body>

<div class="full-height">
    <div class="container">
        <div class="row">
            <div class="col-lg-7 mx-auto">
                <div class="card text-center shadow border-0" style="border-radius: 25px;">
                    <div class="card-body p-5">
                        <div class="mb-4">
                            <img src="{{ asset('assets/images/logo.svg') }}" alt="logo" style="width: 200px;">
                        </div>
                        
                        <h1 class="display-4 font-weight-bold text-primary mb-3">
                            Sistem Informasi Koleksi Buku
                        </h1>
                        
                        <p class="lead text-muted mb-5">
                            Selamat datang di platform manajemen literasi. 
                            Silakan masuk untuk mengelola kategori, daftar buku, dan profil admin kamu.
                        </p>

                        <div class="row justify-content-center">
                            <div class="col-md-5 mb-3">
                                <a href="{{ route('login') }}" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium w-100">
                                    <i class="mdi mdi-login me-2"></i> MASUK
                                </a>
                            </div>
                            <div class="col-md-5 mb-3">
                                <a href="{{ route('register') }}" class="btn btn-block btn-outline-primary btn-lg font-weight-medium w-100">
                                    <i class="mdi mdi-account-plus me-2"></i> DAFTAR
                                </a>
                            </div>
                        </div>

                        <div class="mt-5">
                            <p class="text-small text-muted italic">
                                &copy; {{ date('Y') }} Sistem Manajemen Perpustakaan - Professional Edition
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
</body>
</html>