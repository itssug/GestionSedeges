@extends('adminlte::page')

@section('title', 'Capacitaciones')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Listado de Capacitaciones</h1>
        <div>
            <a href="{{ route('capacitaciones.create') }}" class="btn btn-primary me-2">
                <i class="bi bi-plus-circle me-1"></i> Nueva Capacitación
            </a>
            <a href="{{ route('capacitaciones.pdf') }}" class="btn btn-dark" target="_blank">
                <i class="bi bi-file-earmark-pdf-fill me-1"></i> Reporte Capacitaciones
            </a>

            <a href="{{ route('capacitaciones.capacitaciones_activos.pdf') }}" class="btn btn-dark" target="_blank">
                <i class="bi bi-file-earmark-pdf-fill me-1"></i> Reporte capacitaciones Activos
            </a>

            <a href="{{ route('capacitaciones.capacitaciones_inactivos.pdf') }}" class="btn btn-dark" target="_blank">
                <i class="bi bi-file-earmark-pdf-fill me-1"></i> Reporte capacitaciones inactivos
            </a>
        </div>
    </div>
@stop

@section('content')
    <hr>
    <div class="row-3">
        <form action="{{ route('capacitaciones.index') }}" method="GET" id="formFiltrosCapacitaciones">

            <div class="row">
                <div class="col-md-3">
                    <label>Nombre:</label>
                    <input type="text" name="nombre" class="form-control" value="{{ request('nombre') }}">
                </div>
                <div class="col-md-3">
                    <label>Institución:</label>
                    <input type="text" name="institucion" class="form-control" value="{{ request('institucion') }}">
                </div>
                <div class="col-md-3">
                    <label>Modalidad:</label>
                    <input type="text" name="modalidad" class="form-control" value="{{ request('modalidad') }}">
                </div>
                <div class="col-md-3">
                    <label>Estado:</label>
                    <select name="estado" class="form-control">
                        <option value="">Todos</option>
                        <option value="1" {{ request('estado') === '1' ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ request('estado') === '0' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Fecha Inicio:</label>
                    <input type="date" name="fecha_inicio" class="form-control" value="{{ request('fecha_inicio') }}">
                </div>
                <div class="col-md-3">
                    <label>Fecha Fin:</label>
                    <input type="date" name="fecha_fin" class="form-control" value="{{ request('fecha_fin') }}">
                </div>
                <div class="col-md-3 mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Filtrar
                    </button>
                    <button type="button" class="btn btn-danger" id="btnPdf">
                        <i class="bi bi-file-earmark-pdf-fill"></i> PDF
                    </button>
                </div>
            </div>
        </form>
    </div>

    <hr>
    {{-- Tabla de capacitaciones ACTIVAS --}}
    <div class="card shadow mb-4">
        <div class="card-header bg-teal text-white fw-bold">Capacitaciones Activas</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle table-bordered table-striped" id="tablaActivas">
                    <thead class="table-light text-center">
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            <th>Duración</th>
                            <th>Modalidad</th>
                            <th>Institución</th>
                            <th>Dirección</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($capacitaciones->where('estado', true) as $capacitacion)
                            <tr class="text-center">
                                <td>{{ $capacitacion->id }}</td>
                                <td>{{ $capacitacion->nombre }}</td>
                                <td>{{ $capacitacion->descripcion }}</td>
                                <td>{{ $capacitacion->fecha_inicio }}</td>
                                <td>{{ $capacitacion->fecha_fin }}</td>
                                <td>{{ $capacitacion->duracion }} días</td>
                                <td>{{ $capacitacion->modalidad }}</td>
                                <td>{{ $capacitacion->institucion }}</td>
                                <td>{{ $capacitacion->direccion }}</td>
                                <td>
                                    <form action="{{ route('capacitaciones.destroy', $capacitacion->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-success"
                                            title="Cambiar estado">Activa</button>
                                    </form>
                                </td>
                                <td>
                                    {{-- <button type="button" class="btn btn-outline-info btn-sm ver-sesiones-btn"
                                        data-id="{{ $capacitacion->id }}">
                                        <i class="bi bi-journal-text"></i>
                                    </button> --}}
                                    <a href="{{ route('capacitaciones.edit', $capacitacion) }}"
                                        class="btn btn-outline-warning btn-sm" title="Editar">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Tabla de capacitaciones INACTIVAS --}}
    <div class="card shadow">
        <div class="card-header bg-gray text-white fw-bold">Capacitaciones Inactivas</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle table-bordered table-striped" id="tablaInactivas">
                    <thead class="table-light text-center">
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Fecha Inicio</th>
                            <th>Fecha Fin</th>
                            <th>Duración</th>
                            <th>Modalidad</th>
                            <th>Institución</th>
                            <th>Dirección</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($capacitaciones->where('estado', false) as $capacitacion)
                            <tr class="text-center">
                                <td>{{ $capacitacion->id }}</td>
                                <td>{{ $capacitacion->nombre }}</td>
                                <td>{{ $capacitacion->descripcion }}</td>
                                <td>{{ $capacitacion->fecha_inicio }}</td>
                                <td>{{ $capacitacion->fecha_fin }}</td>
                                <td>{{ $capacitacion->duracion }} días</td>
                                <td>{{ $capacitacion->modalidad }}</td>
                                <td>{{ $capacitacion->institucion }}</td>
                                <td>{{ $capacitacion->direccion }}</td>
                                <td>
                                    <form action="{{ route('capacitaciones.destroy', $capacitacion->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            title="Cambiar estado">Inactiva</button>
                                    </form>
                                </td>
                                <td>
                                    <a href="{{ route('capacitaciones.edit', $capacitacion) }}"
                                        class="btn btn-outline-warning" title="Editar">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal para mostrar sesiones -->
    <div class="modal fade" id="modalSesiones" tabindex="-1" aria-labelledby="modalSesionesLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-teal text-white">
                    <h5 class="modal-title" id="modalSesionesLabel">Sesiones de la Capacitación</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-striped" id="tablaSesiones">
                        <thead>
                            <tr class="text-center">
                                <th>#</th>
                                <th>Tema</th>
                                <th>Fecha</th>
                                <th>Hora Inicio</th>
                                <th>Hora Fin</th>
                                <th>Duración (min)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Aquí se cargarán las sesiones vía JS -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />


@stop

@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

{{-- Bootstrap Bundle (para modal funcional con Bootstrap 5) --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

{{-- DataTables --}}
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {
        console.log("jQuery y DataTables funcionando");

        // Inicializar DataTables
        $('#tablaActivas, #tablaInactivas').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
            },
            responsive: true,
            pageLength: 10,
        });

        // PDF con filtros
        $('#btnPdf').on('click', function () {
            const form = document.getElementById('formFiltrosCapacitaciones');
            const params = new URLSearchParams(new FormData(form)).toString();
            const urlPdf = "{{ route('capacitaciones.filtrar.pdf') }}" + '?' + params;
            window.open(urlPdf, '_blank');
        });

        // Mostrar sesiones
        $(document).on('click', '.ver-sesiones-btn', function () {
            const capacitacionId = $(this).data('id');
            const modalElement = document.getElementById('modalSesiones');
            const modal = new bootstrap.Modal(modalElement);
            $('#tablaSesiones tbody').empty();

            $.ajax({
                url: '{{ route("capacitaciones.obtenerSesiones") }}',
                method: 'GET',
                success: function (sesiones) {
                    if (sesiones.length === 0) {
                        $('#tablaSesiones tbody').append(
                            '<tr><td colspan="6" class="text-center">No hay sesiones para esta capacitación.</td></tr>'
                        );
                    } else {
                        sesiones.forEach(function (sesion, index) {
                            $('#tablaSesiones tbody').append(`
                                <tr class="text-center">
                                    <td>${index + 1}</td>
                                    <td>${sesion.tema ?? '---'}</td>
                                    <td>${sesion.fecha}</td>
                                    <td>${sesion.hora_inicio}</td>
                                    <td>${sesion.hora_fin}</td>
                                    <td>${sesion.duracion} min</td>
                                </tr>
                            `);
                        });
                    }
                    console.log(sesiones);
                    modal.show();
                },
                error: function () {
                     console.error("Error AJAX:", status, error);
                    alert('Hubo un error al cargar las sesiones.');
                }
            });
        });
           @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '{{ session('success') }}',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false,
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false,
            });
        @endif
    });
</script>
@endsection

