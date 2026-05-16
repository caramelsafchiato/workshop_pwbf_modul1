@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title">Tambah Lokasi Toko</h3>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('lokasitoko.store') }}">
            @csrf
            <div class="mb-3">
                <label>Barcode</label>
                <input type="text" class="form-control" value="(akan digenerate otomatis)" disabled>
                <small class="text-muted">Barcode akan dibuat otomatis setelah disimpan.</small>
            </div>
            <div class="mb-3">
                <label>Nama Toko</label>
                <input type="text" name="nama_toko" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Latitude</label>
                <input type="text" id="latitude" name="latitude" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Longitude</label>
                <input type="text" id="longitude" name="longitude" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Accuracy (meter)</label>
                <input type="text" id="accuracy" name="accuracy" class="form-control" required>
            </div> 

            <div class="mb-3">
                <button type="button" class="btn btn-secondary" id="btnGeolocate">Ambil Lokasi Sekarang</button>
            </div>

            <div class="mb-3">
                <button class="btn btn-success" type="submit">Simpan Lokasi</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.getElementById('btnGeolocate').addEventListener('click', function() {
    if (!navigator.geolocation) return alert('Geolocation tidak tersedia di browser ini.');
    navigator.geolocation.getCurrentPosition(function(pos) {
        document.getElementById('latitude').value = pos.coords.latitude;
        document.getElementById('longitude').value = pos.coords.longitude;
        document.getElementById('accuracy').value = pos.coords.accuracy;
    }, function(err) {
        alert('Gagal ambil lokasi: ' + (err.message || err.code));
    }, { enableHighAccuracy: true, maximumAge: 0, timeout: 20000 });
});
</script>
@endsection
