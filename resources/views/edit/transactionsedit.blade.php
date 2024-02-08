@extends('layout.header')
@section('content')
<h3 class="h3 mb-0 text-gray-800"><strong>PAGES - EDIT TRANSACTIONS</strong></h3>
<br>
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
        <a href="{{ route('transactions.index') }}" class="btn btn-outline-dark m-1"><i
                        class="ti ti-arrow-left"></i> </a>
                        <br>
                        <br>
            <form action="{{ route('transactions.update', $transaction->id) }}" method="POST" enctype="multipart/form-data" id="transactionForm">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Nomor Unik</label>
                    <input name="nomor_unik" type="text" class="form-control" placeholder="..." value="{{ random_int(1000000000, 9999999999) }}" readonly>
                    @error('nomor_unik')
                    <p>{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Nama Pelanggan</label>
                    <input name="nama_pelanggan" type="text" class="form-control" placeholder="..."value="{{ $transaction->nama_pelanggan }}">
                    @error('nama_pelanggan')
                    <p>{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Pilih Produk</label>
                    <div class="input-group">
                        <select class="form-control" id="id_produk">
                            <option value="">Pilih Produk</option>
                            @foreach ($products as $data)
                                <option value="{{ $data->id }}" data-nama="{{ $data->nama_produk }}" data-harga="{{ $data->harga_produk }}" data-stok="{{ $data->stok }}">
                                    {{ $data->nama_produk }} - {{ $data->harga_produk }}
                                </option>
                            @endforeach
                        </select>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-outline-primary m-1" onclick="addSelectedProduct()"><i class="ti ti-plus"></i></button>
                        </div>
                    </div>
                </div>
                <br>
               <!-- Tambahkan elemen untuk menampilkan tabel produk yang dipilih -->
                <div id="selectedProductsTableContainer">
                    <table id="selectedProductsTable" class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama Produk</th>
                                <th>Harga Produk</th>
                                <th>Qty</th>
                                <th>Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Daftar produk yang dipilih akan ditampilkan di sini -->
                        </tbody>
                    </table>
                </div>

                <!-- Tambahkan tabel total harga -->
                <div id="totalContainer" class="mt-3">
                    <table class="table table-bordered">
                        <tr>
                            <th>Total Keseluruhan Harga:</th>
                            <td id="totalHarga">Rp.0</td>
                        </tr>
                    </table>
                </div>

                <script>
                    var selectedProducts = {};

                    function addProductToTable(productId, productName, productPrice, productStock) {
                        if (productStock <= 0) {
                            Swal.fire({
                                title: 'Stok Habis',
                                text: 'Stok produk ' + productName + ' habis',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                            return;
                        }

                        if (selectedProducts[productId]) {
                            selectedProducts[productId].qty += 1;
                        } else {
                            selectedProducts[productId] = {
                                name: productName,
                                price: productPrice,
                                qty: 1
                            };
                        }

                        displaySelectedProducts();
                    }

                    function addSelectedProduct() {
                    var selectedProductId = $('#id_produk').val();
                    var selectedProductName = $('#id_produk option:selected').data('nama');
                    var selectedProductPrice = $('#id_produk option:selected').data('harga');
                    var selectedProductStock = $('#id_produk option:selected').data('stok');

                        if (selectedProductId && selectedProductName && selectedProductPrice) {
                            addProductToTable(selectedProductId, selectedProductName, selectedProductPrice, selectedProductStock);
                        } else {
                            Swal.fire({
                                title: 'Pilih Produk',
                                text: 'Pilih setidaknya satu produk',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    }


                function removeProductFromTable(button) {
                    var productId = $(button).data('product-id');

                    if (selectedProducts[productId]) {
                        delete selectedProducts[productId];
                        $(button).closest('tr').remove(); // Hapus baris dari tabel saat menghapus produk
                    }

                        displaySelectedProducts();
                    }

                    function formatRupiah(angka) {
                        var reverse = angka.toString().split('').reverse().join(''),
                            ribuan = reverse.match(/\d{1,3}/g);
                        ribuan = ribuan.join('.').split('').reverse().join('');
                        return ribuan;
                    }

                    function displayTotalHarga() {
                        var totalHarga = 0;

                        for (var productId in selectedProducts) {
                            if (selectedProducts.hasOwnProperty(productId)) {
                                var product = selectedProducts[productId];
                                var totalPerProduk = product.qty * parseFloat(product.price);
                                totalHarga += totalPerProduk;
                            }
                        }

                        $('#totalHarga').text('Rp.' + formatRupiah(totalHarga.toFixed(2)));
                    }

                    function displaySelectedProducts() {
                        $('#selectedProductsTable tbody').empty();

                        for (var productId in selectedProducts) {
                            if (selectedProducts.hasOwnProperty(productId)) {
                                var product = selectedProducts[productId];
                                var totalPerProduk = product.qty * parseFloat(product.price);

                                $('#selectedProductsTable tbody').append(
                                    '<tr>' +
                                    '<td>' + product.name + '</td>' +
                                    '<td>' + product.price + '</td>' +
                                    '<td><input type="number" class="form-control" value="' + product.qty + '" onchange="updateQty(this, ' + productId + ')" /></td>' +
                                    '<td>' + formatRupiah(totalPerProduk) + '</td>' +
                                    '<td><button type="button" class="btn btn-outline-danger" data-product-id="' + productId + '" onclick="removeProductFromTable(this)"><i class="ti ti-trash"></i></button></td>' +
                                    '</tr>'
                                );
                            }
                        }

                        displayTotalHarga();
                    }

                    function updateQty(input, productId) {
                        var qty = parseInt($(input).val());
                        if (!isNaN(qty) && qty > 0) {
                            selectedProducts[productId].qty = qty;
                            displaySelectedProducts();
                        } else {
                            // Jika input tidak valid, tampilkan pesan kesalahan dan kembalikan ke nilai sebelumnya
                            $(input).val(selectedProducts[productId].qty);
                            Swal.fire({
                                title: 'Input tidak valid',
                                text: 'Harap masukkan nilai kuantitas yang valid.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    }

                    function validateAndSubmit() {
                        if ($('#selectedProductsTable tbody tr').length === 0) {
                            Swal.fire({
                                title: 'Pilih Produk',
                                text: 'Pilih setidaknya satu produk',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        } else if (!$('input[name="uang_bayar"]').val()) {
                            Swal.fire({
                                title: 'Uang Bayar',
                                text: 'Masukkan jumlah uang bayar',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            for (var productId in selectedProducts) {
                                if (selectedProducts.hasOwnProperty(productId)) {
                                    var product = selectedProducts[productId];
                                    $('#transactionForm').append('<input type="hidden" name="selected_products[' + productId + '][name]" value="' + product.name + '">');
                                    $('#transactionForm').append('<input type="hidden" name="selected_products[' + productId + '][price]" value="' + product.price + '">');
                                    $('#transactionForm').append('<input type="hidden" name="selected_products[' + productId + '][qty]" value="' + product.qty + '">');
                                }
                            }

                            displaySelectedProducts();

                            document.getElementById('transactionForm').submit();
                            showSuccessPopup();
                     }
                }
</script>

@endsection