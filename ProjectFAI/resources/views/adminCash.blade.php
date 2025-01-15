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
        <a href="/admin/returnfood" class="btn btn-danger">Return Food</a>
        <a href="/admin/best-seller" class="btn btn-danger">Best Seller</a>
        <a href="/admin/best-pegawai" class="btn btn-danger">Best Pegawai</a>
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


<div class="mb-4">
    <form action="{{ route('admin.addCash') }}" method="POST">
        @csrf
        <div class="input-group">
            <input type="number" name="jumlah_cash" class="form-control" placeholder="Tambah Cash" min="0" required>
            <button class="btn btn-primary" type="submit">Tambah</button>
        </div>
    </form>
</div>

<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Jumlah Cash</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($cashData as $cash)
            <tr>
                <td>{{ $cash->jumlah_cash }}</td>
                <td>{{ $cash->tanggal }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@stop

@section('css')
@stop

@section('js')
<script>
    console.log("Hi, I'm using the Laravel-AdminLTE package!");
    document.querySelectorAll('.form-check-input').forEach(checkbox => {
    checkbox.addEventListener('change', function () {
        const stockInput = this.parentElement.querySelector('input[type="number"]');
            if (this.checked) {
                stockInput.disabled = false;
            } else {
                stockInput.disabled = true;
                stockInput.value = '';
            }
        });
    });
</script>
@stop
