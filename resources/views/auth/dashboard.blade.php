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
            </div>
        </div>
    </div>
    <table class="container table table-bordered">
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Developer</th>
            <th>Actions</th>
            <th><!-- Botón para abrir el modal de creación de productos -->
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#createProductModal">
                    Create
                </button>
            </th>
        </tr>

        @if (@isset($products))
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->developer }}</td>
                    <td>
                        <form action="{{ route('casa', $product->id) }}" method="POST">
                            <a class="btn btn-info" href="{{ route('casa', $product->id) }}">Show</a>
                            <a class="btn btn-primary" href="{{ route('casa', $product->id) }}">Edit</a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>

                    </td>
                </tr>
            @endforeach
        @endif
    </table>

    <!-- Modal de creación de productos -->
    <div class="modal fade" id="createProductModal" tabindex="-1" role="dialog" aria-labelledby="createProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createProductModalLabel">Crear Producto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Formulario para crear el producto -->
                    <form action="{{ route('casa') }}" method="POST" enctype="multipart/form-data">
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
                                <input class="form-check-input" type="radio" name="platform" id="platformNintendoSwitch"
                                    value="NintendoSwitch">
                                <label class="form-check-label" for="platformNintendoSwitch">
                                    Nintendo Switch
                                </label>
                            </div>
                            <!-- Repite para otras plataformas -->
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

    <!-- CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- JS de jQuery y Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
@endsection
