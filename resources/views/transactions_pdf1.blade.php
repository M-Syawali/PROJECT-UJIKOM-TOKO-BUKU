<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Transaksi</title>

    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.6/css/jquery.dataTables.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JavaScript -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.6/js/jquery.dataTables.js"></script>

    <!-- Custom Styles -->
    <style>
        @page {
            size: landscape;
        }

        body {
            font-family: Arial, sans-serif;
        }

        h3 {
            text-align: center;
            color: #000000;
            padding: 10px;
        }

        table {
            width: 100%;
            border: 1px solid #000000;
            border-collapse: collapse;
            font-size: 14px; /* Adjust the font size as needed */
        }

        th, td {
            border: 1px solid #000000;
            padding: 5px;
        }

        th {
            background-color: #5D87FF;
            color: #000000;
        }

        tr:nth-child(even) {
            background-color: #ffffff;
        }

        tr:hover {
            background-color: #000000;
        }
        .total-section {
            margin-top: 20px;
            text-align: right;
            font-weight: bold;
        }

        .signature-section {
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <h3>DAFTAR TRANSAKSI</h3>
    <table id="myTable" class="table table-bordered table-striped">
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
                </tr>
                <?php $grandTotal += $totalHarga; ?>
            @empty
                <tr>
                    <td colspan="9">Tidak Ada Data Transaksi</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    <div class="total-section">
        <p>Total Transaksi: Rp.{{ number_format($grandTotal, 0, ',', '.') }}</p>
    </div>

    <!-- Additional Information -->
    <div class="signature-section">
        <p>Printed by: {{ Auth::user()->nama }}</p>
        <p>Date: <?php echo date("Y-m-d H:i:s"); ?></p>
    </div>

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
</body>
</html>