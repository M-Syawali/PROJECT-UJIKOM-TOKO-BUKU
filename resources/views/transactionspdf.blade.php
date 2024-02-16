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
        /* Menambahkan margin antara setiap produk */
        .product-item {
            margin-bottom: 7;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h3 style="font-size: 24px;">
            <i class="fas fa-paw"></i> Book Store
        </h3>
        <p style="font-size: 14px;  text-align: left">Tanggal : {{ $transactions->created_at }}</p>
        <p style="font-size: 14px;  text-align: left">Nomor Unik : {{ $transactions->nomor_unik }}</p>
        <p style="font-size: 14px;  text-align: left;">Kasir : {{ Auth::user()->nama }} </p>
        <div class="divider"></div>
        <p style="font-size: 18px;">Bukti Transaksi Pembelian</p>
    </div>
    <p style="font-size: 14px;">Nama Pelanggan: {{ $transactions->nama_pelanggan }}</p>
    <p style="font-size: 14px;">Nama Produk:</p>
    @if(isset($transactions->products) && is_array($transactions->products))
        @php
            $counter = 1; // variabel untuk nomor urut
        @endphp
        @foreach ($transactions->products as $product)
            @php
                $produkName = \App\Models\ProductsM::find($product['produkId']);
            @endphp

            @if(isset($produkName))
                <p style="font-size: 14px;">{{ $counter }}. {{ $produkName['nama_produk'] }} - {{ $product['qty'] }} x <br> {{ isset($product['total']) ? 'Rp ' . number_format($product['total'], 0, ',', '.') : 'N/A' }}</p>
                @php
                    $counter++; // increment nomor urut
                @endphp
            @endif
        @endforeach
    @endif 
    <div class="divider"></div>
    <!-- Total Harga for the Group -->
    <p style="font-size: 14px;">Total Harga: Rp {{ number_format($transactions->total_harga, 0, ',', '.') }}</p>
    <div class="divider"></div>
    <p style="font-size: 14px;">Uang Bayar: Rp {{ number_format($transactions->uang_bayar, 0, ',', '.') }}</p>
    <p style="font-size: 14px;">Uang Kembali: Rp {{ number_format($transactions->uang_kembali, 0, ',', '.') }}</p>
    <!-- Add other transaction details as needed -->
    <div class="footer">
        <div class="divider"></div>
        <p style="font-size: 15px;">Terima kasih atas kunjungan Anda</p>
    </div>
</div>
</body>
</html>
