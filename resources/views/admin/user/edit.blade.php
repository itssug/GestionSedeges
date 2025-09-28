@extends('adminlte::page')

@section('title', 'Editar Usuario')

@section('content_header')
    <h1>Usuarios</h1>
@stop

@section('content')
<main class="container py-4">
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card shadow rounded-3">
        <div class="card-header bg-primary text-white">
          <h4 class="mb-0">Editar Usuario</h4>
        </div>
        <div class="card-body">
          <form action="{{ url('/usuarios/' . $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Campo: Nombre --}}
            <div class="mb-3">
              <label for="name" class="form-label">Nombre</label>
              <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
            </div>

            {{-- Campo: Apellidos --}}
            <div class="mb-3">
              <label for="apellidos" class="form-label">Apellidos</label>
              <input type="text" class="form-control" id="apellidos" name="apellidos" value="{{ $user->apellidos }}" required>
            </div>

            {{-- Campo: Código de Usuario --}}
            <div class="mb-3">
              <label for="cod_usu" class="form-label">Código de Usuario</label>
              <input type="text" class="form-control" id="cod_usu" name="cod_usu" value="{{ $user->cod_usu }}" required>
            </div>

            {{-- Campo: Contacto --}}
            <div class="mb-3">
              <label for="contacto" class="form-label">Contacto</label>
              <input type="text" class="form-control" id="contacto" name="contacto" value="{{ $user->contacto }}" required>
            </div>

            {{-- Campo: Dirección --}}
            <div class="mb-3">
              <label for="direccion" class="form-label">Dirección</label>
              <input type="text" class="form-control" id="direccion" name="direccion" value="{{ $user->direccion }}" required>
            </div>

            {{-- Campo: Fecha de Nacimiento --}}
            <div class="mb-3">
              <label for="fecha_nac" class="form-label">Fecha de Nacimiento</label>
              <input type="date" class="form-control" id="fecha_nac" name="fecha_nac" value="{{ $user->fecha_nac }}" required>
            </div>

            {{-- Campo: Identificación --}}
            <div class="mb-3">
              <label for="identificacion" class="form-label">Identificación</label>
              <input type="text" class="form-control" id="identificacion" name="identificacion" value="{{ $user->identificacion }}" required>
            </div>

            {{-- Campo: Rol --}}
            <div class="mb-3">
              <label for="rol_id" class="form-label">Rol</label>
              <select class="form-control" id="rol_id" name="rol_id" required>
                @foreach($roles as $rol)
                  <option value="{{ $rol->id }}" {{ $user->rol_id == $rol->id ? 'selected' : '' }}>
                    {{ $rol->nombre_rol }}
                  </option>
                @endforeach
              </select>
            </div>

            {{-- Campo: Email --}}
            <div class="mb-3">
              <label for="email" class="form-label">Correo Electrónico</label>
              <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
            </div>

            {{-- Campo: Estado --}}
            <div class="mb-3">
              <label for="estado_usu" class="form-label">Estado</label>
              <select class="form-control" id="estado_usu" name="estado_usu">
                <option value="1" {{ $user->estado_usu == 1 ? 'selected' : '' }}>Activo</option>
                <option value="0" {{ $user->estado_usu == 0 ? 'selected' : '' }}>Inactivo</option>
              </select>
            </div>

            <div class="d-flex justify-content-end">
              <a href="{{ url('/usuarios') }}" class="btn btn-secondary me-2">Cancelar</a>
              <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</main>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
@stop
