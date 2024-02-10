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
                <div class="row align-items-center">
                    <!-- Button for opening the product creation modal -->
                    <div class="col-auto">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                            data-bs-target="#createProductModal">
                            Create
                        </button>
                    </div>
                    <!-- Single Toggle Switch for Showing Deleted Products -->
                    <div class="col-auto">
                        <div class="form-check form-switch mt-3">
                            <input class="form-check-input" type="checkbox" id="filterToggle">
                            <label class="form-check-label" for="filterToggle">Show Deleted Products</label>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <table class="container table table-bordered">
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Developer</th>
            <th>Platform</th>
            <th>Actions</th>
        </tr>
        @if (isset($products))
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->developer }}</td>
                    <td>{{ $product->platform }}</td>
                    <td>
                        <a class="btn btn-warning" href="{{ route('products.edit.view', $product->id) }}">Edit</a>
    
                        <form action="{{ route('product.delete', $product->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            {{-- {{ route('home',$product->id) }} --}}
                            <a class="btn btn-info" href="">Show</a>
    
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        @endif
    </table>

    <!-- Añadir la tabla con los productos más favoritos-->
    @include('partials.mostFavoritedProducts')


    <!-- "PRODUCTOS ELIMINADOS" -->
    <div class="container mt-4">
        <h2 class="mb-3">Productos eliminados</h2>
        <div id="productTableContainer" style="display: none;">
            <!-- La tabla se rellena aquí mediante JavaScript -->
        </div>
    </div>




    <!-- Modal de creación de productos -->
    <div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="createProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createProductModalLabel">Crear Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulario para crear el producto -->
                    <form action="{{ route('products.create') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" step="0.01" class="form-control" id="price" name="price"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="stock">Stock</label>
                            <input type="number" class="form-control" id="stock" name="stock" required>
                        </div>
                        <div class="form-group">
                            <label for="developer">Developer</label>
                            <input type="text" class="form-control" id="developer" name="developer" required>
                        </div>
                        <div class="form-group">
                            <label for="publisher">Publisher</label>
                            <input type="text" class="form-control" id="publisher" name="publisher" required>
                        </div>
                        <div class="form-group">
                            <label>Platform</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="platform" id="platformPC"
                                    value="PC" checked>
                                <label class="form-check-label" for="platformPC">
                                    PC
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="platform" id="platformPs5"
                                    value="Ps5">
                                <label class="form-check-label" for="platformPs5">
                                    PS5
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="platform" id="platformXbox"
                                    value="Xbox">
                                <label class="form-check-label" for="platformXbox">
                                    Xbox
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="platform"
                                    id="platformNintendoSwitch" value="NintendoSwitch">
                                <label class="form-check-label" for="platformNintendoSwitch">
                                    Nintendo Switch
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="launcher">Launcher</label>
                            <select class="form-control" id="launcher" name="launcher">
                                <option value="">Select a launcher</option>
                                <option value="Steam">Steam</option>
                                <option value="Ubisoft Connect">Ubisoft Connect</option>
                                <option value="EA App">EA App</option>
                                <option value="Battle.net">Battle.net</option>
                                <option value="Rockstar">Rockstar</option>
                                <option value="GOG.com">GOG.com</option>
                                <option value="Epic">Epic</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" class="form-control-file" id="image" name="image">
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
