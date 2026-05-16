@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title">Daftar Lokasi Toko</h3>
</div>

<div class="mb-3">
    <a href="{{ route('lokasitoko.create') }}" class="btn btn-primary">Tambah Lokasi Toko</a>
    <a href="{{ route('lokasitoko.scan') }}" class="btn btn-info">Scan & Validasi Kunjungan</a>
    <a href="{{ route('lokasitoko.history') }}" class="btn btn-dark">
        <i class="mdi mdi-history"></i> Riwayat Kunjungan
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Barcode</th>
                    <th>QR</th>
                    <th>Nama Toko</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th>Accuracy (m)</th>
                </tr> 
            </thead>
            <tbody>
                @foreach($list as $it)
                <tr>
                    <td>{{ $it->barcode }}</td>
                    <td>{!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(100)->generate($it->barcode) !!}</td>
                    <td>{{ $it->nama_toko }}</td>
                    <td>{{ $it->latitude }}</td>
                    <td>{{ $it->longitude }}</td>
                    <td>{{ $it->accuracy }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
