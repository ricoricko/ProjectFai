<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
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
                <a class="nav-link" href="{{ route('cart.view') }}">Cart</a>

                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                @if(isset($username))
                    <li class="nav-item">
                        <span class="navbar-text">
                            Welcome, {{ $username ?? 'Guest' }}
                            <p>Session ID User: {{ Session::get('id_user') }}</p>
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
                        <img src="{{ asset($menu->image_menu)}}" class="card-img-top" alt="{{ $menu->nama_menu }}">
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
                                        <form method="POST" action="{{ route('cart.add') }}">
                                            @csrf
                                            <input type="hidden" name="id_menu" value="{{ $menu->id_menu }}">
                                            <input type="number" name="jumlah" class="form-control me-2" placeholder="Jumlah" min="1" required>
                                            <button type="submit" class="btn btn-primary w-100">Add to Cart</button>
                                        </form>



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

<div class="cart-button" style="position: fixed; bottom: 20px; right: 20px;">
    <a href="{{ route('payment') }}" class="btn btn-danger">
        <i class="bi bi-cart"></i> Keranjang
    </a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
