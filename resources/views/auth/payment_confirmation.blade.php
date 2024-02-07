@extends('auth.template')

@section('content')
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

            <div class="col-md-5 col-lg-4 order-md-last">
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
            {{-- direcciones --}}
            <div class="col-md-7 col-lg-8">
                <h4 class="mb-3">Billing address</h4>
                <form class="needs-validation" action="{{ route('address.create') }}" method="post">
                    @csrf
                    @method('POST')
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label for="firstName" class="form-label">First name</label>
                            <input type="text" class="form-control" id="firstName" placeholder="" value=""
                                required="">
                            <div class="invalid-feedback">
                                Valid first name is required.
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <label for="lastName" class="form-label">Last name</label>
                            <input type="text" class="form-control" id="lastName" placeholder="" value=""
                                required="">
                            <div class="invalid-feedback">
                                Valid last name is required.
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="username" class="form-label">Username</label>
                            <div class="input-group has-validation">
                                <span class="input-group-text">@</span>
                                <input type="text" class="form-control" id="username" placeholder="Username"
                                    required="">
                                <div class="invalid-feedback">
                                    Your username is required.
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="email" class="form-label">Phone <span
                                    class="text-body-secondary">(Optional)</span></label>
                            <input type="email" class="form-control" id="email" placeholder="you@example.com">
                            <div class="invalid-feedback">
                                Please enter a valid email address for shipping updates.
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" placeholder="1234 Main St"
                                required="">
                            <div class="invalid-feedback">
                                Please enter your shipping address.
                            </div>
                        </div>

                        <div class="col-12">
                            <label for="address2" class="form-label">Address 2 <span
                                    class="text-body-secondary">(Optional)</span></label>
                            <input type="text" class="form-control" id="address2" placeholder="Apartment or suite">
                        </div>

                        <div class="col-md-5">
                            <label for="country" class="form-label">Country</label>
                            <select class="form-select" id="country" required="">
                                <option value="">Choose...</option>
                                <option>United States</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a valid country.
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label for="zip" class="form-label">Zip</label>
                            <input type="text" class="form-control" id="zip" placeholder="" required="">
                            <div class="invalid-feedback">
                                Zip code required.
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">
                    <button class="w-100 btn btn-primary btn-lg" type="button" data-bs-toggle="modal"
                        data-bs-target="#buyAndReturnModal">
                        Comprar
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
