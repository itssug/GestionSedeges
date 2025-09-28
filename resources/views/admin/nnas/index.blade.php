@extends('adminlte::page')

@section('title', 'Listado de NNA')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Listado de Niños, Niñas y Adolescentes (NNA)</h1>
        <div>
    <a href="{{ route('nnas.create') }}" class="btn btn-primary me-2">
        <i class="bi bi-plus-circle me-1"></i> Nuevo Registro
    </a>

    <a href="{{ route('nnas.nna_activos.pdf') }}" class="btn btn-dark" target="_blank">
        <i class="bi bi-file-earmark-pdf-fill me-1"></i> Reporte nnas Activos
    </a>

    <a href="{{ route('nnas.nna_inactivos.pdf') }}" class="btn btn-dark" target="_blank">
        <i class="bi bi-file-earmark-pdf-fill me-1"></i> Reporte nnas Inactivos
    </a>

    {{-- <button
        type="submit"
        class="btn btn-danger"
        formaction="{{ route('nnas.filtrar.pdf') }}"
        formmethod="GET"
        form="formFiltros"
        formtarget="_blank"
    >
        <i class="bi bi-download me-1"></i> Reporte con filtros
    </button> --}}
</div>



    </div>
@stop

@section('content')
    <hr>
 <form action="{{ route('nnas.filtrar') }}" method="GET" class="mb-4" id="formFiltros">
    <div class="row">
        <!-- Campos tipo LIKE -->
        <div class="col-md-3">
            <label>Código NNA:</label>
            <input type="text" name="cod_nna" class="form-control" placeholder="Ej. NNA001" value="{{ request('cod_nna') }}">
        </div>

        <div class="col-md-3">
            <label>Nombres:</label>
            <input type="text" name="nombres" class="form-control" placeholder="Ej. Ana María" value="{{ request('nombres') }}">
        </div>

        <div class="col-md-3">
            <label>Apellidos:</label>
            <input type="text" name="apellidos" class="form-control" placeholder="Ej. Pérez López" value="{{ request('apellidos') }}">
        </div>

        <div class="col-md-3">
            <label>Identificación:</label>
            <input type="text" name="identificacion" class="form-control" value="{{ request('identificacion') }}">
        </div>

        <div class="col-md-3">
            <label>Motivo de ingreso:</label>
            <input type="text" name="motivo_ingreso" class="form-control" value="{{ request('motivo_ingreso') }}">
        </div>

        <div class="col-md-3">
            <label>Tipo de discapacidad:</label>
            <input type="text" name="tipo_discapacidad" class="form-control" value="{{ request('tipo_discapacidad') }}">
        </div>

        <!-- Campos exactos -->
        <div class="col-md-3">
            <label>Sexo:</label>
            <select name="sexo" class="form-control">
                <option value="" {{ request('sexo') == '' ? 'selected' : '' }}>Todos</option>
                <option value="femenino" {{ request('sexo') == 'femenino' ? 'selected' : '' }}>Femenino</option>
                <option value="masculino" {{ request('sexo') == 'masculino' ? 'selected' : '' }}>Masculino</option>
            </select>
        </div>

        <div class="col-md-3">
            <label>Tipo de identificación:</label>
            <input type="text" name="tipo_identificacion" class="form-control" value="{{ request('tipo_identificacion') }}">
        </div>

        <div class="col-md-3">
            <label>Nacionalidad:</label>
            <input type="text" name="nacionalidad" class="form-control" value="{{ request('nacionalidad') }}">
        </div>

        <div class="col-md-3">
            <label>Situación jurídica:</label>
            <input type="text" name="situacion_juridica" class="form-control" value="{{ request('situacion_juridica') }}">
        </div>

        <div class="col-md-3">
            <label>Nivel educativo:</label>
            <input type="text" name="nivel_educativo" class="form-control" value="{{ request('nivel_educativo') }}">
        </div>

        <div class="col-md-3">
            <label>Discapacidad:</label>
            <select name="discapacidad" class="form-control">
                <option value="" {{ request('discapacidad') == '' ? 'selected' : '' }}>Todos</option>
                <option value="1" {{ request('discapacidad') == '1' ? 'selected' : '' }}>Sí</option>
                <option value="0" {{ request('discapacidad') == '0' ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <div class="col-md-3">
            <label>Centro de acogida:</label>
            <select name="centro_id" class="form-control">
                <option value="" {{ request('centro_id') == '' ? 'selected' : '' }}>Todos</option>
                @foreach($centros as $centro)
                    <option value="{{ $centro->id }}" {{ request('centro_id') == $centro->id ? 'selected' : '' }}>
                        {{ $centro->nombre_centro }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Rangos de fechas -->
        <div class="col-md-3">
            <label>Fecha de nacimiento (inicio):</label>
            <input type="date" name="fecha_nac_inicio" class="form-control" value="{{ request('fecha_nac_inicio') }}">
        </div>

        <div class="col-md-3">
            <label>Fecha de nacimiento (fin):</label>
            <input type="date" name="fecha_nac_fin" class="form-control" value="{{ request('fecha_nac_fin') }}">
        </div>

        <div class="col-md-3">
            <label>Fecha de ingreso (inicio):</label>
            <input type="date" name="fecha_ingreso_inicio" class="form-control" value="{{ request('fecha_ingreso_inicio') }}">
        </div>

        <div class="col-md-3">
            <label>Fecha de ingreso (fin):</label>
            <input type="date" name="fecha_ingreso_fin" class="form-control" value="{{ request('fecha_ingreso_fin') }}">
        </div>

        <div class="col-md-3">
            <label>Fecha de salida:</label>
            <input type="date" name="fecha_salida" class="form-control" value="{{ request('fecha_salida') }}">
        </div>

        <!-- Botones -->
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




    {{-- Tabla NNA ACTIVOS --}}
    <div class="card shadow mb-4">
        <div class="card-header bg-teal text-white fw-bold">
            NNA Activos
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle table-bordered table-striped" id="tablaActivos">
                    <thead class="table-light text-center">
                        <tr>
                            <th>#</th>

                            <th>Código</th>
                            <th>Foto</th>
                            <th>Nombre Completo</th>

                            <th>Identificación</th>
                            <th>Centro de Acogida</th>
                            <th>Fecha Nac.</th>
                            <th>Género</th>
                            <th>Nacionalidad</th>
                            <th>Situación Jurídica</th>
                            <th>Nivel Educativo</th>
                            <th>Motivo Ingreso</th>
                            <th>Fecha Ingreso</th>
                            <th>Fecha Salida</th>
                            <th>Observaciones</th>
                            <th>Discapacidad</th>
                            <th>Tipo Discapacidad</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($nnas->where('estado', true) as $nna)
                            <tr class="text-center">
                                <td>{{ $nna->id }}</td>
                                <td>{{ $nna->cod_nna ?? '-' }}</td>
                                <td>
                                    @if ($nna->ruta_foto)
                                        <img src="{{ asset('storage/' . $nna->ruta_foto) }}" alt="Foto" width="50"
                                            style="cursor:pointer;" class="img-thumbnail fotoModalTrigger"
                                            data-foto="{{ asset('storage/' . $nna->ruta_foto) }}">
                                    @else
                                        Sin foto
                                    @endif
                                </td>
                                <td>{{ $nna->nombres }} {{ $nna->apellidos }}</td>


                                <td>{{ $nna->tipo_identificacion }}:{{ $nna->identificacion ?? '----' }}</td>

                                <td>{{ $nna->centro->nombre_centro ?? 'Sin centro' }}</td>

                                <td>{{ $nna->fecha_nac }}</td>
                                <td>{{ $nna->sexo }}</td>
                                <td>{{ $nna->nacionalidad ?? '-' }}</td>
                                <td>{{ $nna->situacion_juridica }}</td>
                                <td>{{ $nna->nivel_educativo ?? '-' }}</td>

                                <td>{{ $nna->motivo_ingreso }}</td>
                                <td>{{ $nna->fecha_ingreso ?? '-' }}</td>
                                <td>{{ $nna->fecha_salida ?? '-' }}</td>
                                <td>{{ $nna->observaciones }}</td>
                                <td>{{ $nna->discapacidad ? 'Sí' : 'No' }}</td>
                                <td>{{ $nna->tipo_discapacidad ?? '-' }}</td>
                                <td>
                                    <form action="{{ route('nnas.destroy', $nna->id) }}" method="POST" class="d-inline">

                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-success"
                                            title="Cambiar estado">Activado</button>
                                    </form>
                                </td>
                                <td>
                                    <a href="{{ route('nnas.edit', $nna) }}" class="btn btn-outline-warning"
                                        title="Editar">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                     <a href="{{ route('nnas.reporteNna', $nna->id) }}" class="btn btn-outline-primary"
                                        title="Ver Reporte PDF">
                                        <i class="bi bi-file-earmark-pdf"></i> PDF
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Tabla NNA INACTIVOS --}}
    <div class="card shadow">
        <div class="card-header bg-gray text-white fw-bold">
            NNA Inactivos
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle table-bordered table-striped" id="tablaInactivos">
                    <thead class="table-light text-center">
                        <tr>
                            <th>#</th>
                            <th>Código</th>
                            <th>Foto</th>
                            <th>Nombre Completo</th>

                            <th>Identificación</th>
                            <th>Centro de Acogida</th>
                            <th>Fecha Nac.</th>
                            <th>Género</th>
                            <th>Nacionalidad</th>
                            <th>Situación Jurídica</th>
                            <th>Nivel Educativo</th>
                            <th>Motivo Ingreso</th>
                            <th>Fecha Ingreso</th>
                            <th>Fecha Salida</th>
                            <th>Observaciones</th>
                            <th>Discapacidad</th>
                            <th>Tipo Discapacidad</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($nnas->where('estado', false) as $nna)
                            <tr class="text-center">
                                <td>{{ $nna->id }}</td>
                                <td>{{ $nna->cod_nna ?? '-' }}</td>
                                <td>
                                    @if ($nna->ruta_foto)
                                        <img src="{{ asset('storage/' . $nna->ruta_foto) }}" alt="Foto" width="50"
                                            style="cursor:pointer;" class="img-thumbnail fotoModalTrigger"
                                            data-foto="{{ asset('storage/' . $nna->ruta_foto) }}">
                                    @else
                                        Sin foto
                                    @endif
                                </td>
                                <td>{{ $nna->nombres }} {{ $nna->apellidos }}</td>
                                <td>{{ $nna->tipo_identificacion }}: {{ $nna->identificacion ?? '---' }}</td>

                                <td>{{ $nna->centro->nombre_centro ?? 'Sin centro' }}</td>

                                <td>{{ $nna->fecha_nac }}</td>
                                <td>{{ $nna->sexo }}</td>
                                <td>{{ $nna->nacionalidad ?? '-' }}</td>
                                <td>{{ $nna->situacion_juridica }}</td>
                                <td>{{ $nna->nivel_educativo ?? '-' }}</td>
                                <td>{{ $nna->motivo_ingreso }}</td>
                                <td>{{ $nna->fecha_ingreso ?? '-' }}</td>
                                <td>{{ $nna->fecha_salida ?? '-' }}</td>
                                <td>{{ $nna->observaciones }}</td>
                                <td>{{ $nna->discapacidad ? 'Sí' : 'No' }}</td>
                                <td>{{ $nna->tipo_discapacidad ?? '-' }}</td>
                                <td>
                                    <form action="{{ route('nnas.destroy', $nna->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            title="Cambiar estado">Desactivado</button>
                                    </form>
                                </td>
                                <td>
                                    <a href="{{ route('nnas.edit', $nna) }}" class="btn btn-outline-warning"
                                        title="Editar">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                     <a href="{{ route('nnas.reporteNna', $nna->id) }}" class="btn btn-outline-primary"
                                        title="Ver Reporte PDF">
                                        <i class="bi bi-file-earmark-pdf"></i> PDF
                                    </a>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="fotoModal" tabindex="-1" aria-labelledby="fotoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header  bg-teal text-white rounded-top-4 ">
                    <h5 class="modal-title" id="fotoModalLabel">Foto del NNA</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="" alt="Foto ampliada" id="fotoModalImg" class="img-fluid rounded">
                </div>
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

            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(el => new bootstrap.Tooltip(el));
        });

         document.getElementById('btnPdf').addEventListener('click', function() {
        // Obtiene el formulario
        const form = document.getElementById('formFiltros');
        // Construye los parámetros URL con los valores actuales del formulario
        const params = new URLSearchParams(new FormData(form)).toString();
        // Construye la URL para el PDF
        const urlPdf = "{{ route('nnas.filtrar.pdf') }}" + '?' + params;
        // Abre la URL en una nueva pestaña
        window.open(urlPdf, '_blank');
    });

        // Evento click en la foto para abrir modal
        $('.fotoModalTrigger').on('click', function() {
            const src = $(this).data('foto');
            $('#fotoModalImg').attr('src', src);
            const modal = new bootstrap.Modal(document.getElementById('fotoModal'));
            modal.show();
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
