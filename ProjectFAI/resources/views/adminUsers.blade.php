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
    <form action="{{ route('logout') }}" method="POST" class="d-inline">
        @csrf
        <button type="submit" class="btn btn-secondary">Logout</button>
    </form>
</div>
@stop

@section('content')
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

<h2>List Users</h2>
<div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Password</th>
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
                        <td><input type="text" name="nama_produk" class="form-control" value="{{ $pgw->username }}" disabled></td>
                        <td><input type="password" name="password" class="form-control" value="{{ $pgw->password }}" disabled></td>
                        <td><input type="text" name="nama" class="form-control" value="{{ $pgw->nama }}" disabled></td>
                        <td><input type="email" name="email" class="form-control" value="{{ $pgw->email }}" disabled></td>
                        <td><input type="number" name="phone" class="form-control" value="{{ $pgw->phone }}" disabled></td>
                        <td>{{ $pgw->status == '1' ? 'Aktif' : 'Inactive' }}</td>
                        {{-- <td>
                            <button class="btn btn-success" type="submit">Update</button>
                        </td> --}}
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
</div>
@stop
