@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Manajemen User & Role </h3>
    <a href="{{ route('user.create') }}" class="btn btn-gradient-primary btn-icon-text">
        <i class="mdi mdi-account-plus btn-icon-prepend"></i> Tambah User
    </a>
</div>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Daftar Pengguna Sistem</h4>
                
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th> Nama </th>
                                <th> Email </th>
                                <th> Role </th>
                                <th> Vendor </th>
                                <th> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $u)
                            <tr>
                                <td>{{ $u->nama }}</td>
                                <td>{{ $u->email }}</td>
                                <td>
                                    <label class="badge {{ $u->role == 'admin' ? 'badge-danger' : ($u->role == 'vendor' ? 'badge-info' : 'badge-primary') }}">
                                        {{ strtoupper($u->role) }}
                                    </label>
                                </td>
                                <td>{{ $u->idvendor ? 'ID: '.$u->idvendor : '-' }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('user.edit', $u->iduser) }}" class="btn btn-sm btn-warning text-white">
                                            Edit
                                        </a>

                                        <form action="{{ route('user.destroy', $u->iduser) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin mau hapus user ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
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