@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h4 class="card-title">Riwayat Kunjungan Sales</h4>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>Sales</th>
                        <th>Toko</th>
                        <th>Jarak</th> 
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($history as $h)
                    <tr>
                        <td>{{ date('d M Y H:i', strtotime($h->created_at)) }}</td>
                        <td>{{ $h->nama_sales }}</td>
                        <td>{{ $h->nama_toko }}</td>
                        <td>{{ number_format($h->distance, 2) }} meter</td>
                        <td>
                            @if($h->accepted)
                                <span class="badge bg-success">DITERIMA ✓</span>
                            @else
                                <span class="badge bg-danger">DITOLAK ✗</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection