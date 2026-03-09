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
                
                <form id="mainForm" action="{{ route('kategori.store') }}" method="POST">
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
                </form>

                <div class="mt-4">
                    <button type="button" id="submitBtn" class="btn btn-gradient-primary me-2" onclick="processForm()">
                        <span id="btnText">Simpan Kategori</span>
                        
                        <span id="spinnerIcon" style="display: none;">
                            <i class="mdi mdi-loading mdi-spin"></i> Loading...
                        </span>
                    </button>
                    <a href="{{ route('kategori.index') }}" class="btn btn-light">Batal</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .mdi-spin {
        display: inline-block;
        animation: mdi-spin 2s infinite linear;
    }
    @keyframes mdi-spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(359deg); }
    }
</style>

<script>
    function processForm() {
        const form = document.getElementById('mainForm');
        const btn = document.getElementById('submitBtn');
        const text = document.getElementById('btnText');
        const loader = document.getElementById('spinnerIcon');

        // (c.i) Check validity HTML5 melalui Javascript
        if (form.checkValidity()) {
            // (c.iii) Jika valid, ubah button jadi spinner & disable untuk hindari double submit
            btn.disabled = true;
            text.style.display = 'none';
            loader.style.display = 'inline-block';

            // Submit form secara manual
            form.submit();
        } else {
            // (c.ii) Jika kosong, tunjukkan input mana yang error
            form.reportValidity();
        }
    }
</script>
@endsection