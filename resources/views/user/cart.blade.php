@extends('auth.template')

@section('content')
    <div class="container">
        <h1>{{ __('cart.cart') }}</h1>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('errors'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                {{ session('errors')->first('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

    </div>

    <!-- Modal de confirmación de pago -->
    <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModalLabel"> {{ __('cart.confirm_payment') }}
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{ __('cart.confirm_payment_message') }}
                </div>
                <div class="modal-footer">
                    <form action="{{ route('cart.proceedToPayment') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary">{{ __('cart.confirm') }}</button>
                    </form>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">{{ __('cart.cancel') }}</button>
                    {{-- Podemos cambiar a secondary en vez de danger para el boton azul --}}
                </div>
            </div>
        </div>
    </div>

    <!-- cart + summary -->
    @if ($products->count())
        <section class=" my-5">
            <div class="container">
                <div class="row">
                    <!-- cart -->
                    <?php
                    $total = 0;
                    foreach ($products as $product) {
                        $total += $product->price * $product->pivot->quantity;
                    }
                    ?>
                    <div class="col-lg-9">
                        <div class="card shadow-0">
                            <div class="m-4">
                                <h4 class="card-title mb-4">{{ __('cart.products') }}</h4>
                                @foreach ($products as $product)
                                    <div class="row gy-3 mb-4 d-flex align-items-center">
                                        <div class="col-lg-5">
                                            <div class="me-lg-5">
                                                <div class="d-flex">
                                                    @if ($product->images->isNotEmpty())
                                                        <img src="{{ $product->images->first()->url }}"
                                                            class="border rounded me-3" style="width: 96px; height: 96px;"
                                                            alt="{{ $product->name }}">
                                                    @endif
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <a href="#" class="nav-link">{{ $product->name }}</a>
                                                        <p class="text">{{ $product->platform }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="col-lg-2 col-sm-6 col-6 d-flex flex-row flex-lg-column flex-xl-row text-nowrap">
                                            <form action="{{ route('cart.update', ['product' => $product->id]) }}"
                                                method="POST" class=" me-4">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" name="action" value="decrement"
                                                    class="btn btn-lg "><i class="bi bi-dash"></i></button>
                                                <span
                                                    id="quantity-{{ $product->id }}">{{ $product->pivot->quantity }}</span>
                                                <button type="submit" name="action" value="increment"
                                                    class="btn btn-lg"><i class="bi bi-plus"></i></button>
                                            </form>
                                            <div class="">

                                                <text
                                                    class="h6">${{ number_format($product->price * $product->pivot->quantity, 2) }}</text>
                                                <br />
                                                <small class="text text-nowrap">
                                                    ${{ number_format($product->price, 2) }}
                                                    {{ __('cart.per_item') }} </small>
                                            </div>
                                        </div>
                                        <div
                                            class="col-lg col-sm-6 d-flex justify-content-sm-center justify-content-md-start justify-content-lg-center justify-content-xl-end mb-2">
                                            <div class="float-md-end d-flex flex-row align-items-center">
                                                <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST" class="mb-0">
                                                    @csrf
                                                    <button type="submit" class="btn btn-wishlist border-0">
                                                        @if ($product->wishlists()->where('users_id', Auth::id())->exists())
                                                            <i class="bi bi-heart-fill px-1"></i>
                                                        @else
                                                            <i class="bi bi-heart px-1"></i>
                                                        @endif
                                                    </button>
                                                </form>
                                                <form action="{{ route('cart.delete', $product->id) }}" method="get" class="mb-0">
                                                    @csrf
                                                    @method('get')
                                                    <button type="submit"
                                                        class="btn btn-light border text-danger icon-hover-danger"><i class="bi bi-trash text-danger icon-hover-danger"></i> {{ __('cart.remove') }}</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                    <!-- cart -->
                    <!-- summary -->
                    <div class="col-lg-3">
                        <div class="card shadow-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <p class="mb-2">{{ __('cart.total_price') }}</p>
                                    <p class="mb-2 fw-bold">${{ number_format($total, 2) }}</p>
                                </div>

                                <div class="mt-3">
                                    <button type="button" class="btn btn-success w-100 shadow-0 mb-2"
                                        data-bs-toggle="modal" data-bs-target="#paymentModal">
                                        {{ __('cart.purchase') }}
                                    </button>
                                    <a href="{{ route('landing') }}"
                                        class="btn btn-light w-100 border mt-2">{{ __('cart.back_shop') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- summary -->
                </div>
            </div>
        </section>
    @else
        <p>{{ __('cart.empty_cart') }}</p>
    @endif
