@extends('auth.template')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('payment_confirmation.close') }}"></button>
        </div>
    @endif

    @if (session('errors'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('errors')->first('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('payment_confirmation.close') }}"></button>
        </div>
    @endif
    <main class="container my-5">

        <div class="row g-5">
            @php
                $totalQuantity = 0;
                $productsTotal = 0;
                foreach ($order->products as $product) {
                    $totalQuantity += $product->pivot->quantity;
                    $productsTotal += $product->price * $product->pivot->quantity;
                }
            @endphp
            {{-- resumen compras --}}
            <div class="col-md-5 col-lg-6 order-md-2">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text">{{ __('payment_confirmation.purchase_summary') }}</span>
                    <span class="badge rounded-pill">{{ $totalQuantity }}</span>
                </h4>
                <ul class="list-group mb-3">
                    @foreach ($order->products as $product)
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0 text-light">{{ $product->name }}</h6>
                                <small class="text-light">{{ __('payment_confirmation.quantity') }}: {{ $product->pivot->quantity }}</small>
                            </div>
                            <span class="text-light">
                                ${{ number_format($product->price, 2) }} x {{ $product->pivot->quantity }} =
                                ${{ number_format($product->price * $product->pivot->quantity, 2) }}
                            </span>
                        </li>
                    @endforeach

                    @if (!empty($discount))
                        <li class="list-group-item d-flex justify-content-between">
                            <span>{{ __('payment_confirmation.subtotal') }} (USD)</span>
                            <strong class="text-decoration-line-through">${{ number_format($productsTotal, 2) }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>{{ __('payment_confirmation.discount') }} {{ $discount->percent }}%</span>
                            <strong>${{ number_format($productsTotal * ($discount->percent / 100), 2) }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>{{ __('payment_confirmation.total') }} (USD)</span>
                            <strong>${{ number_format($productsTotal - $productsTotal * ($discount->percent / 100), 2) }}</strong>
                        </li>
                    @else
                        <li class="list-group-item d-flex justify-content-between">
                            <span>{{ __('payment_confirmation.total') }} (USD)</span>
                            <strong>${{ number_format($productsTotal, 2) }}</strong>
                        </li>
                    @endif

                </ul>
                @if (empty($discount))
                    <form action="{{ route('apply.discount', ['order' => $order->id]) }}" method="post">
                        @csrf
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="{{ __('payment_confirmation.promo_code') }}" name="discount_code">
                            <button type="submit" class="btn btn-secondary">{{ __('payment_confirmation.redeem') }}</button>
                        </div>
                    </form>
                @endif

                @if ($discount)
                    <div class="alert alert-success">
                        {{ __('payment_confirmation.discount_applied') }}: {{ $discount->percent }}% {{ __('payment_confirmation.off') }}
                    </div>
                @endif

            </div>
            {{-- panel direcciones --}}
            @if ($addresses->isNotEmpty())
                <div class="col-md-7 col-lg-6 order-md-1">
                    <div class="d-flex flex-row justify-content-center">
                    @foreach ($addresses as $address)
                        @if (!empty($discount))
                            <form
                                action="{{ route('order.save', ['addressId' => $address->id, 'discount' => $discount->id]) }}"
                                method="post" class="w-50 mx-2">
                            @else
                                <form action="{{ route('order.save', ['addressId' => $address->id]) }}" method="post"
                                    class="w-50 mx-2">
                        @endif
                        @csrf
                        @method('post')
                        <div class="card mb-3 mt-5">
                            <div class="card-body">
                                <h5 class="card-title">{{ __('payment_confirmation.user_address') }}</h5>
                                <p class="card-text">
                                    <strong>{{ __('payment_confirmation.address') }}:</strong> {{ $address->address }}<br>
                                    <strong>{{ __('payment_confirmation.zip_code') }}:</strong> {{ $address->zip }}<br>
                                    <strong>{{ __('payment_confirmation.country') }}:</strong> {{ $address->country }}
                                </p>
                            </div>
                            <!-- Botón de comprar dentro de la tarjeta -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary"> {{ __('payment_confirmation.buy') }} </button>
                                <a class="btn btn-danger bi bi bi-trash"
                                    href="{{ route('addresses.delete', ['addressId' => $address->id]) }}">{{ __('payment_confirmation.remove') }}</a>
                            </div>
                        </div>
                        </form>
                    @endforeach


                </div>
                {{ $addresses->links() }}
                    {{-- boton nuevas direcciones --}}
                    <button type="button" class="btn btn-primary w-100 bi bi bi-plus" data-bs-toggle="collapse"
                        data-bs-target="#orderAddressDiv" aria-expanded="false" aria-controls="orderAddressDiv"
                        id="newAddressToggle">
                        {{ __('payment_confirmation.new_address') }}
                    </button>
                </div>
            @endif
            {{-- Nueva dirección --}}
            @if ($addresses->isnotEmpty())
            <div class="col-md-7 col-lg-8 order-md-3 collapse" id="orderAddressDiv">
                @else
                <div class="col-md-7 col-lg-6 order-md-1 collapse show" id="orderAddressDiv">
                @endif
                <h4 class="mb-3">{{ __('payment_confirmation.order_address') }}</h4>
                @if (!empty($discount))
                    <form class="needs-validation" action="{{ route('address.create', ['discount' => $discount->id]) }}"
                        method="post">
                    @else
                        <form class="needs-validation" action="{{ route('address.create') }}" method="post">
                @endif
                @csrf
                @method('POST')
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label for="firstName" class="form-label">{{ __('payment_confirmation.first_name') }}</label>
                        <input type="text" class="form-control" id="firstName" placeholder="{{ __('payment_confirmation.first_name_placeholder') }}" name="firstName" required>
                        <div class="invalid-feedback">
                            {{ __('payment_confirmation.first_name_required') }}
                        </div>
                    </div>


                    <div class="col-sm-6">
                        <label for="lastName" class="form-label">{{ __('payment_confirmation.last_name') }}</label>
                        <input type="text" class="form-control" id="lastName" placeholder="{{ __('payment_confirmation.last_name_placeholder') }}" name="lastName">
                        <div class="invalid-feedback">
                            {{ __('payment_confirmation.last_name_required') }}
                        </div>
                    </div>


                    <div class="col-12">
                        <label for="telephone_number" class="form-label">{{ __('payment_confirmation.phone') }} <span
                            class="text-body-light">({{ __('payment_confirmation.optional') }})</span></label>
                    <input type="number" class="form-control" id="telephone_number" placeholder="{{ __('payment_confirmation.phone_placeholder') }}"
                        name="telephone_number">
                    <div class="invalid-feedback">
                        {{ __('payment_confirmation.phone_required') }}
                    </div>
                </div>

                <div class="col-12">
                    <label for="address" class="form-label">{{ __('payment_confirmation.address') }}</label>
                    <input type="text" class="form-control" id="address" placeholder="{{ __('payment_confirmation.address_placeholder') }}"
                        name="address" required>
                    <div class="invalid-feedback">
                        {{ __('payment_confirmation.address_required') }}
                    </div>
                </div>

                <div class="col-12">
                    <label for="secondary_address" class="form-label">{{ __('payment_confirmation.secondary_address') }}<span
                            class="text-body-light">({{ __('payment_confirmation.optional') }})</span></label>
                    <input type="text" class="form-control" id="secondary_address"
                        placeholder="{{ __('payment_confirmation.secondary_address_placeholder') }}" name="secondary_address">
                </div>

                <div class="col-md-5">
                    <label for="country" class="form-label">{{ __('payment_confirmation.country') }}</label>
                    <select class="form-select" id="country" name="country" required>
                        <option value="">{{ __('payment_confirmation.choose') }}...</option>
                        <option>{{ __('payment_confirmation.united_states') }}</option>
                        <option>{{ __('payment_confirmation.china') }}</option>
                        <option>{{ __('payment_confirmation.india') }}</option>
                        <option>{{ __('payment_confirmation.japan') }}</option>
                        <option>{{ __('payment_confirmation.germany') }}</option>
                        <option>{{ __('payment_confirmation.united_kingdom') }}</option>
                        <option>{{ __('payment_confirmation.russia') }}</option>
                        <option>{{ __('payment_confirmation.france') }}</option>
                        <option>{{ __('payment_confirmation.brazil') }}</option>
                        <option>{{ __('payment_confirmation.italy') }}</option>
                        <option>{{ __('payment_confirmation.canada') }}</option>
                        <option>{{ __('payment_confirmation.south_korea') }}</option>
                        <option>{{ __('payment_confirmation.australia') }}</option>
                        <option>{{ __('payment_confirmation.spain') }}</option>
                        <option>{{ __('payment_confirmation.mexico') }}</option>
                        <option>{{ __('payment_confirmation.indonesia') }}</option>
                        <option>{{ __('payment_confirmation.netherlands') }}</option>
                        <option>{{ __('payment_confirmation.saudi_arabia') }}</option>
                        <option>{{ __('payment_confirmation.turkey') }}</option>
                    </select>

                    <div class="invalid-feedback">
                        {{ __('payment_confirmation.country_required') }}
                    </div>
                </div>

                <div class="col-md-3">
                    <label for="zip" class="form-label">{{ __('payment_confirmation.zip') }}</label>
                    <input type="text" class="form-control" id="zip" name="zip" required>
                    <div class="invalid-feedback">
                        {{ __('payment_confirmation.zip_required') }}
                    </div>
                </div>
                <hr class="my-4">

                {{-- ! sin name para que no se envie --}}
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="same-address" name="saveAddress">
                    <label class="form-check-label" for="same-address">{{ __('payment_confirmation.not_save_address') }}</label>
                </div>

                <hr class="my-4">
            </div>

            <button class="w-100 btn btn-primary btn-lg" type="button" data-bs-toggle="modal"
                data-bs-target="#buyAndReturnModal">
                {{ __('payment_confirmation.buy') }}
            </button>
            <div class="modal fade" id="buyAndReturnModal" tabindex="-1" role="dialog"
                aria-labelledby="buyAndReturnModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="buyAndReturnModalLabel">{{ __('payment_confirmation.confirmation_of_purchase') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="{{ __('payment_confirmation.close') }}"></button>
                        </div>
                        <div class="modal-body">
                            {{ __('payment_confirmation.confirm_purchase_message') }}
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">{{ __('payment_confirmation.confirm') }}</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                aria-label="{{ __('payment_confirmation.close') }}">
                                {{ __('payment_confirmation.close') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</main>
@endsection