@extends('adminlte::page')

@section('title', 'Crear Documento')

@section('content_header')
    <br>
@stop

@section('content')
<main class="container mt-4">
    <div class="card shadow rounded-4 border-0">
        <div class="card-header bg-gradient-teal text-white">
            <h4 class="mb-0 fw-semibold">Agregar nuevo documento al repositorio</h4>
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

            <form action="{{ route('documentosNnas.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf

                <div class="row g-3">
                    {{-- Selección de NNA --}}
                    <div class="col-md-6">
                        <label for="nna_id" class="form-label fw-semibold">Niño, Niña o Adolescente <span class="text-danger">*</span></label>
                        <select name="nna_id" id="nna_id" class="form-control @error('nna_id') is-invalid @enderror" required>
                            <option value="">Seleccionar NNA</option>
                            @foreach ($nnas as $nna)
                                <option value="{{ $nna->id }}" {{ old('nna_id') == $nna->id ? 'selected' : '' }}>
                                    {{ $nna->cod_nna }} - {{ $nna->nombres }} {{ $nna->apellidos }}
                                </option>
                            @endforeach
                        </select>
                        @error('nna_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Nombre del documento --}}
                    <div class="col-md-6">
                        <label for="nombre" class="form-label fw-semibold">Nombre del Documento <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre" name="nombre"
                               value="{{ old('nombre') }}" placeholder="Ingrese el nombre del documento" required>
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tipo de documentación --}}
                    <div class="col-md-6">
                        <label for="tipo" class="form-label fw-semibold">Tipo de Documentación <span class="text-danger">*</span></label>
                        <select name="tipo" id="tipo" class="form-control @error('tipo') is-invalid @enderror" required>
                            <option value="">Seleccionar tipo</option>
                            <option value="Identificación" {{ old('tipo') == 'Identificación' ? 'selected' : '' }}>Identificación</option>
                            <option value="Educación" {{ old('tipo') == 'Educación' ? 'selected' : '' }}>Educación</option>
                            <option value="Salud" {{ old('tipo') == 'Salud' ? 'selected' : '' }}>Salud</option>
                            <option value="Legal" {{ old('tipo') == 'Legal' ? 'selected' : '' }}>Legal</option>
                            <option value="Otros" {{ old('tipo') == 'Otros' ? 'selected' : '' }}>Otros</option>
                        </select>
                        @error('tipo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Fecha de emisión --}}
                    <div class="col-md-6">
                        <label for="fecha_emision" class="form-label fw-semibold">Fecha de Emisión <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('fecha_emision') is-invalid @enderror" id="fecha_emision"
                               name="fecha_emision" value="{{ old('fecha_emision') }}" required>
                        @error('fecha_emision')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Descripción --}}
                    <div class="col-12">
                        <label for="descripcion" class="form-label fw-semibold">Descripción</label>
                        <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion" rows="3"
                                  placeholder="Opcional">{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Estado --}}
                    <div class="col-md-6 d-flex align-items-end">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="estado" name="estado"
                                   value="1" {{ old('estado', '1') == '1' ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="estado">Documento vigente</label>
                        </div>
                    </div>

                    {{-- Archivo del documento --}}
                    <div class="col-md-6">
                        <label for="documento" class="form-label fw-semibold">Archivo del Documento <span class="text-danger">*</span></label>
                        <input type="file" class="form-control @error('documento') is-invalid @enderror" id="documento" name="documento" required>
                        <small class="text-muted">Formatos permitidos: PDF, DOC, DOCX, JPG, PNG (máx. 5MB)</small>
                        @error('documento')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Botones --}}
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('documentosNnas.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar Documento</button>
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
    console.log('Formulario de creación de documento cargado.');
</script>
@stop
