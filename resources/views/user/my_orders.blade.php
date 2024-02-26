@extends('auth.template')

@section('content')
    <div class="container">
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

        <h1>Mis Órdenes</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID del pedido</th>
                    <th>Estado</th>
                    <th>Total</th>
                    <th>Detalles del pedido</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <?php
                    $orderDetails = json_decode($order->orderData, true);
                    // en caso de error en el json de datos del pedido se quitan las filas y se pone la de error
                    $showOrderDetails = !is_null($orderDetails) && isset($orderDetails['user']) && isset($orderDetails['address']);
                    ?>
                    <tr>
                        @if ($showOrderDetails)
                            <td>{{ $order->id }}</td>
                            <td>{{ ucfirst($order->state) }}</td>
                            <td>{{ number_format($order->total, 2) }}</td>
                            <td>
                                <strong>Nombre:</strong> {{ $orderDetails['user']['real_name'] ?? '' }}
                                {{ $orderDetails['user']['surname'] ?? '' }}<br>
                                <strong>Dirección:</strong> {{ $orderDetails['address']['address'] ?? '' }}<br>
                                <strong>País:</strong> {{ $orderDetails['address']['country'] ?? '' }}<br>
                                <strong>Código Postal:</strong> {{ $orderDetails['address']['zip'] ?? '' }}
                            </td>
                            <td>

                                <a class="btn btn-primary btn-lg bi bi-file-earmark-arrow-down-fill"
                                    href="{{ route('generate.pdf', ['orderId' => $order->id]) }}"
                                    data-id-order-pdf="{{ $order->id }}"
                                    onclick="downloadPDF({{ $order->id }})"></a>

                                <a class="btn btn-primary btn-lg bi bi-envelope-arrow-down-fill"
                                    data-id-order="{{ $order->id }}" onclick="sendMail({{ $order->id }})">
                                </a>
                            </td>
                        @else
                            <td colspan="5 justify-content-center">Error en los detalles del pedido</td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $orders->links() }}

@endsection
