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
        <a href="/admin/best-seller" class="btn btn-danger">Best Drink</a>
        <a href="/admin/best-food" class="btn btn-danger">Best Food</a>
        <a href="/admin/best-pegawai" class="btn btn-danger">Best Pegawai</a>
    </div>
    <form action="{{ route('logout') }}" method="POST" class="d-inline">
        @csrf
        <button type="submit" class="btn btn-secondary">Logout</button>
    </form>
</div>
@stop
@section('content')
    <h1>Best Seller Food</h1>
    <table border="1" class="table">
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
            @if ($item['kategori_menu']==2)
            <tr>
                <td>{{ $item['nama_menu'] }}</td>
                <td>{{ $item['harga_menu'] }}</td>
                <td>{{ $item['jumlah_dipesan'] }}</td>
                <td>{{ $item['total'] }}</td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
@stop
