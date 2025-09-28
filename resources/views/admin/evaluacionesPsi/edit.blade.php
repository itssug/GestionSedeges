@extends('adminlte::page')

@section('title', 'Editar Evaluación Psicológica')

@section('content_header')
    <br>
@stop

@section('content')

    <main class="container mt-4">
        <div class="card shadow rounded-4 border-0">
            <div class="card-header bg-gradient-teal text-white">
                <h4 class="mb-0 fw-semibold">Editar Evaluación Psicológica</h4>
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

                <form action="{{ route('evaluacionesPsi.update', $evaluacion->id) }}" method="POST"
                    enctype="multipart/form-data" novalidate>
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        {{-- Selección de NNA --}}
                        <div class="col-md-6">
                            <label for="nna_id" class="form-label fw-semibold">Niño, Niña o Adolescente <span
                                    class="text-danger">*</span></label>
                            <select name="nna_id" id="nna_id" class="form-control @error('nna_id') is-invalid @enderror"
                                required>
                                <option value="">Seleccionar NNA</option>
                                @foreach ($nnas as $nna)
                                    <option value="{{ $nna->id }}"
                                        {{ old('nna_id', $evaluacion->nna_id) == $nna->id ? 'selected' : '' }}>
                                        {{ $nna->cod_nna }} - {{ $nna->nombres }} {{ $nna->apellidos }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="valid-feedback">¡Correcto!</div>
                            @error('nna_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Selección de Psicólogo --}}
                        <div class="col-md-6">
                            <label for="personal_sedeges_id" class="form-label fw-semibold">Psicólogo Responsable <span
                                    class="text-danger">*</span></label>
                            <select name="personal_sedeges_id" id="personal_sedeges_id"
                                class="form-control @error('personal_sedeges_id') is-invalid @enderror" required>
                                <option value="">Seleccionar Psicólogo</option>
                                @foreach ($psicologos as $psicologo)
                                    <option value="{{ $psicologo->id }}"
                                        {{ old('personal_sedeges_id', $evaluacion->personal_sedeges_id) == $psicologo->id ? 'selected' : '' }}>
                                        {{ $psicologo->usuario->name }} {{ $psicologo->usuario->apellidos }} (CI:
                                        {{ $psicologo->usuario->cod_usu }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="valid-feedback">¡Correcto!</div>
                            @error('personal_sedeges_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Diagnóstico --}}
                        <div class="col-12">
                            <label for="diagnostico" class="form-label fw-semibold">Diagnóstico <span
                                    class="text-danger">*</span></label>
                            <textarea name="diagnostico" id="diagnostico" class="form-control @error('diagnostico') is-invalid @enderror"
                                rows="3" placeholder="Ingrese el diagnóstico psicológico" required>{{ old('diagnostico', $evaluacion->diagnostico) }}</textarea>
                            <div class="valid-feedback">¡Correcto!</div>
                            @error('diagnostico')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Recomendaciones --}}
                        <div class="col-12">
                            <label for="recomendaciones" class="form-label fw-semibold">Recomendaciones <span
                                    class="text-danger">*</span></label>
                            <textarea name="recomendaciones" id="recomendaciones"
                                class="form-control @error('recomendaciones') is-invalid @enderror" rows="3"
                                placeholder="Ingrese las recomendaciones" required>{{ old('recomendaciones', $evaluacion->recomendaciones) }}</textarea>
                            <div class="valid-feedback">¡Correcto!</div>
                            @error('recomendaciones')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Observaciones --}}
                        <div class="col-12">
                            <label for="observaciones" class="form-label fw-semibold">Observaciones</label>
                            <textarea name="observaciones" id="observaciones" class="form-control @error('observaciones') is-invalid @enderror"
                                rows="2" placeholder="Ingrese observaciones adicionales">{{ old('observaciones', $evaluacion->observaciones) }}</textarea>
                            <div class="valid-feedback">¡Correcto!</div>
                            @error('observaciones')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Fecha de Emisión --}}
                        <div class="col-md-6">
                            <label for="fecha_emision" class="form-label fw-semibold">Fecha de Emisión <span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('fecha_emision') is-invalid @enderror"
                                id="fecha_emision" name="fecha_emision"
                                value="{{ old('fecha_emision', isset($evaluacion->documentoNna) ? \Carbon\Carbon::parse($evaluacion->documentoNna->fecha_emision)->format('Y-m-d') : '') }}"
                                required>
                            <div class="valid-feedback">¡Correcto!</div>
                            @error('fecha_emision')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        {{-- Estado --}}
                        <div class="col-md-6 d-flex align-items-end">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="estado" name="estado"
                                    value="1" {{ old('estado', $evaluacion->documentoNna->estado) ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="estado">Evaluación Vigente</label>
                            </div>
                        </div>

                        {{-- Documento adjunto --}}
                        <div class="col-12">
                            <label for="documento" class="form-label fw-semibold">Documento adjunto</label>
                            <input type="file" name="documento" id="documento"
                                class="form-control @error('documento') is-invalid @enderror"
                                accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            <div class="form-text">Formatos permitidos: PDF, DOC, DOCX, JPG, JPEG, PNG. Tamaño máximo: 5MB
                            </div>
                            @if ($evaluacion->documentoNna && $evaluacion->documentoNna->url)
                                <div class="mt-2">
                                    <span class="badge bg-info text-dark">Documento actual:</span>
                                    <a href="{{ asset('storage/' . $evaluacion->documentoNna->url) }}" target="_blank"
                                        class="ms-2">
                                        Ver documento actual
                                    </a>
                                </div>
                            @endif
                            @error('documento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('evaluacionesPsi.index') }}"
                            class="btn btn-outline-secondary me-3 px-4">Cancelar</a>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm">Guardar Cambios</button>
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
