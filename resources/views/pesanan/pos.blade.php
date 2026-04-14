@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title">Kantin Online - Point of Sale</h3>
</div>

<div class="row">
    <div class="col-md-7 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Pilih Makanan & Minuman</h4>
                <p class="card-description">Silakan pilih vendor kantin terlebih dahulu.</p>

                <div class="form-group">
                    <label for="selectVendor">Vendor Kantin</label>
                    <select class="form-control form-control-lg" id="selectVendor">
                        <option value="">-- Pilih Vendor --</option>
                        @foreach($vendors as $v)
                            <option value="{{ $v->idvendor }}">{{ $v->nama_vendor }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mt-3">
                    <label for="selectMenu">Menu Tersedia</label>
                    <select class="form-control" id="selectMenu" disabled>
                        <option value="">-- Pilih Menu --</option>
                    </select>
                </div>

                <div class="form-group mt-3">
                    <label for="inputQty">Jumlah</label>
                    <input type="number" class="form-control" id="inputQty" min="1" value="1">
                </div>

                <button type="button" id="btnTambah" class="btn btn-gradient-success w-100 mt-3" disabled>
                    <i class="mdi mdi-cart-plus me-2"></i>Tambah ke Keranjang
                </button>
            </div>
        </div>
    </div>

    <div class="col-md-5 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Keranjang Belanja</h4>
                <div class="table-responsive">
                    <table class="table" id="tabelKeranjang">
                        <thead>
                            <tr>
                                <th>Menu</th>
                                <th>Qty</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <hr>
                <div class="d-flex justify-content-between align-items-center">
                    <h5>Total Bayar:</h5>
                    <h4 class="text-primary">Rp <span id="textTotal">0</span></h4>
                </div>

                <button type="button" id="btnBayar" class="btn btn-gradient-primary w-100 mt-4 d-flex align-items-center justify-content-center" disabled>
                    <span id="btnText">Bayar Sekarang </span>
                    <div id="btnSpinner" class="spinner-border spinner-border-sm ms-2 d-none" role="status"></div>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@php
    $midtransSnapUrl = config('services.midtrans.is_production')
        ? 'https://app.midtrans.com/snap/snap.js'
        : 'https://app.sandbox.midtrans.com/snap/snap.js';
@endphp
<script src="{{ $midtransSnapUrl }}" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script>
$(function () {
    let listBelanja = [];
    let totalHarga = 0;
    let isSubmitting = false;
    let invoiceTab = null;

    $('#selectVendor').on('change', function () {
        const idVendor = $(this).val();
        $('#selectMenu').empty().append('<option value="">-- Pilih Menu --</option>').prop('disabled', true);
        $('#btnTambah').prop('disabled', true);

        if (!idVendor) return;

        $.get("{{ url('/api/menu/vendor') }}/" + idVendor)
            .done(function (data) {
                if (!Array.isArray(data) || data.length === 0) {
                    alert('Vendor ini belum punya menu.');
                    return;
                }
                data.forEach(function (menu) {
                    $('#selectMenu').append(
                        `<option value="${menu.idmenu}" data-harga="${menu.harga}" data-nama="${menu.nama_menu}">
                            ${menu.nama_menu} - Rp ${Number(menu.harga).toLocaleString('id-ID')}
                        </option>`
                    );
                });
                $('#selectMenu').prop('disabled', false);
            });
    });

    $('#selectMenu').on('change', function () {
        $('#btnTambah').prop('disabled', !$(this).val());
    });

    $('#btnTambah').on('click', function () {
        const opt = $('#selectMenu option:selected');
        const idmenu = Number(opt.val());
        const nama = opt.data('nama');
        const harga = Number(opt.data('harga'));
        const jumlah = Math.max(1, Number($('#inputQty').val() || 1));

        const existing = listBelanja.find(item => item.idmenu === idmenu);
        if (existing) { existing.quantity += jumlah; } 
        else { listBelanja.push({ idmenu, nama, harga, quantity: jumlah }); }

        $('#inputQty').val(1);
        renderTabel();
    });

    function renderTabel() {
        let html = '';
        totalHarga = 0;
        listBelanja.forEach((item, index) => {
            const subtotal = item.harga * item.quantity;
            totalHarga += subtotal;
            html += `<tr>
                <td>${item.nama}</td>
                <td>
                    <div class="d-flex align-items-center" style="gap: 6px;">
                        <button class="btn btn-outline-secondary btn-sm" data-action="decrease" data-index="${index}">-</button>
                        <span>${item.quantity}</span>
                        <button class="btn btn-outline-secondary btn-sm" data-action="increase" data-index="${index}">+</button>
                    </div>
                </td>
                <td>Rp ${subtotal.toLocaleString('id-ID')}</td>
                <td><button class="btn btn-danger btn-sm" data-index="${index}">x</button></td>
            </tr>`;
        });
        $('#tabelKeranjang tbody').html(html);
        $('#textTotal').text(totalHarga.toLocaleString('id-ID'));
        $('#btnBayar').prop('disabled', listBelanja.length === 0 || isSubmitting);
    }

    $('#tabelKeranjang').on('click', 'button[data-index]', function () {
        const index = Number($(this).data('index'));
        const action = $(this).data('action');
        if (action === 'decrease') {
            if (listBelanja[index].quantity > 1) listBelanja[index].quantity -= 1;
            else listBelanja.splice(index, 1);
        } else if (action === 'increase') {
            listBelanja[index].quantity += 1;
        } else { listBelanja.splice(index, 1); }
        renderTabel();
    });

    function openInvoiceInNewTab(idpesanan) {
        const invoiceUrl = "/pesanan/invoice/" + idpesanan;

        if (invoiceTab && !invoiceTab.closed) {
            invoiceTab.location.href = invoiceUrl;
            invoiceTab.focus();
            invoiceTab = null;
            return;
        }

        const newTab = window.open(invoiceUrl, '_blank');
        if (newTab) {
            newTab.focus();
            return;
        }

        window.location.href = invoiceUrl;
    }

    $('#btnBayar').on('click', function () {
        if (isSubmitting || listBelanja.length === 0) return;

        invoiceTab = window.open('', '_blank');

        isSubmitting = true;
        setLoadingButton(true);

        $.ajax({
            url: "{{ route('pesanan.checkout') }}",
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            data: { items: listBelanja, total_harga: totalHarga }
        })
        .done(function (response) {
            if (!response.token) {
                alert('Gagal mendapatkan token Midtrans.');
                setLoadingButton(false);
                isSubmitting = false;
                return;
            }

            window.snap.pay(response.token, {
                onSuccess: function () {
                    alert('Pembayaran berhasil.');
                    setLoadingButton(false);
                    isSubmitting = false;
                    openInvoiceInNewTab(response.idpesanan);
                },
                onPending: function () {
                    alert('Pembayaran tertunda. Silakan selesaikan pembayaran Anda.');
                    setLoadingButton(false);
                    isSubmitting = false;
                    openInvoiceInNewTab(response.idpesanan);
                },
                onError: function () {
                    alert('Pembayaran gagal. Silakan coba kembali.');
                    if (invoiceTab && !invoiceTab.closed) {
                        invoiceTab.close();
                    }
                    invoiceTab = null;
                    setLoadingButton(false);
                    isSubmitting = false;
                },
                onClose: function () {
                    if (invoiceTab && !invoiceTab.closed) {
                        invoiceTab.close();
                    }
                    invoiceTab = null;
                    setLoadingButton(false);
                    isSubmitting = false;
                }
            });
        })
        .fail(function (xhr) {
            alert(xhr.responseJSON?.message || 'Gagal menghubungi server.');
            if (invoiceTab && !invoiceTab.closed) {
                invoiceTab.close();
            }
            invoiceTab = null;
            setLoadingButton(false);
            isSubmitting = false;
        });
    });

    function setLoadingButton(loading) {
        $('#btnBayar').prop('disabled', loading);
        $('#btnSpinner').toggleClass('d-none', !loading);
        $('#btnText').text(loading ? 'Menghubungkan Midtrans...' : 'Bayar Sekarang (Midtrans)');
    }
});
</script>
@endsection