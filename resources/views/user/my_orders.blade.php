@extends('auth.template')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('my_orders.close') }}"></button>
            </div>
        @endif

        @if (session('errors'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                {{ session('errors')->first('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('my_orders.close') }}"></button>
            </div>
        @endif

        <h1>{{ __('my_orders.my_orders') }}</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>{{ __('my_orders.order_id') }}</th>
                    <th>{{ __('my_orders.status') }}</th>
                    <th>{{ __('my_orders.total') }}</th>
                    <th>{{ __('my_orders.order_details') }}</th>
                    <th>{{ __('my_orders.actions') }}</th>
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
                                <strong>{{ __('my_orders.name') }}:</strong> {{ $orderDetails['user']['real_name'] ?? '' }}
                                {{ $orderDetails['user']['surname'] ?? '' }}<br>
                                <strong>{{ __('my_orders.address') }}:</strong> {{ $orderDetails['address']['address'] ?? '' }}<br>
                                <strong>{{ __('my_orders.country') }}:</strong> {{ $orderDetails['address']['country'] ?? '' }}<br>
                                <strong>{{ __('my_orders.zip_code') }}:</strong> {{ $orderDetails['address']['zip'] ?? '' }}
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
                            <td colspan="5 justify-content-center">{{ __('my_orders.order_details_error') }}</td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $orders->links() }}
@endsection