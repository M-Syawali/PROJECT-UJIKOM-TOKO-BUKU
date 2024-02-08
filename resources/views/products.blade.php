@extends('layout.header')
@section('content')
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><strong>PAGES - PRODUCTS</strong></h1>
    <div class="row">
    <div class="row">
        <div class="col-lg-12 grid-margin text-align-right"> <!-- Updated class to text-align-right -->  <form action="{{ route('products.index')}}" method="get" class="d-flex justify-content-end"> <!-- Updated class to justify-content-end -->
                <input type="search" name="search" class="form-control shorter-input" placeholder="Cari Produk" value="{{ $vcari }}">
                <button type="submit" class="btn btn-outline-primary"><i class="ti ti-search"></i></button>
                <a href="{{ url('products')}}" class="ml-2">
                    <button type="button" class="btn btn-outline-dark"><i class="ti ti-reload"></i></button>
                </a>
            </form>
            <br>
            @if (Auth::user()->role == 'admin')
                <a href="{{ url('products/create') }}" class="btn btn-outline-primary"><i class="ti ti-plus"></i> Tambah</a>
            @endif
            @if (Auth::user()->role == 'owner')
                <a href="{{ url('produk/pdf')}}" class="btn btn-outline-warning"><i class="ti ti-printer"></i> Print Data</a>
            @endif
            <br>
            <br>
        </div>
    </div>
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
        <style>
            .card {
                height: 100%;
                width: 250%;
                max-width: 170px; /* Set your desired max-width */
                margin: auto;
            }

            .card-body {
                display: flex;
                flex-direction: column;
                justify-content: space-between;
                height: 300%;
            }

            .card-text {
                font-size: 60px; /* Set your desired font size */
            }

            .btn {
                font-size: 15px; /* Set your desired font size */
            }
            .shorter-input {
                max-width: 200px; /* Set your desired maximum width */
            }
        </style>
        @foreach ($products as $p)
            <div class="col-lg-2 col-md-2 col-sm-4 mb-2"> <!-- Adjusted grid classes here -->
                <div class="card shadow">
                    <img src="{{ asset('assets/images/products/' . $p->foto) }}" class="card-img-top" alt="Product Image">
                    <div class="card-body">
                        <p class="card-title" style="font-size: 15px;"><strong>{{ $p->nama_produk }}</strong></p>
                        <h5 class="card-text" style="font-size: 11px;">{{ 'Rp ' . number_format($p->harga_produk, 0, ',', '.') }}</h5>
                        <br>
                        <div class="mb-0">
                        @if (Auth::user()->role== 'admin')
                            <a href="{{ route('products.edit', $p->id) }}" class="btn btn-sm btn-outline-primary" style="font-size: 15px;"><i class="ti ti-edit"></i></a>
                            @endif
                            <button type="button" class="btn btn-sm btn-outline-warning" data-toggle="modal" data-target="#detailModal{{ $p->id }}">
                                <i class="ti ti-eye"></i> 
                            </button>
                            @if (Auth::user()->role== 'admin')
                            <a href="{{ route('products.destroy', $p->id) }}"
                                class="btn btn-sm btn-outline-danger"
                                onclick="event.preventDefault();
                                        if (confirm('Apakah anda yakin ingin menghapus?')) {
                                            document.getElementById('delete-form-{{ $p->id }}').submit();
                                        }" style="font-size: 15px;">
                                <i class="ti ti-trash"></i>
                            </a>
                            <form id="delete-form-{{ $p->id }}" action="{{ route('products.destroy', $p->id) }}"
                                method="POST" style="display: none;">
                                @method('DELETE')
                                @csrf
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="detailModal{{ $p->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <!-- Isi modal dengan detail produk -->
                        <div class="row">
                            <div class="col-md-6">
                                <img src="{{ asset('assets/images/products/' . $p->foto) }}" class="img-fluid" alt="Product Image">
                            </div>
                            <div class="col-md-5">
                                <h4 class="modal-title" id="exampleModalLabel">{{ $p->nama_produk }}</h4>
                                <br>
                                <p> {{ $p->jenis_buku }}</p>
                                <p>Penulis : {{ $p->penulis }}</p>
                                <p>Penerbit : {{ $p->penerbit }}</p>
                                <p>Stok : {{ $p->stok }}</p>
                                <p>{{ 'Rp ' . number_format($p->harga_produk, 0, ',', '.') }}</p>
                                <!-- Tambahkan informasi lain sesuai kebutuhan -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary m-1" data-dismiss="modal">Tutup</button>
                        <!-- Tambahkan tombol atau fungsi lain sesuai kebutuhan -->
                    </div>
                </div>
            </div>
        </div>

        @endforeach
    </div>
@endsection
