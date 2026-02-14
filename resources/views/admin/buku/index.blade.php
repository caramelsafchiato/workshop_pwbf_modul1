@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-book-open-page-variant"></i>
        </span> Koleksi Buku
    </h3>
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Buku</li>
        </ul>
    </nav>
</div>

<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title">Daftar Semua Buku</h4>
                    <a href="{{ route('buku.create') }}" class="btn btn-gradient-primary btn-fw">
                        <i class="mdi mdi-plus"></i> Tambah Buku
                    </a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr class="bg-light">
                                <th> ID </th>
                                <th> Kode </th>
                                <th> Judul & Pengarang </th>
                                <th> Kategori </th>
                                <th class="text-center"> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($buku as $item)
                            <tr>
                                <td> #{{ $item->idbuku }} </td>
                                <td> <code class="text-primary">{{ $item->kode }}</code> </td>
                                <td>
                                    <span class="font-weight-bold">{{ $item->judul }}</span><br>
                                    <small class="text-muted">{{ $item->pengarang ?? 'Anonim' }}</small>
                                </td>
                                <td>
                                    <label class="badge badge-info">{{ $item->nama_kategori }}</label>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('buku.edit', $item->idbuku) }}" class="btn btn-sm btn-gradient-info btn-icon-text">
                                            <i class="mdi mdi-pencil btn-icon-prepend"></i> Edit
                                        </a>
                                        <form action="{{ route('buku.destroy', $item->idbuku) }}" method="POST" onsubmit="return confirm('Hapus buku ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-gradient-danger btn-icon-text">
                                                <i class="mdi mdi-delete btn-icon-prepend"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">Belum ada koleksi buku.</td>
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