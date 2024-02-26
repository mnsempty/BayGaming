@extends('auth.template')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong><i class="bi bi-exclamation-triangle-fill"></i> Error:</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <!-- Botón para abrir el modal -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createDiscountModal">
        Crear Descuento
    </button>

    <div class="container">
        <h2>Descuentos</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Porcentaje</th>
                    <th>Código</th>
                    <th>Usos</th>
                    <th>Fecha de Caducidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($discounts as $discount)
                    <tr>
                        <td>{{ $discount->id }}</td>
                        <td>{{ $discount->percent }}%</td>
                        <td>{{ $discount->code }}</td>
                        <td>{{ $discount->uses }}</td>
                        <td>{{ $discount->expire_date ? \Carbon\Carbon::parse($discount->expire_date)->format('d F, Y') : 'N/A' }}
                        </td>
                        <td>
                            <!-- Botón para abrir el modal de edición -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#editDiscountModal{{ $discount->id }}">
                                Editar
                            </button>
                            <!-- Modal de edición -->
                            <div class="modal fade" id="editDiscountModal{{ $discount->id }}" tabindex="-1"
                                aria-labelledby="editDiscountModalLabel{{ $discount->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editDiscountModalLabel{{ $discount->id }}">Editar
                                                Descuento</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('discounts.update', $discount->id) }}" method="post">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label for="percent{{ $discount->id }}" class="form-label">Porcentaje
                                                        de Descuento</label>
                                                    <input type="number" class="form-control"
                                                        id="percent{{ $discount->id }}" name="percent"
                                                        value="{{ $discount->percent }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="code{{ $discount->id }}" class="form-label">Código de
                                                        Descuento</label>
                                                    <input type="text" class="form-control" id="code{{ $discount->id }}"
                                                        name="code" value="{{ $discount->code }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="uses{{ $discount->id }}" class="form-label">Usos del
                                                        Descuento</label>
                                                    <input type="number" class="form-control" id="uses{{ $discount->id }}"
                                                        name="uses" value="{{ $discount->uses }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="expire_date{{ $discount->id }}" class="form-label">Fecha de
                                                        Caducidad</label>
                                                    <input type="date" class="form-control"
                                                        id="expire_date{{ $discount->id }}" name="expire_date"
                                                        value="{{ $discount->expire_date }}">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Actualizar Descuento</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
    </div>
    <!-- Botón para eliminar el descuento -->
    <form action="{{ route('discounts.delete', $discount->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Eliminar</button>
    </form>
    </td>
    </tr>
    @endforeach
    </tbody>
    </table>
    </div>
    <div class="container">
        <h2>Descuentos Inactivos</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Porcentaje</th>
                    <th>Código</th>
                    <th>Usos</th>
                    <th>Fecha de Caducidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($inactiveDiscounts as $discount)
                    <tr>
                        <td>{{ $discount->id }}</td>
                        <td>{{ $discount->percent }}%</td>
                        <td>{{ $discount->code }}</td>
                        <td>{{ $discount->uses }}</td>
                        <td>{{ $discount->expire_date ? \Carbon\Carbon::parse($discount->expire_date)->format('d F, Y') : 'N/A' }}</td>
                        <td>
                            <!-- Botón para abrir el modal de edición -->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#editInactiveDiscountModal{{ $discount->id }}">
                                Editar
                            </button>
                            <!-- Modal de edición -->
                            <div class="modal fade" id="editInactiveDiscountModal{{ $discount->id }}" tabindex="-1"
                                aria-labelledby="editDiscountModalLabel{{ $discount->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editDiscountModalLabel{{ $discount->id }}">Editar
                                                Descuento</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('discounts.update', $discount->id) }}" method="post">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label for="percent{{ $discount->id }}" class="form-label">Porcentaje
                                                        de Descuento</label>
                                                    <input type="number" class="form-control"
                                                        id="percent{{ $discount->id }}" name="percent"
                                                        value="{{ $discount->percent }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="code{{ $discount->id }}" class="form-label">Código de
                                                        Descuento</label>
                                                    <input type="text" class="form-control"
                                                        id="code{{ $discount->id }}" name="code"
                                                        value="{{ $discount->code }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="uses{{ $discount->id }}" class="form-label">Usos del
                                                        Descuento</label>
                                                    <input type="number" class="form-control"
                                                        id="uses{{ $discount->id }}" name="uses"
                                                        value="{{ $discount->uses }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="expire_date{{ $discount->id }}" class="form-label">Fecha
                                                        de
                                                        Caducidad</label>
                                                    <input type="date" class="form-control"
                                                        id="expire_date{{ $discount->id }}" name="expire_date"
                                                        value="{{ $discount->expire_date }}">
                                                </div>
                                                <button type="submit" class="btn btn-primary">Actualizar
                                                    Descuento</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- activar descuento --}}
                            <form action="{{ route('discounts.activate', $discount->id) }}" method="POST">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-success mt-2">Activar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal create discount-->
    <div class="modal fade" id="createDiscountModal" tabindex="-1" aria-labelledby="createDiscountModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createDiscountModalLabel">Crear Descuento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('discounts.create') }}" method="post">
                        @csrf
                        @method('POST')
                        <div class="mb-3">
                            <label for="percent" class="form-label">Porcentaje de Descuento</label>
                            <input type="number" class="form-control" id="percent" name="percent"
                                placeholder="Ingrese el porcentaje de descuento" required>
                        </div>
                        <div class="mb-3">
                            <label for="code" class="form-label">Código de Descuento</label>
                            <input type="text" class="form-control" id="code" name="code"
                                placeholder="testCode01" required>
                        </div>
                        <div class="mb-3">
                            <label for="uses" class="form-label">Usos del Descuento</label>
                            <input type="number" class="form-control" id="uses" name="uses"
                                placeholder="Ingrese la cantidad de veces usado" required>
                        </div>
                        <div class="mb-3">
                            <label for="expire_date" class="form-label">Fecha de Caducidad</label>
                            <input type="date" class="form-control" id="expire_date" name="expire_date">
                        </div>
                        <button type="submit" class="btn btn-primary">Crear Descuento</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
