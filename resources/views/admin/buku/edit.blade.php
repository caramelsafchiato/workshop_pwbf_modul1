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
                <form id="formEditBuku" class="forms-sample" action="{{ route('buku.update', $buku->idbuku) }}" method="POST">
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
                        <input type="text" name="pengarang" class="form-control" value="{{ old('pengarang', $buku->pengarang) }}"required>
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
                </form>

                <div class="mt-3">
                    <button type="button" id="btnUpdateBuku" class="btn btn-gradient-primary me-2" onclick="handleUpdateBuku()">
                        <span id="textUpdate">Update Buku</span>
                        <span id="loaderUpdate" style="display: none;">
                            <i class="mdi mdi-loading mdi-spin"></i> Menyimpan Perubahan...
                        </span>
                    </button>
                    <a href="{{ route('buku.index') }}" class="btn btn-light">Batal</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* CSS Spinner agar icon MDI berputar */
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
    function handleUpdateBuku() {
        const form = document.getElementById('formEditBuku');
        const btn = document.getElementById('btnUpdateBuku');
        const text = document.getElementById('textUpdate');
        const loader = document.getElementById('loaderUpdate');

        // (c.i) Validasi form menggunakan HTML5 checkValidity
        if (form.checkValidity()) {
            // (c.iii) Jika valid: Disable button, sembunyikan teks, munculkan loader
            btn.disabled = true;
            text.style.display = 'none';
            loader.style.display = 'inline-block';

            // Kirim form
            form.submit();
        } else {
            // (c.ii) Jika tidak valid: Munculkan tooltip error dari browser
            form.reportValidity();
        }
    }
</script>
@endsection