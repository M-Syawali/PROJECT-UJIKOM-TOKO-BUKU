<!DOCTYPE html>
<html>
<head>
    <title>TOKO BUKU | Transactions PDF</title>
    <style>
        body {
            font-family: 'Courier New', monospace;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 300px; /* Adjust the width as needed */
            margin: 0 auto;
            padding: 10px;
        }
        .header {
            text-align: center;
        }
        .content {
            margin-top: 20px;
            font-size: 14px;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 12px;
        }
        .barcode {
            text-align: center;
            margin-top: 20px;
        }
        .divider {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h3 style="font-size: 24px;">
            <i class="fas fa-paw"></i> Book Store
        </h3>
        <p style="font-size: 14px;  text-align: left;">Tanggal : {{ $transactions[0]->created_at }} </p>
        <p style="font-size: 14px;  text-align: left">Nomor Unik: {{ $transactions[0]->nomor_unik }}</p>
        <p style="font-size: 14px;  text-align: left;">Kasir : {{ Auth::user()->nama }} </p>
        <div class="divider"></div>
        <p style="font-size: 18px;">Bukti Transaksi Pembelian</p>
    </div>
    
   
    <p style="font-size: 14px;">Nama Pelanggan: {{ $transactions[0]->nama_pelanggan }}</p>
                    <p style="font-size: 14px;">Nama Produk:</p>
                    <ol>
                        <?php $totalHarga = 0; ?>
                        @foreach ($transactions as $transaction)
                            @foreach ($transaction->products as $product)
                                <li style="font-size: 14px;">
                                    {{ $product->nama_produk }} - {{ $transaction->qty }} - Rp.{{ number_format($transaction->qty * $product->harga_produk, 0, ',', '.') }}
                                    <?php $totalHarga += $transaction->qty * $product->harga_produk; ?>
                                </li>
                            @endforeach
                        @endforeach
                    </ol>
             
     <!-- Total Harga for the Group -->
     <p style="font-size: 14px;">Total Harga: Rp {{ number_format($totalHarga, 0, ',', '.') }}</p>
     <p style="font-size: 14px;">Uang Bayar: Rp {{ number_format($transactions[0]->uang_bayar, 0, ',', '.') }}</p>
     <p style="font-size: 14px;">Uang Kembali: Rp {{ number_format($transactions[0]->uang_kembali, 0, ',', '.') }}</p>
                <!-- Add other transaction details as needed -->
    <div class="footer">
        <div class="divider"></div>
        <p style="font-size: 15px;">Terima kasih atas kunjungan Anda</p>
    </div>
</div>
</body>
</html>