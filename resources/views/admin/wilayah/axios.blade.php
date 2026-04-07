@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Wilayah Indonesia (Versi Axios & API)</h4>
        
        <div class="form-group"><label>Provinsi</label><select id="provinsi" class="form-control"><option value="">Loading Provinsi...</option></select></div>
        <div class="form-group"><label>Kota/Kabupaten</label><select id="kota" class="form-control" disabled><option value="">Pilih Provinsi Dahulu</option></select></div>
        <div class="form-group"><label>Kecamatan</label><select id="kecamatan" class="form-control" disabled><option value="">Pilih Kota Dahulu</option></select></div>
        <div class="form-group"><label>Kelurahan</label><select id="kelurahan" class="form-control" disabled><option value="">Pilih Kecamatan Dahulu</option></select></div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    axios.get('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')
        .then(function (response) {
            let options = '<option value="">-- Pilih Provinsi --</option>';
            response.data.forEach(item => { options += `<option value="${item.id}">${item.name}</option>`; });
            document.getElementById('provinsi').innerHTML = options;
        });

    document.getElementById('provinsi').addEventListener('change', function() {
        let id_prov = this.value;
        document.getElementById('kota').innerHTML = '<option value="">Loading Kota...</option>';
        document.getElementById('kecamatan').innerHTML = '<option value="">Pilih Kota Dahulu</option>';
        document.getElementById('kelurahan').innerHTML = '<option value="">Pilih Kecamatan Dahulu</option>';
        
        document.getElementById('kota').disabled = true;
        document.getElementById('kecamatan').disabled = true;
        document.getElementById('kelurahan').disabled = true;

        if(id_prov) {
            axios.get(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${id_prov}.json`)
                .then(function (response) {
                    let options = '<option value="">-- Pilih Kota --</option>';
                    response.data.forEach(item => { options += `<option value="${item.id}">${item.name}</option>`; });
                    document.getElementById('kota').innerHTML = options;
                    document.getElementById('kota').disabled = false;
                });
        }
    });

    document.getElementById('kota').addEventListener('change', function() {
        let id_kota = this.value;
        document.getElementById('kecamatan').innerHTML = '<option value="">Loading Kecamatan...</option>';
        document.getElementById('kelurahan').innerHTML = '<option value="">Pilih Kecamatan Dahulu</option>';
        
        document.getElementById('kecamatan').disabled = true;
        document.getElementById('kelurahan').disabled = true;

        if(id_kota) {
            axios.get(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${id_kota}.json`)
                .then(function (response) {
                    let options = '<option value="">-- Pilih Kecamatan --</option>';
                    response.data.forEach(item => { options += `<option value="${item.id}">${item.name}</option>`; });
                    document.getElementById('kecamatan').innerHTML = options;
                    document.getElementById('kecamatan').disabled = false;
                });
        }
    });

    document.getElementById('kecamatan').addEventListener('change', function() {
        let id_kecamatan = this.value;
        document.getElementById('kelurahan').innerHTML = '<option value="">Loading Kelurahan...</option>';
        document.getElementById('kelurahan').disabled = true;

        if(id_kecamatan) {
            axios.get(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${id_kecamatan}.json`)
                .then(function (response) {
                    let options = '<option value="">-- Pilih Kelurahan --</option>';
                    response.data.forEach(item => { options += `<option value="${item.id}">${item.name}</option>`; });
                    document.getElementById('kelurahan').innerHTML = options;
                    document.getElementById('kelurahan').disabled = false;
                });
        }
    });
}); 
</script>
@endsection