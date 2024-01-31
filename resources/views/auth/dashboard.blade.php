@extends('auth.template')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Dashboard
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        You are logged in!
                    </div>
                </div>
                @if (session('mensaje'))
                    <div class="alert alert-success">
                        {{ session('mensaje') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <table class="container table table-bordered">
        <tr>
            <th>Name</th>
            <th>Precio</th>
            <th>Developer</th>
        </tr>
        @if (@isset($products))
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->developer }}</td>
                    <td>{{ $product->platform }}</td>
                    <td>
                        <form action="{{ route('product.delete', $product->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            {{-- {{ route('home',$product->id) }} --}}
                            <a class="btn btn-info" href="">Show</a>
                            {{-- {{ route('products.edit',$product->id) }} --}}
                            <a class="btn btn-primary" href="">Edit</a>
                        </form>
                    </td>
                    </td>
                </tr>
            @endforeach
        @endif
    </table>
@endsection
