<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1,
        h2,
        h3 {
            color: #FFA500; /* Naranja */
        }

        .card {
            margin-top: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            overflow: hidden;
        }

        .card-body {
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border-bottom: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #FFA500; /* Naranja */
            color: #fff;
        }

        tfoot {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>{{ $title }}</h1>
        <div class="card">
            <div class="card-body">
                <h2>Detalles del pedido</h2>
                <p><strong>Estado del pedido:</strong> {{ ucfirst($order->state) }}</p>
                <p><strong>Total:</strong> {{ number_format($order->total, 2) }}</p>
                <h3>Datos del comprador</h3>
                <ul>
                    <li>Nombre: {{ $orderData['user']['real_name'] }}</li>
                    <li>Apellido: {{ $orderData['user']['surname'] }}</li>
                </ul>
                <h3>Dirección</h3>
                <ul>
                    <li>Dirección: {{ $orderData['address']['address'] }}</li>
                    @if (isset($orderData['address']['secondary_address']))
                        <li>Dirección Secundaria (opcional): {{ $orderData['address']['secondary_address'] }}</li>
                    @endif
                    @if (isset($orderData['address']['telephone_number']))
                    <li>Teléfono (opcional): {{ $orderData['address']['telephone_number'] }}</li>
                @endif
                    <li>País: {{ $orderData['address']['country'] }}</li>
                    <li>Código Postal: {{ $orderData['address']['zip'] }}</li>

                </ul>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h2>Productos</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Precio Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total = 0;
                        @endphp
                        @foreach ($order->products as $product)
                            @php
                                $quantity = $product->pivot->quantity;
                                $productTotal = $product->price * $quantity;
                                $total += $productTotal;
                            @endphp
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ number_format($product->price, 2) }}</td>
                                <td>{{ $quantity }}</td>
                                <td>{{ number_format($productTotal, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end">Total</td>
                            <td>{{ number_format($total, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</body>

</html>
