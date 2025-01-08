<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Keranjang Belanja</h2>
    <p>Session ID User: {{ $userId }}</p>

    @if(session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif

    @if(empty($cartItems))
        <div class="alert alert-warning" role="alert">
            {{ $message }}
        </div>
        <a href="{{ route('menu') }}" class="btn btn-primary">Kembali ke Menu</a>
    @else
        @foreach($cartItems as $item)
            <div class="card mb-3">
                <div class="row g-0">
                    <!-- Gambar Produk -->
                    <div class="col-md-4">
                        <img src="{{ asset($item->image_menu) }}" class="img-fluid rounded-start" alt="{{ $item->nama_menu }}">
                    </div>
                    <!-- Detail Produk -->
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->nama_menu }}</h5>
                            <p class="card-text text-muted">Jumlah: {{ $item->jumlah }}</p>
                            <p class="card-text">Harga Satuan: <strong>Rp {{ number_format($item->harga_menu, 0, ',', '.') }}</strong></p>
                            <p class="card-text">Subtotal: <strong>Rp {{ number_format($item->jumlah * $item->harga_menu, 0, ',', '.') }}</strong></p>

                            <div class="d-flex justify-content-between">
                                <!-- Tombol Hapus -->
                                <form action="{{ route('cart.remove', $item->id_cart) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                                <!-- Tombol Ubah -->
                                <form action="{{ route('cart.update') }}" method="POST" style="display: inline-block;">
    @csrf
    <input type="hidden" name="id_cart" value="{{ $item->id_cart }}">
    <input type="number" name="jumlah" value="{{ $item->jumlah }}" min="1" class="form-control form-control-sm d-inline w-25">
    <button type="submit" class="btn btn-primary btn-sm">Ubah</button>
</form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Total & Tombol Checkout -->
        <div class="text-end mt-4">
            <h4>Total: <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong></h4>
            <form action="{{ route('checkout') }}" method="POST" class="d-inline-block">
                @csrf
                <button type="submit" class="btn btn-success">Checkout</button>
            </form>
            <a href="{{ route('menu') }}" class="btn btn-primary">Kembali ke Menu</a>
        </div>
    @endif
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>