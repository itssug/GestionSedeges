@extends('adminlte::page')

@section('title', 'Crear Trámite para Adoptante')

@section('content_header')
    <br>
@stop

@section('content')

<main class="container mt-4">
  <div class="card shadow rounded-4 border-0">
    <div class="card-header bg-gradient-teal text-white">
      <h4 class="mb-0 fw-semibold">Nuevo Trámite para Adoptante</h4>
    </div>

    <div class="card-body">
      {{-- Mostrar errores de validación --}}
      @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Por favor corrige los siguientes errores:</strong>
          <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
      @endif

      <form action="{{ route('tramites_adoptantes.store') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf

        <div class="row g-3">
          {{-- Selección de Adoptante --}}
          <div class="col-md-6">
            <label for="adoptante_id" class="form-label fw-semibold">Adoptante <span class="text-danger">*</span></label>
            <select name="adoptante_id" id="adoptante_id" class="form-control @error('adoptante_id') is-invalid @enderror" required>
              <option value="">Seleccionar Adoptante</option>
              @foreach ($adoptantes as $adoptante)
                <option value="{{ $adoptante->id }}" {{ old('adoptante_id') == $adoptante->id ? 'selected' : '' }}>
                  {{ $adoptante->usuario->cod_usu }} --- {{ $adoptante->usuario->name }}  {{ $adoptante->usuario->apellidos }}
                </option>
              @endforeach
            </select>
            <div class="valid-feedback">¡Correcto!</div>
            @error('adoptante_id')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          {{-- Selección de Trámite --}}
          <div class="col-md-6">
            <label for="tramite_id" class="form-label fw-semibold">Trámite <span class="text-danger">*</span></label>
            <select name="tramite_id" id="tramite_id" class="form-control @error('tramite_id') is-invalid @enderror" required>
              <option value="">Seleccionar Trámite</option>
              @foreach ($tramites as $tramite)
                <option value="{{ $tramite->id }}" {{ old('tramite_id') == $tramite->id ? 'selected' : '' }}>
                  {{ $tramite->nombre }}
                </option>
              @endforeach
            </select>
            <div class="valid-feedback">¡Correcto!</div>
            @error('tramite_id')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          {{-- Nombre del Documento --}}
          <div class="col-md-6">
            <label for="nombre" class="form-label fw-semibold">Nombre del Documento <span class="text-danger">*</span></label>
            <input
              type="text"
              class="form-control @error('nombre') is-invalid @enderror"
              id="nombre"
              name="nombre"
              value="{{ old('nombre') }}"
              placeholder="Ingrese el nombre del documento"
            
            >
            <div class="valid-feedback">¡Correcto!</div>
            @error('nombre')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          {{-- Tipo de Documento --}}
          <div class="col-md-6">
            <label for="tipo" class="form-label fw-semibold">Tipo de Documento <span class="text-danger">*</span></label>
            <input
              type="text"
              class="form-control @error('tipo') is-invalid @enderror"
              id="tipo"
              name="tipo"
              value="{{ old('tipo') }}"
              placeholder="Ingrese el tipo de documento"
              required
            >
            <div class="valid-feedback">¡Correcto!</div>
            @error('tipo')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          {{-- Descripción --}}
          <div class="col-12">
            <label for="descripcion" class="form-label fw-semibold">Descripción</label>
            <textarea
              name="descripcion"
              id="descripcion"
              class="form-control @error('descripcion') is-invalid @enderror"
              rows="2"
              placeholder="Ingrese una descripción del documento"
            >{{ old('descripcion') }}</textarea>
            <div class="valid-feedback">¡Correcto!</div>
            @error('descripcion')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          {{-- Fecha de Emisión --}}
          <div class="col-md-6">
            <label for="fecha_emision" class="form-label fw-semibold">Fecha de Emisión</label>
            <input
              type="date"
              class="form-control @error('fecha_emision') is-invalid @enderror"
              id="fecha_emision"
              name="fecha_emision"
              value="{{ old('fecha_emision') }}"
            >
            @error('fecha_emision')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          {{-- Fecha de Vencimiento --}}
          <div class="col-md-6">
            <label for="fecha_vencimiento" class="form-label fw-semibold">Fecha de Vencimiento</label>
            <input
              type="date"
              class="form-control @error('fecha_vencimiento') is-invalid @enderror"
              id="fecha_vencimiento"
              name="fecha_vencimiento"
              value="{{ old('fecha_vencimiento') }}"
            >
            @error('fecha_vencimiento')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          {{-- URL del Documento --}}
          <div class="col-md-12">
            <label for="url" class="form-label fw-semibold">Archivo del Documento <span class="text-danger">*</span></label>
            <input
              type="file"
              class="form-control @error('url') is-invalid @enderror"
              id="url"
              name="url"
            >
            <small class="text-muted">Formatos permitidos: PDF, DOC, DOCX, JPG, PNG (máx. 5MB)</small>
            @error('url')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="d-flex justify-content-end mt-4">
          <a href="{{ route('tramites_adoptantes.index') }}" class="btn btn-outline-secondary me-3 px-4">Cancelar</a>
          <button type="submit" class="btn btn-primary px-4 shadow-sm">Guardar Trámite</button>
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
