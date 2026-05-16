@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title">Scan & Validasi Kunjungan Toko</h3>
</div>

<div class="card">
    <div class="card-body">
        <div id="reader" style="width:100%; border:2px solid #28a745; border-radius:8px; overflow:hidden;"></div>
        <audio id="beepSound" src="{{ asset('audio/beep.mp3') }}"></audio>

        <div id="result_area" class="mt-3 d-none">
            <div class="alert alert-info">
                <h5>Hasil Scan</h5>
                <p><strong>Barcode:</strong> <span id="res_barcode"></span></p>
                <p><strong>Nama Toko:</strong> <span id="res_nama"></span></p>
                <p><strong>Jarak (m):</strong> <span id="res_distance"></span></p>
                <p><strong>Keputusan:</strong> <span id="res_decision"></span></p>
            </div>
            <button class="btn btn-primary" onclick="location.reload()">Scan Lagi</button>
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

function onScanSuccess(decodedText) {
    beep.play();
    html5QrCode.stop().then(() => {
        document.getElementById('res_barcode').textContent = decodedText;
        // lookup toko
        fetch('/api/lokasi-toko/' + encodeURIComponent(decodedText))
            .then(r => r.json()).then(res => {
                if (!res.success) { alert(res.message || 'Toko tidak ditemukan'); location.reload(); return; }
                const toko = res.data;
                document.getElementById('res_nama').textContent = toko.nama_toko;

                // ambil lokasi sales
                if (!navigator.geolocation) { alert('Geolocation tidak tersedia'); location.reload(); return; }
                navigator.geolocation.getCurrentPosition(function(pos) {
                    const lat = pos.coords.latitude;
                    const lng = pos.coords.longitude;
                    const acc = pos.coords.accuracy;

                    // kirim ke API validate
                    fetch('/api/lokasi-toko/validate', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                        body: JSON.stringify({ barcode: decodedText, lat: lat, lng: lng, accuracy: acc })
                    }).then(r => r.json()).then(v => {
                        if (!v.success) { alert('Error validasi'); location.reload(); return; }
                        document.getElementById('res_distance').textContent = v.distance;
                        document.getElementById('res_decision').textContent = v.accepted ? 'DITERIMA' : 'DITOLAK';
                        document.getElementById('result_area').classList.remove('d-none');
                    });
                }, function(err) { alert('Gagal ambil lokasi: ' + err.message); location.reload(); }, { enableHighAccuracy: true, maximumAge: 0, timeout: 20000 });
            });
    }).catch(err => { console.error(err); alert('Gagal menghentikan scanner'); });
}

html5QrCode.start({ facingMode: "environment" }, { fps: 10, qrbox: 250 }, onScanSuccess)
    .catch(err => { console.error('Gagal mulai kamera:', err); alert('Gagal mulai kamera scanner'); });
</script>
@endsection
