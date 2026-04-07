@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Wilayah Indonesia (Versi AJAX jQuery & API)</h4>
        
        <div class="form-group">
            <label>Provinsi</label>
            <select id="provinsi" class="form-control">
                <option value="">Loading Provinsi...</option>
            </select>
        </div>

        <div class="form-group">
            <label>Kota/Kabupaten</label>
            <select id="kota" class="form-control" disabled>
                <option value="">Pilih Provinsi Dahulu</option>
            </select>
        </div>

        <div class="form-group">
            <label>Kecamatan</label>
            <select id="kecamatan" class="form-control" disabled>
                <option value="">Pilih Kota Dahulu</option>
            </select>
        </div>

        <div class="form-group">
            <label>Kelurahan</label>
            <select id="kelurahan" class="form-control" disabled>
                <option value="">Pilih Kecamatan Dahulu</option>
            </select>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $.getJSON('https://emsifa.github.io/api-wilayah-indonesia/api/provinces.json', function(res) {
        let options = '<option value="">-- Pilih Provinsi --</option>';
        res.forEach(item => options += `<option value="${item.id}">${item.name}</option>`);
        $('#provinsi').html(options);
    }).fail(function() {
        $.getJSON('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json', function(res) {
            let options = '<option value="">-- Pilih Provinsi --</option>';
            res.forEach(item => options += `<option value="${item.id}">${item.name}</option>`);
            $('#provinsi').html(options);
        });
    });

    $('#provinsi').change(function() {
        let id = $(this).val();
        $('#kota').html('<option value="">Loading...</option>').prop('disabled', true);
        if(id) {
            $.getJSON(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${id}.json`, function(res) {
                let options = '<option value="">-- Pilih Kota --</option>';
                res.forEach(item => options += `<option value="${item.id}">${item.name}</option>`);
                $('#kota').html(options).prop('disabled', false);
            });
        }
    });

    $('#kota').change(function() {
        let id = $(this).val();
        $('#kecamatan').html('<option value="">Loading...</option>').prop('disabled', true);
        if(id) {
            $.getJSON(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${id}.json`, function(res) {
                let options = '<option value="">-- Pilih Kecamatan --</option>';
                res.forEach(item => options += `<option value="${item.id}">${item.name}</option>`);
                $('#kecamatan').html(options).prop('disabled', false);
            });
        }
    });

    $('#kecamatan').change(function() {
        let id = $(this).val();
        $('#kelurahan').html('<option value="">Loading...</option>').prop('disabled', true);
        if(id) {
            $.getJSON(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${id}.json`, function(res) {
                let options = '<option value="">-- Pilih Kelurahan --</option>';
                res.forEach(item => options += `<option value="${item.id}">${item.name}</option>`);
                $('#kelurahan').html(options).prop('disabled', false);
            });
        }
    });
});
</script>
@endsection