@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tambah User Baru</h4>
                <form action="{{ route('user.store') }}" method="POST" class="forms-sample">
                    @csrf
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <select name="role" class="form-control" id="roleSelect" required>
                            <option value="admin">Admin</option>
                            <option value="vendor">Vendor</option>
                            <option value="sales">Sales</option>
                        </select>
                    </div>
                    <div class="form-group" id="vendorField" style="display:none;">
                        <label>Pilih Vendor</label>
                        <select name="idvendor" class="form-control">
                            @foreach($vendors as $v)
                                <option value="{{ $v->idvendor }}">{{ $v->nama_vendor }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-gradient-primary me-2">Simpan</button>
                    <a href="{{ route('user.index') }}" class="btn btn-light">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('roleSelect').addEventListener('change', function() {
        document.getElementById('vendorField').style.display = this.value == 'vendor' ? 'block' : 'none';
    });
</script>
@endsection