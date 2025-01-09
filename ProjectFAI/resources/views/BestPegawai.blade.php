
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Best Pegawai</title>
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
    <h1>Best Pegawai</h1>
    <table>
        <thead>
            <tr>
                <th>Nama Pegawai</th>
                <th>Alamat Pegawai</th>
                <th>Gaji Pegawai</th>
                <th>Jumlah Confirm</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pegawai as $pgw)
                <tr>
                    <td>{{ $pgw->nama_pegawai }}</td>
                    <td>{{ $pgw->alamat_pegawai }}</td>
                    <td>{{ $pgw->gaji_pegawai }}</td>
                    <td>{{ $pgw->jumlah_confirm }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
