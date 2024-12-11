<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu with Categories</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f7f7;
        }
        #navmenu {
            background-color: #5a3827;
            color: white;
            padding: 15px 0;
        }
        #navmenu ul {
            display: flex;
            list-style: none;
            justify-content: center;
            margin: 0;
            padding: 0;
        }
        #navmenu ul li {
            margin: 0 15px;
        }
        #navmenu ul li a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }
        .card {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .quantity-controls {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }
        .quantity-controls button {
            background-color: #5a3827;
            color: white;
            border: none;
            padding: 5px 10px;
            font-weight: bold;
        }
        .cart-button {
            position: fixed;
            bottom: 20px;
            left: 20px;
            background-color: #5a3827;
            color: white;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <nav id="navmenu" class="navmenu">
        <ul>
            <li><a href="#hero" class="active">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#menu">Menu</a></li>
            <li><a href="#specials">Specials</a></li>
            <li><a href="#events">Events</a></li>
            <li><a href="#gallery">Gallery</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
    </nav>

    <div class="container mt-5">
        <ul class="nav nav-tabs" id="categoryTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="food-tab" data-bs-toggle="tab" data-bs-target="#food" type="button" role="tab">Food</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="beverage-tab" data-bs-toggle="tab" data-bs-target="#beverage" type="button" role="tab">Beverage</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="snacks-tab" data-bs-toggle="tab" data-bs-target="#snacks" type="button" role="tab">Snacks</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="addon-tab" data-bs-toggle="tab" data-bs-target="#addon" type="button" role="tab">Add-On</button>
            </li>
        </ul>
        <div class="tab-content" id="categoryTabContent">
            <div class="tab-pane fade show active" id="food" role="tabpanel">
                <div class="row mt-3">
                    <div class="col-md-4">
                        <div class="card">
                            <img src="https://via.placeholder.com/200" class="card-img-top" alt="Food">
                            <div class="card-body">
                                <h5 class="card-title">Grilled Chicken</h5>
                                <p class="card-text">Juicy grilled chicken with herbs and spices.</p>
                                <p class="text-muted">$12.99</p>
                                <div class="quantity-controls">
                                    <button onclick="changeQuantity(-1, 0)">-</button>
                                    <span id="quantity-0" class="mx-2">0</span>
                                    <button onclick="changeQuantity(1, 0)">+</button>
                                </div>
                                <button class="btn btn-primary mt-2" onclick="addToCart('Grilled Chicken', 12.99, 0)">ADD</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="beverage" role="tabpanel">
                <div class="row mt-3">
                    <div class="col-md-4">
                        <div class="card">
                            <img src="https://via.placeholder.com/200" class="card-img-top" alt="Beverage">
                            <div class="card-body">
                                <h5 class="card-title">Fresh Orange Juice</h5>
                                <p class="card-text">Refreshing and healthy orange juice.</p>
                                <p class="text-muted">$4.99</p>
                                <div class="quantity-controls">
                                    <button onclick="changeQuantity(-1, 1)">-</button>
                                    <span id="quantity-1" class="mx-2">0</span>
                                    <button onclick="changeQuantity(1, 1)">+</button>
                                </div>
                                <button class="btn btn-primary mt-2" onclick="addToCart('Fresh Orange Juice', 4.99, 1)">ADD</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="snacks" role="tabpanel">
                <div class="row mt-3">
                    <div class="col-md-4">
                        <div class="card">
                            <img src="https://via.placeholder.com/200" class="card-img-top" alt="Snacks">
                            <div class="card-body">
                                <h5 class="card-title">Potato Chips</h5>
                                <p class="card-text">Crispy and salty potato chips.</p>
                                <p class="text-muted">$2.99</p>
                                <div class="quantity-controls">
                                    <button onclick="changeQuantity(-1, 2)">-</button>
                                    <span id="quantity-2" class="mx-2">0</span>
                                    <button onclick="changeQuantity(1, 2)">+</button>
                                </div>
                                <button class="btn btn-primary mt-2" onclick="addToCart('Potato Chips', 2.99, 2)">ADD</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="addon" role="tabpanel">
                <div class="row mt-3">
                    <div class="col-md-4">
                        <div class="card">
                            <img src="https://via.placeholder.com/200" class="card-img-top" alt="Addon">
                            <div class="card-body">
                                <h5 class="card-title">Extra Cheese</h5>
                                <p class="card-text">Add extra cheese to your dish.</p>
                                <p class="text-muted">$1.50</p>
                                <div class="quantity-controls">
                                    <button onclick="changeQuantity(-1, 3)">-</button>
                                    <span id="quantity-3" class="mx-2">0</span>
                                    <button onclick="changeQuantity(1, 3)">+</button>
                                </div>
                                <button class="btn btn-primary mt-2" onclick="addToCart('Extra Cheese', 1.50, 3)">ADD</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="cart-button" onclick="toggleCart()">
        <i class="bi bi-cart"></i>
    </div>

    <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cartModalLabel">Your Cart</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul id="cartItems" class="list-group">
                    </ul>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" onclick="checkout()">Go to Payment</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let cart = [];

        function changeQuantity(amount, index) {
            const quantityElement = document.getElementById(`quantity-${index}`);
            let quantity = parseInt(quantityElement.textContent) + amount;
            if (quantity < 0) quantity = 0;
            quantityElement.textContent = quantity;
        }

        function addToCart(name, price, index) {
            const quantity = parseInt(document.getElementById(`quantity-${index}`).textContent);
            if (quantity > 0) {
                cart.push({ name, price, quantity });
                alert(`${name} has been added to your cart!`);
            } else {
                alert('Please select a quantity greater than 0.');
            }
        }

        function toggleCart() {
            const cartModal = new bootstrap.Modal(document.getElementById('cartModal'));
            const cartItems = document.getElementById('cartItems');
            cartItems.innerHTML = '';
            cart.forEach(item => {
                const listItem = document.createElement('li');
                listItem.className = 'list-group-item';
                listItem.textContent = `${item.name} x ${item.quantity} - $${(item.price * item.quantity).toFixed(2)}`;
                cartItems.appendChild(listItem);
            });
            cartModal.show();
        }

        function checkout() {
            const cartData = JSON.stringify(cart);
            localStorage.setItem('cart', cartData);
            window.location.href = '/payment';
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
