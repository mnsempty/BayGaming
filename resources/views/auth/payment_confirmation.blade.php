@extends('auth.template')

@section('content')
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
    <main class="container my-5">

        <div class="row g-5">
            @php
                $totalQuantity = 0;
                $subtotal = 0;
                foreach ($order->products as $product) {
                    $totalQuantity += $product->pivot->quantity;
                    $subtotal += $product->price * $product->pivot->quantity;
                }
            @endphp
            {{-- resumen compras --}}
            <div class="col-md-5 col-lg-6 order-md-2">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-primary">Resumen de compra</span>
                    <span class="badge bg-primary rounded-pill">{{ $totalQuantity }}</span>
                </h4>
                <ul class="list-group mb-3">
                    @foreach ($order->products as $product)
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0">{{ $product->name }}</h6>
                                <small class="text-body-secondary">Cantidad: {{ $product->pivot->quantity }}</small>
                            </div>
                            <span class="text-body-secondary">
                                ${{ number_format($product->price, 2) }} x {{ $product->pivot->quantity }} =
                                ${{ number_format($product->price * $product->pivot->quantity, 2) }}
                            </span>
                        </li>
                    @endforeach
                    <!-- Aquí puedes agregar otros elementos como descuentos o impuestos si son aplicables -->
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Subtotal (USD)</span>
                        <strong>${{ number_format($subtotal, 2) }}</strong>
                    </li>
                    <!-- Aquí puedes agregar otros elementos como descuentos o impuestos si son aplicables -->
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Total (USD)</span>
                        <strong>${{ number_format($subtotal, 2) }}</strong>
                    </li>
                </ul>

                <form class="card p-2">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Promo code">
                        <button type="submit" class="btn btn-secondary">Redeem</button>
                    </div>
                </form>
            </div>
            {{-- test --}}
            <div class="col-md-7 col-lg-6 order-md-1">
                @foreach ($addresses as $address)
                    <form action="{{ route('order.save', ['addressId' => $address->id]) }}" method="post">
                        @csrf
                        @method('get')
                        <div class="card w-75 mb-3 mt-5">
                            <div class="card-body">
                                <h5 class="card-title">User Address</h5>
                                <p class="card-text">
                                    <strong>Address:</strong> {{ $address->address }}<br>
                                    <strong>Zip Code:</strong> {{ $address->zip }}<br>
                                    <strong>Country:</strong> {{ $address->country }}
                                </p>
                            </div>
                            <!-- Botón de comprar dentro de la tarjeta -->
                            <a class="btn btn-danger bi bi-trash3-fill" href="{{route('addresses.delete', ['addressId' => $address->id])}}">Eliminar address</a>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Buy</button>
                            </div>
                        </div>
                    </form>
                @endforeach

                <button type="button" class="btn btn-primary w-100 bi bi-plus" data-bs-toggle="collapse"
                    data-bs-target="#orderAddressDiv" aria-expanded="false" aria-controls="orderAddressDiv"
                    id="newAddressToggle">
                    New Address
                </button>

            </div>

            {{-- direcciones --}}
            <div class="col-md-7 col-lg-8 order-md-3 collapse" id="orderAddressDiv">
                <h4 class="mb-3">Order address</h4>
                <form class="needs-validation" action="{{ route('address.create') }}" method="post">
                    @csrf
                    @method('POST')
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label for="firstName" class="form-label">First name</label>
                            <input type="text" class="form-control" id="firstName" placeholder="" name="firstName"
                                required>
                            <div class="invalid-feedback">
                                Valid first name is required.
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label for="lastName" class="form-label">Last name</label>
                            <input type="text" class="form-control" id="lastName" placeholder="" name="lastName">
                            <div class="invalid-feedback">
                                Valid last name is required.
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="telephone_number" class="form-label">Phone <span
                                    class="text-body-secondary">(Optional)</span></label>
                            <input type="number" class="form-control" id="telephone_number" placeholder="472410399"
                                name="telephone_number">
                            <div class="invalid-feedback">
                                Please enter a valid email address for shipping updates.
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" placeholder="1234 Main St"
                                name="address" required>
                            <div class="invalid-feedback">
                                Please enter your shipping address.
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="secondary_address" class="form-label">Address<span
                                    class="text-body-secondary">(Optional)</span></label>
                            <input type="text" class="form-control" id="secondary_address"
                                placeholder="Apartment or suite" name="secondary_address">
                        </div>

                        <div class="col-md-5">
                            <label for="country" class="form-label">Country</label>
                            <select class="form-select" id="country" name="country" required>
                                <option value="">Choose...</option>
                                <option>United States</option>
                                <option>China</option>
                                <option>India</option>
                                <option>Japan</option>
                                <option>Germany</option>
                                <option>United Kingdom</option>
                                <option>Russia</option>
                                <option>France</option>
                                <option>Brazil</option>
                                <option>Italy</option>
                                <option>Canada</option>
                                <option>South Korea</option>
                                <option>Australia</option>
                                <option>Spain</option>
                                <option>Mexico</option>
                                <option>Indonesia</option>
                                <option>Netherlands</option>
                                <option>Saudi Arabia</option>
                                <option>Turkey</option>
                            </select>

                            <div class="invalid-feedback">
                                Please select a valid country.
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label for="zip" class="form-label">Zip</label>
                            <input type="text" class="form-control" id="zip" name="zip" required>
                            <div class="invalid-feedback">
                                Zip code required.
                            </div>
                        </div>
                        <hr class="my-4">

                        {{-- ! sin name para que no se envie --}}
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="same-address" name="saveAddress">
                            <label class="form-check-label" for="same-address">Not save the direcction (will save in
                                invoice)</label>
                        </div>

                        <hr class="my-4">

                    </div>

                    <button class="w-100 btn btn-primary btn-lg" type="button" data-bs-toggle="modal"
                        data-bs-target="#buyAndReturnModal">
                        Buy
                    </button>
                    <div class="modal fade" id="buyAndReturnModal" tabindex="-1" role="dialog"
                        aria-labelledby="buyAndReturnModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="buyAndReturnModalLabel">Confirmar Compra y Volver al
                                        Carrito</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    ¿Estás seguro de que quieres completar la compra?
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Confirmar y enviar factura</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                        aria-label="Close">
                                        Cerrar
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
