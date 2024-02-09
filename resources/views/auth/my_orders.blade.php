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
          </tr>
      </thead>
      <tbody>
          @foreach($orders as $order)
              <tr>
                  <td>{{ $order->id }}</td>
                  <td>{{ ucfirst($order->state) }}</td>
                  <td>{{ number_format($order->total,  2) }}</td>
                  <td>
                      <?php
                          $orderDetails = json_decode($order->orderData, true);
                      ?>
                      <strong>Nombre:</strong> {{ $orderDetails['user']['real_name'] }} 
                      {{ $orderDetails['user']['surname'] }}<br>
                      <strong>Dirección:</strong> {{ $orderDetails['address']['address'] }}<br>
                      <strong>País:</strong> {{ $orderDetails['address']['country'] }}<br>
                      <strong>Código Postal:</strong> {{ $orderDetails['address']['zip'] }}
                  </td>
              </tr>
          @endforeach
      </tbody>
  </table>
</div>
@endsection