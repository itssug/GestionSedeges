<h2>Reporte de Asistencias por Capacitación</h2>
<p class="report-date">Capacitacióes filtradas <br> Fecha de Reporte: {{ date('d/m/Y') }}</p>

<div class="table-container">
    <table class="table tablesorter">
        <thead>
            <tr>
                <th>Nro</th>
                <th>Nombre Completo</th>
                <th>Sesión</th>
                <th>Fecha</th>
                <th>Asistencia</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($asistencias as $index => $asistencia)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $asistencia->adoptante->user->name }} {{ $asistencia->adoptante->user->apellidos }}</td>
                    <td>{{ $asistencia->sesion->tema }}</td>
                    <td>{{ $asistencia->sesion->fecha}}</td>
                    <td>
                        @if ($asistencia->asistencia)
                            <span class="badge bg-success">Asistió</span>
                        @else
                            <span class="badge bg-danger">No asistió</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="no-data">No hay registros de asistencia.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
