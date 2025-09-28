@extends('adminlte::page')

@section('title', 'Evaluaciones Psicológicas')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Evaluaciones Psicológicas a Niñez y Adolescencia</h1>
        <div>
            <a href="{{ route('evaluacionesPsi.create') }}" class="btn btn-primary me-2">
                <i class="bi bi-plus-circle me-1"></i> Nuevo Registro
            </a>
            {{-- <a href="{{ route('evaluacionesPsi.pdf') }}" class="btn btn-dark" target="_blank">
                <i class="bi bi-file-earmark-pdf-fill me-1"></i> Reporte Evaluaciones
            </a> --}}
        </div>
    </div>
@stop

@section('content')
    <hr>

    {{-- Tabla de evaluaciones VIGENTES --}}
    <div class="card shadow mb-4">
        <div class="card-header bg-teal text-white fw-bold">
            Evaluaciones Vigentes
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle table-bordered table-striped" id="tablaVigentes">
                    <thead class="table-light text-center">
                        <tr>
                            <th>#</th>
                            <th>Código NNA</th>
                            <th>Nombre completo</th>
                            <th>Evaluador</th>
                            <th>Diagnóstico</th>
                            <th>Recomendaciones</th>
                            <th>Observaciones</th>
                            <th>Fecha de evaluacion</th>
                            <th>Estado</th>
                            <th>Documento</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($evaluaciones->where('documentoNna.estado', true) as $evaluacion)
                            <tr class="text-center">
                                <td>{{ $evaluacion->id }}</td>
                                <td>{{ $evaluacion->nna->cod_nna }}</td>
                                <td>{{ $evaluacion->nna->nombres . ' ' . $evaluacion->nna->apellidos }}</td>
                                <td>{{ $evaluacion->personalSedeges->usuario->name }}</td>
                                <td>{{ $evaluacion->diagnostico }}</td>
                                <td>{{ $evaluacion->recomendaciones }}</td>
                                <td>{{ $evaluacion->observaciones }}</td>
                                <td>{{ $evaluacion->fecha }}</td>
                                <td>
                                    <form action="{{ route('evaluacionesPsi.destroy', $evaluacion->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-success" title="Cambiar estado">Vigente</button>
                                    </form>
                                </td>
                                <td>
                                    @if ($evaluacion->documentoNna && $evaluacion->documentoNna->url)
                                        <a href="{{ asset('storage/' . $evaluacion->documentoNna->url) }}" target="_blank" class="btn btn-info btn-sm">
                                            <i class="bi bi-eye-fill"></i> Ver
                                        </a>
                                    @else
                                        No disponible
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('evaluacionesPsi.edit', $evaluacion) }}" class="btn btn-outline-warning" title="Editar">
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

    {{-- Tabla de evaluaciones VENCIDAS --}}
    <div class="card shadow">
        <div class="card-header bg-gray text-white fw-bold">
            Evaluaciones Vencidas
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle table-bordered table-striped" id="tablaVencidas">
                    <thead class="table-light text-center">
                        <tr>
                            <th>#</th>
                            <th>Código NNA</th>
                            <th>Nombre completo</th>
                            <th>Evaluador</th>
                            <th>Diagnóstico</th>
                            <th>Recomendaciones</th>
                            <th>Observaciones</th>
                            <th>Estado</th>
                            <th>Documento</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($evaluaciones->where('documentoNna.estado', false) as $evaluacion)
                            <tr class="text-center">
                                <td>{{ $evaluacion->id }}</td>
                                <td>{{ $evaluacion->nna->cod_nna }}</td>
                                <td>{{ $evaluacion->nna->nombres . ' ' . $evaluacion->nna->apellidos }}</td>
                                <td>{{ $evaluacion->personalSedeges->usuario->name }}</td>
                                <td>{{ $evaluacion->diagnostico }}</td>
                                <td>{{ $evaluacion->recomendaciones }}</td>
                                <td>{{ $evaluacion->observaciones }}</td>
                                <td>
                                    <form action="{{ route('evaluacionesPsi.destroy', $evaluacion->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Cambiar estado">Vencido</button>
                                    </form>
                                </td>
                                <td>
                                    @if ($evaluacion->documentoNna && $evaluacion->documentoNna->url)
                                        <a href="{{ asset('storage/' . $evaluacion->documentoNna->url) }}" target="_blank" class="btn btn-info btn-sm">
                                            <i class="bi bi-eye-fill"></i> Ver
                                        </a>
                                    @else
                                        No disponible
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('evaluacionesPsi.edit', $evaluacion) }}" class="btn btn-outline-warning" title="Editar">
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@stop

@section('js')
    <script>
        $(document).ready(function () {
            $('#tablaVigentes').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
                }
            });

            $('#tablaVencidas').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
                }
            });

            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(el => new bootstrap.Tooltip(el));
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
