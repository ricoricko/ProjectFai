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
        <div class="btn-group">
            <button type="button" class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                Cash
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/admin/cash">Cash</a></li>
                <li><a class="dropdown-item" href="/admin/cashIn">Cash In</a></li>
                <li><a class="dropdown-item" href="/admin/cashOut">Cash Out</a></li>
            </ul>
        </div>
        <a href="/admin/returnfood" class="btn btn-danger">Return Food</a>
        <div class="btn-group">
            <button type="button" class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                Laporan
            </button>
            <ul class="dropdown-menu">
            <li><a href="/admin/best-seller" class="dropdown-item">Penjualan Minuman</a></li>
                <li><a href="/admin/best-food" class="dropdown-item">Penjualan Makanan</a></li>
                <li><a href="/admin/best-pegawai" class="dropdown-item">Best Pegawai</a></li>
            </ul>
        </div>
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
    <h1>Return Food</h1>
    <table border="1" class="table">
        <tr>
            <th>No</th>
            <th>Nama Menu</th>
            <th>Jumlah</th>
            <th>Harga</th>
            <th>Total</th>
            <th>Action</th>
        </tr>
        @foreach($dtrans as $item)
            <tr>
                <td>{{$item->id_htrans}}</td>
                <td>{{$item->menu->nama_menu}}</td>
                <td>{{$item->jumlah}}</td>
                <td>{{$item->harga}}</td>
                <td>{{$item->total}}</td>
                <td>
                    <!-- Button to populate form -->
                    <button type="button" class="btn btn-primary populate-form"
                        data-id="{{$item->id_htrans}}"
                        data-nama="{{$item->menu->nama_menu}}"
                        data-idmenu="{{$item->id_menu}}"
                        data-jumlah="{{$item->jumlah}}"
                        data-harga="{{$item->harga}}">
                        Return
                    </button>
                </td>
            </tr>
        @endforeach
    </table>

    <!-- Form -->
    <form action="{{route('return.add')}}" method="post" class="form-control">
        @csrf
        Id
        <input type="text" name="id" id="id" readonly><br>
        Nama Menu
        <input type="text" name="nama" id="nama" readonly><br>
        Jumlah
        <input type="number" name="jumlah" id="jumlah" readonly><br>
        Harga
        <input type="text" name="harga" id="harga" readonly><br>
        Alasan
        <input type="text" name="alasan" id="alasan" required><br>
        <input type="hidden" name="id_menu" id="id_menu"><br>
        <button type="submit">Submit</button>
    </form>
@stop

@section('css')
<style>
    .btn-group a,
    .btn-group button {
        margin-right: 10px; 
        border-radius: 10px; 
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
        color: white;
    }

    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
        color: white;
    }

    .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
        color: black;
    }

    .btn-info {
        background-color: #17a2b8;
        border-color: #17a2b8;
        color: white;
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
        color: white;
    }

    .dropdown-menu {
        border-radius: 10px; 
    }

    .dropdown-menu a {
        color: black;
    }

    .dropdown-menu a:hover {
        background-color: #f8f9fa; 
        border-radius: 5px; 
    }

    .btn-group {
        display: flex;
        flex-wrap: wrap; 
        gap: 10px; 
    }
</style>
@stop
@section('js')
<script>
    // JavaScript to populate form fields
    document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('.populate-form');
        buttons.forEach(button => {
            button.addEventListener('click', function () {
                const id = this.dataset.id;
                const nama = this.dataset.nama;
                const jumlah = this.dataset.jumlah;
                const harga = this.dataset.harga;
                const idmenu = this.dataset.idmenu

                // Set form values
                document.getElementById('id').value = id;
                document.getElementById('nama').value = nama;
                document.getElementById('jumlah').value = jumlah;
                document.getElementById('harga').value = harga;
                document.getElementById('id_menu').value = idmenu;
            });
        });
    });
</script>
@stop
