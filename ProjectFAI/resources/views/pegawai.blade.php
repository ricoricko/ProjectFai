<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Pegawai - Cart Status</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5dc;
        }
        .container {
            margin-top: 20px;
        }
        .btn-secondary {
            background-color: #d2b48c;
            border-color: #d2b48c;
        }
        .table-hover tbody tr:hover {
            background-color: #d2b48c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="my-4">Carts with Status 0</h1>
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-secondary">Logout</button>
        </form>
        @if($cart->isEmpty())
            <p>No carts found with status 0.</p>
        @else
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>User Name</th>
                        <th>Product Names</th>
                        <th>Total Quantity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $user_name => $items)
                        <tr>
                            <td>{{ $user_name }}</td>
                            <td>
                                @foreach($items as $item)
                                    <div>{{ $item->product_name }}</div>
                                @endforeach
                            </td>
                            <td>
                                @php
                                    $total_quantity = $items->sum('jumlah');
                                @endphp
                                {{ $total_quantity }}
                            </td>
                            <td>
                                <form action="{{ route('pegawai.confirm') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $items->first()->id_user }}">
                                    <button type="submit" class="btn btn-success">Confirm</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
