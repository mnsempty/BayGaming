@extends('auth.template')

@section('content')
    <div class="container">
        <h1>Mis Órdenes</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID de la Orden</th>
                    <th>Estado</th>
                    <th>Total</th>
                    <th>Detalles de la Orden</th>
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
                                <a href="#" class="btn btn-primary btn-sm bi bi-file-earmark-arrow-down-fill"></a>
                                {{-- bi bi-envelope-check-fill --}}
                                <a href="#" class="btn btn-secondary btn-sm bi bi-envelope-arrow-down-fill"></a>
                            </td>
                        @else
                            <td colspan="5 justify-content-center">Error en los detalles del pedido</td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
