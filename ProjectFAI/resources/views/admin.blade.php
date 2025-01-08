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
    </div>
    <form action="{{ route('logout') }}" method="POST" class="d-inline">
        @csrf
        <button type="submit" class="btn btn-secondary">Logout</button>
    </form>
</div>
@stop

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

<p class="mt-4">Welcome to this beautiful admin panel.</p>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<h2 class="mt-4">Daftar Pegawai</h2>
<div class="table-responsive">
    <table class="table table-bordered table-hover align-middle mt-3">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Status</th>
                <th>Gaji</th>
                <th colspan="2" class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pegawai as $pgw)
                <tr>
                    <form action="{{ route('admin.update', $pgw->id_pegawai) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <td>{{ $pgw->id_pegawai }}</td>
                        <td><input type="text" name="nama_pegawai" class="form-control" value="{{ $pgw->nama_pegawai }}"></td>
                        <td><input type="text" name="alamat_pegawai" class="form-control" value="{{ $pgw->alamat_pegawai }}"></td>
                        <td><input type="text" name="status_pegawai" class="form-control" value="{{ $pgw->status_pegawai }}"></td>
                        <td><input type="number" name="gaji_pegawai" class="form-control" value="{{ $pgw->gaji_pegawai }}"></td>
                        <td class="text-center">
                            <button type="submit" class="btn btn-success">Update</button>
                        </td>
                    </form>
                    <td class="text-center">
                        <form action="{{ route('admin.destroy', $pgw->id_pegawai) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Form Tambah Pegawai --}}
<div class="col-md-6 mt-5">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4>Tambah Pegawai</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nama_pegawai" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama_pegawai" name="nama_pegawai" required>
                </div>
                <div class="mb-3">
                    <label for="alamat_pegawai" class="form-label">Alamat</label>
                    <input type="text" class="form-control" id="alamat_pegawai" name="alamat_pegawai" required>
                </div>
                <div class="mb-3">
                    <label for="status_pegawai" class="form-label">Status</label>
                    {{-- <input type="text" class="form-control" id="status_pegawai" name="status_pegawai" required> --}}
                    <label for="status_pegawai" class="form-label">Status</label>
                    <select class="form-control" name="status_pegawai" required>
                        <option value="0">Pegawai biasa</option>
                        <option value="1">Manager</option>
                    </select><br>
                </div>
                <div class="mb-3">
                    <label for="password_pegawai" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password_pegawai" name="password_pegawai" required>
                </div>
                <div class="mb-3">
                    <label for="gaji_pegawai" class="form-label">Gaji</label>
                    <input type="number" class="form-control" id="gaji_pegawai" name="gaji_pegawai" required>
                </div>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </form>
        </div>
    </div>
</div>
@stop

@section('css')
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
