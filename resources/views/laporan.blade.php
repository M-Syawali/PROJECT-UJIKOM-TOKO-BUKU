@extends('layout.header')

@section('content')
<h1 class="h3 mb-4 text-gray-800"><strong>PAGES - LAPORAN</strong></h1>
<div class="card shadow mb-4">
    <div class="card-body">
        <form action="{{ route('laporan.filter') }}" method="GET" class="row">
            <div class="form-group col-md-5">
                <label for="startDate">Tanggal Awal:</label>
                <input type="date" name="startDate" id="startDate" class="form-control">
            </div>
            <div class="form-group col-md-5">
                <label for="endDate">sampai</label>
                <input type="date" name="endDate" id="endDate" class="form-control">
            </div>
            <div class="form-group col-md-5">
                <label for="productName">Nama Produk:</label>
                <select name="productName" id="productName" class="form-control">
                    <option value="" selected>Pilih Produk</option>
                    @foreach($products as $product)
                        <option value="{{ $product->nama_produk }}" @if(request('productName') == $product->nama_produk) selected @endif>{{ $product->nama_produk }}</option>
                    @endforeach
                </select>
            </div>
            <br>
            <br>
            <br>
            <br>
            <div class="form-group col-md-12">
                <!-- Move the buttons to the same row -->
                <button type="submit" class="btn btn-outline-primary m-1">Cari Data</button>

                @if(request()->has('startDate') && request()->has('endDate'))
                    <a href="{{ route('laporan.export', ['startDate' => request('startDate'), 'endDate' => request('endDate') , 'productName' => request('productName') ]) }}" class="btn btn-outline-dark m-1">Cetak PDF</a>
                @else
                    <a href="{{ route('laporan.export') }}" class="btn btn-outline-dark">Export PDF</a>
                @endif
            </div>
        </form>
        <div class="d-flex justify-content-between align-items-center col-md-4">
        </div>
        <br>
        <br>
        @if(($transactionsM)->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered text-nowrap" id="" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>NOMOR UNIK</th>
                        <th>NAMA PELANGGAN</th>
                        <th>NAMA PRODUK</th>
                        <th>HARGA PRODUK</th>
                        <th>QTY</th>
                        <th>TOTAL HARGA</th>
                        <th>UANG BAYAR</th>
                        <th>UANG KEMBALI</th>
                        <th>TANGGAL</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactionsM as $data)
                    <tr>
                        <td>{{ $data->nomor_unik}}</td>
                        <td>{{ $data->nama_pelanggan }}</td>
                        <td>{{ $data->products->nama_produk }}</td>
                        <td>Rp. {{ number_format ($data->products->harga_produk, 0, ',', ',') }}</td>
                        <td>{{ $data->qty }}</td>
                        <td>Rp. {{ number_format ($data->total_harga, 0, ',', ',') }}</td>
                        <td>Rp. {{ number_format ($data->uang_bayar, 0, ',', ',') }}</td>
                        <td>Rp. {{ number_format ($data->uang_kembali, 0, ',', ',') }}</td>
                        <td>{{ $data->created_at }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <!-- Table content remains the same -->
            </table>
        </div>
        @else
        <p class="mt-3">Tidak ada data yang sesuai dengan filter.</p>
        @endif
    </div>
</div>
</div><!-- .content -->
@endsection
