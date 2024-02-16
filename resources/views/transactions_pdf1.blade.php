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
            font-size: 13px; /* Adjust the font size as needed */
        }

        th, td {
            border: 1px solid #000000;
            padding: 5px;
            text-align: left;
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
    <div class="table-responsivie">
    <table id="myTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Unik</th>
                <th>Nama Pelanggan</th>
                <th>Produk</th>
                <th>Harga Satuan</th>
                <th>Total Harga</th> 
                <th>Uang Bayar</th>
                <th>Uang Kembali</th>
                <th>Waktu Transaksi</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalTransactions = 0;
            @endphp
            @foreach ($transactions as $p)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $p->nomor_unik }}</td>
                    <td>{{ $p->nama_pelanggan }}</td>
                    <td>
                        <ul>
                            @if(isset($p->products) && is_array($p->products))
                                @php $counter = 1; @endphp
                                @foreach ($p->products as $products)
                                    @php
                                        $produkName = \App\Models\ProductsM::find($products['produkId']);
                                    @endphp

                                    @if(isset($produkName))
                                        <li>{{ $counter }}. {{ $produkName['nama_produk'] }} - {{ $products['qty'] }} x</li>
                                        @php
                                            $counter++;
                                        @endphp
                                    @endif
                                @endforeach
                            @endif
                        </ul>
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
                </tr>
                @php
                    $totalTransactions += $p->total_harga;
                @endphp
            @endforeach
        </tbody>
    </table>
    </div>
  
    <!-- Total Keseluruhan Transaksi -->
    <div class="total-section">
        Total Keseluruhan Transaksi: Rp. {{ number_format($totalTransactions, 0, ',', '.') }}
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
