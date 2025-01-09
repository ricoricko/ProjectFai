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

<div class="card">
    <div class="card-header bg-primary text-white">
        <h3 class="card-title">Tambah Menu</h3>
    </div>
    <div class="card-body">
        <form action="{{route('admin.addMenu')}}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="nama_menu" class="form-label">Nama Menu</label>
                <input type="text" name="nama_menu" id="nama_menu" class="form-control" placeholder="Masukkan Nama Menu">
            </div>

            <div class="mb-3">
                <label for="harga_menu" class="form-label">Harga</label>
                <input type="text" name="harga_menu" id="harga_menu" class="form-control" placeholder="Masukkan Harga">
            </div>

            <div class="mb-3">
                <label for="image_menu" class="form-label">Photo Menu</label>
                <input type="file" name="image_menu" id="image_menu" class="form-control">
            </div>

            <div class="mb-3">
                <label for="kategori_menu" class="form-label">Kategori Menu</label>
                <select name="kategori_menu" id="kategori_menu" class="form-select">
                    @foreach ($kategori as $item)
                        <option value="{{$item->id_kategori}}">{{$item->nama_kategori}}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="produk" class="form-label">Produk</label><br>
                @foreach ($produk as $item)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="produk[]" value="{{$item->id_produk}}" id="produk{{$item->id_produk}}">
                        <label class="form-check-label" for="produk{{$item->id_produk}}">
                            {{$item->nama_produk}}
                        </label>
                        <input type="number" name="stok_produk[{{$item->id_produk}}]" class="form-control form-control-sm w-25" placeholder="Stok" min="0" disabled>
                    </div>
                @endforeach
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
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
