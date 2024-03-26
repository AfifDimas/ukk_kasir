<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Penjualan {{ $tanggal}} </title>
</head>
<center>
<body>

        <h4>KASIRKU</h4>
        <p>Laporan Penjualan tanggal {{ $tanggal }}</p>
        <table border="1" width="100%">
            <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Jumlah terjual</th>
                <th>Subtotal</th>
            </tr>
            @foreach($totalTransaksi as $penjualan)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $penjualan['nama_barang'] }}</td>
                <td>{{ $penjualan['totalTerjual'] }}</td>
                <td>Rp. {{ $penjualan['subtotal'] }}</td>
            </tr>
            @endforeach
        </table>
        
    </body>
    </center>
</html>