<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang - Sistem Informasi Koleksi Buku</title>
    
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    
    <style>
        .full-height {
            min-height: 100vh;
            display: flex;
            align-items: center;
            background: linear-gradient(to right, #da8ee7, #844fc1); 
        }
        .card {
            transition: transform 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
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
                            Silakan masuk untuk mengelola kategori, daftar buku, dan profil kamu.
                        </p>

                        <div class="row justify-content-center">
                            @guest
                                <div class="col-md-4 mb-3">
                                    <a href="{{ route('login') }}" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium w-100">
                                        <i class="mdi mdi-login me-2"></i> MASUK
                                    </a>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <a href="{{ route('register') }}" class="btn btn-block btn-outline-primary btn-lg font-weight-medium w-100">
                                        <i class="mdi mdi-account-plus me-2"></i> DAFTAR
                                    </a>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <a href="{{ route('pos.index') }}" class="btn btn-block btn-gradient-info btn-lg font-weight-medium w-100 text-white">
                                        <i class="mdi mdi-cart me-2"></i> KE KANTIN
                                    </a>
                                </div>
                            @else
                                <div class="col-md-10 mb-3">
                                    <h4 class="mb-3 text-dark">Halo, {{ Auth::user()->nama }}! Kamu sudah masuk.</h4>
                                    
                                    @if(Auth::user()->role == 'admin')
                                        <a href="{{ route('dashboard') }}" class="btn btn-block btn-gradient-info btn-lg font-weight-medium w-100">
                                            <i class="mdi mdi-view-dashboard me-2"></i> KE DASHBOARD ADMIN
                                        </a>
                                    @elseif(Auth::user()->idvendor != null || Auth::user()->role == 'vendor')
                                        <a href="{{ route('vendor.index') }}" class="btn btn-block btn-gradient-success btn-lg font-weight-medium w-100">
                                            <i class="mdi mdi-store me-2"></i> KE MENU VENDOR
                                        </a>
                                    @else
                                        <a href="{{ url('/') }}" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium w-100">
                                            <i class="mdi mdi-home me-2"></i> KE HALAMAN UTAMA
                                        </a>
                                    @endif
                                </div>

                                <div class="col-md-10 mb-3">
                                    <a href="{{ route('pos.index') }}" class="btn btn-block btn-outline-info btn-lg font-weight-medium w-100">
                                        <i class="mdi mdi-shopping me-2"></i> BELANJA DI KANTIN (POS)
                                    </a>
                                </div>
                                
                                <div class="col-md-10">
                                    <form action="{{ route('logout') }}" method="POST" class="mt-2">
                                        @csrf
                                        <button type="submit" class="btn btn-link text-danger text-decoration-none p-0">
                                            Bukan kamu? Keluar (Logout)
                                        </button>
                                    </form>
                                </div>
                            @endguest
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