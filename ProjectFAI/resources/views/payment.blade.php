<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f7f7;
        }
        .container {
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4">Order Summary</h1>
        <ul class="list-group" id="orderSummary">
        </ul>
        <div class="mt-4">
            <h3>Total: <span id="totalPrice">$0.00</span></h3>
        </div>
        <button class="btn btn-success mt-4" onclick="processPayment()">Go to Payment</button>
    </div>

    <script>
        const cart = JSON.parse(localStorage.getItem('cart')) || [];

        function populateOrderSummary() {
            const orderSummary = document.getElementById('orderSummary');
            const totalPriceElement = document.getElementById('totalPrice');
            let total = 0;

            cart.forEach(item => {
                const listItem = document.createElement('li');
                listItem.className = 'list-group-item d-flex justify-content-between align-items-center';
                listItem.innerHTML = `
                    <span>${item.name} x ${item.quantity}</span>
                    <span>$${(item.price * item.quantity).toFixed(2)}</span>
                `;
                orderSummary.appendChild(listItem);

                total += item.price * item.quantity;
            });

            totalPriceElement.textContent = `$${total.toFixed(2)}`;
        }

        function processPayment() {
            const orderNumber = Math.floor(Math.random() * 10000);
            alert(`Pembayaran berhasil! Nomor pesanan Anda adalah ${orderNumber}.`);
            localStorage.removeItem('cart'); 
            window.location.href = '/index'; 
        }

        document.addEventListener('DOMContentLoaded', populateOrderSummary);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
