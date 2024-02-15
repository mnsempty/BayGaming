@extends('auth.template')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <form action="{{ route('language.change') }}" method="POST">
                @csrf
                <select name="language" onchange="this.form.submit()">
                    <option value="en"
                        {{ session('language') === 'en' || Cookie::get('language') === 'en' ? 'selected' : '' }}>
                        <span class="fi fi-gb"></span> English
                    </option>
                    <option value="es"
                        {{ session('language') === 'es' || Cookie::get('language') === 'es' ? 'selected' : '' }}>
                        <span class="fi fi-es"></span> Español
                    </option>
                </select>
            </form>

            <h1>{{ __('landing.shop') }}</h1>
            <!-- Botón para abrir el modal de la lista de deseos -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#wishlistModal">
                {{ __('landing.view_wishlist') }}
                <i class="bi bi-heart"></i>
            </button>
            <a href="{{ route('cart.list') }}" class="btn btn-success">
                {{ __('landing.cart') }}
                <i class="bi bi-cart"></i>
            </a>
        </div>

        <!-- Modal de la lista de deseos -->
        <div class="modal fade" id="wishlistModal" tabindex="-1" aria-labelledby="wishlistModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="wishlistModalLabel">{{ __('landing.my_wishlist') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <ul id="wishlistItems">
                            <!-- Los elementos de la lista de deseos se llenarán aquí con jquery-->
                        </ul>
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">{{ __('landing.close') }}</button>
                    </div>
                </div>
            </div>
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
                            <img src="{{ $product->images->first()->url }}" class="card-img-top"
                                alt="{{ $product->name }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ $product->price }} {{ config('app.currency') }}</p>

                            <!-- Botón para añadir o quitar de la lista de deseos -->
                            <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-wishlist">
                                    @if ($product->wishlists()->where('users_id', Auth::id())->exists())
                                        <i class="bi bi-heart-fill"></i>
                                    @else
                                        <i class="bi bi-heart"></i>
                                    @endif
                                </button>
                            </form>


                            <!-- añadir al carrito -->
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-primary">{{ __('landing.add_To_Cart') }}
                                </button>
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
        {{ $products->links() }}

    </div>
@endsection
