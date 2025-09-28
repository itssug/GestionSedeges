@extends('adminlte::page')

@section('title', 'Editar Documento')

@section('content_header')
    <br>
@stop

@section('content')

<main class="container mt-4">
    <div class="card shadow rounded-4 border-0">
        <div class="card-header bg-teal text-white">
            <h4 class="mb-0 fw-semibold">Editar Datos del Documento</h4>
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

            <form action="{{ route('documentosNnas.update', $documento->id) }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                @method('PUT')

                <div class="row g-3">
                    {{-- Selección de NNA --}}
                    <div class="col-md-6">
                        <label for="nna_id" class="form-label fw-semibold">Niño, Niña o Adolescente <span class="text-danger">*</span></label>
                        <select name="nna_id" id="nna_id" class="form-control @error('nna_id') is-invalid @enderror" required>
                            <option value="">Seleccionar NNA</option>
                            @foreach ($nnas as $nna)
                                <option value="{{ $nna->id }}" {{ old('nna_id', $documento->nna_id) == $nna->id ? 'selected' : '' }}>
                                    {{ $nna->cod_nna }} - {{ $nna->nombres }} {{ $nna->apellidos }}
                                </option>
                            @endforeach
                        </select>
                        <div class="valid-feedback">¡Correcto!</div>
                        @error('nna_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tipo de Documentación --}}
                    <div class="col-md-6">
                        <label for="tipo" class="form-label fw-semibold">Tipo de Documentación <span class="text-danger">*</span></label>
                        <input type="
                        text" id="tipo" name="tipo" class="form-control @error('tipo') is-invalid @enderror"
                            value="{{ old('tipo', $documento->tipo) }}" required placeholder="Ingrese el tipo de documento">
                        <div class="valid-feedback">¡Correcto!</div>
                        @error('tipo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Nombre del Documento --}}
                    <div class="col-md-6">
                        <label for="nombre" class="form-label fw-semibold">Nombre del Documento <span class="text-danger">*</span></label>
                        <input type="text" id="nombre" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                            value="{{ old('nombre', $documento->nombre) }}" required placeholder="Ingrese el nombre del documento">
                        <div class="valid-feedback">¡Correcto!</div>
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Fecha de Emisión --}}
                    <div class="col-md-6">
                        <label for="fecha_emision" class="form-label fw-semibold">Fecha de Emisión <span class="text-danger">*</span></label>
                        <input type="date" id="fecha_emision" name="fecha_emision" class="form-control @error('fecha_emision') is-invalid @enderror"
                            value="{{ old('fecha_emision', \Carbon\Carbon::parse($documento->fecha_emision)->format('Y-m-d')) }}" required>
                        <div class="valid-feedback">¡Correcto!</div>
                        @error('fecha_emision')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Descripción --}}
                    <div class="col-12">
                        <label for="descripcion" class="form-label fw-semibold">Descripción</label>
                        <textarea id="descripcion" name="descripcion" rows="3" class="form-control @error('descripcion') is-invalid @enderror"
                            placeholder="Ingrese una descripción">{{ old('descripcion', $documento->descripcion) }}</textarea>
                        <div class="valid-feedback">¡Correcto!</div>
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Estado --}}
                    <div class="col-md-6">
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" id="estado" name="estado" value="1" {{ $documento->estado ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="estado">Documento vigente</label>
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
                            @if ($documento->url)
                                <div class="mt-2">
                                    <span class="badge bg-info text-dark">Documento actual:</span>
                                    <a href="{{ asset('storage/' . $documento->url) }}" target="_blank"
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
                    <a href="{{ route('documentosNnas.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
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
@stop
