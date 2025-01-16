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
                <li><a href="/admin/best-seller" class="dropdown-item">Best Drink</a></li>
                <li><a href="/admin/best-food" class="dropdown-item">Best Food</a></li>
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
                <div class="row">
                    @foreach ($produk as $index => $item)
                        <div class="col-md-2 mb-2"> <!-- Adjust width for 5 items per row -->
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="produk[]" value="{{$item->id_produk}}" id="produk{{$item->id_produk}}">
                                <label class="form-check-label" for="produk{{$item->id_produk}}">
                                    {{$item->nama_produk}}
                                </label>
                            </div>
                        </div>
                        @if (($index + 1) % 5 == 0)
                            </div><div class="row">
                        @endif
                    @endforeach
                </div>
            </div>

            <div class="text-end">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
    <h1>Daftar Menu</h1>
    <table border="1" class="table">
        <tr>
            <th>Nama</th>
            <th>Harga</th>
            <th>Foto Menu</th>
            <th>Kategori</th>
            <th>Action</th>
        </tr>
        @foreach ($menu as $item)
            <tr>
                <td>{{$item->nama_menu}}</td>
                <td>{{$item->harga_menu}}</td>
                <td><img src="{{asset($item->image_menu)}}" width="50px" srcset=""></td>
                <td>{{$item->kategori->nama_kategori}}</td>
                <td>
                    <button type="button" class="populate-form btn btn-warning"
                        data-id="{{ $item->id_menu }}"
                        data-nama="{{ $item->nama_menu }}"
                        data-harga="{{ $item->harga_menu }}"
                        data-image="{{ asset($item->image_menu) }}"
                        data-kategori="{{ $item->kategori->id_kategori }}"
                        data-idmenu="{{ $item->id_menu }}">
                        Update
                    </button>
                    <form action="{{ route('admin.deletemenu', $item->id_menu) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus menu ini?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
    <form action="{{ route('admin.updateMenu') }}" method="post" enctype="multipart/form-data" class="form-control mt-3">
        @csrf
        <div class="mb-3">
            <label for="id" class="form-label">Id</label>
            <input type="text" name="id" id="id" class="form-control" readonly>
        </div>
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Menu</label>
            <input type="text" name="nama" id="nama" class="form-control">
        </div>
        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="text" name="harga" id="harga" class="form-control">
        </div>
        <div class="mb-3">
            <label for="image_menu" class="form-label">Photo Menu</label>
            <input type="file" name="image_menu" id="image_menu" class="form-control">
            <img id="preview_image" src="" alt="Preview Image" style="width: 100px; margin-top: 10px;">
        </div>
        <div class="mb-3">
            <label for="kategori_menu" class="form-label">Kategori Menu</label>
            <select name="kategori_menu" id="kategori_menu" class="form-select">
                @foreach ($kategori as $item)
                    <option value="{{ $item->id_kategori }}">{{ $item->nama_kategori }}</option>
                @endforeach
            </select>
        </div>
        <input type="hidden" name="id_menu" id="id_menu">
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
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
    document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.populate-form');
    buttons.forEach(button => {
        button.addEventListener('click', function () {
            const id = this.dataset.id;
            const nama = this.dataset.nama;
            const harga = this.dataset.harga;
            const image = this.dataset.image;
            const kategori = this.dataset.kategori;
            const idmenu = this.dataset.idmenu;

            document.getElementById('id').value = id;
            document.getElementById('nama').value = nama;
            document.getElementById('harga').value = harga;
            document.getElementById('id_menu').value = idmenu;

            const previewImage = document.getElementById('preview_image');
            previewImage.src = image;
            const kategoriMenu = document.getElementById('kategori_menu');
            kategoriMenu.value = kategori;
        });
    });
});

</script>
@stop
