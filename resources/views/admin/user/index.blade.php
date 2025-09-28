@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
<div class="row">
    <h1>Listado de Usuarios</h1>
</div>
@stop

@section('content')
  {{-- Barra de búsqueda --}}
<div class="row mb-3">
    <div class="col-md-4">
      <input type="text" id="busqueda" class="form-control" placeholder="Buscar usuario...">
    </div>

    {{-- Boton de crear--}}
    {{-- Botón que abre el modal --}}
    <a href="{{ route('usuarios.create') }}" class="btn btn-primary">
      <i class="bi bi-plus-circle me-1"></i> Nuevo Usuario
    </a>

    <a href="{{ route('usuarios.pdf') }}" class="btn btn-dark">
        Generar Reporte
      </a>
</div>
<hr>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Usuarios</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table tablesorter">
                        <thead class="text-primary">
                            <tr>
                                <th><center>Nro</center></th>
                                <th><center>Cod</center></th>
                                <th><center>Identificación</center></th>
                                <th><center>Nombres</center></th>
                                <th><center>Apellidos</center></th>
                                <th><center>Fecha Nacimiento</center></th>
                                <th><center>Contacto</center></th>
                                <th><center>Dirección</center></th>
                                <th><center>Email</center></th>
                                <th><center>contrasena</center></th>
                                <th><center>Rol</center></th>
                                <th><center>Estado</center></th>
                                <th><center>Acciones</center></th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($user as $usuario)
                                <tr>
                                    <td><center>{{ $usuario->id }}</center></td>
                                    <td><center>{{ $usuario->cod_usu }}</center></td>
                                    <td><center>{{ $usuario->identificacion }}</center></td>
                                    <td><center>{{ $usuario->name }}</center></td>
                                    <td><center>{{ $usuario->apellidos }}</center></td>
                                    <td><center>{{ $usuario->fecha_nac ?? '-' }}</center></td>
                                    <td><center>{{ $usuario->contacto }}</center></td>
                                    <td><center>{{ $usuario->direccion }}</center></td>
                                    <td><center>{{ $usuario->email }}</center></td>
                                    <!-- Se reemplaza la contraseña por ****** -->
                                    <td><center>******</center></td>
                                    <td><center>{{ $usuario->rol->nombre_rol ?? 'Sin rol' }}</center></td>


                                    <td class="text-center d-flex gap-1 justify-content-center">
                                        {{-- Botón Activar/Desactivar --}}
                                        <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST"
                                            onsubmit="return confirmDeletion(event, '{{ $usuario->id }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-sm {{ $usuario->estado_usu ? 'btn-success' : 'btn-danger' }}"
                                                title="Cambiar estado">
                                                {{ $usuario->estado_usu ? 'Activa' : 'Inactiva' }}
                                            </button>
                                        </form>
                                    </td>


                                    <td>
                                        <div class="d-flex justify-content-center gap-2">
                                            {{-- Botón Editar --}}
                                            <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-primary btn-sm" title="Editar">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11"><center>No hay usuarios registrados.</center></td>
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
<!-- Definimos la sección de scripts -->
{{-- Script para búsqueda en tiempo real --}}
<script>
    document.getElementById('busqueda').addEventListener('keyup', function() {
      let valor = this.value.toLowerCase();
      let filas = document.querySelectorAll('#tablaUsuarios tbody tr');

      filas.forEach(fila => {
        const textoFila = fila.textContent.toLowerCase();
        fila.style.display = textoFila.includes(valor) ? '' : 'none';
      });
    });
</script>
@stop
