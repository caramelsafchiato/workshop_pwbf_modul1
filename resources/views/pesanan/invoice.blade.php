@php
    $midtransSnapUrl = config('services.midtrans.is_production')
        ? 'https://app.midtrans.com/snap/snap.js'
        : 'https://app.sandbox.midtrans.com/snap/snap.js';
@endphp

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-body text-center">
                    <h5 class="mb-2">QR Pesanan Internal</h5>
                    <p class="text-muted mb-3">QR ini hanya untuk identitas/pengambilan pesanan, bukan untuk pembayaran.</p>
                    <div class="d-flex justify-content-center my-3">
                        {!! $qrcode !!}
                    </div>
                    <h4 class="mb-0">Order ID: {{ $pesanan->idpesanan }}</h4>
                </div>
            </div>

            <div class="card">
                <div class="card-body text-center">
                    <h5 class="mb-2">Pembayaran QRIS Midtrans</h5>
                    <p class="text-muted mb-3">Klik tombol berikut untuk menampilkan QRIS resmi Midtrans yang dapat diuji di simulator sandbox.</p>

                    @if($pesanan->status_bayar == 1)
                        <div class="alert alert-success mb-0">Pesanan ini sudah lunas.</div>
                    @elseif($pesanan->snap_token)
                        <button id="btnPayQris" class="btn btn-primary">Tampilkan QRIS Pembayaran</button>
                    @else
                        <div class="alert alert-warning mb-0">Token pembayaran tidak tersedia untuk pesanan ini.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if($pesanan->snap_token)
<script src="{{ $midtransSnapUrl }}" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('btnPayQris');
    if (!btn) return;

    btn.addEventListener('click', function () {
        window.snap.pay("{{ $pesanan->snap_token }}", {
            onSuccess: function () {
                alert('Pembayaran berhasil.');
                window.location.reload();
            },
            onPending: function () {
                alert('Transaksi masih tertunda. Silakan selesaikan pembayaran QRIS Anda.');
            },
            onError: function () {
                alert('Gagal membuka pembayaran Midtrans. Silakan coba kembali.');
            }
        });
    });
});
</script>
@endif