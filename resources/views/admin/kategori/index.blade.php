@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-bookmark-outline"></i>
        </span> Manajemen Kategori
    </h3>
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Kategori</li>
        </ul>
    </nav>
</div>

<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title">Daftar Kategori Buku</h4>
                    <a href="{{ route('kategori.create') }}" class="btn btn-gradient-primary btn-fw">
                        <i class="mdi mdi-plus"></i> Tambah Kategori
                    </a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr class="bg-light">
                                <th> ID </th>
                                <th> Nama Kategori </th>
                                <th class="text-center"> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kategori as $item)
                            <tr>
                                <td> #{{ $item->idkategori }} </td>
                                <td class="font-weight-bold"> {{ $item->nama_kategori }} </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('kategori.edit', $item->idkategori) }}" class="btn btn-sm btn-gradient-info btn-icon-text">
                                            <i class="mdi mdi-pencil btn-icon-prepend"></i> Edit 
                                        </a>
                                        
                                        <form action="{{ route('kategori.destroy', $item->idkategori) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-gradient-danger btn-icon-text">
                                                <i class="mdi mdi-delete btn-icon-prepend"></i> Hapus 
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">
                                    <i class="mdi mdi-information-outline mdi-24px"></i><br>
                                    Belum ada data kategori.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection