@extends('adminlte::page')

@section('title', 'Registrar Responsable Legal')

@section('content_header')
    <br>
@stop

@section('content')
    <main class="container mt-4">
        <div class="card shadow rounded-4 border-0">
            <div class="card-header bg-gradient-teal text-white">
                <h4 class="mb-0 fw-semibold">Registrar Nuevo Responsable Legal</h4>
            </div>

            <div class="card-body">
                {{-- Mostrar errores de validación --}}
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

                <form action="{{ route('resp_legales.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf

                    <div class="row g-3">

                        {{-- Ruta Foto --}}
                        <div class="col-md-6">
                            <label for="ruta_foto" class="form-label fw-semibold">Foto de Perfil</label>
                            <input type="file" class="form-control @error('ruta_foto') is-invalid @enderror"
                                name="ruta_foto" id="ruta_foto" accept="image/*" onchange="previewImage(event)">
                            <div class="valid-feedback">¡Correcto!</div>
                            @error('ruta_foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Vista previa --}}
                        <div class="col-md-6 mt-3">
                            <label class="form-label fw-semibold">Vista previa</label><br>
                            <img id="preview" src="#" alt="Vista previa"
                                style="width: 150px; height: 150px; object-fit: cover; border-radius: 50%; display: none;"
                                class="shadow">
                        </div>

                        {{-- Nombre --}}
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-semibold">Nombre <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" id="name" required>
                        </div>

                        {{-- Apellido --}}
                        <div class="col-md-6">
                            <label for="apellidos" class="form-label fw-semibold">Apellido <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="apellidos" id="apellidos" required>
                        </div>




                        {{-- Contacto --}}
                        <div class="col-md-6">
                            <label for="contacto" class="form-label fw-semibold">Número de Contacto <span
                                    class="text-danger">*</span></label>
                            <input type="tel" class="form-control @error('contacto') is-invalid @enderror"
                                name="contacto" id="contacto" value="{{ old('contacto') }}" placeholder="Ej: 71234567"
                                required>
                            <div class="valid-feedback">¡Correcto!</div>
                            @error('contacto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Fecha Nacimiento --}}
                        <div class="col-md-6">
                            <label for="fecha_nac" class="form-label fw-semibold">Fecha de Nacimiento <span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('fecha_nac') is-invalid @enderror"
                                name="fecha_nac" id="fecha_nac" value="{{ old('fecha_nac') }}" required>
                            @error('fecha_nac')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Identificación --}}
                        <div class="col-md-6">
                            <label for="identificacion" class="form-label fw-semibold">Número de Identificación <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('identificacion') is-invalid @enderror"
                                name="identificacion" id="identificacion" value="{{ old('identificacion') }}"
                                placeholder="Ej: 12345678" required>
                            <div class="valid-feedback">¡Correcto!</div>
                            @error('identificacion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        {{-- Email (autogenerado) --}}
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold">Correo Electrónico <span
                                    class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" id="email" readonly required>
                        </div>

                        {{-- Password --}}
                        <div class="col-md-6">
                            <label for="password" class="form-label fw-semibold">Contraseña <span
                                    class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                name="password" id="password" placeholder="Ingrese una contraseña segura" required>
                            <div class="valid-feedback">¡Correcto!</div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        {{-- direcion_oficina --}}

                        <div class="col-md-6">
                            <label for="direccion_oficina" class="form-label fw-semibold">Dirección Oficina <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('direccion_oficina') is-invalid @enderror"
                                name="direccion_oficina" id="direccion_oficina" value="{{ old('direccion_oficina') }}"
                                placeholder="Ingrese la dirección de la oficina" required>
                            <div class="valid-feedback">¡Correcto!</div>
                            @error('direccion_oficina')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- especialidad --}}

                        <div class="col-md-6">
                            <label for="especialidad" class="form-label fw-semibold">Especialidad <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('especialidad') is-invalid @enderror"
                                name="especialidad" id="especialidad" value="{{ old('especialidad') }}"
                                placeholder="Ingrese la especialidad" required>
                            <div class="valid-feedback">¡Correcto!</div>
                            @error('especialidad')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        {{-- horarios_atencion --}}
                        <div class="col-md-6">
                            <label for="horarios_atencion" class="form-label fw-semibold">Horarios de Atención <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('horarios_atencion') is-invalid @enderror"
                                name="horarios_atencion" id="horarios_atencion" value="{{ old('horarios_atencion') }}"
                                placeholder="Ej: Lunes a Viernes 8:00-16:00" required>
                            <div class="valid-feedback">¡Correcto!</div>
                            @error('horarios_atencion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="d-flex justify-content-end mt-4">
                            <a href="{{ route('resp_legales.index') }}"
                                class="btn btn-outline-secondary me-3 px-4">Cancelar</a>
                            <button type="submit" class="btn btn-primary px-4 shadow-sm">Registrar</button>
                        </div>
                </form>
            </div>
        </div>
    </main>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
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
                preview.src = '#';
                preview.style.display = 'none';
            }
        }

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


        document.addEventListener('DOMContentLoaded', () => {
            const fechaInput = document.getElementById('fecha_nac');

            fechaInput.addEventListener('change', () => {
                const fechaSeleccionada = new Date(fechaInput.value);
                const hoy = new Date();
                const limiteEdad = new Date();
                limiteEdad.setFullYear(hoy.getFullYear() - 10); // mínimo 10 años

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
                        text: 'La persona debe tener al menos 10 años.',
                    });
                    fechaInput.value = '';
                }
            });
        });



        document.addEventListener("DOMContentLoaded", function() {
            const nombreInput = document.getElementById("name");
            const apellidoInput = document.getElementById("apellidos");
            const emailInput = document.getElementById("email");

            function generarCorreo() {
                let name = nombreInput.value.trim().toLowerCase();
                let apellidos = apellidoInput.value.trim().toLowerCase();

                if (name && apellidos) {
                    let correo = `${name}.${apellidos}@sedegeslp.bo`.replace(/\s+/g, '');
                    emailInput.value = correo;
                } else {
                    emailInput.value = '';
                }
            }

            nombreInput.addEventListener("input", generarCorreo);
            apellidoInput.addEventListener("input", generarCorreo);
        });
    </script>
@stop
