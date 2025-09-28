@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1>Dashboard</h1>


@stop

@section('content')
<div class="row mb-3">
    <div class="col-md-4">
        <input type="text" id="busqueda" class="form-control" placeholder="Buscar rol...">
    </div>

    {{-- Boton de crear --}}
    <a href="{{ route('roles_personal.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Nuevo Rol
    </a>

</div>
<hr>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Roles Sedeges</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table tablesorter">
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
                                    <center>{{ $rol->cod_rol_per }}</center>
                                </td>
                                <td>
                                    <center>{{ $rol->nombre_rol_per }}</center>
                                </td>

                                <td class="text-center d-flex gap-1 justify-content-center">
                                    {{-- Botón Activar/Desactivar --}}
                                    <form action="{{ route('roles_personal.destroy', $rol->id) }}" method="POST"
                                        onsubmit="return confirm('¿Deseas cambiar el estado de este rol?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-sm {{ $rol->estado ? 'btn-success' : 'btn-danger' }}"
                                            title="Cambiar estado">
                                            {{ $rol->estado ? 'Activado' : 'Desactivado' }}
                                        </button>
                                    </form>
                                </td>


                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        {{-- Botón Editar --}}
                                        <a href="{{ url('/roles_personal/' . $rol->id . '/edit') }}" class="btn btn-primary btn-sm" title="Editar">EDITAR
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                    </div>
                                </td>


                            </tr>
                            @empty
                            <tr>
                                <td colspan="3">
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

{{-- Script para búsqueda en tiempo real --}}
<script>
    document.getElementById('busqueda').addEventListener('keyup', function() {
        let valor = this.value.toLowerCase();
        let filas = document.querySelectorAll('tbody tr');

        filas.forEach(fila => {
            const textoFila = fila.textContent.toLowerCase();
            fila.style.display = textoFila.includes(valor) ? '' : 'none';
        });
    });
</script>

@stop