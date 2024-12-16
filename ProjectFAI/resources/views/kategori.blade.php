@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
    <button class="btn btn-secondary">
        <a style="color: white"  href="/admin/produk">Produk</a>

    </button>
    <button class="btn btn-primary">
        <a style="color: white"  href="/admin">Admin</a>

    </button>
    <button class="btn btn-success">
        <a style="color: white" href="/admin/kategori">Kategori</a>

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

<h2>Master Produk</h2>
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            
            <th colspan="2">Action</th>
            
        </tr>
    </thead>
    <tbody>
        @foreach ($kategori as $pgw)
            <tr>
                
                    
                    <form action="{{ route('admin.updatekategori', $pgw->id_kategori) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <td>{{ $pgw->id_kategori }}</td>
                        <td><input type="text" name="nama_produk" value="{{ $pgw->nama_kategori }}"></td>
                        
                        <td>
                            <button class="btn btn-success" type="submit">Update</button>
                        </td>
                    </form>
                    
                    <td>
                        <form action="{{ route('admin.deletekategori', $pgw->id_kategori) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Delete</button>
                        </form>
                    </td>
                
            </tr>
        @endforeach
    </tbody>
</table>
<br><br>



<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h4>Add Kategori </h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.addkategori') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nama_produk" class="form-label">Nama kategori</label>
                    <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Add</button>
            </form>
        </div>
    </div>
</div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop