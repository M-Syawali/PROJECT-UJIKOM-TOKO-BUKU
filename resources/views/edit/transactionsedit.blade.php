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
            <form action="{{ route('transactions.update', $transactions->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="nomor_unik">Nomor Unik</label>
                    <input type="text" class="form-control" id="nomor_unik" name="nomor_unik" value="{{ $transactions->nomor_unik }}" readonly >
                    @error('nomor_unik')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Nama Pelanggan</label>
                    <input name="nama_pelanggan" type="text" class="form-control" placeholder="..." value="{{ $transactions->nama_pelanggan }}">
                    @error('nama_pelanggan')
                    <p>{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Nama Produk + Harga</label>
                    <select name="id_produk" class="form-control" onchange="updateTotalPrice()" required>
                        <option value="">- Pilih Produk -</option>
                        @foreach ($products as $data)
                            <?php
                            $selected = ($data->id == $transactions->id_produk) ? "selected" : "";
                            ?>
                            <option {{ $selected }} value="{{ $data->id }}" data-harga="{{ $data->harga_produk }}">
                                {{ $data->nama_produk }} - {{ $data->harga_produk }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>QTY</label>
                    <input name="qty" id="qty" type="number" class="form-control" placeholder="..." value="{{ $transactions->qty }}" oninput="updateTotalPrice()">
                    @error('qty')
                    <p>{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Total Bayar</label>
                    <input name="total_harga" id="total_harga" type="number" class="form-control" placeholder="..." value="{{ $transactions->total_harga }}" readonly>
                    @error('total_harga')
                    <p>{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Uang Bayar</label>
                    <input name="uang_bayar" type="number" class="form-control" placeholder="..." value="{{ $transactions->uang_bayar }}">
                    @error('uang_bayar')
                    <p>{{ $message }}</p>
                    @enderror
                </div>
                <br>
                <button type="submit" class="btn btn-outline-primary m-1 px-5">Edit</button>
            </form>
        </div>
</div>

<script>

    function updateTotalPrice() {
        var selectedProduct = document.querySelector('select[name="id_produk"]');
        var selectedHarga = parseFloat(selectedProduct.options[selectedProduct.selectedIndex].getAttribute('data-harga'));
        var qtyInput = parseFloat(document.getElementById('qty').value);
        var totalHarga = selectedHarga * qtyInput;

        document.getElementById('total_harga').value = totalHarga.toFixed(2); // Format the total price with two decimal places
    }
</script>
@endsection