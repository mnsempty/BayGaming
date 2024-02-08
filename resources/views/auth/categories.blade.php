
<table class="container table table-bordered">
        <tr>
            <h4 class="text-center">
                Categorias
            </h4>
        </tr>
        <tr>
            <th>Name</th>
        </tr>
        @if (isset($categories))
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>
                        {{-- <form action="{{ route('product.delete', $category->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            {{ route('home',$product->id) }}
                            <a class="btn btn-info" href="show">Show</a>
                            {{ route('products.edit',$product->id) }}
                            <a class="btn btn-primary" href="">Edit</a>
                        </form>  --}}
                    </td>
                </tr>
            @endforeach
        @endif
    </table>