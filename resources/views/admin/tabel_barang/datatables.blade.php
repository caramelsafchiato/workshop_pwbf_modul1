@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<div class="page-header d-flex justify-content-between align-items-center">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-table"></i>
        </span> Tabel Barang (DataTables)
    </h3>

    <a href="{{ route('tabel_barang.index') }}" class="btn btn-outline-primary btn-fw">
        <i class="mdi mdi-swap-horizontal"></i> Pindah ke Versi Biasa
    </a>
</div>

<div class="row">


    <div class="col-md-5 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <h4 class="card-title">Input Barang</h4>

                <div class="form-group">
                    <label>Nama barang :</label>
                    <input type="text" id="namaBarang" class="form-control" placeholder="Contoh: Meja">
                </div>

                <div class="form-group">
                    <label>Harga barang :</label>
                    <input type="number" id="hargaBarang" class="form-control" placeholder="10000">
                </div>

                <button id="btnTambah" class="btn btn-gradient-success">
                    <span id="textTambah">submit</span>
                    <span id="loaderTambah" style="display:none;">
                        <i class="mdi mdi-loading mdi-spin"></i> processing...
                    </span>
                </button>

            </div>
        </div>
    </div>


    <!-- TABEL -->
    <div class="col-md-7 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">

                <table id="tabelBarang" class="table table-bordered">

                    <thead>
                        <tr>
                            <th>ID barang</th>
                            <th>Nama</th>
                            <th>Harga</th>
                        </tr>
                    </thead>

                    <tbody></tbody>

                </table>

            </div>
        </div>
    </div>

</div>


<!-- MODAL EDIT -->

<div id="modalEdit" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5);">

<div style="background:white; width:320px; margin:10% auto; padding:20px; border-radius:8px;">

<h4>Edit Barang</h4>

<label>ID</label>
<input type="text" id="editId" class="form-control" readonly>

<br>

<label>Nama Barang</label>
<input type="text" id="editNama" class="form-control">

<br>

<label>Harga</label>
<input type="number" id="editHarga" class="form-control">

<br>

<button id="btnUpdate" class="btn btn-warning">Ubah</button>
<button id="btnDelete" class="btn btn-danger">Hapus</button>
<button onclick="$('#modalEdit').hide()" class="btn btn-secondary">Batal</button>

</div>

</div>


<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>

let tabelBarang;
let selectedRow;
let idCounter = 1;

$(document).ready(function(){

tabelBarang = $('#tabelBarang').DataTable();

});


/* TAMBAH DATA */

$("#btnTambah").click(function(){

let nama = $("#namaBarang").val();
let harga = $("#hargaBarang").val();

if(nama=="" || harga==""){
alert("Isi semua data");
return;
}

let btn = $("#btnTambah");

btn.prop("disabled",true);
$("#textTambah").hide();
$("#loaderTambah").show();

setTimeout(function(){

tabelBarang.row.add([
idCounter++,
nama,
"Rp "+parseInt(harga).toLocaleString('id-ID')
]).draw(false);

$("#namaBarang").val("");
$("#hargaBarang").val("");

btn.prop("disabled",false);
$("#textTambah").show();
$("#loaderTambah").hide();

},800);

});


/* KLIK ROW */

$('#tabelBarang tbody').on('click','tr',function(){

selectedRow = tabelBarang.row(this);

let data = selectedRow.data();

$("#editId").val(data[0]);
$("#editNama").val(data[1]);
$("#editHarga").val(data[2].replace(/[^0-9]/g,''));

$("#modalEdit").show();

});


/* UPDATE */

$("#btnUpdate").click(function(){

let nama = $("#editNama").val();
let harga = $("#editHarga").val();

selectedRow.data([
$("#editId").val(),
nama,
"Rp "+parseInt(harga).toLocaleString('id-ID')
]).draw(false);

$("#modalEdit").hide();

});


/* DELETE */

$("#btnDelete").click(function(){

selectedRow.remove().draw(false);

$("#modalEdit").hide();

});

</script>

@endsection