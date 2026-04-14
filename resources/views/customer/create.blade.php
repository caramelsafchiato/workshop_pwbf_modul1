@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title">Tambah Customer - Studi Kasus 3</h3>
</div>

<div class="row">
    <div class="col-md-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body text-center">
                <h4 class="card-title">Ambil Foto Customer</h4>
                
                <div class="form-group text-start">
                    <label>Nama Lengkap</label>
                    <input type="text" id="nama" class="form-control" placeholder="Input Nama Customer">
                </div>

                <div class="camera-container mb-3" style="position: relative;">
                    <video id="video" width="100%" height="300" autoplay style="border-radius: 10px; background: #000; object-fit: cover;"></video>
                </div>

                <button type="button" class="btn btn-gradient-info w-100" onclick="take_snapshot()">
                    <i class="mdi mdi-camera me-2"></i>Ambil Foto
                </button>

                <canvas id="canvas" width="640" height="480" style="display:none;"></canvas>

                <div id="results_area" class="mt-4" style="display:none;">
                    <hr>
                    <label>Hasil Snapshot:</label>
                    <img id="results" class="img-thumbnail w-100 mb-3">
                    <button type="button" id="btnSimpan" class="btn btn-gradient-success w-100">
                        <i class="mdi mdi-content-save me-2"></i>Simpan Permanen
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const results = document.getElementById('results');
    const resultsArea = document.getElementById('results_area');
    let imageData = null;

    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        navigator.mediaDevices.getUserMedia({ video: true })
        .then(function(stream) {
            video.srcObject = stream;
        })
        .catch(function(err) {
            alert("Kamera diblokir atau tidak ditemukan!");
        });
    }

    function take_snapshot() {
        const context = canvas.getContext('2d');
        context.drawImage(video, 0, 0, 640, 480);
        
        imageData = canvas.toDataURL('image/png');
        results.src = imageData;
        resultsArea.style.display = 'block';
    }

    document.getElementById('btnSimpan').addEventListener('click', function() {
        const namaCustomer = document.getElementById('nama').value;
        if(!namaCustomer) return alert('Harap isi nama!');

        $.ajax({
            url: "{{ route('customer.store') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                nama: namaCustomer,
                image: imageData
            },
            success: function(res) {
                alert(res.success);
                window.location.reload();
            },
            error: function(xhr) {
                alert("Gagal simpan: " + xhr.responseText);
            }
        });
    });
</script>
@endsection