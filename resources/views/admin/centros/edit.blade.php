@extends('adminlte::page')

@section('title', 'Editar Capacitación')

@section('content_header')
    <br>
@stop

@section('content')
<main class="container py-4">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow rounded-4 border-0">
        <div class="card-header bg-gradient-teal text-white">
          <h4 class="mb-0 fw-semibold">Editar Capacitación</h4>
        </div>
        <div class="card-body">
          {{-- Mostrar errores --}}
          @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong>Corrige los siguientes errores:</strong>
              <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
            </div>
          @endif

          <form action="{{ route('capacitaciones.update', $capacitacion->id) }}" method="POST" novalidate>
            @csrf
            @method('PUT')

            <div class="row g-3">
              {{-- Nombre --}}
              <div class="col-md-12">
                <label for="nombre" class="form-label fw-semibold">Nombre <span class="text-danger">*</span></label>
                <input
                  type="text"
                  class="form-control @error('nombre') is-invalid @enderror"
                  id="nombre"
                  name="nombre"
                  value="{{ old('nombre', $capacitacion->nombre) }}"
                  placeholder="Ingrese el nombre de la capacitación"
                  required
                >
                @error('nombre')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              {{-- Descripción --}}
              <div class="col-md-12">
                <label for="descripcion" class="form-label fw-semibold">Descripción <span class="text-danger">*</span></label>
                <textarea
                  class="form-control @error('descripcion') is-invalid @enderror"
                  id="descripcion"
                  name="descripcion"
                  rows="3"
                  placeholder="Ingrese la descripción de la capacitación"
                  required
                >{{ old('descripcion', $capacitacion->descripcion) }}</textarea>
                @error('descripcion')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              {{-- Fecha Inicio --}}
              <div class="col-md-6">
                <label for="fecha_inicio" class="form-label fw-semibold">Fecha Inicio <span class="text-danger">*</span></label>
                <input
                  type="date"
                  class="form-control @error('fecha_inicio') is-invalid @enderror"
                  id="fecha_inicio"
                  name="fecha_inicio"
                  value="{{ old('fecha_inicio', $capacitacion->fecha_inicio) }}"
                  required
                >
                @error('fecha_inicio')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              {{-- Fecha Fin --}}
              <div class="col-md-6">
                <label for="fecha_fin" class="form-label fw-semibold">Fecha Fin <span class="text-danger">*</span></label>
                <input
                  type="date"
                  class="form-control @error('fecha_fin') is-invalid @enderror"
                  id="fecha_fin"
                  name="fecha_fin"
                  value="{{ old('fecha_fin', $capacitacion->fecha_fin) }}"
                  required
                >
                @error('fecha_fin')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              {{-- Duración --}}
              <div class="col-md-4">
                <label for="duracion" class="form-label fw-semibold">Duración (horas) <span class="text-danger">*</span></label>
                <input
                  type="number"
                  class="form-control @error('duracion') is-invalid @enderror"
                  id="duracion"
                  name="duracion"
                  value="{{ old('duracion', $capacitacion->duracion) }}"
                  placeholder="Ingrese la duración en horas"
                  required
                  min="1"
                >
                @error('duracion')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              {{-- Modalidad --}}
              <div class="col-md-4">
                <label for="modalidad" class="form-label fw-semibold">Modalidad <span class="text-danger">*</span></label>
                <select
                  class="form-control @error('modalidad') is-invalid @enderror"
                  id="modalidad"
                  name="modalidad"
                  required
                >
                  <option value="Presencial" {{ old('modalidad', $capacitacion->modalidad) == 'Presencial' ? 'selected' : '' }}>Presencial</option>
                  <option value="Virtual" {{ old('modalidad', $capacitacion->modalidad) == 'Virtual' ? 'selected' : '' }}>Virtual</option>
                  <option value="Mixta" {{ old('modalidad', $capacitacion->modalidad) == 'Mixta' ? 'selected' : '' }}>Mixta</option>
                </select>
                @error('modalidad')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              {{-- Institución --}}
              <div class="col-md-4">
                <label for="institucion" class="form-label fw-semibold">Institución <span class="text-danger">*</span></label>
                <input
                  type="text"
                  class="form-control @error('institucion') is-invalid @enderror"
                  id="institucion"
                  name="institucion"
                  value="{{ old('institucion', $capacitacion->institucion) }}"
                  placeholder="Ingrese la institución"
                  required
                >
                @error('institucion')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>

              {{-- Dirección --}}
              <div class="col-md-12">
                <label for="direccion" class="form-label fw-semibold">Dirección <span class="text-danger">*</span></label>
                <input
                  type="text"
                  class="form-control @error('direccion') is-invalid @enderror"
                  id="direccion"
                  name="direccion"
                  value="{{ old('direccion', $capacitacion->direccion) }}"
                  placeholder="Ingrese la dirección"
                  required
                >
                @error('direccion')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <hr class="my-4">
            <h5 class="fw-semibold">Sesiones</h5>
            <table class="table table-bordered table-striped" id="tabla-sesiones">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Hora Inicio</th>
                        <th>Hora Fin</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($capacitacion->sesiones as $i => $sesion)
                        <tr>
                            <td><input type="date" name="sesiones[{{ $i }}][fecha]" class="form-control" value="{{ $sesion->fecha }}" required></td>
                            <td><input type="time" name="sesiones[{{ $i }}][hora_inicio]" class="form-control" value="{{ $sesion->hora_inicio }}" required></td>
                            <td><input type="time" name="sesiones[{{ $i }}][hora_fin]" class="form-control" value="{{ $sesion->hora_fin }}" required></td>
                            <td>
                                <input type="hidden" name="sesiones[{{ $i }}][id]" value="{{ $sesion->id }}">
                                <button type="button" class="btn btn-sm btn-danger" onclick="eliminarFila(this)">Eliminar</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <button type="button" class="btn btn-success mb-3" onclick="agregarSesion()">
                <i class="fas fa-plus"></i> Agregar Sesión
            </button>

            <div class="d-flex justify-content-end mt-4">
              <a href="{{ route('capacitaciones.index') }}" class="btn btn-outline-secondary me-3 px-4">Cancelar</a>
              <button type="submit" class="btn btn-primary px-4 shadow-sm">Actualizar Capacitación</button>
            </div>
          </form>
        </div>
      </div>
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

  let indexSesion = {{ $capacitacion->sesiones->count() }};

  function agregarSesion() {
      const tabla = document.getElementById('tabla-sesiones').getElementsByTagName('tbody')[0];
      const fila = document.createElement('tr');

      fila.innerHTML = `
          <td><input type="date" name="sesiones[${indexSesion}][fecha]" class="form-control" required></td>
          <td><input type="time" name="sesiones[${indexSesion}][hora_inicio]" class="form-control" required></td>
          <td><input type="time" name="sesiones[${indexSesion}][hora_fin]" class="form-control" required></td>
          <td><button type="button" class="btn btn-sm btn-danger" onclick="eliminarFila(this)">Eliminar</button></td>
      `;

      tabla.appendChild(fila);
      indexSesion++;
  }

  function eliminarFila(boton) {
      const fila = boton.closest('tr');
      fila.remove();
  }
</script>
@stop
