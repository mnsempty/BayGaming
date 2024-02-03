@extends('auth.template')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Tienda</h1>
            <a href="{{ route('cart') }}" class="btn btn-success">
                Carrito
                <i class="bi bi-cart"></i>
            </a>
        </div>

        <div class="row">
            @foreach ($products as $product)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        @if ($product->images->isNotEmpty())
                            <img src="{{ $product->images->first()->url }}" class="card-img-top" alt="{{ $product->name }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ $product->price }} {{ config('app.currency') }}</p>
                            <p class="card-text">Stock: {{ $product->stock }}</p>
                            <!-- añadir al carrito -->
                            <a href="#" class="btn btn-primary">Añadir al carrito</a>
                        </div>
                    </div>
                </div>
                <!-- sirve para crear una nueva fila después de cada tres tarjetas -->
                @if ($loop->iteration % 3 == 0)
        </div>
        <div class="row">
            @endif
            @endforeach
        </div>
    </div>
@endsection
