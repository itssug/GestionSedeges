@extends('adminlte::page')

@section('title', 'Inicio - Panel Principal')

@section('content_header')
    <h1 class="text-center text-success">Bienvenido al Sistema de Gestión SEDEGES</h1>
@stop

@section('content')
    {{-- Mensaje de bienvenida --}}
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>¡Hola {{ Auth::user()->name }}!</strong> Te damos la bienvenida al sistema. Usa el panel lateral para acceder a los diferentes módulos.
    </div>

    {{-- Tarjetas resumen --}}
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $adoptantesPorEstado->sum() }}</h3>
                    <p>Adoptantes Registrados</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-friends"></i>
                </div>
                <a href="{{ route('adoptantes.index') }}" class="small-box-footer">Ver adoptantes <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-md-3">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $tramitesEstado['Entregado'] ?? 0 }}</h3>
                    <p>Trámites Completados</p>
                </div>
                <div class="icon">
                    <i class="fas fa-file-alt"></i>
                </div>
                <a href="{{ route('tramites_adoptantes.index') }}" class="small-box-footer">Ver trámites <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-md-3">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $participacionPorCapacitacion->sum() }}</h3>
                    <p>Adoptantes en Capacitaciones</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <a href="{{ route('capacitaciones.index') }}" class="small-box-footer">Ver capacitaciones <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-md-3">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ \App\Models\User::count() }}</h3>
                    <p>Usuarios del Sistema</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-shield"></i>
                </div>
                <a href="{{ route('usuarios.index') }}" class="small-box-footer">Ver usuarios <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    {{-- Gráficos --}}
    <div class="card mt-4">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title"><i class="fas fa-chart-bar"></i> Estadísticas Generales</h3>
        </div>
        <div class="card-body">
            <div class="row">
                {{-- Adoptantes por Estado --}}
                <div class="col-md-6">
                    <h5>Adoptantes por Estado</h5>
                    <canvas id="graficoAdoptantesEstado"></canvas>
                </div>

                {{-- NNA por Edad --}}
                <div class="col-md-6">
                    <h5>NNA por Edad</h5>
                    <canvas id="graficoNnaEdad"></canvas>
                </div>
            </div>

            <div class="row mt-4">
                {{-- NNA por Sexo --}}
                <div class="col-md-6">
                    <h5>NNA por Sexo</h5>
                    <canvas id="graficoNnaSexo"></canvas>
                </div>

                {{-- Trámites por Estado --}}
                <div class="col-md-6">
                    <h5>Trámites por Estado</h5>
                    <canvas id="graficoTramitesEstado"></canvas>
                </div>
            </div>

            <div class="row mt-4">
                {{-- Participación por Capacitación --}}
                <div class="col-md-6">
                    <h5>Participación en Capacitaciones</h5>
                    <canvas id="graficoParticipacionCap"></canvas>
                </div>
                {{-- Asistencias Totales --}}
                <div class="col-md-6">
                    <h5>Total de Asistencias por Capacitación</h5>
                    <canvas id="graficoAsistenciasTotales"></canvas>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .small-box .icon i {
            font-size: 3rem;
            margin-top: 10px;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const chartAdoptantesEstado = new Chart(document.getElementById('graficoAdoptantesEstado'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($adoptantesPorEstado->keys()) !!},
                datasets: [{
                    label: 'Cantidad',
                    data: {!! json_encode($adoptantesPorEstado->values()) !!},
                    backgroundColor: '#17a2b8'
                }]
            }
        });

        const chartNnaEdad = new Chart(document.getElementById('graficoNnaEdad'), {
            type: 'line',
            data: {
                labels: {!! json_encode($nnaPorEdad->keys()) !!},
                datasets: [{
                    label: 'Cantidad',
                    data: {!! json_encode($nnaPorEdad->values()) !!},
                    borderColor: '#28a745',
                    fill: false,
                    tension: 0.3
                }]
            }
        });

        const chartNnaSexo = new Chart(document.getElementById('graficoNnaSexo'), {
            type: 'pie',
            data: {
                labels: {!! json_encode($nnaPorSexo->keys()) !!},
                datasets: [{
                    data: {!! json_encode($nnaPorSexo->values()) !!},
                    backgroundColor: ['#f39c12', '#00c0ef']
                }]
            }
        });

        const chartTramites = new Chart(document.getElementById('graficoTramitesEstado'), {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($tramitesEstado->keys()) !!},
                datasets: [{
                    data: {!! json_encode($tramitesEstado->values()) !!},
                    backgroundColor: ['#28a745', '#dc3545', '#ffc107']
                }]
            }
        });

        const chartParticipacion = new Chart(document.getElementById('graficoParticipacionCap'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($participacionPorCapacitacion->keys()) !!},
                datasets: [{
                    label: 'Participantes',
                    data: {!! json_encode($participacionPorCapacitacion->values()) !!},
                    backgroundColor: '#6610f2'
                }]
            }
        });

        const chartAsistencias = new Chart(document.getElementById('graficoAsistenciasTotales'), {
            type: 'bar',
            data: {
                labels: {!! json_encode($asistenciasTotales->keys()) !!},
                datasets: [{
                    label: 'Asistencias',
                    data: {!! json_encode($asistenciasTotales->values()) !!},
                    backgroundColor: '#fd7e14'
                }]
            }
        });
    </script>
@stop
