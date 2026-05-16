@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12 grid-margin">
        <div class="card bg-gradient-success card-img-holder text-white">
            <div class="card-body">
                <h2 class="mb-4">Siap untuk kunjungan hari ini?</h2>
                
                <a href="{{ route('sales.scan') }}" class="btn btn-light btn-lg w-100 font-weight-bold" style="color: #1bcfb4;">
                    <i class="mdi mdi-qrcode-scan"></i> MULAI SCAN SEKARANG
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Riwayat Kunjungan Terakhirmu</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>Toko</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($myHistory as $h)
                            <tr>
                                <td>{{ date('H:i', strtotime($h->created_at)) }} WIB</td>
                                <td>{{ $h->nama_toko }}</td>
                                <td>
                                    @if($h->accepted)
                                        <label class="badge badge-success">DITERIMA</label>
                                    @else
                                        <label class="badge badge-danger">DITOLAK</label>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">Belum ada kunjungan hari ini.</td>
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