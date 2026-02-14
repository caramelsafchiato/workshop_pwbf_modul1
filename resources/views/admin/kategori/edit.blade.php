@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-pencil"></i>
        </span> Edit Kategori
    </h3>
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('kategori.index') }}">Kategori</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ul>
    </nav>
</div>

<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Form Perubahan Kategori</h4>
                <p class="card-description"> Ubah nama kategori sesuai kebutuhan sistem </p>
                
                <form class="forms-sample" action="{{ route('kategori.update', $kategori->idkategori) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="namaKategori">Nama Kategori</label>
                        <input type="text" 
                               name="nama_kategori" 
                               class="form-control @error('nama_kategori') is-invalid @enderror" 
                               id="namaKategori" 
                               placeholder="Contoh: Novel, Teknologi, dll" 
                               value="{{ old('nama_kategori', $kategori->nama_kategori) }}" 
                               required>
                        
                        @error('nama_kategori')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-gradient-primary me-2">Update Data</button>
                    <a href="{{ route('kategori.index') }}" class="btn btn-light">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection