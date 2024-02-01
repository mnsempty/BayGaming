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
                        {{-- <form action="{{ route('products.edit', $product->id) }}" method="POST">
                            @csrf
                            {{--* @method = a route::X --}}
                            {{-- @method('PUT')
                            <button type="submit" class="btn btn-warning">Delete</button>
                        </form> --}} 
                        
                        <a class="btn btn-warning" href="{{ route('products.edit.view', $product->id) }}">Edit</a>

                        <form action="{{ route('product.delete', $product->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            {{-- {{ route('home',$product->id) }} --}}
                            <a class="btn btn-info" href="">Show</a>

                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                    </td>
                </tr>
            @endforeach
        @endif
    </table>
@endsection
