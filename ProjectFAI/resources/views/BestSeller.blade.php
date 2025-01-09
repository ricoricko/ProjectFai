<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Best Seller Menu</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Best Seller Menu</h1>
    <table>
        <thead>
            <tr>
                <th>Nama Menu</th>
                <th>Harga Menu</th>
                <th>Jumlah Dipesan</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bestSellers as $item)
                <tr>
                    <td>{{ $item['nama_menu'] }}</td>
                    <td>{{ $item['harga_menu'] }}</td>
                    <td>{{ $item['jumlah_dipesan'] }}</td>
                    <td>{{ $item['total'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
