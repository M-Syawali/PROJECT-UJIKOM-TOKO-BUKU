@extends('layout.header')
@section('content')
<h3 class="h3 mb-0 text-gray-800"><strong>PAGES - TAMBAH TRANSACTIONS</strong></h3>
<br>
<form action="{{ route('transactions.store') }}" method="POST" class="mb-3">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="content">
                    <div class="card-body">
                        <a href="{{ route('transactions.index') }}" class="btn btn-outline-dark m-1"><i class="ti ti-arrow-left"></i></a>
                        <div class="card-body card-block">
                            <form action="{{route('transactions.store')}}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="nomor_unik" class="form-label">Nomor Unik</label>
                                    <input type="number" class="form-control" name="nomor_unik" aria-describedby="emailHelp" value="{{ random_int(1000000000, 9999999999) }}" readonly>
                                    @error('nomor_unik')
                                    <p>{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
                                    <input type="text" class="form-control" name="nama_pelanggan" aria-describedby="emailHelp" required>
                                    @error('nama_pelanggan')
                                    <p>{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="searchInput" class="form-label">Cari Jenis Buku - Nama Buku</label>
                                    <div class="input-group">
                                        <input type="text" id="searchInput" class="form-control" placeholder="Masukan Jenis Buku - Nama Buku">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="products" class="form-label">Buku</label>
                                    <div class="d-flex align-items-center">
                                        <select name="products[]" required id="products" class="form-control select2">
                                            <option selected>-Pilih Produk-</option>
                                            @foreach ($products as $p)
                                            <option value="{{ $p->id }}" data-harga="{{ $p->harga_produk }}" data-stok="{{ $p->stok }}" data-jenis="{{ $p->jenis_buku }}">{{ $p->jenis_buku }} - {{ $p->nama_produk }} - ( {{ $p->stok }} )</option>
                                            @endforeach
                                        </select>
                                        <button type="button" class="btn btn-outline-primary ms-2" onclick="addRow()"><i class="ti ti-plus"></i></button>
                                    </div>
                                </div>
                                <!-- Alert stok habis -->
                                <div id="alertStokHabis" class="alert alert-danger d-none" role="alert">
                                    Stok produk habis. Silakan pilih produk lain.
                                </div>
                                <!-- End of alert stok habis -->
                                <div class="table-responsive my-3">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Produk</th>
                                                <th>Harga Produk</th>
                                                <th>Qty</th>
                                                <th>Total</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tableBody"></tbody>
                                    </table>
                                </div>
                                <div class="mb-3">
                                    <label for="total_harga" class="form-label">Total Bayar</label>
                                    <input type="number" class="form-control" id="total_harga" name="total_harga" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="uang_bayar" class="form-label">Uang Bayar</label>
                                    <input type="number" class="form-control" name="uang_bayar" id="uang_bayar" aria-describedby="emailHelp" oninput="hitungUangKembali()">
                                    @error('uang_bayar')
                                    <p>{{ $message }}</p>
                                    @enderror
                                </div>
                                <!-- Alert jika uang bayar kurang -->
                                <div id="alertUangKurang" class="alert alert-danger d-none" role="alert">
                                    Jumlah uang bayar kurang dari total harga.
                                </div>
                                <div class="mb-3">
                                    <button type="submit" class="btn btn-outline-primary btn-animated">Tambah</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
    <script>
        $(document).ready(function () {
            // Get the select element and options
            var select = $('#products');
            var options = select.find('option');

            // Get the search input element
            var searchInput = $('#searchInput');

            // Add input event listener to the search input
            searchInput.on('input', function () {
                var searchQuery = $(this).val().toLowerCase();

                // Filter options based on the search query
                var filteredOptions = options.filter(function () {
                    var optionText = $(this).text().toLowerCase();
                    return optionText.indexOf(searchQuery) > -1;
                });

                // Update the select element with filtered options
                select.html(filteredOptions);
            });
        });

        // Function to add row
        function addRow() {
            var selectedProduk = $('#products option:selected');
            var stok = selectedProduk.data('stok');
            if (stok <= 0) {
                $('#alertStokHabis').removeClass('d-none');
                return;
            }
            $('#alertStokHabis').addClass('d-none');

            var produkName = selectedProduk.text();
            var produkId = selectedProduk.val();
            var produkHarga = selectedProduk.data('harga');
            var qty = selectedProduk.closest('.d-flex').find('.qtyInput').val();
            
            // Check if the product already exists in the table
            var existingProduk = $('#tableBody').find('input[name="produkId[]"][value="' + produkId + '"]').length > 0;
            if (existingProduk) {
                Swal.fire(
                    'Produk sudah ditambahkan sebelumnya',
                    'Anda tidak dapat menambahkan produk yang sama lagi.',
                    'warning'
                );
                return; // Stop further execution
            }

            var total = produkHarga * qty;

            var newRow = `
                <tr>
                    <td>${$('#tableBody tr').length + 1}</td>
                    <td>${produkName}</td>
                    <td>Rp. <span class="harga">${produkHarga}</span></td>
                    <td>
                        <input type="number" class="form-control qtyInput" name="qty[]" value="${qty}" min="1" data-harga="${produkHarga}">
                        <input type="hidden" name="produkId[]" value="${produkId}">
                    </td>
                    <td class="totalRow">Rp. ${total}</td>
                    <td><button type="button" class="btn btn-outline-danger" onclick="removeRow(this)"><i class="ti ti-trash"></i></button></td>
                </tr>`;
            $('#tableBody').append(newRow);

            updateTotalHarga();
        }

       function removeRow(row) {
            $(row).closest('tr').remove();
            updateRowNumbers(); // Update row numbers after removing a row
            updateTotalHarga(); // Update total harga after removing a row
        }

        function updateRowNumbers() {
            $('#tableBody tr').each(function(index) {
                $(this).find('td:first').text(index + 1); // Update nomor urut
            });
        }

        function updateTotalHarga() {
            var totalHarga = 0;

            $('#tableBody tr').each(function() {
                var qty = parseFloat($(this).find('.qtyInput').val());
                var harga = parseFloat($(this).find('.harga').text());
                var totalRow = qty * harga;

                $(this).find('.totalRow').text('Rp. ' + totalRow);
                totalHarga += totalRow;
            });

            $('#total_harga').val(totalHarga);
        }

        $(document).on('input', '.qtyInput', function() {
            updateTotalHarga();
        });

        // Function to calculate uang kembali
        function hitungUangKembali() {
            var totalHarga = parseFloat($('#total_harga').val());
            var uangBayar = parseFloat($('#uang_bayar').val());

            // Check if uang bayar is less than total harga
            if (uangBayar < totalHarga) {
                $('#alertUangKurang').removeClass('d-none');
                // Disable the submit button
                $('button[type="submit"]').prop('disabled', true);
            } else {
                $('#alertUangKurang').addClass('d-none');
                // Enable the submit button
                $('button[type="submit"]').prop('disabled', false);
            }
        }
    </script>
@endsection
