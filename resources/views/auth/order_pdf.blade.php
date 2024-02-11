<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </head>
    
    <body>
    <div class="container">
        <h1 class="my-4">{{ $title }}</h1>
        <div class="card">
            <div class="card-body">
                <h2 class="card-title">Detalles de la Orden</h2>
                <p><strong>Estado de la Orden:</strong> {{ ucfirst($order->state) }}</p>
                <p><strong>Total:</strong> {{ number_format($order->total, 2) }}</p>
                <h3>Datos del Usuario</h3>
                <ul class="list-unstyled">
                    <li>Nombre: {{ $orderData['user']['real_name'] }}</li>
                    <li>Apellido: {{ $orderData['user']['surname'] }}</li>
                </ul>
                <h3>Dirección</h3>
                <ul class="list-unstyled">
                    <li>Dirección: {{ $orderData['address']['address'] }}</li>
                    <li>País: {{ $orderData['address']['country'] }}</li>
                    <li>Código Postal: {{ $orderData['address']['zip'] }}</li>
                    @if (isset($orderData['address']['telephone_number']))
                        <li>Teléfono: {{ $orderData['address']['telephone_number'] }}</li>
                    @endif
                    @if (isset($orderData['address']['secondary_address']))
                        <li>Dirección Secundaria: {{ $orderData['address']['secondary_address'] }}</li>
                    @endif
                </ul>
            </div>
        </div>
        <div class="card my-4">
            <div class="card-body">
                <h2 class="card-title">Productos en la Orden</h2>
                <table class="table table-striped">
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
                                $quantity = $product->pivot->quantity; // Asumiendo que la cantidad está en la tabla pivot
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

</body>

</html>
