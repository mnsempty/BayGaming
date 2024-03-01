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
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('profile_settings.close') }}"></button>
            </div>
        @endif

        @if (session('errors'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('errors')->first('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('profile_settings.close') }}"></button>
            </div>
        @endif
        <div class="container-fluid px-0">
            <div class="row">
                {{-- LEFT SIDEBAR --}}
                {{-- todo modificar top-0 por h de navbar --}}
                <div class="col-12 col-md-4 col-xl-3 col-xxl-3 mb-3 position-sticky top-0 z-index-1000 d-md-block altura">
                    <div class="card">
                        <div class="card-header bg-transparent">
                            <h5 class="card-title mb-0 h4">{{ __('profile_settings.profile_settings') }}</h5>
                        </div>
                        <div class="list-group list-group-flush fw-normal" role="tablist">
                            <a class="list-group-item list-group-item-action" href="#accountSection" role="tab"
                                aria-selected="true">
                                <i class="bi bi-person"></i> {{ __('profile_settings.account') }}
                            </a>
                            <a class="list-group-item list-group-item-action" href="#passwordSection" role="tab"
                                aria-selected="false" tabindex="-1">
                                <i class="bi bi-shield-lock"></i> {{ __('profile_settings.password') }}
                            </a>
                            <a class="list-group-item list-group-item-action" href="#addressesSection" role="tab"
                                aria-selected="false" tabindex="-1">
                                <i class="bi bi-truck"></i> {{ __('profile_settings.addresses') }}
                            </a>
                            <a id="order-section" class="list-group-item list-group-item-action" role="tab"
                                aria-selected="false" tabindex="-1">
                                <i class="bi bi-box-seam"></i> {{ __('profile_settings.orders') }}
                            </a>
                            <a id="delete-account" class="list-group-item list-group-item-action fw-medium text-danger "
                                href="#deleteSection" role="tab" aria-selected="false" tabindex="-1">
                                <i class="bi bi-trash"></i> {{ __('profile_settings.delete_account') }}
                            </a>
                        </div>

                    </div>
                </div>
                <div class="col-12 col-md-8 col-xl-8 col-xxl-9">
                    <div id="accountSection" class="card rounded-12 shadow-dark-80 border border-gray-50 mb-3 mb-xl-5">
                        <div class="d-flex align-items-center px-3 px-md-4 py-3 border-bottom border-gray-200">
                            <h5 class="card-header-title my-2 ps-md-3 font-weight-semibold">{{ __('profile_settings.account_data') }}</h5>
                        </div>
                        {{-- user data --}}
                        <div class="card-body px-0 p-md-4">
                            <form class="px-3 form-style-two" action="{{ route('dataProfile.update') }}" method="post">
                                @csrf
                                @method('POST')
                                <div class="row">
                                    <div class="col-sm-6 mb-md-4 pb-3">
                                        <label for="editName" class="form-label form-label-lg">{{ __('profile_settings.user_name') }}</label>
                                        <input type="text" class="form-control form-control-xl" id="editName"
                                            value="{{ $user->name }}" name="name" placeholder="{{ __('profile_settings.user_name_placeholder') }}">
                                    </div>
                                    <div class="col-sm-6 mb-md-4 pb-3">
                                        <label for="editReal_name" class="form-label form-label-lg">{{ __('profile_settings.name') }}</label>
                                        <input type="text" class="form-control form-control-xl" id="editReal_name"
                                            name="real_name" value="{{ $user->real_name }}" placeholder="{{ __('profile_settings.name_placeholder') }}">
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 pb-3">
                                            <label for="editSurname" class="form-label form-label-lg">{{ __('profile_settings.surname') }}</label>
                                            <input type="text" class="form-control form-control-xl" id="editSurname"
                                                name="surname" value="{{ $user->surname }}" placeholder="{{ __('profile_settings.surname_placeholder') }}">
                                        </div>
                                        <div class="col-sm-6 pb-3">
                                            <label for="editEmail" class="form-label form-label-lg">{{ __('profile_settings.email') }}</label>
                                            <input type="text" class="form-control form-control-xl" id="editEmail"
                                                name="email" value="{{ $user->email }}" placeholder="{{ __('profile_settings.email_placeholder') }}">
                                        </div>
                                    </div>
                                    <div class="text-end pb-md-3">
                                        <button type="submit" class="btn btn-md btn-primary px-md-4 mt-lg-3">{{ __('profile_settings.save') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    {{-- change pass data --}}
                    <div id="passwordSection" class="card rounded-12 shadow-dark-80 border border-gray-50 mb-3 mb-xl-5">
                        <div class="d-flex align-items-center px-3 px-md-4 py-3 border-bottom border-gray-200">
                            <h5 class="card-header-title my-2 ps-md-3 font-weight-semibold">{{ __('profile_settings.change_password') }}</h5>
                        </div>
                        <div class="card-body px-0 p-md-4">
                            <form class="px-3 form-style-two" action="{{ route('PasswordProfile.update') }}"
                                method="post">
                                @csrf
                                @method('POST')
                                <div class="mb-md-4 pb-3">
                                    <label for="Password" class="form-label form-label-lg">{{ __('profile_settings.new_password') }}</label>
                                    <input type="password" class="form-control form-control-xl" id="Password"
                                        name="password" placeholder="{{ __('profile_settings.enter_new_password') }}">
                                </div>
                                <div class="mb-2 mb-md-4 pb-2">
                                    <label for="NewPassword" class="form-label form-label-lg">{{ __('profile_settings.confirm_password') }}</label>
                                    <input type="password" class="form-control form-control-xl" id="NewPassword"
                                        name="password_confirmation" placeholder="{{ __('profile_settings.confirm_new_password') }}">
                                </div>

                                <div class="mb-2 mb-md-4">
                                    <h6 class="font-weight-semibold open-sans-font">{{ __('profile_settings.password_requirements') }}</h6>
                                    <ul>
                                        <li>{{ __('profile_settings.minimum_8_characters') }}</li>
                                        <li>{{ __('profile_settings.one_uppercase_letter') }}</li>
                                        <li>{{ __('profile_settings.at_least_one_number') }}</li>
                                    </ul>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary px-md-4">{{ __('profile_settings.change_password') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    {{-- address --}}
                    <div id="addressesSection" class="card rounded-12 shadow-dark-80 border border-gray-50 mb-3 mb-xl-5">
                        <div class="d-flex align-items-center px-3 px-md-4 py-3 border-bottom border-gray-200">
                            <h5 class="card-header-title my-2 ps-md-3 font-weight-semibold">{{ __('profile_settings.addresses') }}</h5>
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
                                                    <strong>{{ __('profile_settings.address') }}: </strong> {{ $address->address }}<br>
                                                @endif
                                                @if ($address->secondary_address)
                                                    <strong>{{ __('profile_settings.secondary_address') }}: </strong>
                                                    {{ $address->secondary_address }}<br>
                                                @endif
                                                <strong>{{ __('profile_settings.zip_code') }}: </strong> {{ $address->zip }}<br>
                                                <strong>{{ __('profile_settings.country') }}: </strong> {{ $address->country }}<br>
                                                @if ($address->telephone_number)
                                                    <strong>{{ __('profile_settings.telephone_number') }}: </strong> {{ $address->telephone_number }}
                                                @endif
                                            </p>
                                            <div class="d-flex justify-content-center w-100">
                                                <a type="button"
                                                    class="btn btn-secondary border-right border-gray-300 me-2"
                                                    data-bs-toggle="modal" data-bs-target="#editAddressModal"
                                                    onclick="loadAddressData({{ $address->id }})">
                                                    <i class="bi bi-pencil"></i> {{ __('profile_settings.edit') }}
                                                </a>
                                                {{-- addressConfiguration.delete --}}
                                                <a class="btn btn-danger"
                                                    href="{{ route('addressConfiguration.delete', ['addressId' => $address->id]) }}">
                                                    <i class="bi bi-trash"></i> {{ __('profile_settings.delete') }}
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
                            <h5 class="card-header-title my-2 ps-md-3 font-weight-semibold">{{ __('profile_settings.delete_account') }}</h5>
                        </div>
                        <div class="card-body px-0 px-md-4 py-0">
                            <div class="px-3">
                                <div class="media py-2 py-md-4">
                                    <div class="media-body my-2 w-100">
                        <div class="row align-items-center">
                            <div class="col">
                                <span class="fs-16">{{ __('profile_settings.remove_account_completely') }}</span>
                                <span class="d-block small text-gray-600 mt-2">{{ __('profile_settings.this_will_delete_account_and_all_data') }}</span>
                            </div>
                            <div class="col-auto mt-3 mb-md-3">
                                <a href="#0" class="btn btn-danger">{{ __('profile_settings.delete_account') }}</a>
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
                <h5 class="modal-title" id="createAddressModalLabel">{{ __('profile_settings.add_new_address') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="{{ __('profile_settings.close') }}"></button>
            </div>
            {{-- Configuration --}}
            <form action="{{ route('addressProfile.create') }}" method="post">
                @csrf
                @method('post')
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label for="firstName" class="form-label">{{ __('profile_settings.first_name') }}</label>
                            <input type="text" class="form-control" id="firstName" placeholder=""
                                name="firstName" required>
                            <div class="invalid-feedback">
                                {{ __('profile_settings.valid_first_name_required') }}
                            </div>
                        </div>


                        <div class="col-sm-6">
                            <label for="lastName" class="form-label">{{ __('profile_settings.last_name') }}</label>
                            <input type="text" class="form-control" id="lastName" placeholder=""
                                name="lastName" required>
                            <div class="invalid-feedback">
                                {{ __('profile_settings.valid_last_name_required') }}
                            </div>
                        </div>


                        <div class="col-12">
                            <label for="telephone_number" class="form-label">{{ __('profile_settings.phone') }} <span
                                    class="text-body-secondary">({{ __('profile_settings.optional') }})</span></label>
                            <input type="number" class="form-control" id="telephone_number"
                                placeholder="472410399" name="telephone_number">
                            <div class="invalid-feedback">
                                {{ __('profile_settings.enter_valid_phone_number') }}
                            </div>
                        </div>


                        <div class="col-12">
                            <label for="address" class="form-label">{{ __('profile_settings.address') }}</label>
                            <input type="text" class="form-control" id="address"
                                placeholder="1234 Main St" name="address" required>
                            <div class="invalid-feedback">
                                {{ __('profile_settings.enter_shipping_address') }}
                            </div>
                        </div>


                        <div class="col-12">
                            <label for="secondary_address" class="form-label">{{ __('profile_settings.secondary_address') }}<span
                                class="text-body-secondary">({{ __('profile_settings.optional') }})</span></label>
                            <input type="text" class="form-control" id="secondary_address"
                                placeholder="Apartment or suite" name="secondary_address">
                        </div>


                        <div class="col-md-5">
                            <label for="country" class="form-label">{{ __('profile_settings.country') }}</label>
                            <select class="form-select" id="country" name="country" required>
                                <option value="">{{ __('profile_settings.choose') }}...</option>
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
                                lands</option>
                                <option>Turkey</option>
                            </select>
                            <div class="invalid-feedback">
                                {{ __('profile_settings.choose_valid_country') }}
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label for="zip" class="form-label">{{ __('profile_settings.zip_code') }}</label>
                            <input type="text" class="form-control" id="zip" name="zip"
                                required>
                            <div class="invalid-feedback">
                                {{ __('profile_settings.zip_code_required') }}
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <a class="btn btn-secondary" data-bs-dismiss="modal">{{ __('profile_settings.close') }}</a>
                    <!-- Campos del formulario para la nueva dirección -->
                    <button type="submit" class="btn btn-primary">{{ __('profile_settings.save_addresses') }}</button>
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
                <h5 class="modal-title" id="editAddressModalLabel">{{ __('profile_settings.edit_address') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="{{ __('profile_settings.close') }}"></button>
            </div>
            <div class="modal-body">
                <form id="editAddressForm" method="post">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="editAddress" class="form-label">{{ __('profile_settings.address') }}</label>
                        <input type="text" class="form-control" id="editAddress" name="address" required>
                    </div>
                    <div class="mb-3">
                        <label for="editSecondaryAddress" class="form-label">{{ __('profile_settings.secondary_address') }}</label>
                        <input type="text" class="form-control" id="editSecondaryAddress"
                            name="secondary_address">
                    </div>
                    <div class="mb-3">
                        <label for="editTelephoneNumber" class="form-label">{{ __('profile_settings.telephone_number') }}</label>
                        <input type="text" class="form-control" id="editTelephoneNumber"
                            name="telephone_number">
                    </div>
                    <div class="mb-3">
                        <label for="editCountry" class="form-label">{{ __('profile_settings.country') }}</label>
                        <select class="form-select" id="editCountry" name="country" required>
                            <option value="">{{ __('profile_settings.choose') }}...</option>
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
                        <label for="editZip" class="form-label">{{ __('profile_settings.zip_code') }}</label>
                        <input type="text" class="form-control" id="editZip" name="zip" required>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('profile_settings.cancel') }}</button>
                <button type="submit" class="btn btn-primary" form="editAddressForm">{{ __('profile_settings.save_changes') }}</button>
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