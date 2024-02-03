@extends('auth.template')

@section('content')
    <div class="container">
        <h1>Carrito de Compras</h1>
        @if($products->count())
            <ul>
                @foreach($products as $product)
                    <li>
                        {{ $product->name }} - {{ $product->price }} {{ config('app.currency') }} x {{ $product->pivot->quantity }}
                    </li>
                @endforeach
            </ul>
        @else
            <p>Tu carrito está vacío.</p>
        @endif
    </div>
@endsection
