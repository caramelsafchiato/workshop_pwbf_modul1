@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title">Vendor Panel - Scanner QR Pesanan</h3>
</div>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center">Scan QR Code Pesanan</h4>
                
                <!-- Area Kamera -->
                <div id="reader" style="width: 100%; border: 2px solid #6610f2; border-radius: 10px; overflow: hidden;"></div>
                
                <!-- Audio Beep -->
                <audio id="beepSound" src="{{ asset('audio/beep.mp3') }}"></audio>

                <div id="result_area" class="mt-4 d-none">
                    <div class="alert alert-success">
                        <h5><i class="mdi mdi-check-circle me-2"></i>Pesanan Ditemukan!</h5>
                        <hr>
                        <p><strong>ID Pesanan:</strong> <span id="res_id"></span></p>
                        <p><strong>Status:</strong> <span id="res_status"></span></p>
                        <p><strong>Total:</strong> Rp <span id="res_total"></span></p>
                        <hr>
                        <div id="res_items" class="text-start">
                            <!-- Daftar menu dipesan akan dimasukkan di sini -->
                        </div>
                    </div>
                    <button class="btn btn-gradient-primary w-100" onclick="location.reload()">Scan Pesanan Lain</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://unpkg.com/html5-qrcode"></script>
<script>
    const beep = document.getElementById('beepSound');
    const html5QrCode = new Html5Qrcode("reader");
    const qrConfig = {
        fps: 12,
        qrbox: { width: 280, height: 280 },
        disableFlip: false,
        rememberLastUsedCamera: true,
        formatsToSupport: [Html5QrcodeSupportedFormats.QR_CODE]
    };

    function onScanSuccess(decodedText) {
        beep.play();
        
        html5QrCode.stop().then(() => {
            $.get("/api/scanner/pesanan/" + decodedText, function(res) {
                if(res.success) {
                    const d = res.data;
                    $('#res_id').text(d.idpesanan);
                    $('#res_status').text(d.status == 1 ? 'Lunas' : (d.status == 0 ? 'Belum Lunas' : d.status));
                    $('#res_total').text(Number(d.total).toLocaleString('id-ID'));

                    let itemsHtml = '<ul class="list-group">';
                    if (Array.isArray(d.items) && d.items.length > 0) {
                        d.items.forEach(function(it) {
                            itemsHtml += `<li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-bold">${it.nama_menu}</div>
                                    <small class="text-muted">Harga: Rp ${Number(it.harga).toLocaleString('id-ID')}</small>
                                </div>
                                <span class="badge bg-primary rounded-pill">x${it.jumlah}</span>
                            </li>`;
                        });
                    } else {
                        itemsHtml += '<li class="list-group-item">(Tidak ada item untuk vendor ini)</li>';
                    }
                    itemsHtml += '</ul>';
                    $('#res_items').html(itemsHtml);

                    $('#result_area').removeClass('d-none');
                } else {
                    alert(res.message);
                    location.reload();
                }
            });
        });
    }

    html5QrCode.start({ facingMode: "environment" }, qrConfig, onScanSuccess)
        .catch(function (err) {
            console.error('Gagal memulai kamera scanner:', err);
            alert('Kamera scanner gagal dimulai. Cek izin kamera dan coba lagi.');
        });
</script>
@endsection