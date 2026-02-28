@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-tag-outline"></i>
        </span> Manajemen Tag Harga UMKM
    </h3>
    <nav aria-label="breadcrumb">
        <a href="{{ route('barang.create') }}" class="btn btn-gradient-success btn-icon-text">
            <i class="mdi mdi-plus btn-icon-prepend"></i> Tambah Barang 
        </a>
    </nav>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Daftar Barang & Pengaturan Cetak Label</h4>
                <p class="card-description">Pilih barang dan tentukan koordinat awal cetak (Kertas TnJ No. 108)</p>
                
                <form action="{{ route('barang.cetak') }}" method="POST" target="_blank" id="printForm">
                    @csrf
                    
                    <div class="row mb-4 p-3 bg-light border rounded mx-0">
                        <div class="col-md-3">
                            <label class="form-label font-weight-bold">Mulai Kolom (X: 1-5)</label>
                            <input type="number" name="x" class="form-control" value="1" min="1" max="5" required>
                            <small class="text-muted">Horizontal (1-5)</small>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label font-weight-bold">Mulai Baris (Y: 1-8)</label>
                            <input type="number" name="y" class="form-control" value="1" min="1" max="8" required>
                            <small class="text-muted">Vertikal (1-8)</small>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-gradient-primary btn-icon-text w-100">
                                <i class="mdi mdi-printer btn-icon-prepend"></i> Cetak Label Dipilih
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover" id="barangTable">
                            <thead>
                                <tr class="bg-light">
                                    <th> <input type="checkbox" id="selectAll"> </th>
                                    <th> ID Barang </th>
                                    <th> Nama Barang </th>
                                    <th> Harga (Rp) </th>
                                    <th> Aksi </th> </tr>
                            </thead>
                            <tbody>
                                @foreach($barang as $item)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="ids[]" value="{{ $item->id_barang }}" class="barang-checkbox">
                                    </td>
                                    <td> <code>{{ $item->id_barang }}</code> </td>
                                    <td> {{ $item->nama }} </td>
                                    <td> Rp {{ number_format($item->harga, 0, ',', '.') }} </td>
                                    <td>
                                        <a href="{{ route('barang.edit', $item->id_barang) }}" class="btn btn-inverse-warning btn-sm">
                                            <i class="mdi mdi-pencil"></i>
                                        </a>

                                        <button type="button" class="btn btn-inverse-danger btn-sm" onclick="confirmDelete('{{ $item->id_barang }}')">
                                            <i class="mdi mdi-trash-can"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<form id="delete-form" action="" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

[Image of a web-based data management interface showing a table with checkboxes for record selection and action buttons for editing or deleting entries]

<script>
$(document).ready(function() {
    // 1. Inisialisasi DataTables
    $('#barangTable').DataTable({
        "pageLength": 10,
        "language": {
            "search": "Cari Barang:",
            "lengthMenu": "Tampilkan _MENU_ data",
            "zeroRecords": "Barang tidak ditemukan"
        }
    });

    // 2. Fungsi Pilih Semua Checkbox
    $('#selectAll').click(function() {
        $('.barang-checkbox').prop('checked', this.checked);
    });
});

// 3. Fungsi Konfirmasi Hapus
function confirmDelete(id) {
    if (confirm('Apakah Anda yakin ingin menghapus barang ini?')) {
        let form = document.getElementById('delete-form');
        form.action = '/admin/barang/' + id; // Sesuaikan URL dengan route resource kamu
        form.submit();
    }
}
</script>
@endsection