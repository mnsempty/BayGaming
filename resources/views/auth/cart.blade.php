@extends('auth.template')

@section('content')
    <div class="container">
        <h1>Mi Carrito</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('errors'))
            <div class="alert alert-danger">
                {{ session('errors')->first('message') }}
            </div>
        @endif

        @if ($products->count())
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>
                            <form action="{{ route('cart.update', ['product' => $product->id]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <button type="submit" name="action" value="decrement" class="btn btn-sm btn-primary">-</button>
                                <span id="quantity-{{ $product->id }}">{{ $product->pivot->quantity }}</span>
                                <button type="submit" name="action" value="increment" class="btn btn-sm btn-primary">+</button>
                            </form>
                        </td>
                        <td>${{ number_format($product->price,  2) }}</td>
                        <td>${{ number_format($product->price * $product->pivot->quantity,  2) }}</td>
                        <td>
                            <form action="{{ route('cart.delete', $product->id) }}" method="get">
                                @csrf
                                @method('get')
                                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                </table>
                
                <?php
                $total =  0;
                foreach ($products as $product) {
                    $total += $product->price * $product->pivot->quantity;
                }
                ?>
                
                <div class="text-right">
                    <strong>Total: ${{ number_format($total,  2) }}</strong>
                    <button type="button" class="btn btn-lg btn-success" data-bs-toggle="modal" data-bs-target="#paymentModal">
                        Proceder al Pago
                    </button>
                </div>
                
        @else
            <p>Tu carrito está vacío.</p>
        @endif
    </div>

    <!-- Modal de confirmación de pago -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel">Confirmar Pago</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Estás seguro de que quieres proceder con el pago?
                </div>
                <div class="modal-footer">
                    <form action="{{ route('cart.proceedToPayment') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">Confirmar</button>
                    </form>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    

@endsection
