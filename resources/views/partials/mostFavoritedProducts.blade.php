<!-- resources/views/partials/most_favorited_products.blade.php -->
@if ($mostFavorited)
    <div class="container mt-4">
        <h2>Productos más favoritos</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Precio</th>
                    <th>Desarrollador</th>
                    <th>Plataforma</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mostFavorited as $product)
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->price }}</td>
                        <td>{{ $product->developer }}</td>
                        <td>{{ $product->platform }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endif
