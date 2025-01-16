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
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPegawaiModal">Add Pegawai</button>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#gajiPegawaiModal">Gaji Pegawai</button>
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
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
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

{{-- add pegawai --}}
<div class="modal fade" id="addPegawaiModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Pegawai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
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
</div>

{{-- Gaji --}}
<div class="modal fade" id="gajiPegawaiModal" tabindex="-1" aria-labelledby="gajiPegawaiLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="gajiPegawaiLabel">Gaji Pegawai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.gajiPegawai') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="id_pegawai" class="form-label">Pilih Pegawai</label>
                        <select class="form-control" id="id_pegawai" name="id_pegawai" required>
                            @foreach($pegawai as $pgw)
                                <option value="{{ $pgw->id_pegawai }}">{{ $pgw->nama_pegawai }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah_gaji" class="form-label">Jumlah Gaji</label>
                        <input type="number" class="form-control" id="jumlah_gaji" name="jumlah_gaji" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Gaji</button>
                </form>
            </div>
        </div>
    </div>
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
