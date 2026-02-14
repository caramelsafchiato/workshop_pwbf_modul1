@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-plus-box"></i>
        </span> Tambah Kategori
    </h3>
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('kategori.index') }}">Kategori</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Baru</li>
        </ul>
    </nav>
</div>

<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Form Kategori Baru</h4>
                <p class="card-description"> Tambahkan kategori buku baru ke dalam sistem perpus </p>
                
                <form class="forms-sample" action="{{ route('kategori.store') }}" method="POST">
                    @csrf
                    
                    <div class="form-group">
                        <label for="namaKategori">Nama Kategori</label>
                        <input type="text" 
                               name="nama_kategori" 
                               class="form-control @error('nama_kategori') is-invalid @enderror" 
                               id="namaKategori" 
                               placeholder="Contoh: Novel, Sains, Religi" 
                               value="{{ old('nama_kategori') }}" 
                               required>
                        
                        @error('nama_kategori')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-gradient-primary me-2">Simpan Kategori</button>
                        <a href="{{ route('kategori.index') }}" class="btn btn-light">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection