@extends('adminlte::page')

@section('title', 'Editar Trámite para Adoptante')

@section('content_header')
    <br>
@stop

@section('content')

    <main class="container mt-4">
        <div class="card shadow rounded-4 border-0">
            <div class="card-header bg-gradient-teal text-white">
                <h4 class="mb-0 fw-semibold">Editar Trámite para Adoptante</h4>
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

                <form action="{{ route('tramites_adoptantes.update', $tramiteAdoptante->id) }}" method="POST"
                    enctype="multipart/form-data" novalidate>
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        {{-- Selección de Adoptante --}}
                        <div class="col-md-6">
                            <label for="adoptante_id" class="form-label fw-semibold">Adoptante <span
                                    class="text-danger">*</span></label>
                            @if ($tramiteAdoptante->estado > 0)
                                <input type="text" class="form-control"
                                    value="{{ $tramiteAdoptante->adoptante->usuario->nombre }} {{ $tramiteAdoptante->adoptante->usuario->apellido }} ({{ $tramiteAdoptante->adoptante->usuario->email }})"
                                    readonly>
                                <input type="hidden" name="adoptante_id" value="{{ $tramiteAdoptante->adoptante_id }}">
                            @else
                                <select name="adoptante_id" id="adoptante_id"
                                    class="form-control @error('adoptante_id') is-invalid @enderror" required>
                                    <option value="">Seleccionar Adoptante</option>
                                    @foreach ($adoptantes as $adoptante)
                                        <option value="{{ $adoptante->id }}"
                                            {{ old('adoptante_id', $tramiteAdoptante->adoptante_id) == $adoptante->id ? 'selected' : '' }}>
                                            {{ $adoptante->usuario->nombre }} {{ $adoptante->usuario->apellido }}
                                            ({{ $adoptante->usuario->email }})
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                            <div class="valid-feedback">¡Correcto!</div>
                            @error('adoptante_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Selección de Trámite --}}
                        <div class="col-md-6">
                            <label for="tramite_id" class="form-label fw-semibold">Trámite <span
                                    class="text-danger">*</span></label>
                            @if ($tramiteAdoptante->estado > 0)
                                <input type="text" class="form-control" value="{{ $tramiteAdoptante->tramite->nombre }}"
                                    readonly>
                                <input type="hidden" name="tramite_id" value="{{ $tramiteAdoptante->tramite_id }}">
                            @else
                                <select name="tramite_id" id="tramite_id"
                                    class="form-control @error('tramite_id') is-invalid @enderror" required>
                                    <option value="">Seleccionar Trámite</option>
                                    @foreach ($tramites as $tramite)
                                        <option value="{{ $tramite->id }}"
                                            {{ old('tramite_id', $tramiteAdoptante->tramite_id) == $tramite->id ? 'selected' : '' }}>
                                            {{ $tramite->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            @endif
                            <div class="valid-feedback">¡Correcto!</div>
                            @error('tramite_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Nombre del Documento --}}
                        <div class="col-md-6">
                            <label for="nombre" class="form-label fw-semibold">Nombre del Documento <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="nombre"
                                name="nombre" value="{{ old('nombre', $tramiteAdoptante->documentoAdoptante->nombre) }}"
                                placeholder="Ingrese el nombre del documento" required>
                            <div class="valid-feedback">¡Correcto!</div>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tipo de Documento --}}
                        <div class="col-md-6">
                            <label for="tipo" class="form-label fw-semibold">Tipo de Documento <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('tipo') is-invalid @enderror" id="tipo"
                                name="tipo" value="{{ old('tipo', $tramiteAdoptante->documentoAdoptante->tipo) }}"
                                placeholder="Ingrese el tipo de documento" required>
                            <div class="valid-feedback">¡Correcto!</div>
                            @error('tipo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Descripción --}}
                        <div class="col-12">
                            <label for="descripcion" class="form-label fw-semibold">Descripción</label>
                            <textarea name="descripcion" id="descripcion" class="form-control @error('descripcion') is-invalid @enderror"
                                rows="2" placeholder="Ingrese una descripción del documento">{{ old('descripcion', $tramiteAdoptante->documentoAdoptante->descripcion) }}</textarea>
                            <div class="valid-feedback">¡Correcto!</div>
                            @error('descripcion')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Fecha_emison --}}
                        {{-- Fecha de Emisión --}}
                        <div class="col-md-6">
                            <label for="fecha_emision" class="form-label fw-semibold">Fecha de Emisión <span
                                    class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('fecha_emision') is-invalid @enderror"
                                id="fecha_emision" name="fecha_emision"
                               value="{{ old('fecha_emision', $tramiteAdoptante->documentoAdoptante->fecha_emision ?? '') }}"

                                required>
                            <div class="valid-feedback">¡Correcto!</div>
                            @error('fecha_emision')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Fecha de Vencimiento --}}
                        <div class="col-md-6">
                            <label for="fecha_vencimiento" class="form-label fw-semibold">Fecha de Vencimiento</label>
                            <input type="date" class="form-control @error('fecha_vencimiento') is-invalid @enderror"
                                id="fecha_vencimiento" name="fecha_vencimiento"
                           value="{{ old('fecha_vencimiento', $tramiteAdoptante->documentoAdoptante->fecha_vencimiento ?? '') }}">

                            <div class="valid-feedback">¡Correcto!</div>
                            @error('fecha_vencimiento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>



                        {{-- Archivo del Documento --}}
                        <div class="col-12">
                            <label for="url" class="form-label fw-semibold">Archivo del Documento (PDF, JPG, PNG) -
                                Máx: 2MB</label>
                            <input type="file" class="form-control @error('url') is-invalid @enderror" id="url"
                                name="url" accept=".pdf,.jpg,.jpeg,.png">
                            @if ($tramiteAdoptante->documentoAdoptante->url)
                                <small class="form-text text-muted mt-2">
                                    Documento actual:
                                    <a href="{{ asset('storage/' . $tramiteAdoptante->documentoAdoptante->url) }}"
                                        target="_blank" class="link-primary">Ver archivo</a>
                                </small>
                            @endif
                            <div class="valid-feedback">¡Correcto!</div>
                            @error('url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Estado --}}
                        <div class="col-md-6 mt-3">
                            <label class="form-label fw-semibold">Estado del Trámite</label>
                            <div class="form-control-plaintext">
                                @if ($tramiteAdoptante->estado == 0)
                                    <span class="badge bg-warning text-dark">Pendiente</span>
                                @elseif($tramiteAdoptante->estado == 1)
                                    <span class="badge bg-info text-white">En Proceso</span>
                                @elseif($tramiteAdoptante->estado == 2)
                                    <span class="badge bg-success text-white">Completado</span>
                                @elseif($tramiteAdoptante->estado == 3)
                                    <span class="badge bg-danger text-white">Rechazado</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('tramites_adoptantes.index') }}"
                            class="btn btn-outline-secondary me-3 px-4">Cancelar</a>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm">Actualizar Trámite</button>
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
