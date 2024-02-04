@extends('auth.template')

@section('content')
    <div class="container my-5">
        <h1 class="mb-4">Confirmación de Pago</h1>

        <div class="container my-5">
            <div class="row align-items-center">
                <div class="col-auto">
                    <p class="fs-5">Su pago ha sido procesado exitosamente.</p>
                </div>
                <div class="col-auto ms-3">
                    <a href="{{ route('send.invoice') }}" class="btn btn-dark">Enviar factura al correo</a>
                </div>
            </div>
        </div>


        <h2 class="mt-4">Resumen de Compra</h2>
        <ul class="list-group list-group-flush">
            @foreach ($order->products as $product)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $product->name }} - Cantidad: {{ $product->pivot->quantity }}
                    <span
                        class="badge bg-primary rounded-pill">${{ number_format($product->price * $product->pivot->quantity, 2) }}</span>
                </li>
            @endforeach

        </ul>

        <div class="mt-4 text-end">
            <p class="fs-4 fw-bold">Total: <span class="fw-normal">${{ number_format($order->total, 2) }}</span></p>
        </div>

        <div class="mt-4">
            <a href="{{ route('cart.list') }}" class="btn btn-primary">Volver al Carrito</a>
        </div>
    </div>
@endsection
