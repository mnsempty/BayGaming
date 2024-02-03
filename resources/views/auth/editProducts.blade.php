@extends('auth.template')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Product</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('products.edit', $product->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('POST')

                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ $product->name }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required>{{ $product->description }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" step="0.01" class="form-control" id="price" name="price"
                                    value="{{ $product->price }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="stock" class="form-label">Stock</label>
                                <input type="number" class="form-control" id="stock" name="stock"
                                    value="{{ $product->stock }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="developer" class="form-label">Developer</label>
                                <input type="text" class="form-control" id="developer" name="developer"
                                    value="{{ $product->developer }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="publisher" class="form-label">Publisher</label>
                                <input type="text" class="form-control" id="publisher" name="publisher"
                                    value="{{ $product->publisher }}" required>
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="show" name="show" value="1"
                                    {{ $product->show ? 'checked' : '' }}>
                                <label class="form-check-label" for="show">Show</label>
                            </div>

                            <div class="mb-3">
                                <label for="platform" class="form-label">Platform</label>
                                <select class="form-select" id="platform" name="platform" required>
                                    <option value="PC" {{ $product->platform == 'PC' ? 'selected' : '' }}>PC</option>
                                    <option value="Ps5" {{ $product->platform == 'Ps5' ? 'selected' : '' }}>PS5</option>
                                    <option value="Xbox" {{ $product->platform == 'Xbox' ? 'selected' : '' }}>Xbox
                                    </option>
                                    <option value="Nintendo Switch"
                                        {{ $product->platform == 'Nintendo Switch' ? 'selected' : '' }}>Nintendo Switch
                                    </option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="launcher" class="form-label">Launcher</label>
                                <select class="form-select" id="launcher" name="launcher">
                                    <option value="" selected>Select a launcher</option>
                                    <option value="Steam" {{ $product->launcher == 'Steam' ? 'selected' : '' }}>Steam
                                    </option>
                                    <option value="Ubisoft Connect"
                                        {{ $product->launcher == 'Ubisoft Connect' ? 'selected' : '' }}>Ubisoft Connect
                                    </option>
                                    <option value="EA App" {{ $product->launcher == 'EA App' ? 'selected' : '' }}>EA App
                                    </option>
                                    <option value="Battle.net" {{ $product->launcher == 'Battle.net' ? 'selected' : '' }}>
                                        Battle.net</option>
                                    <option value="Rockstar" {{ $product->launcher == 'Rockstar' ? 'selected' : '' }}>
                                        Rockstar</option>
                                    <option value="GOG.com" {{ $product->launcher == 'GOG.com' ? 'selected' : '' }}>GOG.com
                                    </option>
                                    <option value="Epic" {{ $product->launcher == 'Epic' ? 'selected' : '' }}>Epic
                                    </option>
                                </select>
                            </div>
                            {{-- ! esta parte no he conseguido sacarla por la parte de imagenes  --}}
                            <!-- Formulario para las imágenes -->
                            <div class="mb-3">
                                <h4>Images</h4>
                                @foreach ($images as $image)
                                    <div class="form-group">
                                        <label for="image{{ $image->id }}">Imagen</label>
                                        <img src="{{ asset('storage/' . $image->url) }}" alt="Imagen del producto"
                                            style="width: 100px; height: auto;">
                                        <input type="hidden" name="images[{{ $image->id }}][id]"
                                            value="{{ $image->id }}">
                                        <input type="file" class="form-control" id="image{{ $image->id }}"
                                            name="images[{{ $image->id }}][file][]" accept="image/*" multiple>
                                    </div>
                                @endforeach

                            </div>


                            <!-- Formulario para los descuentos -->
                            <div class="mb-3">
                                <h4>Discounts</h4>
                                <div class="form-group">
                                    <label for="discount">Discount Percentage</label>
                                    <input type="number" class="form-control" id="discount" name="discount" min="0" max="100" step="1" value="{{ old('discount', $discounts->first()->percent ?? '') }}">
                                </div>
                            </div>



                            <button type="submit" class="btn btn-primary">Update Product</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
