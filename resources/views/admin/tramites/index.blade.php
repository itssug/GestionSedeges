@extends('adminlte::page')

@section('title', 'Listado de Trámites')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0 ">Listado de Trámites</h1>
        <div>
            <a href="{{ route('tramites.create') }}" class="btn btn-primary me-2">
                <i class="bi bi-plus-circle me-1"></i> Nuevo Trámite
            </a>
            {{-- <a href="{{ route('tramites.pdf') }}" class="btn btn-dark" target="_blank">
                <i class="bi bi-file-earmark-pdf-fill me-1"></i> Reporte Trámites
            </a> --}}

            {{-- <a href="{{ route('tramites.activos.pdf') }}" class="btn btn-dark" target="_blank">
                <i class="bi bi-file-earmark-pdf-fill me-1"></i> Reporte Trámites Activos
            </a>

            <a href="{{ route('tramites.inactivos.pdf') }}" class="btn btn-dark" target="_blank">
                <i class="bi bi-file-earmark-pdf-fill me-1"></i> Reporte Trámites Inactivos
            </a> --}}
        </div>
    </div>
@stop

@section('content')
    <hr>

    <div class="row-3">
        <form action="{{ route('tramites.index') }}" method="GET" class="mb-4" id="formFiltrosTramites">
            <div class="row">
                <div class="col-md-3">
                    <label>Nombre:</label>
                    <input type="text" name="nombre" class="form-control" placeholder="Ej. Trámite de solicitud" value="{{ request('nombre') }}">
                </div>

                <div class="col-md-3">
                    <label>Descripción:</label>
                    <input type="text" name="descripcion" class="form-control" placeholder="Ej. Descripción del trámite" value="{{ request('descripcion') }}">
                </div>

                <div class="col-md-3">
                    <label>Tipo:</label>
                    <select name="tipo" class="form-control">
                        <option value="" {{ request('tipo') === null ? 'selected' : '' }}>Todos</option>
                        <option value="legal" {{ request('tipo') === 'legal' ? 'selected' : '' }}>Legal</option>
                        <option value="administrativo" {{ request('tipo') === 'administrativo' ? 'selected' : '' }}>Administrativo</option>
                        <option value="judicial" {{ request('tipo') === 'judicial' ? 'selected' : '' }}>Judicial</option>
                         <option value="medico" {{ request('tipo') === 'medico' ? 'selected' : '' }}>Medico</option>
                    </select>
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

                    <a href="{{ route('tramites.index') }}" class="btn btn-secondary">
                <i class="fas fa-broom"></i> Limpiar
            </a>

                    <button type="submit" class="btn btn-danger" formaction="{{ route('tramites.filtrar.pdf') }}" formtarget="_blank">
                        <i class="bi bi-file-earmark-pdf-fill"></i> PDF
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- Tabla de trámites ACTIVOS --}}
    <div class="card shadow mb-4">
        <div class="card-header bg-teal text-white fw-bold">
            Trámites Activos
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle table-bordered table-striped" id="tablaActivos">
                    <thead class="table-light text-center">
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Tipo</th>
                            <th>Institución</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tramites->where('estado', true) as $tramite)
                            <tr class="text-center">
                                <td>{{ $tramite->id }}</td>
                                <td>{{ $tramite->nombre }}</td>
                                <td>{{ $tramite->descripcion }}</td>
                                <td>{{ ucfirst($tramite->tipo) }}</td>
                                <td>{{ $tramite->institucion }}</td>
                                <td>
                                    <form action="{{ route('tramites.destroy', $tramite->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-success" title="Cambiar estado">Activado</button>
                                    </form>
                                </td>
                                <td>
                                    <a href="{{ route('tramites.edit', $tramite) }}" class="btn btn-outline-warning" title="Editar">
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

    {{-- Tabla de trámites INACTIVOS --}}
    <div class="card shadow">
        <div class="card-header bg-gray text-white fw-bold">
            Trámites Inactivos
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle table-bordered table-striped" id="tablaInactivos">
                    <thead class="table-light text-center">
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Tipo</th>
                            <th>Institución</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tramites->where('estado', false) as $tramite)
                            <tr class="text-center">
                                <td>{{ $tramite->id }}</td>
                                <td>{{ $tramite->nombre }}</td>
                                <td>{{ $tramite->descripcion }}</td>
                                <td>{{ ucfirst($tramite->tipo) }}</td>
                                <td>{{ $tramite->institucion }}</td>
                                <td>
                                    <form action="{{ route('tramites.destroy', $tramite->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Cambiar estado">Desactivado</button>
                                    </form>
                                </td>
                                <td>
                                    <a href="{{ route('tramites.edit', $tramite) }}" class="btn btn-outline-warning" title="Editar">
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

            // Solo si tienes botón con id btnPdf
            const btnPdf = document.getElementById('btnPdf');
            if (btnPdf) {
                btnPdf.addEventListener('click', function() {
                    const form = document.getElementById('formFiltrosTramites');
                    const params = new URLSearchParams(new FormData(form)).toString();
                    const urlPdf = "{{ route('tramites.filtrar.pdf') }}" + '?' + params;
                    window.open(urlPdf, '_blank');
                });
            }

            @if (session('success'))
                Swal.fire({
                    title: '¡Éxito!',
                    text: @json(session('success')),
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
                    text: @json(session('error')),
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
        });
    </script>
@stop
