@extends('adminlte::page')

@section('title', 'Crear Trámite')

@section('content_header')
    <br>
@stop

@section('content')

<main class="container mt-4">
  <div class="card shadow rounded-4 border-0">
    <div class="card-header bg-gradient-teal text-white">
      <h4 class="mb-0 fw-semibold">Crear Nuevo Requerimiento</h4>
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

      <form action="{{ route('tramites.store') }}" method="POST" novalidate>
        @csrf

        <div class="row g-3">
          {{-- Nombre del Trámite --}}
          <div class="col-md-6">
            <label for="nombre" class="form-label fw-semibold">Nombre del Trámite <span class="text-danger">*</span></label>
            <input
              type="text"
              class="form-control @error('nombre') is-invalid @enderror"
              id="nombre"
              name="nombre"
              value="{{ old('nombre') }}"
              placeholder="Ingrese el nombre del trámite"
              required
            >
            <div class="valid-feedback">¡Correcto!</div>
            @error('nombre')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          {{-- Tipo de Trámite --}}
          <div class="col-md-6">
            <label for="tipo" class="form-label fw-semibold">Tipo de Trámite <span class="text-danger">*</span></label>
            <select
              class="form-control @error('tipo') is-invalid @enderror"
              id="tipo"
              name="tipo"
              required
            >
              <option value="" selected disabled>Seleccione un tipo</option>
              <option value="legal" {{ old('tipo') == 'legal' ? 'selected' : '' }}>Legal</option>
              <option value="administrativo" {{ old('tipo') == 'administrativo' ? 'selected' : '' }}>Administrativo</option>
              <option value="judicial" {{ old('tipo') == 'judicial' ? 'selected' : '' }}>Judicial</option>
              <option value="medico" {{ old('tipo') == 'medico' ? 'selected' : '' }}>Medico</option>
            </select>
            <div class="valid-feedback">¡Correcto!</div>
            @error('tipo')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="col-md-6">
            <label for="institucion" class="form-label fw-semibold">Institucion <span class="text-danger">*</span></label>
            <input
              type="text"
              class="form-control @error('institucion') is-invalid @enderror"
              id="institucion"
              name="institucion"
              value="{{ old('institucion') }}"
              placeholder="Ingrese el institucion responsable del trámite"
              required
            >
            <div class="valid-feedback">¡Correcto!</div>
            @error('institucion')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          {{-- Descripción --}}
          <div class="col-12">
            <label for="descripcion" class="form-label fw-semibold">Descripción <span class="text-danger">*</span></label>
            <textarea
              class="form-control @error('descripcion') is-invalid @enderror"
              id="descripcion"
              name="descripcion"
              rows="3"
              placeholder="Ingrese una descripción detallada del trámite"
              required
            >{{ old('descripcion') }}</textarea>
            <div class="valid-feedback">¡Correcto!</div>
            @error('descripcion')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          {{-- Estado --}}
          <div class="col-md-6">
            <label class="form-label fw-semibold">Estado <span class="text-danger">*</span></label>
            <div class="form-check">
              <input
                class="form-check-input @error('estado') is-invalid @enderror"
                type="radio"
                name="estado"
                id="estado_activo"
                value="1"
                {{ old('estado', true) ? 'checked' : '' }}
                required
              >
              <label class="form-check-label" for="estado_activo">
                Activo
              </label>
            </div>
            <div class="form-check">
              <input
                class="form-check-input @error('estado') is-invalid @enderror"
                type="radio"
                name="estado"
                id="estado_inactivo"
                value="0"
                {{ old('estado') === '0' ? 'checked' : '' }}
              >
              <label class="form-check-label" for="estado_inactivo">
                Inactivo
              </label>
              @error('estado')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>

        <div class="d-flex justify-content-end mt-4">
          <a href="{{ route('tramites.index') }}" class="btn btn-outline-secondary me-3 px-4">Cancelar</a>
          <button type="submit" class="btn btn-primary px-4 shadow-sm">Crear Trámite</button>
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
