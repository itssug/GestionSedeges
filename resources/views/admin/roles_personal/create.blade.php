@extends('adminlte::page')  

@section('title', 'Dashboard')  

@section('content_header')  
    <h1>Crear un nuevo rol Sedeges</h1>  


@stop

@section('content')  
<main class="container mt-4">
  <div class="card shadow">
    <div class="card-header bg-primary text-white">
      <h4 class="mb-0">Crear Nuevo Rol Sedeges</h4>
    </div>

    <div class="card-body">
      <form action="{{ route('roles_personal.store') }}" method="POST">
        @csrf

        {{-- Campo: Código del rol --}}
        <div class="form-group mb-3">
          <label for="cod_rol_per">Código del Rol</label>
          <input type="text" class="form-control" id="cod_rol_per" name="cod_rol_per" placeholder="Código del rol" value="{{ old('cod_rol_per') }}" required>
        </div>

        {{-- Campo: Nombre del rol --}}
        <div class="form-group mb-4">
          <label for="nombre_rol_per">Nombre del Rol</label>
          <input type="text" class="form-control" id="nombre_rol_per" name="nombre_rol_per" placeholder="Nombre del rol" value="{{ old('nombre_rol_per') }}" required>
        </div>

        <div class="d-flex justify-content-end">
          <a href="{{ route('roles_personal.index') }}" class="btn btn-secondary me-2">Cancelar</a>
          <button type="submit" class="btn btn-primary">Crear Rol</button>
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
