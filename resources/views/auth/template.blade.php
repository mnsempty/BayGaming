<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'BayGaming') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.0.0/css/flag-icons.min.css" />
    <!-- Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <!--js para ajax-->
    <script defer src="{{ asset('js/sendDownloadInvoiceUser.js') }}"></script>
    <script defer src="{{ asset('js/updateAddresses.js') }}"></script>
    {{-- css custom --}}

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/scss/app.scss', 'resources/js/app.js'])

    <!-- Variable de control para que detecte si estamos en landing y use ese vite -->
    @php
        $isLanding = Route::currentRouteName() === 'landing';
        $isCart = Route::currentRouteName() === 'cart.list';
        $isAdmin = Route::currentRouteName() === 'dashboard';
        $isCategoriesAdmin = Route::currentRouteName() === 'categories';
    @endphp

    @vite(['resources/css/app.css', 'resources/scss/app.scss', 'resources/js/app.js', $isLanding ? 'resources/scss/cards.scss' : '', $isLanding ? 'public/js/cards.js' : ''])
</head>

<body>
    <div id="app">
        @if ($isAdmin || $isCategoriesAdmin)
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
                <div class="container">
                    <a class="navbar-brand" href="{{ url('/dashboard') }}">
                        {{ config('app.name', 'BayGaming') }}
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav">
                            <!-- Authentication Links -->
                            @guest
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('categories') }}">{{ __('Categories') }}</a>
                                </li>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle" type="button"
                                        id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ Auth::user()->name }}
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item" href="{{ route('logout') }}"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                                        </li>
                                    </ul>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            @endguest
                        </ul>
                    </div>
                    <div>
                    </div>
                </div>
            </nav>
        @endif

        <main class="pt-4">
            @yield('content')
        </main>

        <footer class="bg-dark text-white mt-auto">
            @if ($isLanding)
                <div class="container py-4">
                    <div class="row gx-5">
                        <div class="col-md-4">
                            <div class="d-flex align-items-center mb-2">
                                <div class="text-success"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="text-[#00b67a] w-6 h-6">
                                        <polygon
                                            points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                        </polygon>
                                    </svg>
                                </div>
                                <span class="ms-2 fw-bold">Trustpilot</span>
                            </div>
                            <p>{{ __('authTemplate.trustScore') }} | {{ __('authTemplate.opinions') }}</p>
                        </div>

                        <div class="col-md-4">
                            <ul class="list-unstyled">
                                <li><a href="#"
                                        class="text-white text-decoration-none">{{ __('authTemplate.terms_conditions') }}</a>
                                </li>
                                <li><a href="#"
                                        class="text-white text-decoration-none">{{ __('authTemplate.privacy_policy') }}</a>
                                </li>
                                <li><a href="#"
                                        class="text-white text-decoration-none">{{ __('authTemplate.contact') }}</a>
                                </li>
                                <li><a href="#"
                                        class="text-white text-decoration-none">{{ __('authTemplate.faq') }}</a></li>
                                <li class="d-flex align-items-center">
                                    <a href="#"
                                        class="text-white text-decoration-none me-2">{{ __('authTemplate.redeem_gift_card') }}</a>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0  0  24  24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round" class="text-[#ff4500] w-5 h-5">
                                        <polyline points="20  12  20  22  4  22  4  12"></polyline>
                                        <rect width="20" height="5" x="2" y="7"></rect>
                                        <line x1="12" x2="12" y1="22" y2="7"></line>
                                        <path d="M12  7H7.5a2.5  2.5  0  0  1  0-5C11  2  12  7  12  7z"></path>
                                        <path d="M12  7h4.5a2.5  2.5  0  0  0  0-5C13  2  12  7  12  7z"></path>
                                    </svg>
                                </li>
                            </ul>
                        </div>

                        <div class="col-md-4 d-flex justify-content-end">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="w-6 h-6 bg-[#7289da] text-white rounded-full p-1">
                                <circle cx="12" cy="12" r="10"></circle>
                                <circle cx="12" cy="12" r="2"></circle>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="w-6 h-6 bg-[#1da1f2] text-white rounded-full p-1">
                                <path
                                    d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z">
                                </path>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="w-6 h-6 bg-[#e1306c] text-white rounded-full p-1">
                                <rect width="20" height="20" x="2" y="2" rx="5" ry="5">
                                </rect>
                                <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                <line x1="17.5" x2="17.51" y1="6.5" y2="6.5"></line>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="w-6 h-6 bg-[#3b5998] text-white rounded-full p-1">
                                <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="w-6 h-6 bg-[#ff0000] text-white rounded-full p-1">
                                <path
                                    d="M2.5 17a24.12 24.12 0 0 1 0-10 2 2 0 0 1 1.4-1.4 49.56 49.56 0 0 1 16.2 0A2 2 0 0 1 21.5 7a24.12 24.12 0 0 1 0 10 2 2 0 0 1-1.4 1.4 49.55 49.55 0 0 1-16.2 0A2 2 0 0 1 2.5 17">
                                </path>
                                <path d="m10 15 5-3-5-3z"></path>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="w-6 h-6 bg-[#6441a5] text-white rounded-full p-1">
                                <path d="M21 2H3v16h5v4l4-4h5l4-4V2zm-10 9V7m5 4V7"></path>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="w-6 h-6 bg-[#ff4500] text-white rounded-full p-1">
                                <polyline points="7 17 2 12 7 7"></polyline>
                                <polyline points="12 17 7 12 12 7"></polyline>
                                <path d="M22 18v-2a4 4 0 0 0-4-4H7"></path>
                            </svg>

                        </div>
                    </div>

                    <div class="row gx-5 border-top border-secondary pt-3 mt-3">
                        <div class="col-6">
                            <p class="small mb-0">{{ __('authTemplate.copyright') }}</p>
                        </div>
                        <div class="col-6 d-flex justify-content-end">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                <path d="m5 8 6 6"></path>
                                <path d="m4 14 6-6 2-3"></path>
                                <path d="M2 5h12"></path>
                                <path d="M7 2h1"></path>
                                <path d="m22 22-5-10-5 10"></path>
                                <path d="M14 18h6"></path>
                            </svg>
                            <div class="d-flex justify-content-between align-items-center mb-4 text-white">
                                <form action="{{ route('language.change') }}" method="POST">
                                    @csrf
                                    <select name="language" onchange="this.form.submit()">
                                        <option value="en"
                                            {{ session('language') === 'en' || Cookie::get('language') === 'en' ? 'selected' : '' }}>
                                            <span class="fi fi-gb"></span> English
                                        </option>
                                        <option value="es"
                                            {{ session('language') === 'es' || Cookie::get('language') === 'es' ? 'selected' : '' }}>
                                            <span class="fi fi-es"></span> Español
                                        </option>
                                    </select>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </footer>
    </div>

    <!-- Se ha intentado enlazar un js con mix no se que y no he podido-->
    <script src="{{ asset('js/showWishlist.js') }}"></script>
    <script src="{{ asset('js/showDeletedProducts.js') }}"></script>
</body>

</html>
