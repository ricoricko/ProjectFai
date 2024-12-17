@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
    <button class="btn btn-primary">
        <a style="color: white;text-decoration:none;" href="/admin/produk">Produk</a>

    </button>
    <button class="btn btn-success">
        <a style="color: white;text-decoration:none;" href="/admin">Admin</a>

    </button>
    <button class="btn btn-success">
        <a style="color: white;text-decoration:none;" href="/admin/kategori">Kategori</a>
    </button>
    <button class="btn btn-success">
        <a style="color: white;text-decoration:none;" href="/admin/users">Users</a>
    </button>
@stop
@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
@if(session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger" role="alert">
        {{ session('error') }}
    </div>
@endif

<h2>List Users</h2>
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>password</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Status</th>
            
            <th colspan="2">Action</th>
            
        </tr>
    </thead>
    <tbody>
        @foreach ($users as $pgw)
            <tr>
                
                    
                    <form action="{{ route('admin.updatekategori', $pgw->id_user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <td>{{ $pgw->id_user }}</td>
                        <td><input type="text" name="nama_produk" value="{{ $pgw->username }}" disabled></td>
                        <td><input type="password" name="password" value="{{ $pgw->password }}" disabled></td>
                        <td><input type="text" name="nama" value="{{ $pgw->nama }}" ></td>
                        <td><input type="text" name="email" value="{{ $pgw->email }}" disabled></td>
                        <td><input type="number" name="phone" value="{{ $pgw->phone }}" disabled></td>
                        @if ($pgw->status=='1')
                            
                            <td>Aktif</td>
                        @else
                            <td>Inactive</td>
                            
                        @endif
                        
                        <td>
                            <button class="btn btn-success" type="submit">Update</button>
                        </td>
                    </form>
                    
                    <td>
                        <form action="{{ route('admin.deletekategori', $pgw->id_user) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit" onclick="return confirm('Apakah Anda yakin ingin menonaktifkan user ini?')">Delete</button>
                        </form>
                    </td>
                
            </tr>
        @endforeach
    </tbody>
</table>
<br><br>

@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop