@extends('adminlte::page')

@section('title', 'Crear Usuario')

@section('content_header')
    <h1>Nuevo Usuario</h1>
@stop

@section('content')
<main class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow rounded-3">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Registrar Usuario</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('usuarios.store') }}" method="POST">
                        @csrf

                        {{-- Cod Usuario --}}
                        <div class="mb-3">
                            <label for="cod_usu" class="form-label">Código Usuario</label>
                            <input type="text" class="form-control" name="cod_usu" required>
                        </div>

                        {{-- Nombre --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>

                        {{-- Apellidos --}}
                        <div class="mb-3">
                            <label for="apellidos" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" name="apellidos" required>
                        </div>

                        {{-- Identificación --}}
                        <div class="mb-3">
                            <label for="identificacion" class="form-label">Identificación</label>
                            <input type="text" class="form-control" name="identificacion" required>
                        </div>

                        {{-- Fecha de Nacimiento --}}
                        <div class="mb-3">
                            <label for="fecha_nac" class="form-label">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" name="fecha_nac" required>
                        </div>

                        {{-- Contacto --}}
                        <div class="mb-3">
                            <label for="contacto" class="form-label">Contacto</label>
                            <input type="text" class="form-control" name="contacto" required>
                        </div>

                        {{-- Dirección --}}
                        <div class="mb-3">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" name="direccion" required>
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>

                        {{-- Contraseña --}}
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>

                        {{-- Rol --}}
                        <div class="mb-3">
                            <label for="rol_id" class="form-label">Rol</label>
                            <select name="rol_id" class="form-select" required>
                                <option value="" disabled selected>Seleccione un rol</option>
                                @foreach ($roles as $rol)
                                    <option value="{{ $rol->id }}">{{ $rol->nombre_rol }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Estado --}}
                        <div class="mb-3">
                            <label for="estado_usu" class="form-label">Estado</label>
                            <select name="estado_usu" class="form-select" required>
                                <option value="1" selected>Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('usuarios.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar</button>
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
