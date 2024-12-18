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
    <button class="btn btn-success">
        <a style="color: white;text-decoration:none;" href="/admin/menu">Menu</a>
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
    <h1>Menu</h1>
    <form action="{{route('admin.addMenu')}}" method="post" enctype="multipart/form-data">
        @csrf
        <label for="">Nama Menu</label>
        <input type="text" name="nama_menu" id=""> <br>
        <label for="">Harga</label>
        <input type="text" name="harga_menu" id=""><br>
        <label for="">Photo Menu</label>
        <input type="file" name="image_menu" id=""> <br>
        <label for="">Kategori Menu</label>
        <select name="kategori_menu" id="">
            @foreach ($kategori as $item)
                <option value="{{$item->id_kategori}}">{{$item->nama_kategori}}</option>
            @endforeach
        </select>
        <br>
        <label for="">Produk </label><br>
            @foreach ($produk as $item)
                <input type="checkbox" id="produkId" name="produk[]" value="{{$item->id_produk}}">{{$item->nama_produk}}<br>
            @endforeach
        <button type="submit">Submit</button>
    </form>
@stop

@section('css')
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
