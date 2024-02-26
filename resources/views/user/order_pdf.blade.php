<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        .invoice-box {
            max-width: 100%;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            font-size: 16px;
            line-height: 24px;
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            color: #555;
        }

        .invoice-box table {
            width: 100%;
            line-height: inherit;
            text-align: left;
        }

        .invoice-box table td {
            padding: 5px;
            vertical-align: top;
        }

        .invoice-box table tr td:nth-child(2),
        .invoice-box table tr td:nth-child(4) {
            text-align: right;
        }

        .invoice-box table tr td:nth-child(3) {
            text-align: center;
        }

        .invoice-box table tr.top table td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.top table td.title {
            font-size: 45px;
            line-height: 45px;
            color: #333;
        }

        .invoice-box table tr.information table td {
            padding-bottom: 40px;
        }

        .invoice-box table tr.heading td {
            background: #eee;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-box table tr.details td {
            padding-bottom: 20px;
        }

        .invoice-box table tr.item td {
            border-bottom: 1px solid #eee;
        }

        .invoice-box table tr.item.last td {
            border-bottom: none;
        }

        .invoice-box table tr.total td:nth-child(1),
        .invoice-box table tr.total td:nth-child(2) {
            border-top: 2px solid #eee;
            font-weight: bold;
        }

        @media only screen and (max-width: 600px) {
            .invoice-box table tr.top table td {
                width: 100%;
                display: block;
                text-align: center;
            }

            .invoice-box table tr.information table td {
                width: 100%;
                display: block;
                text-align: center;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="4">
                    <table>
                        <tr>
                            <td class="title">
                                BayGaming
                                {{-- todo svg del logo --}}
                                <img src="" style="width:  100%; max-width:  300px" />
                            </td>
                            <td>
                                {{ $title }}<br />
                                Creado: {{ \Carbon\Carbon::parse($order->updated_at)->format('d F, Y')}}<br />
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="information">
                <td colspan="4">
                    <table>
                        <tr>
                            <td>
                                {{ $orderData['user']['real_name'] }}<br />
                                {{ $orderData['user']['surname'] }}<br />
                                Dirección: {{ $orderData['address']['address'] }}<br />
                                @if (isset($orderData['address']['secondary_address']))
                                    Dirección Secundaria (opcional):
                                    {{ $orderData['address']['secondary_address'] }}<br />
                                @endif
                                @if (isset($orderData['address']['telephone_number']))
                                    Teléfono (opcional): {{ $orderData['address']['telephone_number'] }}<br />
                                @endif
                                País: {{ $orderData['address']['country'] }}<br />
                                Código Postal: {{ $orderData['address']['zip'] }}<br />
                            </td>

                            <td>
                                {{ config('app.name', 'BayGaming') }}<br />
                                Marie Curie, 5<br />
                                Isla de la Cartuja, Sevilla<br />
                                baygaming@gmail.com
                            </td>

                        </tr>
                    </table>
                </td>
            </tr>

            <tr class="heading">
                <td>Producto</td>
                <td>Precio</td>
                <td>Cantidad</td>
                <td>Total</td>
            </tr>
            @php
                $subtotal = 0;
                $discountAmount = 0;
                $discountPercent = 0;
            @endphp
            @foreach ($order->products as $product)
                @php
                    $quantity = $product->pivot->quantity;
                    $productTotal = $product->price * $quantity;
                    $subtotal += $productTotal;
                @endphp
                <tr class="{{ $loop->last ? 'item last' : 'item' }}">
                    <td>{{ $product->name }}</td>
                    <td>{{ number_format($product->price, 2) }}€</td>
                    <td>{{ $quantity }}</td>
                    <td>{{ number_format($productTotal, 2) }}€</td>
                </tr>
            @endforeach

            @if (isset($orderData['discount']['code']))
                @php
                    $discountPercent = $orderData['discount']['percent'];
                    $discountAmount = $subtotal * ($discountPercent / 100);
                    $total = $subtotal - $discountAmount;
                @endphp
                <tr class="total">
                    <td></td>
                    <td colspan="3">Subtotal:{{ number_format($subtotal, 2) }}€</td>
                </tr>
                <tr class="total">
                    <td></td>
                    <td colspan="3">Descuento ({{ $discountPercent }}%):{{ number_format($discountAmount, 2) }}€</td>
                </tr>
            @endif
            <tr class="total">
                <td></td>
                <td colspan="4">Total:{{ number_format($total, 2) }}€</td>
            </tr>
        </table>
    </div>
</body>


</html>
