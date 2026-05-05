@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title">Admin Panel - Scanner Barcode</h3>
</div>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title text-center">Scan Label Barcode Barang</h4>
                
                <!-- Area Kamera -->
                <div id="reader" style="width: 100%; border: 2px solid #6610f2; border-radius: 10px; overflow: hidden;"></div>
                
                <!-- Audio Beep dari Modul -->
                <audio id="beepSound" src="{{ asset('audio/beep.mp3') }}"></audio>

                <div id="result_area" class="mt-4 d-none">
                    <div class="alert alert-success">
                        <h5><i class="mdi mdi-check-circle me-2"></i>Barang Ditemukan!</h5>
                        <hr>
                        <p><strong>ID Barang:</strong> <span id="res_id"></span></p>
                        <p><strong>Nama Barang:</strong> <span id="res_nama"></span></p>
                        <p><strong>Harga Barang:</strong> Rp <span id="res_harga"></span></p>
                    </div>
                    <button class="btn btn-gradient-primary w-100" onclick="location.reload()">Scan Barang Lain</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/quagga/0.12.1/quagga.min.js"></script>
<script>
    const beep = document.getElementById('beepSound');
    let scannerStarted = false;
    let barcodeDetected = false;

    function startBarcodeScanner() {
        if (scannerStarted) return;
        scannerStarted = true;

        if (typeof Quagga === 'undefined') {
            alert('Library scanner tidak dimuat. Periksa koneksi CDN atau status jaringan.');
            return;
        }

        Quagga.init({
            inputStream: {
                name: 'Live',
                type: 'LiveStream',
                target: document.querySelector('#reader'),
                constraints: {
                    facingMode: 'environment'
                }
            },
            locate: true,
            numOfWorkers: navigator.hardwareConcurrency ? Math.min(4, Math.max(1, navigator.hardwareConcurrency - 1)) : 2,
            frequency: 20,
            area: {
                top: '15%',
                right: '15%',
                left: '15%',
                bottom: '15%'
            },
            locator: {
                patchSize: 'large',
                halfSample: true
            },
            decoder: {
                readers: [
                    'code_128_reader'
                ]
            },
        }, function(err) {
            if (err) {
                console.error('Quagga init error:', err);
                alert('Gagal menginisialisasi scanner: ' + (err.message || err));
                return;
            }
            Quagga.start();
        });

        Quagga.onDetected(function(result) {
            if (barcodeDetected) return;

            const code = result && result.codeResult && result.codeResult.code;
            if (!code) {
                return;
            }

            const barcode = code.trim().replace(/[^0-9A-Za-z]/g, '');
            console.log('Scanned barcode:', code, '=> normalized:', barcode);
            if (!barcode) {
                return;
            }

            barcodeDetected = true;
            Quagga.stop();
            beep.play();

            $.get("{{ url('api/scanner/barang') }}" + '/' + encodeURIComponent(barcode), function(res) {
                if (res.success) {
                    $('#res_id').text(res.data.id_barang);
                    $('#res_nama').text(res.data.nama);
                    $('#res_harga').text(Number(res.data.harga).toLocaleString('id-ID'));
                    $('#result_area').removeClass('d-none');
                } else {
                    alert(res.message);
                    location.reload();
                }
            }).fail(function() {
                alert('Gagal terhubung ke server.');
                location.reload();
            });
        });
    }

    document.addEventListener('DOMContentLoaded', startBarcodeScanner);
</script>
@endsection