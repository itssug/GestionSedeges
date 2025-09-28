@extends('adminlte::page')

@section('title', 'Editar Responsable Legal')

@section('content_header')
    <br>
@stop

@section('content')
<main class="container mt-4">
  <div class="card shadow rounded-4 border-0">
    <div class="card-header bg-gradient-teal text-white">
      <h4 class="mb-0 fw-semibold">Editar Responsable Legal</h4>
    </div>

    <div class="card-body">
      @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <strong>Corrige los errores:</strong>
          <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
      @endif

      <form action="{{ route('resp_legales.update', $responsable->id) }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        @method('PUT')

        <div class="row g-3">
          {{-- Nombre --}}
          <div class="col-md-6">
            <label class="form-label fw-semibold">Nombres <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $responsable->user->name) }}" required>
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          {{-- Apellidos --}}
          <div class="col-md-6">
            <label class="form-label fw-semibold">Apellidos <span class="text-danger">*</span></label>
            <input type="text" name="apellidos" class="form-control @error('apellidos') is-invalid @enderror" value="{{ old('apellidos', $responsable->user->apellidos) }}" required>
            @error('apellidos')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          {{-- Fecha nacimiento --}}
          <div class="col-md-6">
            <label class="form-label fw-semibold">Fecha de Nacimiento <span class="text-danger">*</span></label>
            <input type="date" name="fecha_nac" class="form-control @error('fecha_nac') is-invalid @enderror" value="{{ old('fecha_nac', $responsable->user->fecha_nac) }}" required>
            @error('fecha_nac')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          {{-- Identificación --}}
          <div class="col-md-6">
            <label class="form-label fw-semibold">Identificación <span class="text-danger">*</span></label>
            <input type="text" name="identificacion" class="form-control @error('identificacion') is-invalid @enderror" value="{{ old('identificacion', $responsable->user->identificacion) }}" required>
            @error('identificacion')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          {{-- Contacto --}}
          <div class="col-md-6">
            <label class="form-label fw-semibold">Contacto <span class="text-danger">*</span></label>
            <input type="text" name="contacto" class="form-control @error('contacto') is-invalid @enderror" value="{{ old('contacto', $responsable->user->contacto) }}" required>
            @error('contacto')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          {{-- Email --}}
          <div class="col-md-6">
            <label class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $responsable->user->email) }}" required>
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          {{-- Especialidad --}}
          <div class="col-md-6">
            <label class="form-label fw-semibold">Especialidad <span class="text-danger">*</span></label>
            <input type="text" name="especialidad" class="form-control @error('especialidad') is-invalid @enderror" value="{{ old('especialidad', $responsable->especialidad) }}" required>
            @error('especialidad')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          {{-- Horarios --}}
          <div class="col-md-6">
            <label class="form-label fw-semibold">Horarios de Atención <span class="text-danger">*</span></label>
            <input type="text" name="horarios_atencion" class="form-control @error('horarios_atencion') is-invalid @enderror" value="{{ old('horarios_atencion', $responsable->horarios_atencion) }}" required>
            @error('horarios_atencion')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          {{-- Dirección oficina --}}
          <div class="col-md-6">
            <label class="form-label fw-semibold">Dirección de Oficina</label>
            <input type="text" name="direccion_oficina" class="form-control @error('direccion_oficina') is-invalid @enderror" value="{{ old('direccion_oficina', $responsable->direccion_oficina) }}">
            @error('direccion_oficina')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>

          {{-- Foto --}}
          <div class="col-md-6">
            <label class="form-label fw-semibold">Foto</label>
            <input type="file" name="ruta_foto" class="form-control @error('ruta_foto') is-invalid @enderror">
            @if($responsable->user->ruta_foto)
              <img src="{{ asset('storage/' . $responsable->user->ruta_foto) }}" alt="Foto" class="mt-2" style="max-height: 100px;">
            @endif
            @error('ruta_foto')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="d-flex justify-content-end mt-4">
          <a href="{{ route('resp_legales.index') }}" class="btn btn-outline-secondary me-3 px-4">Cancelar</a>
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
