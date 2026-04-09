@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Tambah Alat Tulis Baru</h4>
        <form action="{{ route('menu.store') }}" method="POST" class="forms-sample">
            @csrf
            <div class="form-group">
                <label>Nama Barang</label>
                <input type="text" name="nama_menu" class="form-control" placeholder="Contoh: Pensil 2B" required>
            </div>
            <div class="form-group">
                <label>Harga (Rp)</label>
                <input type="number" name="harga" class="form-control" placeholder="3000" required>
            </div>
            <div class="form-group">
                <label>Pilih Vendor</label>
                <select name="idvendor" class="form-control" required>
                    <option value="">-- Pilih Vendor --</option>
                    @foreach($vendors as $v)
                        <option value="{{ $v->idvendor }}">{{ $v->nama_vendor }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-gradient-primary me-2">Simpan</button>
            <a href="{{ route('vendor.index') }}" class="btn btn-light">Batal</a>
        </form>
    </div>
</div>
@endsection