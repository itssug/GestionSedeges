@extends('adminlte::page')

@section('title', 'Inscripciones')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Registro de Asistencias</h1>
        <div>
            <a href="{{ route('asistencias.create') }}" class="btn btn-primary me-2" disabled>
                <i class="bi bi-plus-circle me-1"></i> Nuevo Registro
            </a>
        </div>
    </div>
@stop

@section('content')
    <hr>
    <form id="formFiltrosAsistencias" method="GET" action="{{ route('asistencias.index') }}" class="row g-3 mb-4">
        <div class="col-md-3">
            <label class="form-label fw-semibold">Desde</label>
            <input type="date" name="desde" class="form-control" value="{{ request('desde') }}">
        </div>
        <div class="col-md-3">
            <label class="form-label fw-semibold">Hasta</label>
            <input type="date" name="hasta" class="form-control" value="{{ request('hasta') }}">
        </div>
        <div class="col-md-3">
            <label class="form-label fw-semibold">Capacitación</label>
            <select name="capacitacion_id" class="form-control">
                <option value="">-- Todas --</option>
                @foreach ($capacitaciones as $capacitacion)
                    <option value="{{ $capacitacion->id }}"
                        {{ request('capacitacion_id') == $capacitacion->id ? 'selected' : '' }}>
                        {{ $capacitacion->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label fw-semibold">Adoptante</label>
            <select name="adoptante_id" class="form-control">
                <option value="">-- Todos --</option>
                @foreach ($adoptantes as $adoptante)
                    <option value="{{ $adoptante->id }}" {{ request('adoptante_id') == $adoptante->id ? 'selected' : '' }}>
                        {{ $adoptante->usuario->name }} {{ $adoptante->usuario->apellidos }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label fw-semibold">Asistencia</label>
            <select name="asistencia" class="form-control">
                <option value="">-- Todos --</option>
                <option value="1" {{ request('asistencia') === '1' ? 'selected' : '' }}>Asistió</option>
                <option value="0" {{ request('asistencia') === '0' ? 'selected' : '' }}>No asistió</option>
            </select>

        </div>

        <div class="col-md-12 mt-4 d-flex justify-content-end gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-filter"></i> Filtrar
            </button>

            <a href="{{ route('asistencias.index') }}" class="btn btn-secondary">
                <i class="fas fa-broom"></i> Limpiar
            </a>

            <button type="button" class="btn btn-danger" id="btnPdf">
                <i class="fas fa-file-pdf"></i> Generar PDF
            </button>

        </div>
    </form>
    <hr>
<hr>

<div class="row">
    <!-- Reporte 1 -->
    <div class="col-md-6">
        <h5>Lista de personas inscritas una capacitación</h5>
        <form id="formReporte1" method="GET" action="{{ route('reportes.reporte1') }}" class="row g-2 align-items-end">
            <div class="col-8">
                <label class="form-label fw-semibold">Capacitación</label>
                <select name="capacitacion_id" class="form-control form-control-sm">
                    <option value="">-- Seleccione --</option>
                    @foreach ($capacitaciones as $capacitacion)
                        <option value="{{ $capacitacion->id }}">{{ $capacitacion->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-4">
                <button type="submit" class="btn btn-info btn-sm w-100">
                    <i class="fas fa-file-alt"></i> Generar
                </button>
            </div>
        </form>

        @if(isset($reporte1))
        <div class="card mt-2">
            <div class="card-header bg-info text-white fw-bold py-1">
                Resultado Reporte 1
            </div>
            <div class="card-body p-2 table-responsive">
                <table class="table table-bordered table-striped table-hover table-sm mb-0">
                    <thead>
                        <tr class="text-center">
                            <th>Adoptante</th>
                            <th>Sesión</th>
                            <th>Asistió</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reporte1 as $item)
                        <tr>
                            <td>{{ $item->adoptante }}</td>
                            <td>{{ $item->sesion }}</td>
                            <td class="text-center">{!! $item->asistio ? '<span class="badge bg-success">Sí</span>' : '<span class="badge bg-danger">No</span>' !!}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>

    <!-- Aquí iría el Reporte 2 en col-md-6, con formato similar -->

    <div class="col-md-6">
        <!-- Ejemplo Reporte 2 -->
        <h5>capacitaciones y sesiones de un adoptante</h5>
        <form id="formReporte2" method="GET" action="{{ route('reportes.reporte2') }}" class="row g-2 align-items-end">
            <div class="col-8">
                <label class="form-label fw-semibold">Adoptante</label>
                <select name="adoptante_id" class="form-control form-control-sm">
                    <option value="">-- Seleccione --</option>
                    @foreach ($adoptantes as $adoptante)
                        <option value="{{ $adoptante->id }}">{{ $adoptante->usuario->name }} {{ $adoptante->usuario->apellidos }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-4">
                <button type="submit" class="btn btn-info btn-sm w-100">
                    <i class="fas fa-file-alt"></i> Generar
                </button>
            </div>
        </form>

        @if(isset($reporte2))
        <div class="card mt-2">
            <div class="card-header bg-info text-white fw-bold py-1">
                Resultado Reporte 2
            </div>
            <div class="card-body p-2 table-responsive">
                <!-- Aquí la tabla para reporte 2, con table-sm y sin margen extra -->
                <table class="table table-bordered table-striped table-hover table-sm mb-0">
                    <!-- Encabezados y cuerpo -->
                </table>
            </div>
        </div>
        @endif
    </div>
</div>
<hr>

    <div class="card shadow mb-4">
        <div class="card-header bg-teal text-white fw-bold">
            Lista de Asistencias
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle table-bordered table-striped" id="tablaAsistencias">
                    <thead class="table-light text-center">
                        <tr>
                            <th>#</th>
                            <th>Nombre del Adoptante</th>
                            <th>Capacitación</th>

                            <th>Sesión</th>
                            <th>Fecha de Sesión</th>
                            <th>Asistencia</th>
                            <th>Fecha de Registro</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($asistencias as $asistencia)
                            <tr class="text-center">
                                <td>{{ $asistencia->id }}</td>
                                <td>{{ $asistencia->adoptantes->usuario->name ?? 'N/A' }}
                                    {{ $asistencia->adoptantes->usuario->apellidos ?? '' }}</td>
                                <td>{{ $asistencia->sesiones->capacitacion->nombre ?? 'N/A' }}</td>

                                <td>{{ $asistencia->sesiones->tema ?? 'N/A' }}</td>
                                <td>{{ $asistencia->sesiones->fecha ?? 'N/A' }}</td>

                                <td>
                                    <form action="{{ route('asistencias.toggle', $asistencia->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('PATCH')

                                        @if ($asistencia->asistencia)
                                            <button class="btn btn-sm btn-outline-success" type="submit">
                                                <i class="fas fa-check-circle"></i> Asistio
                                            </button>
                                        @else
                                            <button class="btn btn-sm btn-outline-danger" type="submit">
                                                <i class="fas fa-times-circle"></i> No Asistió
                                            </button>
                                        @endif
                                    </form>
                                </td>
                                <td>{{ $asistencia->created_at }}</td>
                                <td>
                                    <form action="{{ route('asistencias.destroy', $asistencia) }}" method="POST"
                                        class="form-eliminar" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger" title="Eliminar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
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
            $('#tablaAsistencias').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
                }
            });

            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(el => new bootstrap.Tooltip(el));
        });

          document.getElementById('btnPdf').addEventListener('click', function() {
        const form = document.getElementById('formFiltrosAsistencias');
        const params = new URLSearchParams(new FormData(form)).toString();
        const urlPdf = "{{ route('asistencias.pdf') }}" + '?' + params;
        window.open(urlPdf, '_blank');
    });

        document.querySelectorAll('.form-eliminar').forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault();

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
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
            });
        @endif
    </script>
@stop
