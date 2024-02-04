<x-mail::message>
    ## Invoice Paid

    Hello {{ $notifiable->name }},

    We have received your payment for the following invoice:

    Here are the products you purchased:

    | Product Name | Quantity | Price per Unit |
    |--------------|----------|-----------------|
    @foreach ($invoice->order->products as $product)
        | {{ $product->name }} | {{ $product->pivot->quantity }} | ${{ number_format($product->price, 2) }} |
    @endforeach

    {{-- ? **Invoice Number:** {{ $invoice->invoice_number }}
  **Issue Date:** {{ $invoice->issue_date->format('F d, Y') }} --}}
    **Date:** {{ $invoice->date->format('F d, Y') }}

    {{-- ? **Subtotal:** ${{ number_format($invoice->subtotal, 2) }} --}}
    {{-- ? **Tax:** ${{ number_format($invoice->tax, 2) }} --}}
    **Total:** ${{ number_format($invoice->total, 2) }}
    {{-- ? **Payment Method:** {{ $invoice->payment_method }}  --}}


    Thank you for choosing our services.

    Best regards,<br>
    {{ config('app.name') }}
</x-mail::message>
