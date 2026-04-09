@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Edit Barang: {{ $menu->nama_menu }}</h4>
        <form action="{{ route('menu.update', $menu->idmenu) }}" method="POST" class="forms-sample">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Nama Barang</label>
                <input type="text" name="nama_menu" class="form-control" value="{{ $menu->nama_menu }}" required>
            </div>
            <div class="form-group">
                <label>Harga (Rp)</label>
                <input type="number" name="harga" class="form-control" value="{{ $menu->harga }}" required>
            </div>
            <div class="form-group">
                <label>Vendor</label>
                <select name="idvendor" class="form-control" required>
                    @foreach($vendors as $v)
                        <option value="{{ $v->idvendor }}" {{ $menu->idvendor == $v->idvendor ? 'selected' : '' }}>
                            {{ $v->nama_vendor }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-gradient-info me-2">Update</button>
            <a href="{{ route('vendor.index') }}" class="btn btn-light">Batal</a>
        </form>
    </div>
</div>
@endsection