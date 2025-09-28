@extends('adminlte::page')

@section('title', 'Editar Capacitación')

@section('content_header')
    <br>
@stop

@section('content')
<main class="container mt-4">
    <div class="card shadow rounded-4 border-0">
        <div class="card-header bg-teal text-white">
            <h4 class="mb-0 fw-semibold">Editar Capacitación</h4>
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

            <form action="{{ route('capacitaciones.update', $capacitacion->id) }}" method="POST" novalidate>
                @csrf
                @method('PUT')

                <div class="row g-3">
                    {{-- Nombre --}}
                    <div class="col-md-6">
                        <label for="nombre" class="form-label fw-semibold">Nombre de la Capacitación <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre"
                            name="nombre" value="{{ old('nombre', $capacitacion->nombre) }}" required>
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Descripción --}}
                    <div class="col-md-6">
                        <label for="descripcion" class="form-label fw-semibold">Descripción <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion"
                            rows="3" required>{{ old('descripcion', $capacitacion->descripcion) }}</textarea>
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Fecha inicio --}}
                    <div class="col-md-6">
                        <label for="fecha_inicio" class="form-label fw-semibold">Fecha de Inicio <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('fecha_inicio') is-invalid @enderror"
                            id="fecha_inicio" name="fecha_inicio" value="{{ old('fecha_inicio', $capacitacion->fecha_inicio)}}" required>
                        @error('fecha_inicio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Fecha fin --}}
                    <div class="col-md-6">
                        <label for="fecha_fin" class="form-label fw-semibold">Fecha de Fin <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('fecha_fin') is-invalid @enderror"
                            id="fecha_fin" name="fecha_fin" value="{{ old('fecha_fin', $capacitacion->fecha_fin )}}" required>
                        @error('fecha_fin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Duración --}}
                    <div class="col-md-6">
                        <label for="duracion" class="form-label fw-semibold">Duración (en días) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('duracion') is-invalid @enderror"
                            id="duracion" name="duracion" value="{{ old('duracion', $capacitacion->duracion) }}" min="1" required>
                        @error('duracion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Modalidad --}}
                    <div class="col-md-6">
                        <label for="modalidad" class="form-label fw-semibold">Modalidad <span class="text-danger">*</span></label>
                        <select class="form-control @error('modalidad') is-invalid @enderror" name="modalidad" id="modalidad" required>
                            <option value="">-- Seleccione modalidad --</option>
                            <option value="presencial" {{ old('modalidad', $capacitacion->modalidad) == 'presencial' ? 'selected' : '' }}>Presencial</option>
                            <option value="virtual" {{ old('modalidad', $capacitacion->modalidad) == 'virtual' ? 'selected' : '' }}>Virtual</option>
                            <option value="semi virtual" {{ old('modalidad', $capacitacion->modalidad) == 'semi virtual' ? 'selected' : '' }}>Semi Virtual</option>
                            <option value="otros" {{ old('modalidad', $capacitacion->modalidad) == 'otros' ? 'selected' : '' }}>Otros</option>
                        </select>
                        @error('modalidad')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Institución --}}
                    <div class="col-md-6">
                        <label for="institucion" class="form-label fw-semibold">Institución <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('institucion') is-invalid @enderror"
                            id="institucion" name="institucion" value="{{ old('institucion', $capacitacion->institucion) }}" required>
                        @error('institucion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Dirección --}}
                    <div class="col-md-6">
                        <label for="direccion" class="form-label fw-semibold">Dirección</label>
                        <input type="text" class="form-control @error('direccion') is-invalid @enderror"
                            id="direccion" name="direccion" value="{{ old('direccion', $capacitacion->direccion) }}">
                        @error('direccion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Estado --}}
                    <div class="col-md-6">
                        <label for="estado" class="form-label fw-semibold">Estado <span class="text-danger">*</span></label>
                        <select class="form-control @error('estado') is-invalid @enderror" name="estado" id="estado" required>
                            <option value="">-- Seleccione estado --</option>
                            <option value="1" {{ old('estado', $capacitacion->estado) == '1' ? 'selected' : '' }}>Activa</option>
                            <option value="0" {{ old('estado', $capacitacion->estado) == '0' ? 'selected' : '' }}>Inactiva</option>
                        </select>
                        @error('estado')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Tabla de sesiones --}}
                <hr class="mt-5 mb-3">
                <h5 class="text-secondary mb-3 fw-semibold">Sesiones</h5>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center" id="tabla-sesiones">
                        <thead class="table-light">
                            <tr>
                                <th>Tema</th>
                                <th>Fecha</th>
                                <th>Hora de Inicio</th>
                                <th>Hora de Fin</th>
                                <th>Duración (min)</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="body-sesiones">
                            @php
                                $sesionesOld = old('sesiones', $capacitacion->sesiones ?? []);
                            @endphp

                            @if(count($sesionesOld) > 0)
                                @foreach($sesionesOld as $i => $sesion)
                                    <tr>
                                        <td><input type="text" name="sesiones[{{ $i }}][tema]" class="form-control" value="{{ $sesion['tema'] ?? $sesion->tema ?? '' }}" required></td>
                                        <td><input type="date" name="sesiones[{{ $i }}][fecha]" class="form-control" value="{{ $sesion['fecha'] ?? (isset($sesion->fecha) ? $sesion->fecha->format('Y-m-d') : '') }}" required></td>
                                        <td><input type="time" name="sesiones[{{ $i }}][hora_inicio]" class="form-control hora-inicio" value="{{ $sesion['hora_inicio'] ?? $sesion->hora_inicio ?? '' }}" required></td>
                                        <td><input type="time" name="sesiones[{{ $i }}][hora_fin]" class="form-control hora-fin" value="{{ $sesion['hora_fin'] ?? $sesion->hora_fin ?? '' }}" required></td>
                                        <td><input type="number" name="sesiones[{{ $i }}][duracion]" class="form-control duracion" value="{{ $sesion['duracion'] ?? $sesion->duracion ?? '' }}" readonly></td>
                                        <td><button type="button" class="btn btn-danger btn-sm eliminar-fila">X</button></td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td><input type="text" name="sesiones[0][tema]" class="form-control" required></td>
                                    <td><input type="date" name="sesiones[0][fecha]" class="form-control" required></td>
                                    <td><input type="time" name="sesiones[0][hora_inicio]" class="form-control hora-inicio" required></td>
                                    <td><input type="time" name="sesiones[0][hora_fin]" class="form-control hora-fin" required></td>
                                    <td><input type="number" name="sesiones[0][duracion]" class="form-control duracion" readonly></td>
                                    <td><button type="button" class="btn btn-danger btn-sm eliminar-fila">X</button></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-primary btn-sm mt-2" id="agregar-fila">+ Agregar Sesión</button>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('capacitaciones.index') }}" class="btn btn-outline-secondary me-3 px-4">Cancelar</a>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm">Actualizar Capacitación</button>
                </div>
            </form>
        </div>
    </div>
</main>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    (() => {
        'use strict';

        // Validación de formulario
        const forms = document.querySelectorAll('form[novalidate]');
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                    form.classList.add('was-validated');
                }
            }, false);
        });

        // Contador para índice de filas de sesión (establecer al último índice +1)
        let filaIndex = {{ count(old('sesiones', $capacitacion->sesiones ?? [])) }};

        // Agregar nueva fila de sesión
        document.getElementById('agregar-fila').addEventListener('click', () => {
            const nuevaFila = `
                <tr>
                    <td><input type="text" name="sesiones[${filaIndex}][tema]" class="form-control" required></td>
                    <td><input type="date" name="sesiones[${filaIndex}][fecha]" class="form-control" required></td>
                    <td><input type="time" name="sesiones[${filaIndex}][hora_inicio]" class="form-control hora-inicio" required></td>
                    <td><input type="time" name="sesiones[${filaIndex}][hora_fin]" class="form-control hora-fin" required></td>
                    <td><input type="number" name="sesiones[${filaIndex}][duracion]" class="form-control duracion" readonly></td>
                    <td><button type="button" class="btn btn-danger btn-sm eliminar-fila">X</button></td>
                </tr>`;
            document.querySelector('#body-sesiones').insertAdjacentHTML('beforeend', nuevaFila);
            filaIndex++;
        });

        // Eliminar fila
        document.querySelector('#body-sesiones').addEventListener('click', e => {
            if (e.target.classList.contains('eliminar-fila')) {
                e.target.closest('tr').remove();
                calcularDuracionTodas();
            }
        });

        // Calcular duración entre hora inicio y fin (en minutos)
        function calcularDuracion(horaInicio, horaFin) {
            if (!horaInicio || !horaFin) return 0;
            const [h1, m1] = horaInicio.split(':').map(Number);
            const [h2, m2] = horaFin.split(':').map(Number);
            let diff = (h2 * 60 + m2) - (h1 * 60 + m1);
            if (diff < 0) diff = 0;
            return diff;
        }

        // Actualizar duración al cambiar hora inicio o fin
        document.querySelector('#body-sesiones').addEventListener('change', e => {
            if (e.target.classList.contains('hora-inicio') || e.target.classList.contains('hora-fin')) {
                const fila = e.target.closest('tr');
                const horaInicio = fila.querySelector('.hora-inicio').value;
                const horaFin = fila.querySelector('.hora-fin').value;
                const duracionInput = fila.querySelector('.duracion');
                duracionInput.value = calcularDuracion(horaInicio, horaFin);
            }
        });

        // Calcular duración para todas las filas al cargar la página
        function calcularDuracionTodas() {
            document.querySelectorAll('#body-sesiones tr').forEach(fila => {
                const horaInicio = fila.querySelector('.hora-inicio').value;
                const horaFin = fila.querySelector('.hora-fin').value;
                const duracionInput = fila.querySelector('.duracion');
                duracionInput.value = calcularDuracion(horaInicio, horaFin);
            });
        }

        calcularDuracionTodas();
    })();
</script>
@stop
