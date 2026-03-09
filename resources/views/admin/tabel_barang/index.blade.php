@extends('layouts.app')

@section('content')
<div class="page-header d-flex justify-content-between align-items-center">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-table"></i>
        </span> Tabel Barang (Biasa)
    </h3>
    <a href="{{ route('tabel_barang.dt') }}" class="btn btn-outline-primary btn-fw">
        <i class="mdi mdi-swap-horizontal"></i> Pindah ke Versi DataTables
    </a>
</div>

<div class="row">
    <div class="col-md-5 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Input Barang</h4>
                <form id="formBiasa">
                    <div class="form-group">
                        <label>Nama barang :</label>
                        <input type="text" id="nama" class="form-control" placeholder="Contoh: Meja" required>
                    </div>
                    <div class="form-group">
                        <label>Harga barang :</label>
                        <input type="number" id="harga" class="form-control" placeholder="10000" required>
                    </div>
                    <button type="button" id="btnBiasa" class="btn btn-gradient-success" onclick="simpanBiasa()">
                        <span id="textBiasa">submit</span>
                        <span id="loaderBiasa" style="display:none;">
                            <i class="mdi mdi-loading mdi-spin"></i> processing...
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-7 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID barang</th>
                            <th>Nama</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody id="bodyBiasa"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    let counter = 1;
    function simpanBiasa() {
        const form = document.getElementById('formBiasa');
        if (form.checkValidity()) {
            const btn = document.getElementById('btnBiasa');
            btn.disabled = true;
            document.getElementById('textBiasa').style.display = 'none';
            document.getElementById('loaderBiasa').style.display = 'inline-block';

            setTimeout(() => {
                const row = `<tr>
                    <td>${counter++}</td>
                    <td>${document.getElementById('nama').value}</td>
                    <td>Rp ${parseInt(document.getElementById('harga').value).toLocaleString('id-ID')}</td>
                </tr>`;
                document.getElementById('bodyBiasa').innerHTML += row;
                form.reset();
                btn.disabled = false;
                document.getElementById('textBiasa').style.display = 'inline-block';
                document.getElementById('loaderBiasa').style.display = 'none';
            }, 800);
        } else {
            form.reportValidity();
        }
    }
</script>
@endsection