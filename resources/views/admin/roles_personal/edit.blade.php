@extends('adminlte::page')  

@section('title', 'Dashboard')  

@section('content_header')  
    <h1>Editar Rol SEDEGES</h1>  


@stop

@section('content')  

<main class="container py-4">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow rounded-3">
        <div class="card-header bg-primary text-white">
          <h4 class="mb-0">Editar Rol</h4>
        </div>
        <div class="card-body">
          <form action="{{ url('/roles_personal/' . $rol->id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Campo: Código del rol --}}
            <div class="mb-3">
              <label for="cod_rol_per" class="form-label">Código del Rol</label>
              <input 
                type="text" 
                class="form-control" 
                id="cod_rol_per" 
                name="cod_rol_per" 
                value="{{ $rol->cod_rol_per }}" 
                placeholder="Ingrese el código del rol"
                required
              >
            </div>

            {{-- Campo: Nombre del rol --}}
            <div class="mb-3">
              <label for="nombre_rol_per" class="form-label">Nombre del Rol</label>
              <input 
                type="text" 
                class="form-control" 
                id="nombre_rol_per" 
                name="nombre_rol_per" 
                value="{{ $rol->nombre_rol_per }}" 
                placeholder="Ingrese el nombre del rol"
                required
              >
            </div>

            <div class="d-flex justify-content-end">
              <a href="{{ url('/roles_personal') }}" class="btn btn-secondary me-2">Cancelar</a>
              <button type="submit" class="btn btn-primary">Guardar Cambios</button>
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
 
@stop
