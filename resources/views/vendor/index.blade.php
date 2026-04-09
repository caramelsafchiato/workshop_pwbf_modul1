@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-info text-white me-2">
            <i class="mdi mdi-food"></i>
        </span> Kelola Menu Kantin
    </h3>
    <button type="button" class="btn btn-gradient-primary btn-icon-text" data-bs-toggle="modal" data-bs-target="#modalTambahMenu">
        <i class="mdi mdi-plus btn-icon-prepend"></i> Tambah Menu Baru
    </button>
</div>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Daftar Makanan & Minuman</h4>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th> Foto </th>
                                <th> Nama Menu </th>
                                <th> Harga </th>
                                <th> Vendor </th>
                                <th> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($menus as $menu)
                                <tr>
                                    <td class="py-1">
                                        <img src="{{ $menu->path_gambar ? asset('storage/'.$menu->path_gambar) : asset('assets/images/no-image.png') }}" alt="image" />
                                    </td>
                                    <td> {{ $menu->nama_menu }} </td>
                                    <td> Rp {{ number_format($menu->harga, 0, ',', '.') }} </td>
                                    <td> {{ $menu->vendor->nama_vendor ?? 'Vendor Tidak Ditemukan' }} </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-inverse-warning" data-bs-toggle="modal" data-bs-target="#modalEditMenu{{ $menu->idmenu }}">
                                            Edit
                                        </button>
                                        
                                        <form action="{{ route('menu.destroy', $menu->idmenu) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-inverse-danger" onclick="return confirm('Yakin mau hapus menu ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>

                                <div class="modal fade" id="modalEditMenu{{ $menu->idmenu }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Menu: {{ $menu->nama_menu }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('menu.update', $menu->idmenu) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label>Nama Menu</label>
                                                        <input type="text" name="nama_menu" class="form-control" value="{{ $menu->nama_menu }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Harga (Rp)</label>
                                                        <input type="number" name="harga" class="form-control" value="{{ $menu->harga }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Pilih Vendor / Toko</label>
                                                        <select name="idvendor" class="form-control" required>
                                                            @foreach($vendors as $v)
                                                                <option value="{{ $v->idvendor }}" {{ $menu->idvendor == $v->idvendor ? 'selected' : '' }}>
                                                                    {{ $v->nama_vendor }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Update Menu</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada menu yang didaftarkan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahMenu" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Menu Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('menu.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Menu</label>
                        <input type="text" name="nama_menu" class="form-control" placeholder="Contoh: Nasi Goreng Gila" required>
                    </div>
                    <div class="form-group">
                        <label>Harga (Rp)</label>
                        <input type="number" name="harga" class="form-control" placeholder="15000" required>
                    </div>
                    <div class="form-group">
                        <label>Pilih Vendor / Toko</label>
                        <select name="idvendor" class="form-control" required>
                            <option value="">-- Pilih Vendor --</option>
                            @foreach($vendors as $v)
                                <option value="{{ $v->idvendor }}" {{ Auth::user()->idvendor == $v->idvendor ? 'selected' : '' }}>
                                    {{ $v->nama_vendor }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Path Gambar (Opsional)</label>
                        <input type="text" name="path_gambar" class="form-control" placeholder="menu/nasgor.jpg">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Menu</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection