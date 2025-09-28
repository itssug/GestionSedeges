@extends('adminlte::page')

@section('title', 'Adoptantes')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Listado de Adoptantes</h1>
        <div>
            <a href="{{ route('adoptantes.create') }}" class="btn btn-primary me-2">
                <i class="bi bi-plus-circle me-1"></i> Nuevo Adoptante
            </a>
            <a href="{{ route('adoptantes.adoptantes_activos.pdf') }}" class="btn btn-dark" target="_blank">
                <i class="bi bi-file-earmark-pdf-fill me-1"></i> Reporte Activos
            </a>

            <a href="{{ route('adoptantes.adoptantes_inactivos.pdf') }}" class="btn btn-dark" target="_blank">
                <i class="bi bi-file-earmark-pdf-fill me-1"></i> Reporte inactivos
            </a>c
        </div>
    </div>
@stop

@section('content')
    <hr>
    <div class="row-3">
       <form id="formFiltrosAdoptantes" method="GET" action="{{ route('adoptantes.index') }}" class="mb-3">
    <div class="row">

        <!-- Nombre -->
        <div class="col-md-3">
            <label>Nombre</label>
            <input type="text" name="nombre" value="{{ request('nombre') }}" class="form-control">
        </div>

        <!-- Apellidos -->
        <div class="col-md-3">
            <label>Apellidos</label>
            <input type="text" name="apellidos" value="{{ request('apellidos') }}" class="form-control">
        </div>

        <!-- Identificación -->
        <div class="col-md-3">
            <label>Identificación</label>
            <input type="text" name="identificacion" value="{{ request('identificacion') }}" class="form-control">
        </div>

        <!-- Estado Civil -->
        <div class="col-md-3">
            <label>Estado Civil</label>
            <select name="estado_civil" class="form-control">
                <option value="">Todos</option>
                <option value="Soltero/a" {{ request('estado_civil') == 'Soltero/a' ? 'selected' : '' }}>Soltero/a</option>
                <option value="Casado/a" {{ request('estado_civil') == 'Casado/a' ? 'selected' : '' }}>Casado/a</option>
                <option value="Divorciado/a" {{ request('estado_civil') == 'Divorciado/a' ? 'selected' : '' }}>Divorciado/a</option>
                <option value="Viudo/a" {{ request('estado_civil') == 'Viudo/a' ? 'selected' : '' }}>Viudo/a</option>
            </select>
        </div>

        <!-- Ocupación -->
        <div class="col-md-3 mt-2">
            <label>Ocupación</label>
            <input type="text" name="ocupacion" value="{{ request('ocupacion') }}" class="form-control">
        </div>

        <!-- País -->
        <div class="col-md-3 mt-2">
            <label>País</label>
            <input type="text" name="pais" value="{{ request('pais') }}" class="form-control">
        </div>

        <!-- Nacionalidad -->
        <div class="col-md-3 mt-2">
            <label>Nacionalidad</label>
            <input type="text" name="nacionalidad" value="{{ request('nacionalidad') }}" class="form-control">
        </div>

        <!-- Ingresos Mínimos -->
        <div class="col-md-3 mt-2">
            <label>Ingresos Mínimos</label>
            <input type="number" name="ingresos_min" value="{{ request('ingresos_min') }}" class="form-control">
        </div>

        <!-- Ingresos Máximos -->
        <div class="col-md-3 mt-2">
            <label>Ingresos Máximos</label>
            <input type="number" name="ingresos_max" value="{{ request('ingresos_max') }}" class="form-control">
        </div>

        <!-- Fecha nacimiento desde -->
        <div class="col-md-3 mt-2">
            <label>Fecha Nac. Desde</label>
            <input type="date" name="fecha_nac_desde" value="{{ request('fecha_nac_desde') }}" class="form-control">
        </div>

        <!-- Fecha nacimiento hasta -->
        <div class="col-md-3 mt-2">
            <label>Fecha Nac. Hasta</label>
            <input type="date" name="fecha_nac_hasta" value="{{ request('fecha_nac_hasta') }}" class="form-control">
        </div>

        <!-- Estado usuario -->
        <div class="col-md-3">
                    <label>Estado:</label>
                    <select name="estado_usu" class="form-control">
    <option value="">Todos</option>
    <option value="1" {{ request('estado_usu') === '1' ? 'selected' : '' }}>Activo</option>
    <option value="0" {{ request('estado_usu') === '0' ? 'selected' : '' }}>Inactivo</option>
</select>
                </div>

        <!-- BOTONES -->
        <div class="col-md-12 mt-4 d-flex justify-content-end gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-filter"></i> Filtrar
            </button>

            <a href="{{ route('adoptantes.index') }}" class="btn btn-secondary">
                <i class="fas fa-broom"></i> Limpiar
            </a>

            <button type="button" class="btn btn-danger" id="btnPdf">
                <i class="fas fa-file-pdf"></i> Generar PDF
            </button>

        </div>
    </div>
</form>
    </div>
    <hr>

    {{-- Tabla de adoptantes ACTIVOS --}}
    <div class="card shadow mb-4">
        <div class="card-header bg-teal text-white fw-bold">Adoptantes Activos</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle table-bordered table-striped" id="tablaActivas">
                    <thead class="table-light text-center">
                        <tr>
                            <th>#</th>
                            <th>Código</th>
                            <th>CI</th>
                            <th>Fotografía</th>
                            <th>Nombre Completo</th>
                            <th>Contacto</th>
                            <th>Fecha de nacimiento</th>
                            <th>Email</th>
                            <th>Dirección</th>
                            <th>País</th>
                            <th>Nacionalidad</th>
                            <th>Estado Civil</th>
                            <th>Nivel Educativo</th>
                            <th>Ocupación</th>
                            <th>Ingresos</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($adoptantes->where('user.estado_usu', true) as  $adoptante)
                            <tr class="text-center align-middle">
                                <td>{{ $adoptante->id }}</td>
                                  <td>{{ $adoptante->user->cod_usu }}</td>
                                <td>{{ $adoptante->user->identificacion }}</td>
                               <td>
                                    @if ($adoptante->user && $adoptante->user->ruta_foto)
                                        <img src="{{ asset('storage/' . $adoptante->user->ruta_foto) }}" alt="Foto"
                                            class="img-fluid" style="max-width: 100px; max-height: 100px;">
                                    @else
                                        <span class="text-muted">Sin foto</span>
                                    @endif
                                </td>
                                <td>{{ $adoptante->user->name }} {{ $adoptante->user->apellidos }}</td>
                                 <td>{{ $adoptante->user->contacto }}</td>
                                 <td>{{ $adoptante->user->fecha_nac }}</td>
                                <td>{{ $adoptante->user->email }}</td>



                                <td>{{ $adoptante->user->direccion }}</td>
                                <td>{{ $adoptante->pais }}</td>
                                <td>{{ $adoptante->nacionalidad }}</td>
                                <td>{{ $adoptante->estado_civil }}</td>
                                <td>{{ $adoptante->nivel_educativo }}</td>
                                 <td>{{ $adoptante->ocupacion }}</td>
                                <td>{{ $adoptante->ingresos_mensuales }} Bs</td>
                                <td>
                                    <form action="{{ route('adoptantes.destroy', $adoptante->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-success"
                                            title="Cambiar estado">Activo</button>
                                    </form>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('adoptantes.edit', $adoptante) }}"
                                            class="btn btn-outline-warning btn-sm" title="Editar">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Tabla de adoptantes INACTIVOS --}}
    <div class="card shadow">
        <div class="card-header bg-gray text-white fw-bold">Adoptantes Inactivos</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle table-bordered table-striped" id="tablaInactivas">
                    <thead class="table-light text-center">
                        <tr>
                            <th>#</th>
                            <th>Código</th>
                            <th>CI</th>
                            <th>Fotografía</th>
                            <th>Nombre Completo</th>
                            <th>Contacto</th>
                            <th>Fecha de nacimiento</th>
                            <th>Email</th>
                            <th>Dirección</th>
                            <th>País</th>
                            <th>Nacionalidad</th>
                            <th>Estado Civil</th>
                            <th>Nivel Educativo</th>
                            <th>Ocupación</th>
                            <th>Ingresos</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($adoptantes->where('user.estado_usu', false) as $adoptante)
                            <tr class="text-center align-middle">
                                <td>{{ $adoptante->id }}</td>
                                  <td>{{ $adoptante->user->cod_usu }}</td>
                                <td>{{ $adoptante->user->identificacion }}</td>
                               <td>
                                    @if ($adoptante->user && $adoptante->user->ruta_foto)
                                        <img src="{{ asset('storage/' . $adoptante->user->ruta_foto) }}" alt="Foto"
                                            class="img-fluid" style="max-width: 100px; max-height: 100px;">
                                    @else
                                        <span class="text-muted">Sin foto</span>
                                    @endif
                                </td>
                                <td>{{ $adoptante->user->name }} {{ $adoptante->user->apellidos }}</td>
                                 <td>{{ $adoptante->user->contacto }}</td>
                                 <td>{{ $adoptante->user->fecha_nac }}</td>
                                <td>{{ $adoptante->user->email }}</td>



                                <td>{{ $adoptante->user->direccion }}</td>
                                <td>{{ $adoptante->pais }}</td>
                                <td>{{ $adoptante->nacionalidad }}</td>
                                <td>{{ $adoptante->estado_civil }}</td>
                                <td>{{ $adoptante->nivel_educativo }}</td>
                                 <td>{{ $adoptante->ocupacion }}</td>
                                <td>{{ $adoptante->ingresos_mensuales }} Bs</td>
                                <td>
                                    <form action="{{ route('adoptantes.destroy', $adoptante->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            title="Cambiar estado">Inactivo</button>
                                    </form>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('adoptantes.edit', $adoptante) }}"
                                            class="btn btn-outline-warning btn-sm" title="Editar">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('css')


@stop

@section('js')
<script>
        $(document).ready(function() {
            $('#tablaActivas').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
                }
            });

            $('#tablaInactivas').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
                }
            });


            document.getElementById('btnPdf').addEventListener('click', function() {
                const form = document.getElementById('formFiltrosAdoptantes');
                const params = new URLSearchParams(new FormData(form)).toString();
                const urlPdf = "{{ route('adoptantes.pdf') }}" + '?' + params;
                window.open(urlPdf, '_blank');
            });



            @if (session('success'))
                Swal.fire({
                    title: '¡Éxito!',
                    text: '{{ session('success') }}',
                    icon: 'success',
                    background: '#f0fdf4',
                    color: '#198754',
                    iconColor: '#198754',
                    showConfirmButton: false,
                    timer: 2500,
                    customClass: {
                        popup: 'rounded-4 shadow-lg',
                        title: 'fw-bold fs-4'
                    },
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    }
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    title: '¡Error!',
                    text: '{{ session('error') }}',
                    icon: 'error',
                    background: '#fff0f0',
                    color: '#dc3545',
                    iconColor: '#dc3545',
                    showConfirmButton: false,
                    timer: 2500,
                    customClass: {
                        popup: 'rounded-4 shadow-lg',
                        title: 'fw-bold fs-4'
                    },
                    showClass: {
                        popup: 'animate__animated animate__shakeX'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOut'
                    }
                });
            @endif
        });
    </script>
@stop

