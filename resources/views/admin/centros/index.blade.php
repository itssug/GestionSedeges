@extends('adminlte::page')

@section('title', 'Listado de Centros')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0 ">Listado de Centros de Acogida</h1>
        <div>
            <a href="{{ route('centros.create') }}" class="btn btn-primary me-2">
                <i class="bi bi-plus-circle me-1"></i> Nuevo Centro
            </a>
            <a href="{{ route('centros.pdf') }}" class="btn btn-dark" target="_blank">
                <i class="bi bi-file-earmark-pdf-fill me-1"></i> Reporte Centros
            </a>

            <a href="{{ route('nnas.centros_activos.pdf') }}" class="btn btn-dark" target="_blank">
                <i class="bi bi-file-earmark-pdf-fill me-1"></i> Reporte centros Activos
            </a>

            <a href="{{ route('nnas.centros_inactivos.pdf') }}" class="btn btn-dark" target="_blank">
                <i class="bi bi-file-earmark-pdf-fill me-1"></i> Reporte centros Inactivos
            </a>
        </div>
    </div>
@stop

@section('content')
    <hr>

    <div class="row-3">

         <form action="{{ route('centros.filtrar') }}" method="GET" class="mb-4" id="formFiltrosCentros">
        <div class="row">
            <div class="col-md-3">
                <label>Código Centro:</label>
                <input type="text" name="cod_centro" class="form-control" placeholder="Ej. CEN001" value="{{ request('cod_centro') }}">
            </div>

            <div class="col-md-3">
                <label>Nombre Centro:</label>
                <input type="text" name="nombre_centro" class="form-control" placeholder="Ej. Centro ABC" value="{{ request('nombre_centro') }}">
            </div>

            <div class="col-md-3">
                <label>Dirección Centro:</label>
                <input type="text" name="direccion_centro" class="form-control" placeholder="Ej. Av. Siempre Viva 123" value="{{ request('direccion_centro') }}">
            </div>

            <div class="col-md-3">
                <label>Contacto:</label>
                <input type="text" name="contacto" class="form-control" placeholder="Ej. 71234567" value="{{ request('contacto') }}">
            </div>

            <div class="col-md-3">
                <label>Capacidad mínima:</label>
                <input type="number" name="capacidad_min" class="form-control" min="0" placeholder="0" value="{{ request('capacidad_min') }}">
            </div>

            <div class="col-md-3">
                <label>Capacidad máxima:</label>
                <input type="number" name="capacidad_max" class="form-control" min="0" placeholder="100" value="{{ request('capacidad_max') }}">
            </div>

            <div class="col-md-3">
                <label>Estado:</label>
                <select name="estado" class="form-control">
                    <option value="" {{ request('estado') === null ? 'selected' : '' }}>Todos</option>
                    <option value="1" {{ request('estado') === '1' ? 'selected' : '' }}>Activo</option>
                    <option value="0" {{ request('estado') === '0' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>

            <div class="col-md-3 mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter"></i> Filtrar
                </button>

                <button type="submit" class="btn btn-danger" formaction="{{ route('centros.filtrar.pdf') }}" formtarget="_blank">
                    <i class="bi bi-file-earmark-pdf-fill"></i> PDF
                </button>
            </div>
        </div>
    </form>
    <hr><!-- Reporte de Centros -->
<div class="col-md-6">
    <h5>Listado de NNAs por Centro</h5>
    <form id="formReporteCentro" method="GET" action="{{ route('centros.reporte') }}" class="row g-2 align-items-end">
        <div class="col-8">
            <label class="form-label fw-semibold">Centro</label>
            <select name="centro_id" class="form-control form-control-sm" required>
                <option value="">-- Seleccione un centro --</option>
                @foreach ($centros as $centro)
                    <option value="{{ $centro->id }}">{{ $centro->cod_centro }} - {{ $centro->nombre_centro }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-4">
            <button type="submit" class="btn btn-primary btn-sm w-100">
                <i class="fas fa-file-pdf"></i> Generar PDF
            </button>
        </div>
    </form>

    @if(isset($nnas) && count($nnas) > 0)
    <div class="card mt-2">
        <div class="card-header bg-primary text-white fw-bold py-1">
            Vista Previa - Centro: {{ $centro->cod_centro }}
        </div>
        <div class="card-body p-2">
            <div class="mb-3">
                <p class="mb-1"><strong>Nombre:</strong> {{ $centro->nombre_centro }}</p>
                <p class="mb-1"><strong>Dirección:</strong> {{ $centro->direccion_centro }}</p>
                <p class="mb-1"><strong>Contacto:</strong> {{ $centro->contacto }}</p>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover table-sm mb-0">
                    <thead>
                        <tr class="text-center">
                            <th width="5%">N°</th>
                            <th>Apellidos</th>
                            <th>Nombres</th>
                            <th width="10%">Sexo</th>
                            <th width="15%">Código NNA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($nnas as $index => $nna)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $nna->apellidos }}</td>
                            <td>{{ $nna->nombres }}</td>
                            <td class="text-center">{{ $nna->sexo }}</td>
                            <td>{{ $nna->cod_nna }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-end fw-bold">Total NNAs:</td>
                            <td class="text-center fw-bold">{{ count($nnas) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    @elseif(request()->has('centro_id'))
    <div class="alert alert-warning mt-2 mb-0">
        No se encontraron NNAs registrados en este centro.
    </div>
    @endif
</div>

<!-- Aquí iría otro reporte en col-md-6 si es necesario -->
<hr>
    </div>
    {{-- Tabla de centros ACTIVOS --}}
    <div class="card shadow mb-4">
        <div class="card-header bg-teal text-white fw-bold">
            Centros Activos
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle table-bordered table-striped" id="tablaActivos">
                    <thead class="table-light text-center">
                        <tr>
                            <th>#</th>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Dirección</th>
                            <th>Contacto</th>
                            <th>Capacidad</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($centros->where('estado', true) as $centro)
                            <tr class="text-center">
                                <td>{{ $centro->id }}</td>
                                <td>{{ $centro->cod_centro }}</td>
                                <td>{{ $centro->nombre_centro }}</td>
                                <td>{{ $centro->direccion_centro }}</td>
                                <td>{{ $centro->contacto }}</td>
                                <td>{{ $centro->capacidad }}</td>
                                <td>
                                    <form action="{{ route('centros.destroy', $centro->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-success"
                                            title="Cambiar estado">Activado</button>
                                    </form>
                                </td>
                                <td>
                                    <a href="{{ route('centros.edit', $centro) }}" class="btn btn-outline-warning"
                                        title="Editar">
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

    {{-- Tabla de centros INACTIVOS --}}
    <div class="card shadow">
        <div class="card-header bg-gray text-white fw-bold">
            Centros Inactivos
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle table-bordered table-striped" id="tablaInactivos">
                    <thead class="table-light text-center">
                        <tr>
                            <th>#</th>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Dirección</th>
                            <th>Contacto</th>
                            <th>Capacidad</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($centros->where('estado', false) as $centro)
                            <tr class="text-center">
                                <td>{{ $centro->id }}</td>
                                <td>{{ $centro->cod_centro }}</td>
                                <td>{{ $centro->nombre_centro }}</td>
                                <td>{{ $centro->direccion_centro }}</td>
                                <td>{{ $centro->contacto }}</td>
                                <td>{{ $centro->capacidad }}</td>
                                <td>
                                    <form action="{{ route('centros.destroy', $centro->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            title="Cambiar estado">Desactivado</button>
                                    </form>
                                </td>
                                <td>
                                    <a href="{{ route('centros.edit', $centro) }}" class="btn btn-outline-warning"
                                        title="Editar">
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
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#tablaActivos').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
                }
            });

            $('#tablaInactivos').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
                }
            });

            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(el => new bootstrap.Tooltip(el));
        });


         document.getElementById('btnPdf').addEventListener('click', function() {
        // Obtiene el formulario
        const form = document.getElementById('formFiltros');
        // Construye los parámetros URL con los valores actuales del formulario
        const params = new URLSearchParams(new FormData(form)).toString();
        // Construye la URL para el PDF
        const urlPdf = "{{ route('nnas.filtrar.pdf') }}" + '?' + params;
        // Abre la URL en una nueva pestaña
        window.open(urlPdf, '_blank');
    });

         @if (session('success'))
                Swal.fire({
                    title: '¡Éxito!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    background: '#f0fdf4',
                    color: '#198754',
                    iconColor: '#198754',
                    showConfirmButton: false,
                    timer: 2500,
                    customClass: {
                        popup: 'rounded-4 shadow-lg',
                        title: 'fw-bold fs-4'
                    },
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    }
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    title: '¡Error!',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    background: '#fff0f0',
                    color: '#dc3545',
                    iconColor: '#dc3545',
                    showConfirmButton: false,
                    timer: 2500,
                    customClass: {
                        popup: 'rounded-4 shadow-lg',
                        title: 'fw-bold fs-4'
                    },
                    showClass: {
                        popup: 'animate__animated animate__shakeX'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOut'
                    }
                 @endif
            });
    </script>
@stop
