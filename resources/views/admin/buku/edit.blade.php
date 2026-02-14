@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-pencil"></i>
        </span> Edit Data Buku
    </h3>
</div>

<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" action="{{ route('buku.update', $buku->idbuku) }}" method="POST">
                    @csrf @method('PUT')
                    
                    <div class="form-group">
                        <label>Kode Buku</label>
                        <input type="text" name="kode" class="form-control" value="{{ old('kode', $buku->kode) }}" required>
                    </div>

                    <div class="form-group">
                        <label>Judul Buku</label>
                        <input type="text" name="judul" class="form-control" value="{{ old('judul', $buku->judul) }}" required>
                    </div>

                    <div class="form-group">
                        <label>Pengarang</label>
                        <input type="text" name="pengarang" class="form-control" value="{{ old('pengarang', $buku->pengarang) }}">
                    </div>

                    <div class="form-group">
                        <label>Kategori</label>
                        <select name="idkategori" class="form-control" required>
                            @foreach($kategori as $k)
                                <option value="{{ $k->idkategori }}" {{ (old('idkategori', $buku->idkategori) == $k->idkategori) ? 'selected' : '' }}>
                                    {{ $k->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-gradient-primary me-2">Update Buku</button>
                    <a href="{{ route('buku.index') }}" class="btn btn-light">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection