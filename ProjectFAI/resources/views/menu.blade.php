<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <style>
    .card-img-top {
        width: 100%;       
        height: 300px;     
        object-fit: cover; 
    }
</style>

</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Restaurant</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Menu</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Cart</a>
        </li>
    </ul>
    <ul class="navbar-nav ms-auto">
        @if(isset($username))
            <li class="nav-item">
                <span class="navbar-text">
                    Welcome, {{ $username }}
                </span>
            </li>
        @endif
    </ul>
</div>

    </div>
</nav>

<div class="container mt-5">
    <ul class="nav nav-tabs" id="menuTabs" role="tablist">
        @foreach($categories as $category)
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="tab-{{ $category->id_kategori }}" data-bs-toggle="tab" data-bs-target="#kategori-{{ $category->id_kategori }}" type="button" role="tab" aria-controls="kategori-{{ $category->id_kategori }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                {{ $category->nama_kategori }}
            </button>
        </li>
        @endforeach
    </ul>

    <div class="tab-content mt-4" id="menuTabContent">
        @foreach($categories as $category)
        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="kategori-{{ $category->id_kategori }}" role="tabpanel" aria-labelledby="tab-{{ $category->id_kategori }}">
            <div class="row">
                @foreach($menus as $menu)
                @if($menu->kategori_menu == $category->id_kategori)
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <img src="{{ asset($menu->image_menu) }}" class="card-img-top" alt="{{ $menu->nama_menu }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $menu->nama_menu }}</h5>
                            <p class="card-text">Harga: Rp {{ number_format($menu->harga_menu, 0, ',', '.') }}</p>
                            <div class="d-flex align-items-center mb-3">
                                <button class="btn btn-outline-secondary btn-sm me-2" onclick="decreaseQuantity({{ $menu->id_menu }})">-</button>
                                <span id="quantity-{{ $menu->id_menu }}" class="me-2">0</span>
                                <button class="btn btn-outline-secondary btn-sm" onclick="increaseQuantity({{ $menu->id_menu }})">+</button>
                            </div>
                            <button class="btn btn-primary add-to-cart"
                                    data-id="{{ $menu->id_menu }}"
                                    data-nama="{{ $menu->nama_menu }}"
                                    data-harga="{{ $menu->harga_menu }}">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
        @endforeach
    </div>
</div>

<div class="cart-button" id="cart-button" style="position: fixed; bottom: 20px; right: 20px;">
    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cartModal">
        <i class="bi bi-cart"></i> Keranjang
    </button>
</div>

<div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cartModalLabel">Keranjang Belanja</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="cart-items-list">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="go-to-payment">Go to Payment</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const quantities = {};
    function decreaseQuantity(id) {
        if (!quantities[id]) {
            quantities[id] = 0;
        }
        if (quantities[id] > 0) {
            quantities[id]--;
            document.getElementById(`quantity-${id}`).textContent = quantities[id];
        }
    }

    function increaseQuantity(id) {
        if (!quantities[id]) {
            quantities[id] = 0;
        }
        quantities[id]++;
        document.getElementById(`quantity-${id}`).textContent = quantities[id];
    }

    $(document).ready(function() {
        $('.add-to-cart').on('click', function() {
            const id_menu = $(this).data('id');
            const nama_menu = $(this).data('nama');
            const harga = $(this).data('harga');
            const jumlah = quantities[id_menu] || 0;

            if (jumlah === 0) {
                alert("Pilih jumlah item terlebih dahulu.");
                return;
            }

            $.ajax({
                url: "{{ route('cart.add') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    id_menu: id_menu,
                    nama_menu: nama_menu,
                    harga: harga,
                    jumlah: jumlah
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                    }
                },
                error: function(error) {
                    alert("Gagal menambahkan item ke cart");
                    console.log(error);
                }
            });
        });

        $('#cart-button').on('click', function() {
            $.ajax({
                url: "{{ route('cart.show') }}",
                type: "GET",
                success: function(response) {
                    if (response.cartItems.length > 0) {
                        let itemsHtml = '';
                        response.cartItems.forEach(item => {
                            itemsHtml += `
                                <div class="cart-item" data-id="${item.id}">
                                    <p>${item.menu.nama_menu} - ${item.quantity}</p>
                                    <button class="btn btn-sm btn-danger remove-item">Hapus</button>
                                </div>
                            `;
                        });
                        $('#cart-items-list').html(itemsHtml);
                    } else {
                        $('#cart-items-list').html('<p>Keranjang Anda kosong</p>');
                    }
                }
            });
        });

        $(document).on('click', '.remove-item', function() {
            const cartItemId = $(this).closest('.cart-item').data('id');

            $.ajax({
                url: "{{ route('cart.remove') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                    id_menu: cartItemId
                },
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        $('#cart-button').click();
                    }
                }
            });
        });

        $('#go-to-payment').on('click', function() {
            window.location.href = "{{ route('payment') }}";
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
