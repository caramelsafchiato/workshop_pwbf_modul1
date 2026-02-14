@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-plus-box"></i>
        </span> Tambah Buku Baru
    </h3>
</div>

<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" action="{{ route('buku.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Kode Buku</label>
                        <input type="text" name="kode" class="form-control @error('kode') is-invalid @enderror" placeholder="Contoh: BUK-001" value="{{ old('kode') }}" required>
                        @error('kode') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label>Judul Buku</label>
                        <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" placeholder="Masukkan judul lengkap" value="{{ old('judul') }}" required>
                        @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label>Pengarang</label>
                        <input type="text" name="pengarang" class="form-control" placeholder="Nama penulis" value="{{ old('pengarang') }}">
                    </div>

                    <div class="form-group">
                        <label>Kategori</label>
                        <select name="idkategori" class="form-control @error('idkategori') is-invalid @enderror" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategori as $k)
                                <option value="{{ $k->idkategori }}" {{ old('idkategori') == $k->idkategori ? 'selected' : '' }}>
                                    {{ $k->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('idkategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn btn-gradient-primary me-2">Simpan Koleksi</button>
                    <a href="{{ route('buku.index') }}" class="btn btn-light">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection