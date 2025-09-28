@extends('adminlte::page')

@section('title', 'Responsables Legales')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Listado de Responsables Legales</h1>
        <div>
            <a href="{{ route('resp_legales.create') }}" class="btn btn-primary me-2">
                <i class="bi bi-plus-circle me-1"></i> Nuevo Responsable
            </a>
            {{-- <a href="{{ route('resp_legales.pdf') }}" class="btn btn-dark" target="_blank">
                <i class="bi bi-file-earmark-pdf-fill me-1"></i> Reporte Responsables
            </a>
            <a href="{{ route('resp_legales.responsables_activos.pdf') }}" class="btn btn-dark" target="_blank">
                <i class="bi bi-file-earmark-pdf-fill me-1"></i> Reporte Activos
            </a>
            <a href="{{ route('resp_legales.responsables_inactivos.pdf') }}" class="btn btn-dark" target="_blank">
                <i class="bi bi-file-earmark-pdf-fill me-1"></i> Reporte Inactivos
            </a> --}}
        </div>
    </div>
@stop

@section('content')
    <hr>
    <div class="row-3">
        <form action="{{ route('resp_legales.index') }}" method="GET" id="formFiltrosResponsables">
            <div class="row">
                <div class="col-md-3">
                    <label>Nombre:</label>
                    <input type="text" name="name" class="form-control" value="{{ request('name') }}">
                </div>

                <div class="col-md-3">
                    <label>Apellidos:</label>
                    <input type="text" name="apellidos" class="form-control" value="{{ request('apellidos') }}">
                </div>

                <div class="col-md-3">
                    <label>Fecha de Nacimiento:</label>
                    <input type="date" name="fecha_nac" class="form-control" value="{{ request('fecha_nac') }}">
                </div>

                <div class="col-md-3">
                    <label>Identificación:</label>
                    <input type="text" name="identificacion" class="form-control"
                        value="{{ request('identificacion') }}">
                </div>

                <div class="col-md-3">
                    <label>Contacto:</label>
                    <input type="text" name="contacto" class="form-control" value="{{ request('contacto') }}">
                </div>

                <div class="col-md-3">
                    <label>Email:</label>
                    <input type="email" name="email" class="form-control" value="{{ request('email') }}">
                </div>

                <div class="col-md-3">
                    <label>Especialidad:</label>
                    <input type="text" name="especialidad" class="form-control" value="{{ request('especialidad') }}">
                </div>

                <div class="col-md-3">
                    <label>Dirección Oficina:</label>
                    <input type="text" name="direccion_oficina" class="form-control"
                        value="{{ request('direccion_oficina') }}">
                </div>

                <div class="col-md-3">
                    <label>Horarios de Atención:</label>
                    <input type="text" name="horarios_atencion" class="form-control"
                        value="{{ request('horarios_atencion') }}">
                </div>

                <div class="col-md-3">
                    <label>Estado:</label>
                    <select name="estado_usu" class="form-control">
                        <option value="">Todos</option>
                        <option value="1" {{ request('estado') === '1' ? 'selected' : '' }}>Activo</option>
                        <option value="0" {{ request('estado') === '0' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>

                <div class="col-md-3 mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i> Filtrar
                    </button>
                    <button type="button" class="btn btn-danger" id="btnPdf">
                        <i class="bi bi-file-earmark-pdf-fill"></i> PDF
                    </button>
                </div>
            </div>
        </form>

    </div>
    <hr>

    {{-- Tabla de responsables ACTIVOS --}}
    <div class="card shadow mb-4">
        <div class="card-header bg-teal text-white fw-bold">Responsables Legales Activos</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle table-bordered table-striped" id="tablaActivas">
                    <thead class="table-light text-center">
                        <tr>
                            <th>#</th>
                            <th>CI</th>
                            <th>Fotografía</th>
                            <th>Código</th>
                            <th>Nombre Completo</th>
                            <th>Fecha Nacimiento</th>
                            <th>Correo</th>
                            <th>Contacto</th>
                            <th>Especialidad</th>
                            <th>Dirección Oficina</th>
                            <th>Horario Atención</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($resp_legales->where('user.estado_usu', true) as $resp)
                            <tr class="text-center">
                                <td>{{ $resp->id }}</td>
                                <td>{{ $resp->user->identificacion ?? 'Sin dato' }}</td>
                                <td>
                                    @if ($resp->user && $resp->user->ruta_foto)
                                        <img src="{{ asset('storage/' . $resp->user->ruta_foto) }}" alt="Foto"
                                            class="img-fluid" style="max-width: 100px; max-height: 100px;">
                                    @else
                                        <span class="text-muted">Sin foto</span>
                                    @endif
                                </td>

                                <td>{{ $resp->user->cod_usu }}</td>
                                <td>{{ $resp->user->name }} {{ $resp->user->apellidos }}</td>
                                <td>{{ $resp->user->fecha_nac }}</td>
                                <td>{{ $resp->user->email ?? '-' }}</td>
                                <td>{{ $resp->user->contacto }}</td>
                                <td>{{ $resp->especialidad }}</td>
                                <td>{{ $resp->direccion_oficina }}</td>
                                <td>{{ $resp->horarios_atencion }}</td>
                                <td>
                                    <form action="{{ route('resp_legales.destroy', $resp->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-success"
                                            title="Cambiar estado">Activo</button>
                                    </form>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('resp_legales.edit', $resp) }}"
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

    {{-- Tabla de responsables INACTIVOS --}}
    <div class="card shadow">
        <div class="card-header bg-gray text-white fw-bold">Responsables Legales Inactivos</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle table-bordered table-striped" id="tablaInactivas">
                    <thead class="table-light text-center">
                        <tr>
                            <th>#</th>
                            <th>CI</th>
                            <th>Fotografía</th>
                            <th>Código</th>
                            <th>Nombre Completo</th>
                            <th>Fecha Nacimiento</th>
                            <th>Correo</th>
                            <th>Contacto</th>
                            <th>Especialidad</th>
                            <th>Dirección Oficina</th>
                            <th>Horario Atención</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($resp_legales->where('user.estado_usu', false) as $resp)
                            <tr class="text-center">
                                <td>{{ $resp->id }}</td>
                                <td>{{ $resp->user->identificacion ?? 'Sin dato' }}</td>
                                 <td>
                                    @if ($resp->user && $resp->user->ruta_foto)
                                        <img src="{{ asset('storage/' . $resp->user->ruta_foto) }}" alt="Foto"
                                            class="img-fluid" style="max-width: 100px; max-height: 100px;">
                                    @else
                                        <span class="text-muted">Sin foto</span>
                                    @endif
                                </td>
                                <td>{{ $resp->user->cod_usu ?? 'Sin dato' }}</td>
                                <td>{{ $resp->user->name ?? 'Sin dato' }} {{ $resp->user->apellidos ?? 'Sin dato' }}</td>
                                <td>{{ $resp->user->fecha_nac ?? 'Sin dato' }}</td>
                                <td>{{ $resp->user->email ?? '-' }}</td>
                                <td>{{ $resp->user->contacto ?? 'Sin dato' }}</td>
                                <td>{{ $resp->especialidad ?? 'Sin dato' }}</td>
                                <td>{{ $resp->direccion_oficina ?? 'Sin dato' }}</td>
                                <td>{{ $resp->horarios_atencion ?? 'Sin dato' }}</td>
                                <td>
                                    <form action="{{ route('resp_legales.destroy', $resp->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            title="Cambiar estado">Inactivo</button>
                                    </form>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('resp_legales.edit', $resp) }}"
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
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
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
                const form = document.getElementById('formFiltrosResponsables');
                const params = new URLSearchParams(new FormData(form)).toString();
                const urlPdf = "{{ route('resp_legales.pdf') }}" + '?' + params;
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
