@extends('adminlte::page')

@section('title', 'Editar Personal')

@section('content_header')
    <br>
@stop

@section('content')
    <main class="container mt-4">
        <div class="card shadow rounded-4 border-0">
            <div class="card-header bg-gradient-teal text-white">
                <h4 class="mb-0 fw-semibold">Editar Personal</h4>
            </div>

            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Por favor corrige los siguientes errores:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                    </div>
                @endif

                <form action="{{ route('personal.update', $personal->id) }}" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        {{-- Foto --}}
                        <div class="col-md-6">
                            <label for="foto" class="form-label fw-semibold">Foto de Perfil</label>
                            <input type="file" class="form-control @error('foto') is-invalid @enderror"
                                name="foto" id="foto" accept="image/*" onchange="previewImage(event)">
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mt-3">
                            <label class="form-label fw-semibold">Vista previa</label><br>
                            <img id="preview"
                                src="{{ $personal->foto ? asset('storage/' . $personal->foto) : '#' }}"
                                alt="Vista previa"
                                style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%; {{ $personal->foto ? '' : 'display: none;' }}"
                                class="shadow">
                        </div>

                        {{-- Nombre --}}
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-semibold">Nombre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" id="name"
                                value="{{ old('name', $personal->usuario->name) }}" required>
                        </div>

                        {{-- Apellidos --}}
                        <div class="col-md-6">
                            <label for="apellidos" class="form-label fw-semibold">Apellidos <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="apellidos" id="apellidos"
                                value="{{ old('apellidos', $personal->usuario->apellidos) }}" required>
                        </div>

                        {{-- Especialidad --}}
                        <div class="col-md-6">
                            <label for="especialidad" class="form-label fw-semibold">Especialidad <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="especialidad" id="especialidad"
                                value="{{ old('especialidad', $personal->especialidad) }}" required>
                        </div>

                        {{-- Área --}}
                        <div class="col-md-6">
                            <label for="area" class="form-label fw-semibold">Área <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="area" id="area"
                                value="{{ old('area', $personal->area) }}" required>
                        </div>

                        {{-- Fecha de ingreso --}}
                        <div class="col-md-6">
                            <label for="fecha_ingreso" class="form-label fw-semibold">Fecha de Ingreso <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="fecha_ingreso" id="fecha_ingreso"
                                value="{{ old('fecha_ingreso', $personal->fecha_ingreso) }}" required>
                        </div>

                        {{-- Años de antigüedad --}}
                        <div class="col-md-6">
                            <label for="anios_antiguedad" class="form-label fw-semibold">Años de Antigüedad</label>
                            <input type="number" class="form-control" name="anios_antiguedad" id="anios_antiguedad"
                                value="{{ old('anios_antiguedad', $personal->anios_antiguedad) }}" min="0">
                        </div>

                        {{-- Horario Laboral --}}
                        <div class="col-md-6">
                            <label for="horario_laboral" class="form-label fw-semibold">Horario Laboral</label>
                            <input type="text" class="form-control" name="horario_laboral" id="horario_laboral"
                                value="{{ old('horario_laboral', $personal->horario_laboral) }}">
                        </div>

                        {{-- Rol --}}
                        <div class="col-md-6">
                            <label for="roles_personal_id" class="form-label fw-semibold">Rol <span class="text-danger">*</span></label>
                            <select class="form-control" name="roles_personal_id" id="roles_personal_id" required>
                                @foreach($roles as $rol)
                                    <option value="{{ $rol->id }}"
                                        {{ old('roles_personal_id', $personal->roles_personal_id) == $rol->id ? 'selected' : '' }}>
                                        {{ $rol->nombre_rol_per }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Estado --}}
                        <div class="col-md-6">
                            <label for="estado" class="form-label fw-semibold">Estado <span class="text-danger">*</span></label>
                            <select class="form-control" name="estado" id="estado" required>
                                <option value="1" {{ old('estado', $personal->estado) == 1 ? 'selected' : '' }}>Activo</option>
                                <option value="0" {{ old('estado', $personal->estado) == 0 ? 'selected' : '' }}>Inactivo</option>
                            </select>
                        </div>

                        {{-- Email --}}
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold">Correo Electrónico</label>
                            <input type="email" class="form-control" name="email" id="email"
                                value="{{ $personal->usuario->email }}" readonly>
                        </div>

                        {{-- Password --}}
                        <div class="col-md-6">
                            <label for="password" class="form-label fw-semibold">Contraseña</label>
                            <input type="password" class="form-control" name="password" id="password"
                                placeholder="Dejar en blanco para no cambiar">
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('personal.index') }}" class="btn btn-outline-secondary me-3 px-4">Cancelar</a>
                            <button type="submit" class="btn btn-primary px-4 shadow-sm">Actualizar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
@stop

@section('js')
<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('preview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            // Mostrar la foto actual o esconder si no hay
            @if ($personal->foto)
                preview.src = "{{ asset('storage/' . $personal->foto) }}";
                preview.style.display = 'block';
            @else
                preview.src = '#';
                preview.style.display = 'none';
            @endif
        }
    }

    // Validación de fecha de ingreso
    document.addEventListener('DOMContentLoaded', () => {
        const fechaInput = document.getElementById('fecha_ingreso');

        fechaInput.addEventListener('change', () => {
            const fechaSeleccionada = new Date(fechaInput.value);
            const hoy = new Date();

            if (fechaSeleccionada > hoy) {
                Swal.fire({
                    icon: 'error',
                    title: 'Fecha Inválida',
                    text: 'La fecha de ingreso no puede ser futura.',
                });
                fechaInput.value = '';
            }
        });
    });

    // Validación de formulario
    (() => {
        'use strict'
        const forms = document.querySelectorAll('form[novalidate]')
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()
</script>
@stop
