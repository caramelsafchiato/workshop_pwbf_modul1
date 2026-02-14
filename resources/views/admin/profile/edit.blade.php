<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Profil - Admin Perpus</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
    <div class="max-w-lg mx-auto bg-white rounded-xl shadow-md border border-gray-200">
        <div class="p-6 border-b border-gray-100">
            <h2 class="text-xl font-bold text-gray-800">Ubah Data Diri</h2>
        </div>

        <form action="{{ route('profile.update') }}" method="POST" class="p-8">
            @csrf
            @method('PUT')

            <div class="space-y-5">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" name="nama" value="{{ auth()->user()->nama }}" 
                           class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" required>
                </div>

                <div>
                    <label class="block text-sm fon@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-account-edit"></i>
        </span> Ubah Data Diri
    </h3>
</div>

<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Form Pembaruan Profil</h4>
                <p class="card-description"> Pastikan email Anda tetap aktif untuk koordinasi sistem </p>
                
                <form class="forms-sample" action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="inputNama">Nama Lengkap</label>
                        <input type="text" 
                               name="nama" 
                               class="form-control @error('nama') is-invalid @enderror" 
                               id="inputNama" 
                               value="{{ old('nama', auth()->user()->nama) }}" 
                               required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="inputEmail">Alamat Email</label>
                        <input type="email" 
                               name="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="inputEmail" 
                               value="{{ old('email', auth()->user()->email) }}" 
                               required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-gradient-primary me-2">Simpan Perubahan</button>
                        <a href="{{ route('profile.index') }}" class="btn btn-light">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsectiont-semibold text-gray-700 mb-2">Alamat Email</label>
                    <input type="email" name="email" value="{{ auth()->user()->email }}" 
                           class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-blue-500 outline-none" required>
                </div>
            </div>

            <div class="mt-8 flex gap-3">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 font-semibold transition">Simpan</button>
                <a href="{{ route('profile.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition">Batal</a>
            </div>
        </form>
    </div>
</body>
</html>