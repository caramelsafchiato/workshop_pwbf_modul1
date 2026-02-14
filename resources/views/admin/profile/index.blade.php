@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-account"></i>
        </span> Profil Saya
    </h3>
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Profil</li>
        </ul>
    </nav>
</div>

<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title">Informasi Akun</h4>
                    <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-gradient-info btn-icon-text">
                        <i class="mdi mdi-pencil btn-icon-prepend"></i> Edit Profil 
                    </a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="text-center mb-4">
                    <div class="h-24 w-24 rounded-circle bg-gradient-primary d-inline-flex align-items-center justify-content-center text-white mb-3" style="width: 80px; height: 80px;">
                        <h2 class="m-0">{{ strtoupper(substr(auth()->user()->nama, 0, 1)) }}</h2>
                    </div>
                    <h4>{{ auth()->user()->nama }}</h4>
                    <p class="text-muted">Administrator Perpus</p>
                </div>

                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span class="text-muted"><i class="mdi mdi-account-card-details me-2"></i> ID Pengguna</span>
                        <span class="font-weight-bold text-dark">#{{ auth()->user()->iduser }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span class="text-muted"><i class="mdi mdi-email-outline me-2"></i> Email</span>
                        <span class="font-weight-bold text-dark">{{ auth()->user()->email }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span class="text-muted"><i class="mdi mdi-shield-check me-2"></i> Hak Akses</span>
                        <span class="badge badge-gradient-success">{{ ucfirst(auth()->user()->role ?? 'Admin') }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection