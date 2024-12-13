
<!DOCTYPE html>
<html>
<head>
    <title>Tambah Pegawai</title>
</head>
<body>
    <h1>Tambah Pegawai</h1>

    @if (session('success'))
        <div>{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.store') }}" method="POST">
        @csrf
        
        <label>Nama:</label>
        <input type="text" name="nama_pegawai" required><br>
        
        <label>Alamat:</label>
        <input type="text" name="alamat_pegawai" required><br>
        
        <label>Status:</label>
        <input type="text" name="status_pegawai" required><br>
        
        <label>Password:</label>
        <input type="password" name="password_pegawai" required><br>
        
        <label>Gaji:</label>
        <input type="number" name="gaji_pegawai" required><br>
        
        <button type="submit">Tambah</button>
    </form>
 
</body>
</html>
