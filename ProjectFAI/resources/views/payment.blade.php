<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script type="text/javascript" 
        src="https://app.sandbox.midtrans.com/snap/snap.js" 
        data-client-key="SB-Mid-client-PtWwnPya47G5ddgV"></script>
</head>
<body>
<div class="container mt-5">

    <h2 class="mb-4">Keranjang Belanja</h2>

    @if(session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
    @endif

    @if(empty($cartItems) || $cartItems->isEmpty())
        <div class="alert alert-warning">
            Keranjang Anda kosong! Silakan tambahkan produk ke dalam keranjang.
        </div>
        <a href="{{ route('menu') }}" class="btn btn-primary">Kembali ke Menu</a>
    @else
        @foreach($cartItems as $item)
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="{{ asset($item->image_menu) }}" class="img-fluid rounded-start" alt="{{ $item->nama_menu }}">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item->nama_menu }}</h5>
                            <p class="card-text text-muted">Jumlah: {{ $item->jumlah }}</p>
                            <p class="card-text">Harga Satuan: <strong>Rp {{ number_format($item->harga_menu, 0, ',', '.') }}</strong></p>
                            <p class="card-text">Subtotal: <strong>Rp {{ number_format($item->jumlah * $item->harga_menu, 0, ',', '.') }}</strong></p>
                            <div class="d-flex justify-content-between">
                                <form action="{{ route('cart.remove', $item->id_cart) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
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

        @if(isset($currentMember))
    <h4>Jenis Member: <strong>{{ $currentMember->jenis_member ?? 'N/A' }}</strong></h4>
    <h4>Potongan: <strong>{{ $currentMember->potongan ?? 0 }}%</strong></h4>
    <h4>Harga Sebelum Potongan: <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong></h4>
    <h4>Harga Setelah Potongan: <strong>Rp {{ number_format($finalTotal, 0, ',', '.') }}</strong></h4>
@else
    <h4>Total: <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong></h4>
@endif


        <div class="text-end mt-4">
            @if(isset($snapToken))
                <button id="pay-button" class="btn btn-success">Checkout</button>
            @else
                <p class="text-danger">Snap Token tidak tersedia. Silakan coba lagi.</p>
            @endif
            <a href="{{ route('menu') }}" class="btn btn-primary">Kembali ke Menu</a>
        </div>
    @endif
</div>

<script>
    @if(isset($snapToken))
        document.getElementById('pay-button').addEventListener('click', function () {
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function (result) {
                    alert('Pembayaran berhasil!');
                    console.log(result);
                    window.location.href = "{{ route('payment.success') }}"; 
                },
                onPending: function (result) {
                    alert('Pembayaran sedang diproses.');
                    console.log(result);
                },
                onError: function (result) {
                    alert('Pembayaran gagal!');
                    console.log(result);
                },
                onClose: function () {
                    alert('Anda menutup halaman pembayaran.');
                }
            });
        });
    @endif
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
