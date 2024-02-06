@extends('layout.header')

@section('content')
<h3 class="h3 mb-0 text-gray-800"><strong>PAGES - EDIT PRODUCTS</strong></h3>
<div class="row mt-3">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
    </div>
    <br>
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <a href="{{ route('products.index') }}" class="btn btn-outline-dark m-1"><i
                        class="ti ti-arrow-left"></i> </a>
                <br>
                <br>
                <form method="POST" action="{{ route('products.update' , $products->id) }}"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="foto">Foto</label>
                        <br>
                        <input type="file" id="foto" class="form-control-file" name="foto"
                            value="{{ $products->foto }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="jenis_buku">Jenis Buku</label>
                        <select name="jenis_buku" id="jenis_buku" class="form-control" name="jenis_buku">
                            <option value="">- Pilih Jenis Buku -</option>
                            <option value="Novel" {{ $products->jenis_buku == 'Novel' ? 'selected' : '' }}>Novel
                            </option>
                            <option value="Cerita" {{ $products->jenis_buku == 'Cerita' ? 'selected' : '' }}>Cerita
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nama_produk">Nama Produk</label>
                        <input type="text" id="nama_produk" class="form-control" name="nama_produk"
                            value="{{ $products->nama_produk }}">
                    </div>
                    <div class="form-group">
                        <label for="penulis">Penulis</label>
                        <input type="text" id="penulis" class="form-control" name="penulis"
                            value="{{ $products->penulis }}">
                    </div>
                    <div class="form-group">
                        <label for="penerbit">Penerbit</label>
                        <input type="text" id="penerbit" class="form-control" name="penerbit"
                            value="{{ $products->penerbit }}">
                    </div>
                    <div class="form-group">
                        <label for="stok">Stok</label>
                        <input type="number" id="stok" class="form-control" name="stok" value="{{ $products->stok }}">
                    </div>
                    <div class="form-group">
                        <label for="harga_produk">Harga Produk</label>
                        <input type="number" id="harga_produk" class="form-control" name="harga_produk"
                            value="{{ $products->harga_produk }}">
                    </div>
                    <br>
                    <button type="submit" class="btn btn-outline-primary m-1 px-5">Edit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
