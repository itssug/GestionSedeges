@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    {{-- <h1 class="fw-bold text-teal">Crear Centro</h1> --}}
    <br>
@stop

@section('content')

<main class="container mt-4">
  <div class="card shadow rounded-4 border-0">
    <div class="card-header bg-gradient-teal text-white">
      <h4 class="mb-0 fw-semibold">Crear Nuevo Centro</h4>
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

      <form action="{{ route('centros.store') }}" method="POST" novalidate>
        @csrf

        <div class="row g-3">
          {{-- Código del Centro --}}
          <div class="col-md-6">
            <label for="cod_centro" class="form-label fw-semibold">Código del Centro <span class="text-danger">*</span></label>
            <input
              type="text"
              class="form-control @error('cod_centro') is-invalid @enderror"
              id="cod_centro"
              name="cod_centro"
              value="{{ old('cod_centro') }}"
              placeholder="Ingrese el código del centro"
              required
            >
            <div class="valid-feedback">¡Correcto!</div>
            @error('cod_centro')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          {{-- Nombre del Centro --}}
          <div class="col-md-6">
            <label for="nombre_centro" class="form-label fw-semibold">Nombre del Centro <span class="text-danger">*</span></label>
            <input
              type="text"
              class="form-control @error('nombre_centro') is-invalid @enderror"
              id="nombre_centro"
              name="nombre_centro"
              value="{{ old('nombre_centro') }}"
              placeholder="Ingrese el nombre del centro"
              required
            >
            <div class="valid-feedback">¡Correcto!</div>
            @error('nombre_centro')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          {{-- Dirección del Centro --}}
          <div class="col-md-6">
            <label for="direccion_centro" class="form-label fw-semibold">Dirección<span class="text-danger">*</span></label>
            <input
              type="text"
              class="form-control @error('direccion_centro') is-invalid @enderror"
              id="direccion_centro"
              name="direccion_centro"
              value="{{ old('direccion_centro') }}"
              placeholder="Ingrese la dirección"
              required
            >
            <div class="valid-feedback">¡Correcto!</div>
            @error('direccion_centro')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          {{-- Contacto --}}
          <div class="col-md-6">
            <label for="contacto" class="form-label fw-semibold">Contacto<span class="text-danger">*</span></label>
            <input
              type="text"
              class="form-control @error('contacto') is-invalid @enderror"
              id="contacto"
              name="contacto"
              value="{{ old('contacto') }}"
              placeholder="Teléfono o email"
              required
            >
            <div class="valid-feedback">¡Correcto!</div>
            @error('contacto')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          {{-- Capacidad --}}
          <div class="col-md-6">
            <label for="capacidad" class="form-label fw-semibold">Capacidad<span class="text-danger">*</span></label>
            <input
              type="number"
              class="form-control @error('capacidad') is-invalid @enderror"
              id="capacidad"
              name="capacidad"
              value="{{ old('capacidad') }}"
              placeholder="Número máximo de personas"
              required
              min="0"
            >
            <div class="valid-feedback">¡Correcto!</div>
            @error('capacidad')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="d-flex justify-content-end mt-4">
          <a href="{{ route('centros.index') }}" class="btn btn-outline-secondary me-3 px-4">Cancelar</a>
          <button type="submit" class="btn btn-primary px-4 shadow-sm">Crear Centro</button>
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
