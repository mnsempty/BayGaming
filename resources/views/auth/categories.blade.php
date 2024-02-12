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
            <th>ID</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
        @if (isset($categories))
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                </tr>
            @endforeach
        @endif
    </table>

@endsection
