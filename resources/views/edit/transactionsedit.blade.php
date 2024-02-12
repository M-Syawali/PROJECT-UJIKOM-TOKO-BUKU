@extends('layout.header')
@section('content')
<h3 class="h3 mb-0 text-gray-800"><strong>PAGES - EDIT TRANSACTIONS</strong></h3>
<br>
<div class="content">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card">        
                    <div class="card-body">
                        <a href="{{ route('transactions.index') }}" class="btn btn-outline-dark m-1"><i
                            class="ti ti-arrow-left"></i> </a>
                        <br>
                        <br>
                        <div class="card-body card-block">   
                            <form action="{{ route('transactions.update', $transactions->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                              
                                <!-- Input untuk nomor unik -->
                                <div class="mb-3">
                                    <label for="nomor_unik" class="form-label">Nomor Unik</label>
                                    <input type="number" class="form-control" name="nomor_unik" value="{{ $transactions->nomor_unik }}" readonly>
                                    @error('nomor_unik')
                                    <p>{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- Input untuk nama pelanggan -->
                                <div class="mb-3">
                                    <label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
                                    <input type="text" class="form-control" name="nama_pelanggan" value="{{ $transactions->nama_pelanggan }}">
                                    @error('nama_pelanggan')
                                    <p>{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Pilihan produk -->
                                <label for="products" class="form-label">Nama Produk</label>
                                <div class="mb-3 d-flex">
                                   
                                    <select name="products[]" required id="products" class="form-control">
                                        <option selected>Pilih Produk</option>
                                        @foreach ($products as $p)
                                            @php
                                                $isSelected = false;
                                                foreach ($transactions->products as $transactionProduct) {
                                                    if ($transactionProduct['produkId'] == $p->id) {
                                                        $isSelected = true;
                                                        break;
                                                    }
                                                }
                                            @endphp
                                            <option value="{{ $p->id }}" data-harga="{{ $p->harga_produk }}" {{ $isSelected ? 'selected' : '' }}>
                                                {{ $p->nama_produk }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" id="selectedProdukId" name="selectedProdukId" value="">
                                    <button type="button" class="btn btn-outline-primary m-1" onclick="addRow()"><i
                                            class="ti ti-plus"></i></button>
                                </div>
                                
                                <!-- Tabel produk yang dipilih -->
                                <div class="table-responsive my-3">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">No</th>
                                                <th scope="col">Produk</th>
                                                <th scope="col">Harga</th>
                                                <th scope="col">Qty</th>
                                                <th scope="col">Total</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tableBody">
                                            @foreach ($transactions->products as $existingProduk)
                                                @php
                                                    $products = \App\Models\ProductsM::find($existingProduk['produkId']);
                                                @endphp
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $products->nama_produk }}</td>
                                                    <td>Rp. <span class="harga" data-harga="{{ $products->harga_produk }}">{{ $products->harga_produk }}</span></td>
                                                    <td>
                                                        <input type="number" class="form-control qtyInput" name="qty[]" value="{{ $existingProduk['qty'] }}" min="1">
                                                        <input type="hidden" name="produkId[]" value="{{ $existingProduk['produkId'] }}">
                                                    </td>
                                                    <td class="totalRow">Rp. {{ $existingProduk['total'] }}</td>
                                                    <td><button type="button" class="btn btn-outline-danger m-1" onclick="removeRow(this)"><i class="ti ti-trash"></i></button></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                
                                <!-- Input untuk total harga -->
                                <div class="mb-3">
                                    <label for="total_harga" class="form-label">Total Bayar</label>
                                    <input type="number" class="form-control" id="total_harga" name="total_harga" readonly value="{{ $transactions->total_harga}}">
                                </div>
                                
                                <!-- Input untuk uang bayar -->
                                <div class="mb-3">
                                    <label for="uang_bayar" class="form-label">Uang Bayar</label>
                                    <input type="number" class="form-control" name="uang_bayar"  aria-describedby="emailHelp" oninput="hitungUangKembali()">
                                    @error('uang_bayar')
                                    <p>{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- Tombol submit -->
                                <button type="submit" class="btn btn-outline-primary m-1">Edit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- .animated -->
</div><!-- .content -->

<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <!-- Your footer content goes here -->
            </div>
        </div>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    $(document).ready(function () {
        $('#myTable').DataTable();

        // Calculate and display the total sum
        var totalHarga = 0;
        var totalTransaksi = 0;

        $('tbody tr').each(function () {
            var harga = parseFloat($(this).find('td:eq(6)').text().replace('Rp. ', '').replace(',', '')) || 0; // Assuming 'total_harga' is in the 7th column
            var transaksi = 1; // Assuming each row is a transaction

            totalHarga += harga;
            totalTransaksi += transaksi;
        });

        $('#total-harga').text('Rp. ' + totalHarga.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        $('#total-transaksi').text(totalTransaksi);
    });
</script>


<script>
    
    function addRow() {
        var selectedProduk = $('#products option:selected');
        var produkName = selectedProduk.text();
        var produkId = selectedProduk.val();
        var produkHarga = selectedProduk.data('harga');
        var qty = $('#qty').val();
        var existingProduk = $('#tableBody tr').find('input[value="' + produkId + '"]').length > 0;

        if (!existingProduk) {
            var total = produkHarga * qty;

            var newRow = `
            <tr>
                <td>${$('#tableBody tr').length + 1}</td>
                <td>${produkName}</td>
                <td>Rp. <span class="harga" data-harga="${produkHarga}">${produkHarga}</span></td>
                <td>
                    <input type="number" class="form-control qtyInput" name="qty[]" value="${qty}" min="1">
                    <input type="hidden" name="produkId[]" value="${produkId}">
                </td>
                <td class="totalRow">Rp. ${total}</td>
                <td><button type="button" class="btn btn-outline-danger m-1" onclick="removeRow(this)"><i class="ti ti-trash"></i></button></td>
            </tr>
            `;

            $('#tableBody').append(newRow);
            updateTotalHarga();
        } else {
            alert('Produk sudah ditambahkan sebelumnya. Untuk mengedit, gunakan fitur edit.');
        }

        // Clear input fields after adding a row
        $('#qty').val('');
        $('#selectedProdukId').val('');
    }

    function removeRow(row) {
        $(row).parent().parent().remove();
        updateTotalHarga();
    }

    function updateTotalHarga() {
        var totalHarga = 0;

        $('#tableBody tr').each(function () {
            var qty = parseFloat($(this).find('.qtyInput').val());
            var harga = parseFloat($(this).find('.harga').data('harga'));
            var totalRow = qty * harga;

            $(this).find('.totalRow').text('Rp. ' + totalRow);
            totalHarga += totalRow;
        });

        $('#total_harga').val(totalHarga);
    }

    $(document).on('input', '.qtyInput', function () {
        updateTotalHarga();
    });

</script>
@endsection