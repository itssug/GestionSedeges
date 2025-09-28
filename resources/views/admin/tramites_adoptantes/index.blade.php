@extends('adminlte::page')

@section('title', 'Trámites de Adoptantes')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Listado de Trámites de Adoptantes</h1>
        <div>
            <a href="{{ route('tramites_adoptantes.create') }}" class="btn btn-primary me-2">
                <i class="bi bi-plus-circle me-1"></i> Nuevo Trámite
            </a>
            <a href="{{ route('tramites_adoptantes.pdf') }}" class="btn btn-dark" target="_blank">
                <i class="bi bi-file-earmark-pdf-fill me-1"></i> Reporte PDF
            </a>
        </div>
    </div>
@stop

@section('content')
    <hr>
    <form id="formFiltrosTramites" method="GET" action="{{ route('tramites_adoptantes.index') }}" class="mb-3">
        <div class="row">
            <div class="col-md-3">
                <label>Nombre del Adoptante</label>
                <input type="text" name="nombre" value="{{ request('nombre') }}" class="form-control"
                    placeholder="Buscar por nombre">
            </div>

            <div class="col-md-3">
                <label>Apellido del Adoptante</label>
                <input type="text" name="descripcion" value="{{ request('descripcion') }}" class="form-control"
                    placeholder="Buscar por apellido">
            </div>

            <div class="col-md-3">
                <label>Tipo de Trámite</label>
                <select name="tipo" class="form-control">
                    <option value="">Todos</option>
                    <option value="legal" {{ request('tipo') == 'legal' ? 'selected' : '' }}>Legal</option>
                    <option value="administrativo" {{ request('tipo') == 'administrativo' ? 'selected' : '' }}>
                        Administrativo</option>
                    <option value="salud" {{ request('tipo') == 'salud' ? 'selected' : '' }}>Salud</option>
                </select>
            </div>

            <div class="col-md-3">
                <label>Institución</label>
                <input type="text" name="institucion" value="{{ request('institucion') }}" class="form-control"
                    placeholder="Buscar por institución">
            </div>

            <div class="col-md-3 mt-2">
                <label>Estado del Documento</label>
                <select name="estado" class="form-control">
                    <option value="">Todos</option>
                    <option value="1" {{ request('estado') === '1' ? 'selected' : '' }}>Entregado</option>
                    <option value="0" {{ request('estado') === '0' ? 'selected' : '' }}>Pendiente</option>
                </select>
            </div>

            <div class="col-md-12 mt-4 d-flex justify-content-end gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter"></i> Filtrar
                </button>

                <a href="{{ route('tramites_adoptantes.index') }}" class="btn btn-secondary">
                    <i class="fas fa-broom"></i> Limpiar
                </a>
                <button type="button" class="btn btn-danger" id="btnPdf">
                    <i class="fas fa-file-pdf"></i> Generar PDF
                </button>
            </div>
        </div>

    </form>

    <hr>
  <form method="GET" target="_blank"
      onsubmit="this.action = '{{ url('/tramites/documentos-adoptante/pdf') }}/' + this.adoptante_id.value;">
    <select name="adoptante_id" required class="form-control">
        <option value="" disabled selected>-- Selecciona --</option>
        @foreach($adoptantes as $a)
            <option value="{{ $a->id }}">{{ $a->name }}</option>
        @endforeach
    </select>
    <button type="submit" class="btn btn-primary mt-2">Ver PDF</button>
</form>

<hr>

    {{-- Tabla de Trámites --}}
    <div class="card shadow mb-4">
        <div class="card-header bg-teal text-white fw-bold">Trámites Registrados</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle table-bordered table-striped" id="tablaTramites">
                    <thead class="table-light text-center">
                        <tr>
                            <th>#</th>
                            <th>CI Adoptante</th>
                            <th>Nombre Completo</th>
                            <th>Estado Civil</th>
                            <th>Trámite</th>
                            <th>Tipo</th>
                            <th>Institución</th>
                            <th>Nombre Documento</th>
                            <th>Documento</th>
                            <th>Estado tramite</th>
                            <th>Fecha Emisión</th>
                            <th>Fecha Vencimiento</th>
                            <th>Estado documento</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tramitesAdoptantes as $tramite)
                            <tr class="text-center">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $tramite->adoptante->usuario->identificacion ?? 'N/A' }}</td>
                                <td>{{ $tramite->adoptante->usuario->name ?? 'N/A' }}
                                    {{ $tramite->adoptante->usuario->apellidos ?? '' }}</td>
                                <td>{{ $tramite->adoptante->estado_civil ?? 'N/A' }}</td>
                                <td>{{ $tramite->tramite->nombre ?? 'N/A' }}</td>

                                <td>{{ ucfirst($tramite->tramite->tipo ?? 'N/A') }}</td>
                                <td>{{ $tramite->tramite->institucion ?? 'N/A' }}</td>
                                <td>{{ $tramite->documentoAdoptante->nombre ?? 'N/A' }}</td>
                                <td>
                                    @if (!empty($tramite->documentoAdoptante->url))
                                        <a href="{{ asset('storage/' . $tramite->documentoAdoptante->url) }}"
                                            target="_blank" class="btn btn-sm btn-info">
                                            <i class="bi bi-eye-fill"></i> Ver
                                        </a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                {{-- <td>{{ $tramite->estado  }}</td> --}}

                                <td>
                                    <form action="{{ route('tramites_adoptantes.cambiarEstado', $tramite->id) }}"
                                        method="POST" style="display:inline;">
                                        @csrf
                                        @method('PATCH')

                                        @if ($tramite->estado ?? false)
                                            <button type="submit" class="btn btn-success btn-sm"
                                                title="Marcar como Pendiente">
                                                Entregado
                                            </button>
                                        @else
                                            <button type="submit" class="btn btn-warning btn-sm"
                                                title="Marcar como Entregado">
                                                Pendiente
                                            </button>
                                        @endif
                                    </form>
                                </td>
                                <td>{{ $tramite->documentoAdoptante->fecha_emision ? $tramite->documentoAdoptante->fecha_emision : 'N/A' }}
                                </td>
                                <td>{{ $tramite->documentoAdoptante->fecha_vencimiento ? $tramite->documentoAdoptante->fecha_vencimiento : 'N/A' }}
                                </td>
                                <td>
                                    @if ($tramite->documentoAdoptante->estado_doc ?? false)
                                        <span class="badge bg-success">Vigente</span>
                                    @else
                                        <span class="badge bg-warning">Vencido</span>
                                    @endif
                                </td>
                                <td>

                                    <a href="{{ route('tramites_adoptantes.edit', $tramite) }}"
                                        class="btn btn-outline-warning" title="Editar">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="12" class="text-center">No se encontraron trámites registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $tramitesAdoptantes->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#tablaTramites').DataTable({
                responsive: true,
                autoWidth: false,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
                },
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                pageLength: 10
            });
        });

        document.getElementById('btnPdf').addEventListener('click', function() {
            const form = document.getElementById('formFiltrosTramites');
            const params = new URLSearchParams(new FormData(form)).toString();
            const urlPdf = "{{ route('tramites_adoptantes.pdf') }}" + '?' + params;
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
    </script>
@stop
