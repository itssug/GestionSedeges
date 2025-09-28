@extends('adminlte::page')

@section('title', 'Repositorio de Documentos')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Repositorio de documentos Niñez y Adolescencia</h1>
        <a href="{{ route('documentosNnas.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Nuevo Documento
        </a>
    </div>
@stop

@section('content')
    <hr>

    {{-- Documentos Vigentes --}}
    <div class="card shadow mb-4">
        <div class="card-header bg-teal text-white fw-bold">
            Documentos Vigentes
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle table-bordered table-striped" id="tablaVigentes">
                    <thead class="table-light text-center">
                        <tr>
                            <th>#</th>
                            <th>Código NNA</th>
                            <th>Nombre completo</th>
                            <th>Nombre del Documento</th>
                            <th>Tipo</th>
                            <th>Descripción</th>
                            <th>Fecha Emisión</th>
                            <th>Documento</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($documentos->where('estado', true) as $documento)
                            <tr class="text-center">
                                <td>{{ $documento->id }}</td>
                                <td>{{ $documento->nna->cod_nna }}</td>
                                <td>{{ $documento->nna->nombres . ' ' . $documento->nna->apellidos }}</td>
                                <td>{{ $documento->nombre }}</td>
                                <td>{{ $documento->tipo }}</td>
                                <td>{{ $documento->descripcion }}</td>
                                <td>{{ $documento->fecha_emision }}</td>
                                <td>
                                    @if ($documento->url)
                                        <a href="{{ asset('storage/' . $documento->url) }}" target="_blank" class="btn btn-info btn-sm">
                                            <i class="bi bi-eye-fill"></i> Ver
                                        </a>
                                    @else
                                        No disponible
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('documentosNnas.destroy', $documento->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-success" title="Cambiar estado">Vigente</button>
                                    </form>
                                </td>
                                <td>
                                    <a href="{{ route('documentosNnas.edit', $documento) }}" class="btn btn-outline-warning btn-sm" title="Editar">
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

    {{-- Documentos Vencidos --}}
    <div class="card shadow">
        <div class="card-header bg-secondary text-white fw-bold">
            Documentos Vencidos
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle table-bordered table-striped" id="tablaVencidos">
                    <thead class="table-light text-center">
                        <tr>
                            <th>#</th>
                            <th>Código NNA</th>
                            <th>Nombre completo</th>
                            <th>Nombre del Documento</th>
                            <th>Tipo</th>
                            <th>Descripción</th>
                            <th>Fecha Emisión</th>
                            <th>Documento</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($documentos->where('estado', false) as $documento)
                            <tr class="text-center">
                                <td>{{ $documento->id }}</td>
                                <td>{{ $documento->nna->cod_nna }}</td>
                                <td>{{ $documento->nna->nombres . ' ' . $documento->nna->apellidos }}</td>
                                <td>{{ $documento->nombre }}</td>
                                <td>{{ $documento->tipo }}</td>
                                <td>{{ $documento->descripcion }}</td>
                                <td>{{ $documento->fecha_emision }}</td>
                                <td>
                                    @if ($documento->url)
                                        <a href="{{ asset('storage/' . $documento->url) }}" target="_blank" class="btn btn-info btn-sm">
                                            <i class="bi bi-eye-fill"></i> Ver
                                        </a>
                                    @else
                                        No disponible
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('documentosNnas.destroy', $documento->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Cambiar estado">Vencido</button>
                                    </form>
                                </td>
                                <td>
                                    <a href="{{ route('documentosNnas.edit', $documento) }}" class="btn btn-outline-warning btn-sm" title="Editar">
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
            $('#tablaVigentes').DataTable();
            $('#tablaVencidos').DataTable();
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
