@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p>Welcome to this beautiful admin panel.</p>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Status</th>
                <th>Gaji</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pegawai as $pgw)
                <tr>
                    <form action="{{ route('admin.update', $pgw->id_pegawai) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <td>{{ $pgw->id_pegawai }}</td>
                        <td><input type="text" name="nama_pegawai" value="{{ $pgw->nama_pegawai }}"></td>
                        <td><input type="text" name="alamat_pegawai" value="{{ $pgw->alamat_pegawai }}"></td>
                        <td><input type="text" name="status_pegawai" value="{{ $pgw->status_pegawai }}"></td>
                        <td><input type="number" name="gaji_pegawai" value="{{ $pgw->gaji_pegawai }}"></td>
                        <td>
                            <button type="submit">Update</button>
                        </td>
                    </form>
                    <td>
                        <form action="{{ route('admin.destroy', $pgw->id_pegawai) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('admin.create') }}"> <button>Tambah Pegawai</button> </a>

    
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
