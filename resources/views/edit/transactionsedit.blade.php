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

                                <div class="mb-3">
                                    <label for="searchInput" class="form-label">Cari Jenis Buku - Nama Buku</label>
                                    <div class="input-group">
                                        <input type="text" id="searchInput" class="form-control" placeholder="Masukan Jenis Buku - Nama Buku">
                                    </div>
                                </div>

                                <!-- Pilihan produk -->
                                <label for="products" class="form-label">Buku</label>
                                <div class="mb-3 d-flex">
                                   
                                    <select name="products[]" required id="products" class="form-control">
                                        <option selected>Pilih Produk</option>
                                        @foreach ($products as $p)
                                            @php
                                                // Mengatur nilai default untuk flag isSelected
                                                $isSelected = false;
                                                
                                                // Melakukan loop pada setiap produk dalam transaksi
                                                foreach ($transactions->products as $transactionProduct) {
                                                    // Memeriksa apakah produk saat ini dalam iterasi cocok dengan produk dalam transaksi
                                                    if ($transactionProduct['produkId'] == $p->id) {
                                                        // Jika ada kecocokan, set isSelected menjadi true dan keluar dari loop
                                                        $isSelected = true;
                                                        break;
                                                    }
                                                }
                                            @endphp
                                            <option value="{{ $p->id }}" data-harga="{{ $p->harga_produk }}" {{ $isSelected ? 'selected' : '' }}>
                                                {{ $p->jenis_buku }} - {{ $p->nama_produk }} - ( {{ $p->stok}} )
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
                                    <input type="number" class="form-control" name="uang_bayar" id="uang_bayar" aria-describedby="emailHelp" oninput="hitungUangKembali()">
                                    @error('uang_bayar')
                                    <p>{{ $message }}</p>
                                    @enderror
                                </div>
                                <!-- Alert jika uang bayar kurang -->
                                <div id="alertUangKurang" class="alert alert-danger d-none" role="alert">
                                    Jumlah uang bayar kurang dari total harga.
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
    </script>
<script>
    
    function addRow() {
        var selectedProduk = $('#products option:selected');
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

        // Clear input fields after adding a row
        $('#qty').val('');
        $('#selectedProdukId').val('');
    }

        function removeRow(row) {
        $(row).closest('tr').remove();
        updateRowNumbers(); // Panggil fungsi untuk memperbarui nomor urut setelah menghapus baris
        updateTotalHarga(); // Panggil fungsi untuk memperbarui total harga setelah menghapus baris
    }

    function updateRowNumbers() {
        $('#tableBody tr').each(function(index) {
            $(this).find('td:first').text(index + 1); // Perbarui nomor urut
        });
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
