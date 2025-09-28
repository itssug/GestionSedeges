@extends('adminlte::page')

@section('title', 'Registrar Personal')

@section('content_header')
    <h1>Registrar Personal SEDEGES</h1>
@stop

@section('content')
    <main class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Formulario de Registro</h4>
            </div>

            <div class="card-body">
                {{-- Mostrar errores --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('personal.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Usuario --}}
                    <div class="form-group mb-3">
                        <label for="usuario_id">Usuario del sistema</label>
                        <select class="form-control @error('user_id') is-invalid @enderror" name="user_id" id="user_id"
                            required>
                            <option value="">Seleccione un usuario</option>
                            @foreach ($usuarios as $usuario)
                                <option value="{{ $usuario->id }}" {{ old('user_id') == $usuario->id ? 'selected' : '' }}>
                                    {{ $usuario->name }} ({{ $usuario->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Foto --}}
                    <div class="form-group mb-3">
                        <label for="foto">Fotografía</label>
                        <input type="file" class="form-control @error('foto') is-invalid @enderror" name="foto"
                            id="foto" accept="image/*">
                        @error('foto')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Especialidad --}}
                    <div class="form-group mb-3">
                        <label for="especialidad">Especialidad</label>
                        <input type="text" class="form-control @error('especialidad') is-invalid @enderror"
                            name="especialidad" id="especialidad" value="{{ old('especialidad') }}" required>
                        @error('especialidad')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Área --}}
                    <div class="form-group mb-3">
                        <label for="area">Área</label>
                        <input type="text" class="form-control @error('area') is-invalid @enderror" name="area"
                            id="area" value="{{ old('area') }}" required>
                        @error('area')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Fecha de ingreso --}}
                    <div class="form-group mb-3">
                        <label for="fecha_ingreso">Fecha de Ingreso</label>
                        <input type="date" class="form-control @error('fecha_ingreso') is-invalid @enderror"
                            name="fecha_ingreso" id="fecha_ingreso" value="{{ old('fecha_ingreso') }}" required>
                        @error('fecha_ingreso')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Horario laboral --}}
                    <div class="form-group mb-3">
                        <label for="horario_laboral">Horario Laboral</label>
                        <input type="text" class="form-control @error('horario_laboral') is-invalid @enderror"
                            name="horario_laboral" id="horario_laboral" value="{{ old('horario_laboral') }}" required>
                        @error('horario_laboral')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    

                    {{-- Rol dentro del personal --}}
                    <div class="form-group mb-3">
                        <label for="roles_personal_id">Rol del Personal</label>
                        <select class="form-control @error('roles_personal_id') is-invalid @enderror"
                            name="roles_personal_id" id="roles_personal_id" required>
                            <option value="">Seleccione un rol</option>
                            @foreach ($roles_personal as $rol)
                                <option value="{{ $rol->id }}"
                                    {{ old('roles_personal_id') == $rol->id ? 'selected' : '' }}>
                                    {{ $rol->nombre_rol_per }}
                                </option>
                            @endforeach
                        </select>
                        @error('roles_personal_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    {{-- Estado --}}
                    <div class="form-group mb-3">
                        <label for="estado">Estado</label>
                        <select class="form-control @error('estado') is-invalid @enderror" name="estado" id="estado"
                            required>
                            <option value="">Seleccione</option>
                            <option value="1" {{ old('estado') == '1' ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ old('estado') == '0' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                        @error('estado')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('personal.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop
