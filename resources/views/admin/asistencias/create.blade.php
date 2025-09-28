@extends('adminlte::page')

@section('title', 'Crear Asistencia')

@section('content_header')
    <br>
@stop

@section('content')
<main class="container mt-4">
    <div class="card shadow rounded-4 border-0">
        <div class="card-header bg-teal text-white">
            <h4 class="mb-0 fw-semibold">Registrar Nueva Asistencia</h4>
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

            <form action="{{ route('asistencias.store') }}" method="POST" novalidate>
                @csrf

                <div class="row g-3">

                    <div class="col-md-12">
                            <label for="adoptante" class="form-label fw-semibold">Adoptante <span class="text-danger">*</span></label>
                            <select id="adoptante" name="adoptante_id" class="form-control @error('adoptante_id') is-invalid @enderror" required>
                                <option value="">-- Selecciona un adoptante --</option>
                                @foreach ($adoptantes as $adoptante)
                                    <option value="{{ $adoptante->id }}">{{ $adoptante->usuario->cod_usu }} --- {{ $adoptante->usuario->name }} {{ $adoptante->usuario->apellidos }}</option>
                                @endforeach
                            </select>
                            @error('adoptante_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    {{-- Select de capacitación --}}
                    <div class="col-md-12">
                        <label for="capacitacion_id" class="form-label fw-semibold">Capacitación <span class="text-danger">*</span></label>
                        <select id="capacitacion_id" name="capacitacion_id" class="form-control" required>
                            <option value="">-- Selecciona una capacitación --</option>
                            @foreach ($capacitaciones as $capacitacion)
                                <option value="{{ $capacitacion->id }}">{{ $capacitacion->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Select de sesión dinámico
                    <div class="col-md-12">
                        <label for="sesion" class="form-label fw-semibold">Sesión <span class="text-danger">*</span></label>
                        <select id="sesion" name="sesion_id" class="form-control" required>
                            <option value="">-- Selecciona una sesión --</option>
                        </select>
                    </div>

                    Fecha automática (readonly)
                    <div class="col-md-6">
                        <label for="fecha" class="form-label fw-semibold">Fecha <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('fecha') is-invalid @enderror" id="fecha"
                            name="fecha" value="{{ date('Y-m-d') }}" readonly>
                        @error('fecha')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    Estado
                    <div class="col-md-6">
                        <label for="asistencia" class="form-label fw-semibold">Estado <span class="text-danger">*</span></label>
                        <select class="form-control @error('asistencia') is-invalid @enderror" name="asistencia" id="asistencia" required>
                            <option value="">-- Seleccione asistencia --</option>
                            <option value="1" {{ old('asistencia') == '1' ? 'selected' : '' }}>Asistió</option>
                            <option value="0" {{ old('asistencia') == '0' ? 'selected' : '' }}>No asistió</option>
                        </select>
                        @error('asistencia')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                {{-- Botones --}}
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('asistencias.index') }}" class="btn btn-outline-secondary me-3 px-4">Cancelar</a>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm">Registrar Inscripcion</button>
                </div>
            </form>
        </div>
    </div>
</main>
@stop
@section('js')
    <script>
        document.getElementById('capacitacion_id').addEventListener('change', function () {
            const idCapacitacion = this.value;
            const sesionSelect = document.getElementById('sesion');

            sesionSelect.innerHTML = '<option value="">-- Selecciona una sesión --</option>';

            if (!idCapacitacion) return;

            fetch(`/capacitaciones/${idCapacitacion}/sesiones`)
                .then(response => {
                    if (!response.ok) throw new Error("Error en la solicitud");
                    return response.json();
                })
                .then(sesiones => {
                    sesiones.forEach(sesion => {
                        const option = document.createElement('option');
                        option.value = sesion.id;
                        option.textContent = sesion.tema;
                        sesionSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error al cargar sesiones:', error);
                    alert('Error al cargar las sesiones. Ver consola.');
                });
        });
    </script>
@stop

