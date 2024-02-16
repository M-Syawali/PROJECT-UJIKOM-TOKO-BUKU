@extends('layout.header')
@section('content')
<h1 class="h3 mb-4 text-gray-800"><strong>PAGES - LAPORAN</strong></h1>
<style>
    /* Font tabel */
    .table td {
        font-size: 14px; /* Ukuran font */
    }

    .btn-action {
        margin-right: 10px;
    }

    /* Mengatur tata letak form secara horizontal */
    .form-inline > * {
        display: inline-block;
        vertical-align: top;
    }

    /* Memberikan jarak antar elemen dalam form */
    .form-group {
        margin-right: 10px;
    }

</style>
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
            <br><br>
            <form action="{{ route('laporan.filter') }}" method="GET" class="form-inline">
                <div class="form-group col-md-5">
                    <label for="startDate">Tanggal Awal: </label>
                    <input type="date" name="startDate" id="startDate" class="form-control">
                </div>
                <div class="form-group col-md-5">
                    <label for="endDate;">Tanggal Akhir: </label>
                    <input type="date" name="endDate" id="endDate" class="form-control">
                </div>
                <br>
                <br>
                <div class="form-group">
                    <button type="submit" class="btn btn-outline-primary btn-icon">
                        <i class="ti ti-search"></i>
                    </button>
                    <button type="button" class="btn btn-outline-dark btn-icon" onclick="window.location.href='{{ route('laporan.index') }}'">
                        <i class="ti ti-refresh"></i>
                    </button>
                    @if(request()->has('startDate') && request()->has('endDate'))
                        <a href="{{ route('laporan.export', ['startDate' => request('startDate'), 'endDate' => request('endDate')]) }}" class="btn btn-outline-danger m-1"><i class="ti ti-printer"></i> Cetak PDF</a>
                    @else
                        <a href="{{ route('laporan.export') }}" target="_blank" class="btn btn-outline-danger m-1">
                            <i class="mdi mdi-printer btn-icon-append"></i>
                            Unduh PDF
                        </a>
                    @endif
                </div>
            </form>
            <br>
            <div class="table-responsive">
                <table id="myTable" class="table table-striped table-bordered table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>NOMOR UNIK</th>
                            <th>NAMA PELANGGAN</th>
                            <th>PRODUK</th>
                            <th>QTY</th>
                            <th>HARGA SATUAN</th>
                            <th>TOTAL HARGA</th>
                            <th>UANG BAYAR</th>
                            <th>UANG KEMBALI</th>
                            <th>TANGGAL PEMBELIAN</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $p->nomor_unik }}</td>
                                <td>{{ $p->nama_pelanggan }}</td>
                                <td>
                                    @if(isset($p->products) && is_array($p->products))
                                        <ul  class="list-item">
                                            @php $counter = 1; @endphp
                                            @foreach ($p->products as $products)
                                                @php
                                                    $produkName = \App\Models\ProductsM::find($products['produkId']);
                                                @endphp
                                                @if(isset($produkName))
                                                    <li>{{ $counter }}. {{ $produkName['nama_produk'] }}</li>
                                                    @php $counter++; @endphp
                                                @endif
                                            @endforeach
                                        </ul>
                                    @endif 
                                </td>
                                <td>
                                    @if(isset($p->products) && is_array($p->products))
                                        <ul>
                                            @foreach ($p->products as $products)
                                                <li>{{ $products['qty'] }}</li>
                                            @endforeach
                                        </ul>
                                    @endif 
                                </td>
                                <td>
                                    @if(isset($p->products) && is_array($p->products))
                                        <ul>
                                            @foreach ($p->products as $products)
                                                @php
                                                    $produkName = \App\Models\ProductsM::find($products['produkId']);
                                                @endphp
                                                @if(isset($produkName))
                                                    <li>Rp. {{ number_format($produkName['harga_produk'], 0, ',', '.') }}</li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    @endif 
                                </td>
                                <td class="text-center">Rp. {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                                <td class="text-center">Rp. {{ number_format($p->uang_bayar, 0, ',', '.') }}</td>
                                <td class="text-center">Rp. {{ number_format($p->uang_kembali, 0, ',', '.') }}</td>
                                <td>{{ $p->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
