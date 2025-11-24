@extends('adminlte::page')

@section('title', 'Crear Capacitación')

@section('content_header')
    <br>
@stop

@section('content')
    <main class="container mt-4">
        <div class="card shadow rounded-4 border-0">
            <div class="card-header bg-teal text-white">
                <h4 class="mb-0 fw-semibold">Crear Nueva Capacitación jshada</h4>
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

                <form action="{{ route('capacitaciones.store') }}" method="POST" novalidate>
                    @csrf

                    <div class="row g-3">
                        {{-- Nombre de la capacitación --}}
                        <div class="col-md-6">
                            <label for="nombre" class="form-label fw-semibold">Nombre de la Capacitación <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre"
                                name="nombre" value="{{ old('nombre') }}" required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Descripción --}}
                        <div class="col-md-6">
                            <label for="descripcion" class="form-label fw-semibold">Descripción <span
                                    class="text-danger">*</span></label>
                            <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion"
                                rows="3" required>{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Fecha de inicio y fin --}}
                        <div class="col-md-6">
                            <label for="fecha_inicio" class="form-label fw-semibold">Fecha de Inicio <span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('fecha_inicio') is-invalid @enderror"
                                id="fecha_inicio" name="fecha_inicio" value="{{ old('fecha_inicio') }}" required>
                            @error('fecha_inicio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="fecha_fin" class="form-label fw-semibold">Fecha de Fin <span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('fecha_fin') is-invalid @enderror"
                                id="fecha_fin" name="fecha_fin" value="{{ old('fecha_fin') }}" required>
                            @error('fecha_fin')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Duración --}}
                        <div class="col-md-6">
                            <label for="duracion" class="form-label fw-semibold">Duración (en días) <span
                                    class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('duracion') is-invalid @enderror"
                                id="duracion" name="duracion" value="{{ old('duracion') }}" min="1" required>
                            @error('duracion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Modalidad --}}
                        <div class="col-md-6">
                            <label for="modalidad" class="form-label fw-semibold">Modalidad <span
                                    class="text-danger">*</span></label>
                            <select class="form-control @error('modalidad') is-invalid @enderror" name="modalidad"
                                id="modalidad" required>
                                <option value="">-- Seleccione modalidad --</option>
                                <option value="presencial" {{ old('modalidad') == 'presencial' ? 'selected' : '' }}>
                                    Presencial</option>
                                <option value="virtual" {{ old('modalidad') == 'virtual' ? 'selected' : '' }}>Virtual
                                </option>
                                <option value="semi virtual" {{ old('modalidad') == 'semi virtual' ? 'selected' : '' }}>
                                    Semi Virtual</option>
                                <option value="otros" {{ old('modalidad') == 'otros' ? 'selected' : '' }}>Otros</option>
                            </select>
                            @error('modalidad')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Institución --}}
                        <div class="col-md-6">
                            <label for="institucion" class="form-label fw-semibold">Institución <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('institucion') is-invalid @enderror"
                                id="institucion" name="institucion" value="{{ old('institucion') }}" required>
                            @error('institucion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Dirección --}}
                        <div class="col-md-6">
                            <label for="direccion" class="form-label fw-semibold">Dirección</label>
                            <input type="text" class="form-control @error('direccion') is-invalid @enderror"
                                id="direccion" name="direccion" value="{{ old('direccion') }}">
                            @error('direccion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Estado --}}
                        <div class="col-md-6">
                            <label for="estado" class="form-label fw-semibold">Estado <span
                                    class="text-danger">*</span></label>
                            <select class="form-control @error('estado') is-invalid @enderror" name="estado"
                                id="estado" required>
                                <option value="">-- Seleccione estado --</option>
                                <option value="1" {{ old('estado') == '1' ? 'selected' : '' }}>Activa</option>
                                <option value="0" {{ old('estado') == '0' ? 'selected' : '' }}>Inactiva</option>
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
                                <tr>
                                    <td><input type="text" name="sesiones[0][tema]" class="form-control" required></td>
                                    <td><input type="date" name="sesiones[0][fecha]" class="form-control" required></td>
                                    <td><input type="time" name="sesiones[0][hora_inicio]" class="form-control hora-inicio" required></td>
                                    <td><input type="time" name="sesiones[0][hora_fin]" class="form-control hora-fin" required></td>
                                    <td><input type="number" name="sesiones[0][duracion]" class="form-control duracion" readonly></td>
                                    <td><button type="button" class="btn btn-danger btn-sm eliminar-fila">X</button></td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="button" class="btn btn-primary btn-sm mt-2" id="agregar-fila">+ Agregar
                            Sesión</button>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('capacitaciones.index') }}"
                            class="btn btn-outline-secondary me-3 px-4">Cancelar</a>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm">Crear Capacitación</button>
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

        // Contador para índice de filas de sesión
        let filaIndex = 1;

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
                </tr>
            `;
            document.getElementById('body-sesiones').insertAdjacentHTML('beforeend', nuevaFila);
            filaIndex++;
        });

        // Eliminar fila de sesión
        document.getElementById('body-sesiones').addEventListener('click', (e) => {
            if (e.target.classList.contains('eliminar-fila')) {
                const filas = document.querySelectorAll('#body-sesiones tr');
                if (filas.length > 1) {
                    e.target.closest('tr').remove();
                } else {
                    Swal.fire('Atención', 'Debe haber al menos una sesión.', 'warning');
                }
            }
        });

        // Función para calcular duración en minutos entre hora fin e inicio
        function calcularDuracion(row) {
            const horaInicioInput = row.querySelector('.hora-inicio');
            const horaFinInput = row.querySelector('.hora-fin');
            const duracionInput = row.querySelector('.duracion');

            if (horaInicioInput.value && horaFinInput.value) {
                const [hIni, mIni] = horaInicioInput.value.split(':').map(Number);
                const [hFin, mFin] = horaFinInput.value.split(':').map(Number);
                let duracionMinutos = (hFin * 60 + mFin) - (hIni * 60 + mIni);

                if (duracionMinutos < 0) {
                    // Si la hora fin es menor que la inicio, asumimos que pasa a la siguiente día
                    duracionMinutos += 24 * 60;
                }
                duracionInput.value = duracionMinutos;
            } else {
                duracionInput.value = '';
            }
        }

        // Escuchar cambios en horas para calcular duración automáticamente
        document.getElementById('body-sesiones').addEventListener('change', (e) => {
            if (e.target.classList.contains('hora-inicio') || e.target.classList.contains('hora-fin')) {
                const fila = e.target.closest('tr');
                calcularDuracion(fila);
            }
        });

    })();
</script>
@stop
