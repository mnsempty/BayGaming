@extends('auth.template')

@section('content')
    <style>
        a.list-group-item-action.active {
            background-color: var(--bs-primary);
            color: var(--bs-white);
        }

        .altura {
            height: 25%;
        }

        #delete-account.active {
            background-color: var(--bs-danger);
            color: var(--bs-white) !important;
            border-top-color: var(--bs-danger);
        }
    </style>
    <div class="p-3 p-5 ">
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
        <div class="container-fluid px-0">
            <div class="row">
                {{-- LEFT SIDEBAR --}}
                {{-- todo modificar top-0 por h de navbar  --}}
                <div class="col-12 col-md-4 col-xl-3 col-xxl-3 mb-3 position-sticky top-0 z-index-1000 d-md-block altura">
                    <div class="card">
                        <div class="card-header bg-transparent">
                            <h5 class="card-title mb-0 h4">Profile Settings</h5>
                        </div>
                        <div class="list-group list-group-flush fw-normal" role="tablist">
                            <a class="list-group-item list-group-item-action" href="#accountSection" role="tab"
                                aria-selected="true">
                                <i class="bi bi-person"></i> Account
                            </a>
                            <a class="list-group-item list-group-item-action" href="#passwordSection" role="tab"
                                aria-selected="false" tabindex="-1">
                                <i class="bi bi-shield-lock"></i> Password
                            </a>
                            <a class="list-group-item list-group-item-action" href="#addressesSection" role="tab"
                                aria-selected="false" tabindex="-1">
                                <i class="bi bi-truck"></i> Addresses
                            </a>
                            <a id="order-section" class="list-group-item list-group-item-action" role="tab"
                                aria-selected="false" tabindex="-1">
                                <i class="bi bi-box-seam"></i> Orders
                            </a>
                            <a id="delete-account" class="list-group-item list-group-item-action fw-medium text-danger "
                                href="#deleteSection" role="tab" aria-selected="false" tabindex="-1">
                                <i class="bi bi-trash"></i> Delete account
                            </a>
                        </div>

                    </div>
                </div>
                <div class="col-12 col-md-8 col-xl-8 col-xxl-9">
                    <div id="accountSection" class="card rounded-12 shadow-dark-80 border border-gray-50 mb-3 mb-xl-5">
                        <div class="d-flex align-items-center px-3 px-md-4 py-3 border-bottom border-gray-200">
                            <h5 class="card-header-title my-2 ps-md-3 font-weight-semibold">Account data</h5>
                        </div>
                        {{-- user data --}}
                        <div class="card-body px-0 p-md-4">
                            <form class="px-3 form-style-two" action="{{ route('dataProfile.update') }}" method="post">
                                @csrf
                                @method('POST')
                                <div class="row">
                                    <div class="col-sm-6 mb-md-4 pb-3">
                                        <label for="editName" class="form-label form-label-lg">User Name</label>
                                        <input type="text" class="form-control form-control-xl" id="editName"
                                            value="{{ $user->name }}" name="name" placeholder="User name">
                                    </div>
                                    <div class="col-sm-6 mb-md-4 pb-3">
                                        <label for="editReal_name" class="form-label form-label-lg">Name</label>
                                        <input type="text" class="form-control form-control-xl" id="editReal_name"
                                            name="real_name" value="{{ $user->real_name }}" placeholder="Email">
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 pb-3">
                                            <label for="editSurname" class="form-label form-label-lg">surname</label>
                                            <input type="text" class="form-control form-control-xl" id="editSurname"
                                                name="surname" value="{{ $user->surname }}" placeholder="Surname">
                                        </div>
                                        <div class="col-sm-6 pb-3">
                                            <label for="editEmail" class="form-label form-label-lg">Email</label>
                                            <input type="text" class="form-control form-control-xl" id="editEmail"
                                                name="email" value="{{ $user->email }}" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="text-end pb-md-3">
                                        <button type="submit" class="btn btn-md btn-primary px-md-4 mt-lg-3">Save</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    {{-- change pass data --}}
                    <div id="passwordSection" class="card rounded-12 shadow-dark-80 border border-gray-50 mb-3 mb-xl-5">
                        <div class="d-flex align-items-center px-3 px-md-4 py-3 border-bottom border-gray-200">
                            <h5 class="card-header-title my-2 ps-md-3 font-weight-semibold">Change password</h5>
                        </div>
                        <div class="card-body px-0 p-md-4">
                            <form class="px-3 form-style-two" action="{{ route('PasswordProfile.update') }}"
                                method="post">
                                @csrf
                                @method('POST')
                                <div class="mb-md-4 pb-3">
                                    <label for="Password" class="form-label form-label-lg">New password</label>
                                    <input type="password" class="form-control form-control-xl" id="Password"
                                        name="password" placeholder="Enter your new password">
                                </div>
                                <div class="mb-2 mb-md-4 pb-2">
                                    <label for="NewPassword" class="form-label form-label-lg">Confirm password</label>
                                    <input type="password" class="form-control form-control-xl" id="NewPassword"
                                        name="password_confirmation" placeholder="Confirm new password">
                                </div>

                                <div class="mb-2 mb-md-4">
                                    <h6 class="font-weight-semibold open-sans-font">Password requirements</h6>
                                    <ul>
                                        <li>Minimum 8 characters or longer</li>
                                        <li>One uppercase letter</li>
                                        <li>At least one number</li>
                                    </ul>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary px-md-4">Change password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    {{-- address --}}
                    <div id="addressesSection" class="card rounded-12 shadow-dark-80 border border-gray-50 mb-3 mb-xl-5">
                        <div class="d-flex align-items-center px-3 px-md-4 py-3 border-bottom border-gray-200">
                            <h5 class="card-header-title my-2 ps-md-3 font-weight-semibold">Adresses</h5>
                            <button type="button" class="btn btn-primary rounded-circle ms-4" data-bs-toggle="modal"
                                data-bs-target="#createAddressModal">
                                <i class="bi bi-plus-lg"></i>
                            </button>
                        </div>
                        <div class="card-body d-flex flex-column flex-xl-row justify-content-evenly px-0 p-md-4 gap-3">
                            @foreach ($addresses as $address)
                                <div class="card w-xl-25 mb-xl-0 mb-4 mx-xl-0 mx-2" id="address-{{ $address->id }}">
                                    <div class="card-body d-flex flex-column justify-content-between">
                                        <div class="card-body d-flex flex-column justify-content-between">
                                            <p class="card-text">
                                                @if ($address->address)
                                                    <strong>Dirección: </strong> {{ $address->address }}<br>
                                                @endif
                                                @if ($address->secondary_address)
                                                    <strong>Dirección Secundaria: </strong>
                                                    {{ $address->secondary_address }}<br>
                                                @endif
                                                <strong>Código Postal: </strong> {{ $address->zip }}<br>
                                                <strong>País: </strong> {{ $address->country }}<br>
                                                @if ($address->telephone_number)
                                                    <strong>Número de Teléfono: </strong> {{ $address->telephone_number }}
                                                @endif
                                            </p>
                                            <div class="d-flex justify-content-center w-100">
                                                <a type="button"
                                                    class="btn btn-secondary border-right border-gray-300 me-2"
                                                    data-bs-toggle="modal" data-bs-target="#editAddressModal"
                                                    onclick="loadAddressData({{ $address->id }})">
                                                    <i class="bi bi-pencil"></i> Editar
                                                </a>
                                                {{-- addressConfiguration.delete --}}
                                                <a class="btn btn-danger"
                                                    href="{{ route('addressConfiguration.delete', ['addressId' => $address->id]) }}">
                                                    <i class="bi bi-trash"></i> Eliminar
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{ $addresses->links() }}
                    </div>
                    {{-- delete account --}}
                    <div id="deleteSection" class="card rounded-12 shadow-dark-80 border border-gray-50 mb-3 pb-3">
                        <div class="d-flex align-items-center px-3 px-md-4 py-3 border-bottom border-gray-200">
                            <h5 class="card-header-title my-2 ps-md-3 font-weight-semibold">Delete Account</h5>
                        </div>
                        <div class="card-body px-0 px-md-4 py-0">
                            <div class="px-3">
                                <div class="media py-2 py-md-4">
                                    <div class="media-body my-2 w-100">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <span class="fs-16">Remove account completely</span>
                                                <span class="d-block small text-gray-600 mt-2">This will delete your
                                                    account and all its data</span>
                                            </div>
                                            <div class="col-auto mt-3 mb-md-3">
                                                <a href="#0" class="btn btn-danger">Delete Account</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal crear direcciones -->
            <div class="modal fade" id="createAddressModal" tabindex="-1" aria-labelledby="createAddressModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="createAddressModalLabel">Add New Address</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        {{-- Configuration --}}
                        <form action="{{ route('addressProfile.create') }}" method="post">
                            @csrf
                            @method('post')
                            <div class="modal-body">
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <label for="firstName" class="form-label">First name</label>
                                        <input type="text" class="form-control" id="firstName" placeholder=""
                                            name="firstName" required>
                                        <div class="invalid-feedback">
                                            Valid first name is required.
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <label for="lastName" class="form-label">Last name</label>
                                        <input type="text" class="form-control" id="lastName" placeholder=""
                                            name="lastName" required>
                                        <div class="invalid-feedback">
                                            Valid last name is required.
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="telephone_number" class="form-label">Phone <span
                                                class="text-body-secondary">(Optional)</span></label>
                                        <input type="number" class="form-control" id="telephone_number"
                                            placeholder="472410399" name="telephone_number">
                                        <div class="invalid-feedback">
                                            Please enter a valid phone number.
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="address"
                                            placeholder="1234 Main St" name="address" required>
                                        <div class="invalid-feedback">
                                            Please enter your shipping address.
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label for="secondary_address" class="form-label">Address<span
                                                class="text-body-secondary">(Optional)</span></label>
                                        <input type="text" class="form-control" id="secondary_address"
                                            placeholder="Apartment or suite" name="secondary_address">
                                    </div>

                                    <div class="col-md-5">
                                        <label for="country" class="form-label">Country</label>
                                        <select class="form-select" id="country" name="country" required>
                                            <option value="">Choose...</option>
                                            <option>United States</option>
                                            <option>China</option>
                                            <option>India</option>
                                            <option>Japan</option>
                                            <option>Germany</option>
                                            <option>United Kingdom</option>
                                            <option>Russia</option>
                                            <option>France</option>
                                            <option>Brazil</option>
                                            <option>Italy</option>
                                            <option>Canada</option>
                                            <option>South Korea</option>
                                            <option>Australia</option>
                                            <option>Spain</option>
                                            <option>Mexico</option>
                                            <option>Indonesia</option>
                                            <option>Netherlands</option>
                                            <option>Saudi Arabia</option>
                                            <option>Turkey</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Please select a valid country.
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="zip" class="form-label">Zip</label>
                                        <input type="text" class="form-control" id="zip" name="zip"
                                            required>
                                        <div class="invalid-feedback">
                                            Zip code required.
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <a class="btn btn-secondary" data-bs-dismiss="modal">Close</a>
                                <!-- Campos del formulario para la nueva dirección -->
                                <button type="submit" class="btn btn-primary">Guardar direcciones</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Modal editar direcciones -->
            <div class="modal fade" id="editAddressModal" tabindex="-1" aria-labelledby="editAddressModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editAddressModalLabel">Editar Dirección</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editAddressForm" method="post">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="editAddress" class="form-label">Dirección</label>
                                    <input type="text" class="form-control" id="editAddress" name="address" required>
                                </div>
                                <div class="mb-3">
                                    <label for="editSecondaryAddress" class="form-label">Dirección Secundaria</label>
                                    <input type="text" class="form-control" id="editSecondaryAddress"
                                        name="secondary_address">
                                </div>
                                <div class="mb-3">
                                    <label for="editTelephoneNumber" class="form-label">Teléfono</label>
                                    <input type="text" class="form-control" id="editTelephoneNumber"
                                        name="telephone_number">
                                </div>
                                <div class="mb-3">
                                    <label for="country" class="form-label">Country</label>
                                    <select class="form-select" id="editCountry" name="country" required>
                                        <option value="">Choose...</option>
                                        <option value="United States">United States</option>
                                        <option value="China">China</option>
                                        <option value="India">India</option>
                                        <option value="Japan">Japan</option>
                                        <option value="Germany">Germany</option>
                                        <option value="United Kingdom">United Kingdom</option>
                                        <option value="Russia">Russia</option>
                                        <option value="France">France</option>
                                        <option value="Brazil">Brazil</option>
                                        <option value="Italy">Italy</option>
                                        <option value="Canada">Canada</option>
                                        <option value="South Korea">South Korea</option>
                                        <option value="Australia">Australia</option>
                                        <option value="Spain">Spain</option>
                                        <option value="Mexico">Mexico</option>
                                        <option value="Indonesia">Indonesia</option>
                                        <option value="Netherlands">Netherlands</option>
                                        <option value="Saudi Arabia">Saudi Arabia</option>
                                        <option value="Turkey">Turkey</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="editZip" class="form-label">Código Postal</label>
                                    <input type="text" class="form-control" id="editZip" name="zip" required>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary" form="editAddressForm">Guardar
                                Cambios</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script defer>
        // Selecciona todos los enlaces con la clase 'list-group-item-action'
        let links = document.querySelectorAll('a.list-group-item-action');

        function handleClick(event) {
            event.preventDefault(); // Evita el comportamiento predeterminado del enlace

            // Elimina la clase 'active' de todos los enlaces
            links.forEach(function(link) {
                link.classList.remove('active');
            });

            // Agrega la clase 'active' al enlace clickeado
            event.target.classList.add('active');

            // Verifica si el enlace clickeado es el enlace específico con ID 'order-section'
            if (event.target.id === 'order-section') {
                // Redirige a '/myOrders'
                window.location.href = '/myOrders';
            } else {
                // Para otros enlaces, simplemente desplaza a la sección
                var target = event.target.getAttribute('href');
                document.querySelector(target).scrollIntoView({
                    behavior: 'smooth'
                });
            }
        }

        // Agrega el manejador de eventos de clic a todos los enlaces
        links.forEach(function(link) {
            link.addEventListener('click', handleClick);
        });
        // eliminar el sticky en movil
        
        function adjustStickyClass() {
            let sidebar = document.querySelector('.position-sticky');
            if (window.innerWidth < 768) { //  768px es el punto de interrupción para 'md' en Bootstrap
                sidebar.classList.remove('position-sticky');
            } else {
                sidebar.classList.add('position-sticky');
            }
        }

        // Ajusta la clase 'position-sticky' al cargar la página
        adjustStickyClass();

        // Ajusta la clase 'position-sticky' cada vez que cambia el tamaño de la ventana
        window.addEventListener('resize', adjustStickyClass);
    </script>
@endsection
