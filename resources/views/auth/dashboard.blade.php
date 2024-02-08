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
                <!-- Botón para abrir el modal de creación de productos -->
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createProductModal">
                    Create
                </button>
            </div>
        </div>
    </div>
    
     <!-- Código para mostrar la vista de productos -->
     @include('auth.products')
     
     <!-- Código para mostrar la vista de categorías -->
     @include('auth.categories')

    
@endsection
