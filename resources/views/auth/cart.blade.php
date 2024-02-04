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
                                <form action="{{ route('cart.update', $product->pivot->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="quantity" value="{{ $product->pivot->quantity }}" min="1"
                                        max="{{ $product->stock }}">
                                    <button type="submit" class="btn btn-sm btn-primary">Actualizar</button>
                                </form>
                            </td>
                            <td>${{ number_format($product->price, 2) }}</td>
                            <td>${{ number_format($product->price * $product->pivot->quantity, 2) }}</td>
                            <td>
                                <form action="{{ route('cart.delete', $product->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

                <div class="text-right">
                    <strong>Total: $</strong>
                    {{--! {{ route('checkout') }} --}}
                    <a href="" class="btn btn-lg btn-success">Proceder al Pago</a>
                </div>
        @else
            <p>Tu carrito está vacío.</p>
        @endif
    </div>
@endsection
