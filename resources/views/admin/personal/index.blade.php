@extends('adminlte::page')

@section('title', 'Personal')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Listado de Personal</h1>
        <div>
            <a href="{{ route('personal.create') }}" class="btn btn-primary me-2">
                <i class="fa-solid fa-plus me-1"></i> Nuevo Personal
            </a>
        </div>
    </div>
@stop

@section('content')
    <hr>

    {{-- FILTROS --}}
    <form action="{{ route('personal.index') }}" method="GET" class="mb-4" id="formFiltrosPersonal">
        <div class="row g-3">
            <div class="col-md-3">
                <label>Nombre:</label>
                <input type="text" name="nombre" class="form-control" placeholder="Ej. Juan"
                    value="{{ request('nombre') }}">
            </div>
            <div class="col-md-3">
                <label>Apellidos:</label>
                <input type="text" name="apellidos" class="form-control" placeholder="Ej. Pérez"
                    value="{{ request('apellidos') }}">
            </div>
            <div class="col-md-3">
                <label>Especialidad:</label>
                <input type="text" name="especialidad" class="form-control" placeholder="Ej. Psicología"
                    value="{{ request('especialidad') }}">
            </div>
            <div class="col-md-3">
                <label>Área:</label>
                <input type="text" name="area" class="form-control" placeholder="Ej. Trabajo Social"
                    value="{{ request('area') }}">
            </div>
            <div class="col-md-3">
                <label>Rol:</label>
                <select name="rol_id" class="form-control">
                    <option value="">Todos los roles</option>
                    @foreach ($roles as $rol)
                        <option value="{{ $rol->id }}" {{ request('rol_id') == $rol->id ? 'selected' : '' }}>
                            {{ $rol->nombre_rol_per }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <label>Estado:</label>
                <select name="estado" class="form-control">
                    <option value="">Todos</option>
                    <option value="1" {{ request('estado') === '1' ? 'selected' : '' }}>Activo</option>
                    <option value="0" {{ request('estado') === '0' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-filter"></i> Filtrar
                </button>
                <button type="submit" class="btn btn-danger w-100" formaction="{{ route('personal.filtrar.pdf') }}"
                    formtarget="_blank">
                    <i class="bi bi-file-earmark-pdf-fill"></i> PDF
                </button>
            </div>
        </div>
    </form>

    {{-- TABLA PERSONAL ACTIVO --}}
    <div class="card shadow mb-4">
        <div class="card-header bg-teal text-white fw-bold">
            Personal Activo
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle table-bordered table-striped" id="tablaActivos">
                    <thead class="table-light text-center">
                        <tr>
                            <th>#</th>
                            <th>Foto</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Especialidad</th>
                            <th>Área</th>
                            <th>Fecha Ingreso</th>
                            <th>Antigüedad</th>
                            <th>Horario</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($personal->where('estado', true) as $persona)
                            <tr class="text-center">
                                <td>{{ $persona->id }}</td>
                                <td>
                                    @if ($persona->foto)
                                        <img src="{{ asset('storage/' . $persona->foto) }}" alt="Foto"
                                            class="img-thumbnail" width="60">
                                    @else
                                        <span>No Disponible</span>
                                    @endif
                                </td>
                                <td>{{ $persona->usuario->name ?? '-' }}</td>
                                <td>{{ $persona->usuario->apellidos ?? '-' }}</td>
                                <td>{{ $persona->especialidad ?? '-' }}</td>
                                <td>{{ $persona->area ?? '-' }}</td>
                                <td>{{ $persona->fecha_ingreso ?? '-' }}</td>
                                <td>{{ $persona->anios_antiguedad ?? '-' }}</td>
                                <td>{{ $persona->horario_laboral ?? '-' }}</td>
                                <td>{{ $persona->rolesPersonal->nombre_rol_per ?? 'Sin rol' }}</td>
                                {{-- <td>{{ $persona->usuario->estado_usu}}</td> --}}
                                <td>
                                    <form action="{{ route('personal.destroy', $persona->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-sm {{ $persona->usuario->estado_usu ? 'btn-success' : 'btn-danger' }}"
                                            title="Cambiar estado">
                                            {{ $persona->usuario->estado_usu ? 'Activado' : 'Desactivado' }}
                                        </button>
                                    </form>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('personal.edit', $persona->id) }}"
                                            class="btn btn-outline-warning btn-sm">
                                            <i class="fa-solid fa-pen-fancy"></i>
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

    {{-- TABLA PERSONAL INACTIVO --}}
    <div class="card shadow">
        <div class="card-header bg-gray text-white fw-bold">
            Personal Inactivo
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle table-bordered table-striped" id="tablaInactivos">
                    <thead class="table-light text-center">
                        <tr>
                            <th>#</th>
                            <th>Foto</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>Especialidad</th>
                            <th>Área</th>
                            <th>Fecha Ingreso</th>
                            <th>Antigüedad</th>
                            <th>Horario</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($personal->where('estado', false) as $persona)
                            <tr class="text-center">
                                <td>{{ $persona->id }}</td>
                                <td>
                                    @if ($persona->foto)
                                        <img src="{{ asset('storage/' . $persona->foto) }}" alt="Foto"
                                            class="img-thumbnail" width="60">
                                    @else
                                        <span>No Disponible</span>
                                    @endif
                                </td>
                                <td>{{ $persona->usuario->name ?? '-' }}</td>
                                <td>{{ $persona->usuario->apellidos ?? '-' }}</td>
                                <td>{{ $persona->especialidad ?? '-' }}</td>
                                <td>{{ $persona->area ?? '-' }}</td>
                                <td>{{ $persona->fecha_ingreso ?? '-' }}</td>
                                <td>{{ $persona->anios_antiguedad ?? '-' }}</td>
                                <td>{{ $persona->horario_laboral ?? '-' }}</td>
                                <td>{{ $persona->rolesPersonal->nombre_rol_per ?? 'Sin rol' }}</td>
                                <td>
                                    <form action="{{ route('personal.destroy', $persona->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-success"
                                            title="Cambiar estado">Activo</button>
                                    </form>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('personal.edit', $persona->id) }}"
                                            class="btn btn-outline-warning btn-sm">
                                            <i class="fa-solid fa-pen-fancy"></i>
                                        </a>
                                        <form action="{{ route('personal.destroy', $persona->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                Desactivado
                                            </button>
                                        </form>
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
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#tablaActivos').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
                }
            });

            $('#tablaInactivos').DataTable({
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
                }
            });
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
    </script>
@stop
