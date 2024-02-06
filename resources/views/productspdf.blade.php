<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Buku</title>

    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.6/css/jquery.dataTables.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JavaScript -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.6/js/jquery.dataTables.js"></script>

    <!-- Custom Styles -->
    <style>
        body {
            font-family: Arial, arial;
        }

h3 {
    text-align: center;
    background-color: ;
    color: #000000 ;
    padding: 10px;
}

table {
    width: 100%;
    border: 1px solid #000000;
    border-collapse: collapse;
}

th, td {
    border: 1px solid #000000;
    padding: 10px;
}

th {
    background-color: #5D87FF;
    color: #0000000;
}

tr:nth-child(even) {
    background-color: #ffffff; /* Warna latar belakang baris genap */
}

tr:hover {
            background-color: #000000;
        }
    </style>
</head>
<body>
    <h3>DAFTAR BUKU</h3>
    <table id="">
        <thead>
            <tr>
                <th>Jenis Buku</th>
                <th>Nama Produk</th>
                <th>Penulis</th>
                <th>Penerbit</th>
                <th>Harga Produk</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $p)
            <tr>
                <td>{{ $p->jenis_buku }}</td>
                <td>{{ $p->nama_produk }}</td>
                <td>{{ $p->penulis }}</td>
                <td>{{ $p->penerbit }}</td>
                <td>Rp. {{ number_format($p->harga_produk, 0, ',', ',') }}</td>           
            </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable();
        });
    </script>
</body>
</html>