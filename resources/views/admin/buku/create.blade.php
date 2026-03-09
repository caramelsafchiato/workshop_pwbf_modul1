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
                <form id="formBuku" class="forms-sample" action="{{ route('buku.store') }}" method="POST">
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
                        <input type="text" name="pengarang" class="form-control" placeholder="Nama penulis" value="{{ old('pengarang') }}"required>
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
                </form>

                <div class="mt-3">
                    <button type="button" id="btnSimpan" class="btn btn-gradient-primary me-2" onclick="submitBuku()">
                        <span id="textBtn">Simpan Koleksi</span>
                        <span id="loaderBtn" style="display: none;">
                            <i class="mdi mdi-loading mdi-spin"></i> Menyimpan...
                        </span>
                    </button>
                    <a href="{{ route('buku.index') }}" class="btn btn-light">Batal</a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* CSS untuk memastikan icon berputar */
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
    function submitBuku() {
        const form = document.getElementById('formBuku');
        const btn = document.getElementById('btnSimpan');
        const text = document.getElementById('textBtn');
        const loader = document.getElementById('loaderBtn');

        // (c.i) Check validity HTML5 melalui Javascript
        if (form.checkValidity()) {
            // (c.iii) Jika valid, aktifkan spinner & disable button
            btn.disabled = true;
            text.style.display = 'none';
            loader.style.display = 'inline-block';

            // Eksekusi submit
            form.submit();
        } else {
            // (c.ii) Jika input required belum lengkap, tunjukkan errornya
            form.reportValidity();
        }
    }
</script>
@endsection