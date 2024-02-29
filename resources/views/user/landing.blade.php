@extends('auth.template')

@section('content')
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 py-2">
        <div class="container-fluid">
            <div class="navbar-brand">
                <img src="https://cdn.worldvectorlogo.com/logos/instant-gaming-1.svg" alt="Logo" width="200"
                    height="32">
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <form action="{{ route('landing') }}" method="GET">
                            <input type="hidden" name="platform" value="{{ $platform === 'PC' ? '' : 'PC' }}">
                            <button type="submit"
                                class="nav-link btn btn-outline-dark {{ $platform === 'PC' ? 'active' : '' }}"
                                role="button">
                                PC
                            </button>
                        </form>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('landing') }}" method="GET">
                            <input type="hidden" name="platform" value="{{ $platform === 'PS5' ? '' : 'PS5' }}">
                            <button type="submit"
                                class="nav-link btn btn-outline-dark {{ $platform === 'PS5' ? 'active' : '' }}"
                                role="button">
                                Playstation
                            </button>
                        </form>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('landing') }}" method="GET">
                            <input type="hidden" name="platform" value="{{ $platform === 'Xbox' ? '' : 'Xbox' }}">
                            <button type="submit"
                                class="nav-link btn btn-outline-dark {{ $platform === 'Xbox' ? 'active' : '' }}"
                                role="button">
                                Xbox
                            </button>
                        </form>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('landing') }}" method="GET">
                            <input type="hidden" name="platform"
                                value="{{ $platform === 'Nintendo Switch' ? '' : 'Nintendo Switch' }}">
                            <button type="submit"
                                class="nav-link btn btn-outline-dark {{ $platform === 'Nintendo Switch' ? 'active' : '' }}"
                                role="button">
                                Nintendo
                            </button>
                        </form>
                    </li>
                    <li class="nav-item dropdown">
                        <form action="{{ route('landing') }}" method="GET"
                            class="nav-link dropdown-toggle btn btn-outline-dark" id="categoriesDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="d-flex align-items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                    class="bi bi-tag" viewBox="0 0 16 16">
                                    <path
                                        d="M6 4.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0m-1 0a.5.5 0 1 0-1 0 .5.5 0 0 0 1 0" />
                                    <path
                                        d="M2 1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 1 6.586V2a1 1 0 0 1 1-1m0 5.586 7 7L13.586 9l-7-7H2z" />
                                </svg> <select id="category-filter" class="form-select" name="category"
                                    onchange="this.form.submit()">
                                    <option value="" {{ is_null($category) ? 'selected' : '' }}>
                                        {{ __('landing.allCategories') }}
                                    </option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->name }}"
                                            {{ $category === $cat->name ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </form>
                    </li>
                </ul>
            </div>
            <div class="d-flex">
                <a href="{{ route('cart.list') }}">
                    <button class="btn btn-outline-dark">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0   0   24   24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="text-white h-6 w-6">
                            <circle cx="8" cy="21" r="1"></circle>
                            <circle cx="19" cy="21" r="1"></circle>
                            <path
                                d="M2.05   2.05h2l2.66   12.42a2   2   0   0   0   2   1.58h9.78a2   2   0   0   0   1.95-1.57l1.65-7.43H5.12">
                            </path>
                        </svg>
                    </button>
                </a>

                <div class="dropdown">
                    <button class="btn btn-outline-dark dropdown-toggle" type="button" id="userMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"
                            class="text-white h-6 w-6" viewBox="0 0 16 16">
                            <path
                                d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" />
                        </svg>
                    </button>
                    <ul class="dropdown-menu" id="user-menu" aria-labelledby="userMenuButton">
                        @guest
                            <li><a class="dropdown-item" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                            @if (Route::has('register'))
                                <li><a class="dropdown-item" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                            @endif
                        @else
                            <li><a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                            </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                            <li class="dropdown-item" data-bs-toggle="modal" data-bs-target="#wishlistModal">
                                {{ __('landing.view_wishlist') }}
                                <i class=" {{ $hasFavorites ? 'bi bi-heart-fill' : 'bi bi-heart' }}"></i>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
    </nav>
    <!-- Modal de la lista de deseos -->
    <div class="modal fade" id="wishlistModal" tabindex="-1" aria-labelledby="wishlistModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="wishlistModalLabel">{{ __('landing.my_wishlist') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul id="wishlistItems">
                        <!-- Los elementos de la lista de deseos se llenarán aquí con jquery-->
                    </ul>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">{{ __('landing.close') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class='banner'>
        <ul class="box-area">
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
            <li></li>
        </ul>
    </div>

    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('errors'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('errors')->first('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row justify-content-center" id="product-container">
            @foreach ($products as $product)
                <div class="col-md-3 mb-3">
                    <div class="card">
                        @if ($product->images->isNotEmpty())
                            <div class="img-container">
                                <img src="{{ $product->images->first()->url }}" class="product-img"
                                    alt="{{ $product->name }}">
                            </div>
                        @endif
                        <div class="details text-white">
                            <div class="name-fav">
                                <strong class="product-name text-white">{{ $product->name }}</strong>
                                <!-- Botón para añadir o quitar de la lista de deseos -->
                                <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-wishlist">
                                        @if ($product->wishlists()->where('users_id', Auth::id())->exists())
                                            <i class="bi bi-heart-fill"></i>
                                        @else
                                            <i class="bi bi-heart"></i>
                                        @endif
                                    </button>
                                </form>
                            </div>
                            <div class="wrapper">
                                <p>{{ $product->description }}</p>
                            </div>
                            <div class="purchase">
                                <p class="product-price text-white">{{ $product->price }} {{ config('app.currency') }}
                                </p>
                                <!-- añadir al carrito -->
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-primary">{{ __('landing.add_To_Cart') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- crear una nueva fila después de cada tres tarjetas -->
                @if ($loop->iteration % 4 == 0)
        </div>
        <div class="row">
            @endif
            @endforeach
        </div>
        {{ $products->links() }}
    @endsection
    @section('scripts')
        <script>
            document.getElementById('category-filter').addEventListener('change', function() {
                var category = this.value;
                var url = "{{ route('landing') }}";
                if (category) {
                    url += '/' + category;
                }
                window.location.href = url;
            });
        </script>
        <script>
            document.getElementById('platform-filter').addEventListener('change', function() {
                var platform = this.value;
                var url = "{{ route('landing') }}";
                if (platform) {
                    url += '/=' + platform;
                }
                window.location.href = url;
            });
        </script>
    @endsection
