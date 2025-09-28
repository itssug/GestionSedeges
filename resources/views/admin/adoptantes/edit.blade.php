@extends('adminlte::page')

@section('title', 'Editar Adoptante')

@section('content_header')
    <br>
@stop

@section('content')
    <main class="container mt-4">
        <div class="card shadow rounded-4 border-0">
            <div class="card-header bg-gradient-teal text-white">
                <h4 class="mb-0 fw-semibold">Editar Adoptante</h4>
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

                <form action="{{ route('adoptantes.update', $adoptante->id) }}" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf
                    @method('PUT')
                    <div class="row g-3">
                        {{-- Foto --}}
                        <div class="col-md-6">
                            <label for="ruta_foto" class="form-label fw-semibold">Foto de Perfil</label>
                            <input type="file" class="form-control @error('ruta_foto') is-invalid @enderror"
                                name="ruta_foto" id="ruta_foto" accept="image/*" onchange="previewImage(event)">
                            @error('ruta_foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mt-3">
                            <label class="form-label fw-semibold">Vista previa</label><br>
                            <img id="preview"
                                src="{{ $adoptante->user->ruta_foto ? asset('storage/' . $adoptante->user->ruta_foto) : '#' }}"
                                alt="Vista previa"
                                style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%; {{ $adoptante->user->ruta_foto ? '' : 'display: none;' }}"
                                class="shadow">
                        </div>

                        {{-- Nombre --}}
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-semibold">Nombre <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $adoptante->user->name) }}" required>
                        </div>

                        {{-- Apellidos --}}
                        <div class="col-md-6">
                            <label for="apellidos" class="form-label fw-semibold">Apellidos <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="apellidos" id="apellidos" value="{{ old('apellidos', $adoptante->user->apellidos) }}" required>
                        </div>

                        {{-- Identificación --}}
                        <div class="col-md-6">
                            <label for="identificacion" class="form-label fw-semibold">Número de Identificación <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="identificacion" id="identificacion" value="{{ old('identificacion', $adoptante->user->identificacion) }}" required>
                        </div>

                        {{-- Fecha de nacimiento --}}
                        <div class="col-md-6">
                            <label for="fecha_nac" class="form-label fw-semibold">Fecha de Nacimiento <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="fecha_nac" id="fecha_nac" value="{{ old('fecha_nac', $adoptante->user->fecha_nac) }}" required>
                        </div>

                        {{-- Contacto --}}
                        <div class="col-md-6">
                            <label for="contacto" class="form-label fw-semibold">Número de Contacto</label>
                            <input type="text" class="form-control" name="contacto" id="contacto" value="{{ old('contacto', $adoptante->user->contacto) }}" required>
                        </div>

                        {{-- Dirección --}}
                        <div class="col-md-6">
                            <label for="direccion" class="form-label fw-semibold">Dirección</label>
                            <input type="text" class="form-control" name="direccion" id="direccion" value="{{ old('direccion', $adoptante->user->direccion) }}" required>
                        </div>

                        {{-- País --}}
                        <div class="col-md-6">
                            <label for="pais" class="form-label fw-semibold">País <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="pais" id="pais" value="{{ old('pais', $adoptante->pais) }}" required>
                        </div>

                        {{-- Nacionalidad --}}
                        <div class="col-md-6">
                            <label for="nacionalidad" class="form-label fw-semibold">Nacionalidad <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nacionalidad" id="nacionalidad" value="{{ old('nacionalidad', $adoptante->nacionalidad) }}" required>
                        </div>

                        {{-- Estado Civil --}}
                        <div class="col-md-6">
                            <label for="estado_civil" class="form-label fw-semibold">Estado Civil <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="estado_civil" id="estado_civil" value="{{ old('estado_civil', $adoptante->estado_civil) }}" required>
                        </div>

                        {{-- Nivel Educativo --}}
                        <div class="col-md-6">
                            <label for="nivel_educativo" class="form-label fw-semibold">Nivel Educativo <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nivel_educativo" id="nivel_educativo" value="{{ old('nivel_educativo', $adoptante->nivel_educativo) }}" required>
                        </div>

                        {{-- Ocupación --}}
                        <div class="col-md-6">
                            <label for="ocupacion" class="form-label fw-semibold">Ocupación <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="ocupacion" id="ocupacion" value="{{ old('ocupacion', $adoptante->ocupacion) }}" required>
                        </div>

                        {{-- Ingresos Mensuales --}}
                        <div class="col-md-6">
                            <label for="ingresos_mensuales" class="form-label fw-semibold">Ingresos Mensuales <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="ingresos_mensuales" id="ingresos_mensuales" min="0" value="{{ old('ingresos_mensuales', $adoptante->ingresos_mensuales) }}" required>
                        </div>

                        {{-- Email --}}
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold">Correo Electrónico</label>
                            <input type="email" class="form-control" name="email" id="email" value="{{ $adoptante->user->email }}" readonly>
                        </div>

                        {{-- Password --}}
                        <div class="col-md-6">
                            <label for="password" class="form-label fw-semibold">Contraseña</label>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Dejar en blanco para no cambiar">
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('adoptantes.index') }}" class="btn btn-outline-secondary me-3 px-4">Cancelar</a>
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
            @if ($adoptante->ruta_foto)
                preview.src = "{{ asset('storage/' . $adoptante->ruta_foto) }}";
                preview.style.display = 'block';
            @else
                preview.src = '#';
                preview.style.display = 'none';
            @endif
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        const nombreInput = document.getElementById("name");
        const apellidoInput = document.getElementById("apellidos");
        const emailInput = document.getElementById("email");

        function generarCorreo() {
            let name = nombreInput.value.trim().toLowerCase();
            let apellidos = apellidoInput.value.trim().toLowerCase();

            if (name && apellidos) {
                let correo = `${name}.${apellidos}@sedegesAdopLP.bo`.replace(/\s+/g, '');
                emailInput.value = correo;
            } else {
                emailInput.value = '';
            }
        }

        // Solo generar correo si quieres permitir cambiar email, si no se puede eliminar esta parte
        nombreInput.addEventListener("input", generarCorreo);
        apellidoInput.addEventListener("input", generarCorreo);
    });

    document.addEventListener('DOMContentLoaded', () => {
        const fechaInput = document.getElementById('fecha_nac');

        fechaInput.addEventListener('change', () => {
            const fechaSeleccionada = new Date(fechaInput.value);
            const hoy = new Date();
            const limiteEdad = new Date();
            limiteEdad.setFullYear(hoy.getFullYear() - 20); // mínimo 20 años

            if (fechaSeleccionada > hoy) {
                Swal.fire({
                    icon: 'error',
                    title: 'Fecha Inválida',
                    text: 'La fecha de nacimiento no puede ser futura.',
                });
                fechaInput.value = '';
            } else if (fechaSeleccionada > limiteEdad) {
                Swal.fire({
                    icon: 'error',
                    title: 'Edad Inválida',
                    text: 'La persona debe tener al menos 20 años.',
                });
                fechaInput.value = '';
            }
        });
    });

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
