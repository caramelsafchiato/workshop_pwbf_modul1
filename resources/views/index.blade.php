@extends('layouts.app')

@section('content')
<div class="row flex-grow">
    <div class="col-lg-8 mx-auto">
        <div class="card text-center shadow-sm border-0" style="border-radius: 20px;">
            <div class="card-body p-5">
                <div class="mb-4">
                    <img src="{{ asset('assets/images/logo.svg') }}" alt="logo" style="width: 180px;">
                </div>
                
                <h1 class="display-4 font-weight-bold text-primary mb-3">
                    Sistem Informasi Koleksi Buku
                </h1>
                
                <p class="lead text-muted mb-5">
                    Selamat datang di platform manajemen literasi. 
                    Silakan masuk untuk mengelola kategori, daftar buku, dan profil admin kamu.
                </p>

                <div class="row justify-content-center gap-3">
                    <div class="col-md-4">
                        <a href="{{ route('login') }}" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium w-100">
                            <i class="mdi mdi-login me-2"></i> MASUK
                        </a>
                    </div>
                    <div class="col-md-4">
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
@endsection