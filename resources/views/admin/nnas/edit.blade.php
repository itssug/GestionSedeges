@extends('adminlte::page')

@section('title', 'Editar NNA')

@section('content_header')
    <br>
@stop

@section('content')

    <main class="container mt-4">
        <div class="card shadow rounded-4 border-0">
            <div class="card-header bg-gradient-teal text-white">
                <h4 class="mb-0 fw-semibold">Editar Niña, Niño o Adolescente</h4>
            </div>

            <div class="card-body">

                <form action="{{ route('nnas.update', $nna->id) }}" method="POST" enctype="multipart/form-data" novalidate>
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        {{-- Código --}}
                        <div class="col-md-6">
                            <label for="cod_nna" class="form-label fw-semibold">Código del NNA <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('cod_nna') is-invalid @enderror" id="cod_nna"
                                name="cod_nna" value="{{ old('cod_nna', $nna->cod_nna) }}" required>
                            @error('cod_nna')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tipo de Identificación --}}
                        <div class="col-md-6">
                            <label for="tipo_identificacion" class="form-label fw-semibold">Tipo de Identificación <span
                                    class="text-danger">*</span></label>
                            <select class="form-control @error('tipo_identificacion') is-invalid @enderror"
                                id="tipo_identificacion" name="tipo_identificacion" required>
                                <option value="" disabled
                                    {{ old('tipo_identificacion', $nna->tipo_identificacion) ? '' : 'selected' }}>
                                    Seleccione...</option>
                                <option value="CI"
                                    {{ old('tipo_identificacion', $nna->tipo_identificacion) == 'CI' ? 'selected' : '' }}>CI
                                </option>
                                <option value="Pasaporte"
                                    {{ old('tipo_identificacion', $nna->tipo_identificacion) == 'Pasaporte' ? 'selected' : '' }}>
                                    Pasaporte</option>
                                <option value="Otro"
                                    {{ old('tipo_identificacion', $nna->tipo_identificacion) == 'Otro' ? 'selected' : '' }}>
                                    Otro</option>
                            </select>
                            @error('tipo_identificacion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Número de Identificación --}}
                        <div class="col-md-6">
                            <label for="identificacion" class="form-label fw-semibold">Número de Identificación</label>
                            <input type="text" class="form-control @error('identificacion') is-invalid @enderror"
                                id="identificacion" name="identificacion"
                                value="{{ old('identificacion', $nna->identificacion) }}">
                            @error('identificacion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Nombres --}}
                        <div class="col-md-6">
                            <label for="nombres" class="form-label fw-semibold">Nombres <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nombres') is-invalid @enderror" id="nombres"
                                name="nombres" value="{{ old('nombres', $nna->nombres) }}" required>
                            @error('nombres')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Apellidos --}}
                        <div class="col-md-6">
                            <label for="apellidos" class="form-label fw-semibold">Apellidos <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('apellidos') is-invalid @enderror"
                                id="apellidos" name="apellidos" value="{{ old('apellidos', $nna->apellidos) }}" required>
                            @error('apellidos')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Fecha de Nacimiento --}}
                        <div class="col-md-6">
                            <label for="fecha_nac" class="form-label fw-semibold">Fecha de Nacimiento</label>
                            <input type="date" class="form-control @error('fecha_nac') is-invalid @enderror"
                                id="fecha_nac" name="fecha_nac" value="{{ old('fecha_nac', $nna->fecha_nac) }}">
                            @error('fecha_nac')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Fecha de ingreso --}}
                        <div class="col-md-6">
                            <label for="fecha_ingreso" class="form-label fw-semibold">Fecha de Ingreso al Centro</label>
                            <input type="date" class="form-control @error('fecha_ingreso') is-invalid @enderror"
                                id="fecha_ingreso" name="fecha_ingreso"
                                value="{{ old('fecha_ingreso', $nna->fecha_ingreso) }}">
                            @error('fecha_ingreso')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Fecha de salida --}}
                        <div class="col-md-6">
                            <label for="fecha_salida" class="form-label fw-semibold">Fecha de Salida del Centro</label>
                            <input type="date" class="form-control @error('fecha_salida') is-invalid @enderror"
                                id="fecha_salida" name="fecha_salida" value="{{ old('fecha_salida', $nna->fecha_salida) }}"
                                readonly>
                            @error('fecha_salida')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Género --}}
                        <div class="col-md-6">
                            <label for="sexo" class="form-label fw-semibold">Género <span
                                    class="text-danger">*</span></label>
                            <select class="form-control @error('sexo') is-invalid @enderror" id="sexo" name="sexo"
                                required>
                                <option value="" disabled {{ old('sexo', $nna->sexo) ? '' : 'selected' }}>Seleccione
                                    género</option>
                                <option value="femenino" {{ old('sexo', $nna->sexo) == 'femenino' ? 'selected' : '' }}>
                                    Femenino</option>
                                <option value="masculino" {{ old('sexo', $nna->sexo) == 'masculino' ? 'selected' : '' }}>
                                    Masculino</option>
                            </select>
                            @error('sexo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Nacionalidad --}}
                        <div class="col-md-6">
                            <label for="nacionalidad" class="form-label fw-semibold">Nacionalidad</label>
                            <input type="text" class="form-control @error('nacionalidad') is-invalid @enderror"
                                id="nacionalidad" name="nacionalidad"
                                value="{{ old('nacionalidad', $nna->nacionalidad) }}">
                            @error('nacionalidad')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Situación Jurídica --}}
                        <div class="col-md-6">
                            <label for="situacion_juridica" class="form-label fw-semibold">Situación Jurídica</label>
                            <input type="text" class="form-control @error('situacion_juridica') is-invalid @enderror"
                                id="situacion_juridica" name="situacion_juridica"
                                value="{{ old('situacion_juridica', $nna->situacion_juridica) }}">
                            @error('situacion_juridica')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Nivel Educativo --}}
                        <div class="col-md-6">
                            <label for="nivel_educativo" class="form-label fw-semibold">Nivel Educativo <span
                                    class="text-danger">*</span></label>
                            <select class="form-control @error('nivel_educativo') is-invalid @enderror"
                                name="nivel_educativo" id="nivel_educativo" required>
                                <option value="" disabled
                                    {{ old('nivel_educativo', $nna->nivel_educativo) ? '' : 'selected' }}>Seleccione nivel
                                    educativo</option>
                                <option value="ninguno"
                                    {{ old('nivel_educativo', $nna->nivel_educativo) == 'ninguno' ? 'selected' : '' }}>
                                    Ninguno</option>
                                <option value="guarderia"
                                    {{ old('nivel_educativo', $nna->nivel_educativo) == 'guarderia' ? 'selected' : '' }}>
                                    Guardería</option>
                                <option value="kinder"
                                    {{ old('nivel_educativo', $nna->nivel_educativo) == 'kinder' ? 'selected' : '' }}>
                                    Kinder</option>
                                <option value="primaria"
                                    {{ old('nivel_educativo', $nna->nivel_educativo) == 'primaria' ? 'selected' : '' }}>
                                    Primaria</option>
                                <option value="secundaria"
                                    {{ old('nivel_educativo', $nna->nivel_educativo) == 'secundaria' ? 'selected' : '' }}>
                                    Secundaria</option>
                            </select>
                            @error('nivel_educativo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Motivo de ingreso --}}
                        <div class="col-md-6">
                            <label for="motivo_ingreso" class="form-label fw-semibold">Motivo de Ingreso</label>
                            <textarea class="form-control @error('motivo_ingreso') is-invalid @enderror" id="motivo_ingreso"
                                name="motivo_ingreso" rows="3">{{ old('motivo_ingreso', $nna->motivo_ingreso) }}</textarea>
                            @error('motivo_ingreso')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Observaciones --}}
                        <div class="col-md-6">
                            <label for="observaciones" class="form-label fw-semibold">Observaciones</label>
                            <textarea class="form-control @error('observaciones') is-invalid @enderror" id="observaciones" name="observaciones"
                                rows="3">{{ old('observaciones', $nna->observaciones) }}</textarea>
                            @error('observaciones')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- Centro --}}
                        <div class="col-md-6">
                            <label for="centro_id" class="form-label fw-semibold">Centro <span
                                    class="text-danger">*</span></label>
                            <select class="form-control @error('centro_id') is-invalid @enderror" id="centro_id"
                                name="centro_id" required>
                                <option value="" disabled {{ old('centro_id', $nna->centro_id) ? '' : 'selected' }}>
                                    Seleccione centro</option>
                                @foreach ($centros as $centro)
                                    <option value="{{ $centro->id }}"
                                        {{ old('centro_id', $nna->centro->id) == $centro->id ? 'selected' : '' }}>
                                        {{ $centro->cod_centro }} -- {{ $centro->nombre_centro }}
                                    </option>
                                @endforeach
                            </select>
                            @error('centro_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Discapacidad --}}
                        <div class="col-md-6">
                            <label for="discapacidad" class="form-label fw-semibold">¿Presenta discapacidad? <span
                                    class="text-danger">*</span></label>
                            <select class="form-control @error('discapacidad') is-invalid @enderror" id="discapacidad"
                                name="discapacidad" onchange="mostrarTipoDiscapacidad()" required>
                                <option value="" disabled
                                    {{ old('discapacidad', $nna->discapacidad) === null ? 'selected' : '' }}>Seleccione...
                                </option>
                                <option value="0"
                                    {{ old('discapacidad', $nna->discapacidad) == '0' ? 'selected' : '' }}>No</option>
                                <option value="1"
                                    {{ old('discapacidad', $nna->discapacidad) == '1' ? 'selected' : '' }}>Sí</option>
                            </select>
                            @error('discapacidad')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                <div class="valid-feedback">¡Correcto!</div>
                            @enderror
                        </div>

                        {{-- Tipo de Discapacidad - Se muestra u oculta según selección --}}
                        <div class="col-md-6" id="tipo_discapacidad_div" style="display: none;">
                            <label for="tipo_discapacidad" class="form-label fw-semibold">Tipo de discapacidad</label>
                            <input type="text" class="form-control @error('tipo_discapacidad') is-invalid @enderror"
                                id="tipo_discapacidad" name="tipo_discapacidad"
                                value="{{ old('tipo_discapacidad', $nna->tipo_discapacidad) }}"
                                placeholder="Describa el tipo de discapacidad">
                            @error('tipo_discapacidad')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                <div class="valid-feedback">¡Correcto!</div>
                            @enderror
                        </div>

                        {{-- Fotografía --}}
                        <div class="col-md-6">
                            <label for="ruta_foto" class="form-label fw-semibold">Fotografía</label>

                            {{-- Mostrar foto actual si existe --}}
                            @if (!empty($nna->ruta_foto))
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $nna->ruta_foto) }}" alt="Foto actual"
                                        style="max-width: 150px; max-height: 150px; object-fit: cover; border-radius: 5px;">
                                </div>
                            @endif

                            <input type="file" class="form-control @error('ruta_foto') is-invalid @enderror"
                                id="ruta_foto" name="ruta_foto" accept="image/*">

                            @error('ruta_foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                <div class="valid-feedback">¡Correcto!</div>
                            @enderror
                        </div>


                    </div>

                    <div class="text-end mt-4">
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                        <a href="{{ route('nnas.index') }}" class="btn btn-secondary">Cancelar</a>
                    </div>
                </form>

            </div>
        </div>
    </main>

@stop
@section('js')
    <script>
        function mostrarTipoDiscapacidad() {
            const discapacidadSelect = document.getElementById('discapacidad');
            const tipoDiv = document.getElementById('tipo_discapacidad_div');
            if (discapacidadSelect.value === '1') {
                tipoDiv.style.display = 'block';
            } else {
                tipoDiv.style.display = 'none';
                document.getElementById('tipo_discapacidad').value = '';
            }
        }
    </script>
@stop
