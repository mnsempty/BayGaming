@extends('product.template')

@section('content')
<div class="card" style="width: 18rem;">
    <div class="card-body">
      <h5 class="card-title">{{$product->name}}</h5>
      <h6 class="card-subtitle mb-2 text-body-primary text-bg-info">{{$product->price}}</h6>
      <p class="card-text">{{$product->description}}</p>
      <p class="card-text text-bg-warning">Stock{{$product->stock}}</p>
      <div class="card" style="width: 18rem;">
        <ul class="list-group list-group-flush">
          <li class="list-group-item">{{$product->developer}}/li>
          <li class="list-group-item">{{$product->platform}}/li>
          <li class="list-group-item">{{$product->launcher}}</li>
        </ul>
      </div>
      <a href="#" class="card-link">Card link</a>
      <a href="#" class="card-link">Another link</a>
    </div>
  </div>
@endsection