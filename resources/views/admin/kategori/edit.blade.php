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
                
                <form id="formEditKategori" action="{{ route('kategori.update', $kategori->idkategori) }}" method="POST">
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
                </form>

                <div class="mt-4">
                    <button type="button" id="btnUpdate" class="btn btn-gradient-primary me-2" onclick="handleUpdate()">
                        <span id="textUpdate">Update Data</span>
                        <span id="loaderUpdate" style="display: none;">
                            <i class="mdi mdi-loading mdi-spin"></i> Memperbarui...
                        </span>
                    </button>
                    <a href="{{ route('kategori.index') }}" class="btn btn-light">Batal</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Animasi putar untuk icon loading */
    .mdi-spin {
        display: inline-block;
        animation: spin 2s infinite linear;
    }
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
</style>

<script>
    function handleUpdate() {
        const form = document.getElementById('formEditKategori');
        const btn = document.getElementById('btnUpdate');
        const text = document.getElementById('textUpdate');
        const loader = document.getElementById('loaderUpdate');

        if (form.checkValidity()) {
            btn.disabled = true;
            text.style.display = 'none';
            loader.style.display = 'inline-block';

            form.submit();
        } else {
            form.reportValidity();
        }
    }
</script>
@endsection