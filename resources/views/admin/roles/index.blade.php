@extends('adminlte::page')
@section('title', 'Roles')

@section('content_header') <!-- Aquí comienza la sección del contenido -->
    <div class="row">
        <h1>Tabla de Roles</h1>
    </div>
@stop

@section('content')

    <hr>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('roles.create') }}" class="btn btn-primary">
                        <i class="fa-solid fa-plus"></i></i> Nuevo Rol
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table tablesorter" id="rolesTable">
                            <thead class="text-primary">
                                <tr>
                                    <th>
                                        <center>Nro</center>
                                    </th>
                                    <th>
                                        <center>Código</center>
                                    </th>
                                    <th>
                                        <center>Nombre</center>
                                    </th>
                                    <th>
                                        <center>Estado</center>
                                    </th>

                                    <th>
                                        <center>Acciones</center>
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($roles as $rol)
                                    <tr>
                                        <td>
                                            <center>{{ $rol->id }}</center>
                                        </td>
                                        <td>
                                            <center>{{ $rol->cod_rol }}</center>
                                        </td>
                                        <td>
                                            <center>{{ $rol->nombre_rol }}</center>
                                        </td>
                                        <td class="text-center d-flex gap-1 justify-content-center">
                                            {{-- Botón Activar/Desactivar --}}
                                            <form action="{{ route('roles.destroy', $rol->id) }}" method="POST"
                                                onsubmit="return confirmDeletion(event, '{{ $rol->id }}');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-sm {{ $rol->estado_rol ? 'btn-success' : 'btn-danger' }}"
                                                    title="Cambiar estado">
                                                    {{ $rol->estado_rol ? 'Activado' : 'Desactivado' }}
                                                </button>
                                            </form>
                                        </td>
                                        <td>
                                            <div class="d-flex justify-content-center gap-2">
                                                {{-- Botón Editar --}}
                                                <a href="{{ url('/roles/' . $rol->id . '/edit') }}"
                                                    class="btn btn-primary btn-sm" title="Editar">
                                                    <i class="fa-solid fa-pen-fancy"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">
                                            <center>No hay roles registrados.</center>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script>
        // Inicializar DataTables
        $(document).ready(function() {
            $('#rolesTable').DataTable();
        });

        @if (session('success'))
            Swal.fire({
                title: '¡Éxito!',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'Aceptar'
            });
        @endif

        @if (session('error'))
            Swal.fire({
                title: '¡Error!',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonText: 'Aceptar'
            });
        @endif
    </script>
@stop
