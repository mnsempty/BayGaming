@extends('auth.template')
@section('content')
    {{-- errors --}}
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
    <!-- Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Editar Perfil</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editProfileForm" method="post">
                    @csrf
                    @method('post')
                    <div class="modal-body">
                        <input type="text" id="editName" name="name" class="form-control" placeholder="Nombre">
                        <input type="text" id="editReal_name" name="real_name" class="form-control" placeholder="Nombre Real">
                        <input type="text" id="editSurname" name="surname" class="form-control" placeholder="Apellido">
                        <input type="email" id="editEmail" name="email" class="form-control" placeholder="Email">
                        <input type="password" name="password" class="form-control" placeholder="Contraseña">
                        <input type="password" name="password_confirmation" class="form-control"
                            placeholder="Confirmar Contraseña">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Botón para abrir el modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal"  onclick="loadUserData()">
        Editar Perfil
    </button>
    {{-- todo  <script src="{{ asset('js/showWishlist.js') }}"></script> --}}
    <script defer>
            // Función para cargar los datos del usuario en el modal
            function loadUserData() {
                // Realiza una solicitud AJAX para obtener los datos del usuario
                fetch('/userProfile')
                    .then(response => response.json())
                    .then(data => {
                        // Llena los campos del formulario en el modal con los datos del usuario
                        document.getElementById('editProfileForm').action = '/editProfile';
                        document.getElementById('editName').value = data.name;
                        document.getElementById('editReal_name').value = data.real_name;
                        document.getElementById('editSurname').value = data.surname;
                        document.getElementById('editEmail').value = data.email;
                    })
                    .catch(error => {
                        console.error('Error al cargar los datos del usuario:', error);
                    });
            }

    </script>
@endsection
