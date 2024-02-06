<x-mail::message>
    ## Invoice Paid

    Hello {{ $name }},

    We have received your payment for the following invoice:

    Here are the products you purchased:

    <table border="1" cellspacing="0" cellpadding="5">
        <tr>
            <th>Product Name</th>
            <th>Quantity</th>
            <th>Price per Unit</th>
        </tr>
        @foreach ($invoice->order->products as $product)
        <tr>
            <td>{{ $product->name }}</td>
            <td>{{ $product->pivot->quantity }}</td>
            <td>${{ number_format($product->price, 2) }}</td>
        </tr>
        @endforeach
    </table>

    **Date:** {{ $invoice->date->format('F d, Y') }}
    **Total:** ${{ number_format($invoice->subtotal, 2) }}

    Thank you for choosing our services.

    Best regards,<br>
    {{ config('app.name', 'BayGaming') }}
</x-mail::message>
