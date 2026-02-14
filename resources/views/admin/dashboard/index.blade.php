@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-home"></i>
        </span> Dashboard Koleksi Buku
    </h3>
</div>

<div class="row">
    <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-danger card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute" />
                <h4 class="font-weight-normal mb-3">Total Buku <i class="mdi mdi-chart-line mdi-24px float-end"></i></h4>
                <h2 class="mb-5">{{ $totalBuku }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-info card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute" />
                <h4 class="font-weight-normal mb-3">Kategori <i class="mdi mdi-bookmark-outline mdi-24px float-end"></i></h4>
                <h2 class="mb-5">{{ $totalKategori }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4 stretch-card grid-margin">
        <div class="card bg-gradient-success card-img-holder text-white">
            <div class="card-body">
                <img src="{{ asset('assets/images/dashboard/circle.svg') }}" class="card-img-absolute" />
                <h4 class="font-weight-normal mb-3">Penulis Unik <i class="mdi mdi-diamond mdi-24px float-end"></i></h4>
                <h2 class="mb-5">{{ $totalPenulis }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Buku Terbaru</h4>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th> Judul & Pengarang </th>
                                <th> Kategori </th>
                                <th> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bukuTerbaru as $b)
                            <tr>
                                <td>
                                    <span class="font-weight-bold">{{ $b->judul }}</span><br>
                                    <small class="text-muted">{{ $b->pengarang }}</small>
                                </td>
                                <td><label class="badge badge-gradient-info">{{ $b->nama_kategori }}</label></td>
                                <td><a href="{{ route('buku.edit', $b->idbuku) }}" class="btn btn-sm btn-outline-primary">Edit</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection