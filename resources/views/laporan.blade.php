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
            <table class="table table-bordered text-nowrap" id="myTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>NOMOR UNIK</th>
                        <th>NAMA PELANGGAN</th>
                        <th>NAMA PRODUK</th>
                        <th>TOTAL HARGA</th>
                        <th>UANG BAYAR</th>
                        <th>UANG KEMBALI</th>
                        <th>TANGGAL</th>
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
                                @if (Auth::user()->role== 'admin')
                                <td>
                            <a href="{{ route('transactions.edit', $transactions[0]->id) }}" class="btn btn-outline-primary m-1"><i class="ti ti-edit"></i></a>
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
                <!-- Table content remains the same -->
            </table>
        </div>
            </div>
</div>

@endsection