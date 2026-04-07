@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-4">
            <div class="card p-3 shadow-sm">
                <h5><i class="fas fa-bolt"></i> POS Versi AXIOS</h5>
                <hr>
                <label class="fw-bold">Pilih Barang</label>
                <select id="pilih_barang" class="form-select mb-2">
                    <option value="0">-- Pilih Barang --</option>
                    @foreach($barang as $b)
                        <option value="{{ $b->id_barang }}">{{ $b->id_barang }} - {{ $b->nama }}</option>
                    @endforeach
                </select>
                
                <label class="fw-bold">Nama Barang</label>
                <input type="text" id="inp_nama" class="form-control mb-2" readonly> <label class="fw-bold">Harga</label>
                <input type="text" id="inp_harga" class="form-control mb-2" readonly> 
                
                <label class="fw-bold">Jumlah</label>
                <input type="number" id="inp_qty" class="form-control mb-3" value="1" min="1"> 
                
                <button id="btn_tambah" class="btn btn-primary w-100" disabled>Tambahkan</button>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card p-3 shadow-sm">
                <table class="table table-bordered table-hover text-center" id="tabel_kasir">
                    <thead class="table-dark">
                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th style="width:15%">Qty</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        </tbody>
                    <tfoot>
                        <tr class="table-secondary fw-bold">
                            <th colspan="4" class="text-end">Total Bayar:</th>
                            <th colspan="2">Rp <span id="total_bayar">0</span></th> 
                        </tr>
                    </tfoot>
                </table>
                <button id="btn_bayar_axios" class="btn btn-success btn-lg w-100 mt-2">
                    <span id="btn_text">Bayar & Simpan (AXIOS)</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function checkButton() {
        let id = $('#pilih_barang').val();
        let nama = $('#inp_nama').val();
        let qty = parseInt($('#inp_qty').val());

        if(id !== "0" && nama !== "" && qty > 0) {
            $('#btn_tambah').prop('disabled', false);
        } else {
            $('#btn_tambah').prop('disabled', true);
        }
    }

    $('#pilih_barang').on('change', function() {
        let id = $(this).val();
        
        if(id == "0") {
            $('#inp_nama').val('');
            $('#inp_harga').val('');
            checkButton();
            return;
        }

        axios.post("{{ route('kasir.cekBarang') }}", {
            _token: "{{ csrf_token() }}", 
            id_barang: id
        })
        .then(function (res) {
            $('#inp_nama').val(res.data.data.nama);
            $('#inp_harga').val(res.data.data.harga);
            checkButton();
        })
        .catch(function (error) {
            Swal.fire('Error', 'Data barang tidak ditemukan', 'error');
            $('#inp_nama').val('');
            $('#inp_harga').val('');
            checkButton();
        });
    });

    $('#inp_qty').on('input change', checkButton);

    $('#btn_tambah').click(function() {
        let kode = $('#pilih_barang').val();
        let nama = $('#inp_nama').val();
        let harga = parseInt($('#inp_harga').val());
        let qty = parseInt($('#inp_qty').val());
        let existing = $(`tr[data-id="${kode}"]`);

        if(existing.length > 0) {
            let inputEdit = existing.find('.edit-qty');
            let newQty = parseInt(inputEdit.val()) + qty;
            inputEdit.val(newQty);
            existing.find('.col-sub').text(newQty * harga);
        } else {
            $('#tabel_kasir tbody').append(`
                <tr data-id="${kode}">
                    <td>${kode}</td>
                    <td>${nama}</td>
                    <td>${harga}</td>
                    <td><input type="number" class="form-control edit-qty" value="${qty}" min="1" data-harga="${harga}"></td>
                    <td class="col-sub">${qty * harga}</td>
                    <td><button class="btn btn-danger btn-sm hapus">Hapus</button></td>
                </tr>
            `);
        }

        $('#pilih_barang').val('0');
        $('#inp_nama').val('');
        $('#inp_harga').val('');
        $('#inp_qty').val(1);
        $(this).prop('disabled', true);
        
        updateTotal(); 
    });

    $(document).on('input', '.edit-qty', function() {
        let qty = $(this).val();
        let harga = $(this).data('harga');
        let row = $(this).closest('tr');
        if(qty < 1 || qty == "") { $(this).val(1); qty = 1; }
        row.find('.col-sub').text(qty * harga);
        updateTotal();
    });

    function updateTotal() {
        let total = 0;
        $('.col-sub').each(function() { total += parseInt($(this).text()); });
        $('#total_bayar').text(total); 
    }

    $('#btn_bayar_axios').click(function() {
        let cart = [];
        $('#tabel_kasir tbody tr').each(function() {
            cart.push({
                id_barang: $(this).data('id'),
                qty: $(this).find('.edit-qty').val(),
                harga: $(this).find('td:eq(2)').text()
            });
        });

        if(cart.length === 0) return Swal.fire('Peringatan', 'Keranjang kosong!', 'warning');

        $(this).prop('disabled', true);
        $('#btn_text').text('Memproses...');

        axios.post("{{ route('kasir.bayar') }}", {
            _token: "{{ csrf_token() }}",
            total: $('#total_bayar').text(),
            cart: cart
        })
        .then(function (res) {
            Swal.fire('Berhasil!', 'Pembayaran Berhasil Disimpan (Axios)', 'success').then(() => {
                location.reload(); 
            });
        })
        .catch(function (err) {
            Swal.fire('Error', 'Gagal menyimpan transaksi', 'error');
            $('#btn_text').text('Bayar & Simpan (AXIOS)');
            $('#btn_bayar_axios').prop('disabled', false);
        });
    });

    $(document).on('click', '.hapus', function() {
        $(this).closest('tr').remove();
        updateTotal();
    });
</script>
@endsection