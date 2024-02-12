@extends('auth.template')

@section('content')

    <div class="container">
        <h2 class="mb-3">Categorias</h2>
        <a href="{{ route('categories.create') }}" class="btn btn-primary mb-3">Add Category</a>

        <table class="container table table-bordered">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Actions</th>
            </tr>
            @if (isset($categories))
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @endif
        </table>
    </div>

@endsection
