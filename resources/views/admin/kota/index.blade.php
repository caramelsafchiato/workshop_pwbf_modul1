@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-primary text-white me-2">
            <i class="mdi mdi-map-marker"></i>
        </span> Manajemen Kota
    </h3>
    <nav aria-label="breadcrumb">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Kota</li>
        </ul>
    </nav>
</div>

<div class="row">

    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="card-title">Kelola Kota</h4>
                </div>

                <!-- CARD SELECT BIASA -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Select Standar</h5>

                        <div class="row mb-3">
                            <label class="col-md-2 col-form-label">Kota:</label>
                            <div class="col-md-8">
                                <input type="text"
                                    id="kotaInputDefault"
                                    class="form-control"
                                    placeholder="Masukkan nama kota"
                                    required>
                            </div>
                            <div class="col-md-2">
                                <button type="button" id="addKotaDefault" class="btn btn-success w-100">
                                    <span class="text">Tambahkan</span>
                                    <span class="spinner-border spinner-border-sm d-none"></span>
                                </button>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-2 col-form-label">Select Kota</label>
                            <div class="col-md-10">
                                <select id="kotaSelectDefault" class="form-control">
                                    <option value="">Pilih kota</option>
                                </select>
                            </div>
                        </div>

                        <p>Kota Terpilih: <strong id="kotaTerpilihDefault">-</strong></p>
                    </div>
                </div>

                <!-- CARD SELECT2 -->
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Select2</h5>

                        <div class="row mb-3">
                            <label class="col-md-2 col-form-label">Kota:</label>
                            <div class="col-md-8">
                                <input type="text"
                                    id="kotaInputSelect2"
                                    class="form-control"
                                    placeholder="Masukkan nama kota"
                                    required>
                            </div>
                            <div class="col-md-2">
                                <button type="button" id="addKotaSelect2" class="btn btn-success w-100">
                                    <span class="text">Tambahkan</span>
                                    <span class="spinner-border spinner-border-sm d-none"></span>
                                </button>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-md-2 col-form-label">Select Kota</label>
                            <div class="col-md-10">
                                <select id="kotaSelect2" class="form-control">
                                    <option value="">Pilih kota</option>
                                </select>
                            </div>
                        </div>

                        <p>Kota Terpilih: <strong id="kotaTerpilihSelect2">-</strong></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
</div>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function(){
    console.log('DOM fully loaded');
    
    /* aktifkan select2 */
    if(typeof $ !== 'undefined') {
        $('#kotaSelect2').select2({
            placeholder:"Pilih kota",
            allowClear:true
        });
    }

    function setup(inputId, selectId, buttonId, outputId){
        const input = document.getElementById(inputId);
        const select = document.getElementById(selectId);
        const button = document.getElementById(buttonId);
        const output = document.getElementById(outputId);

        console.log('Setup:', buttonId, button);

        if(!button) return;

        /* tombol tambah kota */
        button.addEventListener("click", function(e){
            console.log('Button clicked');
            e.preventDefault();
            e.stopPropagation();

            if(!input.checkValidity()){
                input.reportValidity();
                return;
            }

            let kota = input.value;
            console.log('Adding kota:', kota);

            button.disabled = true;

            button.querySelector(".text").innerText = "Loading...";
            button.querySelector(".spinner-border").classList.remove("d-none");

            setTimeout(function(){
                let option = new Option(kota, kota, true, true);
                select.add(option);
                
                if(typeof $ !== 'undefined') {
                    $(select).trigger("change");
                }

                input.value = "";
                button.disabled = false;

                button.querySelector(".text").innerText = "Tambahkan";
                button.querySelector(".spinner-border").classList.add("d-none");
            }, 800);
        });

        /* ketika kota dipilih */
        if(typeof $ !== 'undefined') {
            $(select).on("change", function(){
                output.innerText = this.value ? this.value : "-";
            });
        } else {
            select.addEventListener('change', function(){
                output.innerText = this.value ? this.value : "-";
            });
        }
    }

    /* jalankan untuk dua card */
    setup("kotaInputDefault", "kotaSelectDefault", "addKotaDefault", "kotaTerpilihDefault");
    setup("kotaInputSelect2", "kotaSelect2", "addKotaSelect2", "kotaTerpilihSelect2");
});
</script>

@endsection