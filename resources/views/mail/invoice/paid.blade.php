<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice Paid</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        .total {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1>Invoice Paid</h1>
    <p>Hello {{ $name }},</p>
    <p>We have received your payment for the following invoice:</p>
    <table>
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price per Unit</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->order->products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->pivot->quantity }}</td>
                <td>${{ number_format($product->price, 2) }}</td>
                <td class="total">${{ number_format($product->pivot->quantity * $product->price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    {{-- pasar el string date en la bbdd(he intentado cambiarlo a date pero no funca)
        así que lo pasamos aquí a cabon para pasarlo a fecha y formatear --}}
    <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($invoice->date)->format('d F, Y') }}</p>
    <p><strong>Total:</strong> ${{ number_format($invoice->subtotal, 2) }}</p>
    <p>Thank you for choosing our services.</p>
    <p>Best regards,<br>{{ config('app.name', 'BayGaming') }}</p>
</body>
</html>
