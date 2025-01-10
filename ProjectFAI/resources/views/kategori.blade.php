@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1 class="mb-4">Dashboard</h1>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div class="btn-group" role="group">
        <a href="/admin/produk" class="btn btn-primary">Produk</a>
        <a href="/admin" class="btn btn-success">Admin</a>
        <a href="/admin/kategori" class="btn btn-warning">Kategori</a>
        <a href="/admin/users" class="btn btn-info">Users</a>
        <a href="/admin/menu" class="btn btn-danger">Menu</a>
        <a href="/admin/cash" class="btn btn-danger">Cash</a>
        <a href="/admin/cashIn" class="btn btn-danger">Cash In</a>
        <a href="/admin/cashOut" class="btn btn-danger">Cash Out</a>
    </div>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addKategoriModal">Add Kategori</button>
    <form action="{{ route('logout') }}" method="POST" class="d-inline">
        @csrf
        <button type="submit" class="btn btn-secondary">Logout</button>
    </form>
</div>
@stop

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<h2>Master Produk</h2>
<div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-dark">
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
                        <td><input type="text" name="nama_produk" class="form-control" value="{{ $pgw->nama_kategori }}"></td>
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
</div>

{{-- Modal for Add Kategori --}}
<div class="modal fade" id="addKategoriModal" tabindex="-1" aria-labelledby="addKategoriLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addKategoriLabel">Tambah Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.addkategori') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="nama_kategori" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
@stop
