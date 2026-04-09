@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title">
        <span class="page-title-icon bg-gradient-success text-white me-2">
            <i class="mdi mdi-cash-check"></i>
        </span> Pesanan Masuk (Lunas)
    </h3>
</div>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Daftar Transaksi Berhasil</h4>
                <p class="card-description">Hanya menampilkan pesanan yang sudah dibayar via Midtrans.</p>
                
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID Pesanan</th>
                                <th>Nama Customer</th>
                                <th>Waktu Transaksi</th>
                                <th>Total Bayar</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr>
                                    <td>#{{ $order->idpesanan }}</td>
                                    <td>{{ $order->nama }}</td>
                                    <td>{{ $order->timestamp }}</td>
                                    <td class="text-success font-weight-bold">
                                        Rp {{ number_format($order->total, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        <label class="badge badge-success">LUNAS</label>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada pesanan yang lunas nih, Alisya. 😅</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection