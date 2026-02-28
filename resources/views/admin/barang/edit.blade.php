@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Tambah Barang Baru </h3>
    <nav aria-label="breadcrumb">
        <a href="{{ route('barang.index') }}" class="btn btn-light btn-icon-text">
            <i class="mdi mdi-arrow-left btn-icon-prepend"></i> Kembali
        </a>
    </nav>
</div>

<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Form Input Barang UMKM</h4>
                <p class="card-description"> Masukkan detail barang untuk label harga </p>
                
                <form class="forms-sample" action="{{ route('barang.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="nama">Nama Barang</label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" 
                               id="nama" placeholder="Contoh: Kertas A4" value="{{ old('nama') }}" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="harga">Harga (Rp)</label>
                        <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror" 
                               id="harga" placeholder="Masukkan angka saja" value="{{ old('harga') }}" required>
                        @error('harga')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-gradient-primary me-2">Simpan Barang</button>
                    <button type="reset" class="btn btn-light">Reset</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection