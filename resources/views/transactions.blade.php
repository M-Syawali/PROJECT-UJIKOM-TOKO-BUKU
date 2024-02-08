@extends('layout.header')
@section('content')
<style>
    /* Font tabel */
    .table td {
        font-size: 14px; /* Ukuran font */
    }

    .btn-action {
        margin-right: 10px;
    }
</style>
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
<h1 class="h3 mb-4 text-gray-800"><strong>PAGES - TRANSACTIONS</strong></h1>
<div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
        <div class="card-body">
          
            <div class="table-responsive">
            @if (Auth::user()->role== 'kasir')
                <a href="{{ url('transactions/create') }}" class="btn btn-outline-primary"><i class="ti ti-plus"></i>Tambah</a>
            @endif
                <br><br>
                <br>
                <div class="table-responsive">
                    <table class="table table-bordered text-nowrap" id="myTable" width="100%" cellspacing="0">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nomor Unik</th>
                            <th>Nama Pelanggan</th>
                            <th>Produk</th>
                            <th>Total Harga</th> 
                            <th>Uang Bayar</th>
                            <th>Uang Kembali</th>
                            <th>Waktu Transaksi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $nomor_unik = 1; $grandTotal = 0; ?>
                        @forelse($groupedTransactions as $transactions)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $transactions[0]->nomor_unik }}</td>
                                <td>{{ $transactions[0]->nama_pelanggan }}</td>
                                <td>
                                    <ol>
                                        <?php $totalHarga = 0; ?>
                                        @foreach ($transactions as $transaction)
                                            <li>
                                                @foreach ($transaction->products as $product)
                                                    {{ $product->nama_produk }} - {{ $transaction->qty }} - Rp.{{ number_format($transaction->qty * $product->harga_produk, 0, ',', '.') }}
                                                    <?php $totalHarga += $transaction->qty * $product->harga_produk; ?>
                                                @endforeach
                                            </li>
                                        @endforeach
                                    </ol>
                                </td>                                                                                     
                                <td>Rp.{{ number_format($totalHarga, 0, ',', '.') }}</td> 
                                <td>Rp.{{ number_format($transactions[0]->uang_bayar, 0, ',', '.') }}</td>
                                <td>Rp.{{ number_format($transactions[0]->uang_kembali, 0, ',', '.') }}</td>
                                <td>{{ $transactions[0]->created_at }}</td>
                                <td>
                            @if (Auth::user()->role== 'admin')
                            <a href="{{ route('transactions.edit', $transactions[0]->nomor_unik) }}" class="btn btn-outline-primary m-1"><i class="ti ti-edit"></i></a>
                            <a href="{{ route('transactions.destroy', $transactions[0]->nomor_unik) }}"
                            class="btn btn-outline-danger m-1"
                            onclick="event.preventDefault();
                                          if (confirm('Apakah anda yakin ingin menghapus?')) {
                                              document.getElementById('delete-form-{{ $transactions[0]->nomor_unik }}').submit();
                                            }">
                                <i class="ti ti-trash"></i>
                                <form id="delete-form-{{ $transactions[0]->nomor_unik }}" action="{{ route('transactions.destroy', $transactions[0]->nomor_unik) }}"
                                method="POST" style="display: none;">
                                @method('DELETE')
                                @csrf
                            </form>
                            @endif
                            @if (Auth::user()->role== 'kasir')
                            <a href="{{ url('transactions/pdf', $transactions[0]->nomor_unik) }}" class="btn btn-outline-warning m-1"><i class="ti ti-printer"></i></a>
                            @endif
                            </td>                               
                            </tr>
                            <?php $nomor_unik++; $grandTotal += $totalHarga; ?>
                        @empty
                            <tr>
                                <td colspan="9">Tidak ada transaksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <br>
                </div>
            </div>
</div>

<script>
    function confirmDelete(event) {
        event.preventDefault();

        Swal.fire({
            title: 'Konfirmasi Hapus Data',
            text: 'Apakah Anda yakin ingin menghapus data ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: 'primary',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Lanjutkan dengan mengirim formulir jika dikonfirmasi
                event.target.closest('form').submit();
            }
        });
    }
</script>
@endsection