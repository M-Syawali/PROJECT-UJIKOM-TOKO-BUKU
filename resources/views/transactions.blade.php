@extends('layout.header')
@section('content')
<style>
    .list-item {
        list-style-type: disc;
        margin-left: 20px;
    }
</style>
<h1 class="h3 mb-4 text-gray-800"><strong>PAGES - TRANSACTIONS</strong></h1>
<div class="card shadow mb-4">
    @if ($message = Session::get('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'success',
                title: 'Success Message',
                text: @json($message),
                confirmButtonText: 'OK'
            });
        });
    </script>
    @endif
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="card-body">
                    @if (Auth::user()->role == 'kasir')
                    <a href="{{ url('transactions/create') }}" class="btn btn-outline-primary"><i class="ti ti-plus"></i>Tambah</a>
                    @endif
                    <br>
                    <br>
                    <div class="table-responsive">
                        <table id="myTable" class="table table-striped table-bordered table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>NOMOR UNIK</th>
                                    <th>NAMA PELANGGAN</th>
                                    <th>NAMA PRODUK</th>
                                    <th>QTY</th>
                                    <th>HARGA SATUAN</th>
                                    <th>TOTAL HARGA</th>
                                    <th>UANG BAYAR</th>
                                    <th>UANG KEMBALI</th>
                                    <th>TANGGAL PEMBELIAN</th>
                                    <th>AKSI</th>
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
                                            @foreach ($p->products as $products)
                                                @php
                                                    $produkName = \App\Models\ProductsM::find($products['produkId']);
                                                @endphp
                                                @if(isset($produkName))
                                                    <li>{{ $produkName['nama_produk'] }}</li>
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
                                <td>Rp. {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                                <td>Rp. {{ number_format($p->uang_bayar, 0, ',', '.') }}</td>
                                <td>Rp. {{ number_format($p->uang_kembali, 0, ',', '.') }}</td>
                                <td>{{ $p->created_at }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            @if (Auth::user()->role == 'kasir')
                                            <a href="{{ route('transactions.pdf', $p->id) }}" target="_blank" class="btn btn-outline-warning m-1">
                                                <i class="ti ti-printer"></i>
                                            </a>
                                            @endif
                                            @if (Auth::user()->role == 'admin')
                                            <a href="{{ route('transactions.edit', $p->id) }}" class="btn btn-outline-primary m-1">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            <form action="{{ route('transactions.destroy', $p->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger m-1" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div><!-- .content -->
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
    @endsection
