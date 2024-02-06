@extends('auth.template')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Tienda</h1>
            <a href="{{ route('cart.list') }}" class="btn btn-success">
                Carrito
                <i class="bi bi-cart"></i>
            </a>
        </div>
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('errors'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('errors')->first('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

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
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-primary">Añadir al carrito</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- crear una nueva fila después de cada tres tarjetas -->
                @if ($loop->iteration % 3 == 0)
        </div>
        <div class="row">
            @endif
            @endforeach
        </div>
    </div>
@endsection
