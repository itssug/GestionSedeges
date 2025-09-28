<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <title>Reporte de Capacitaciones por Adoptante</title>
    <style>
        @page {
            size: landscape;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
            font-size: 12px;
        }

        header {
            background-color: #000000;
            color: white;
            padding: 10px;
            text-align: center;
        }

        header img {
            display: block;
            margin: 0 auto 5px;
            width: 60px;
            height: 60px;
        }

        header h1 {
            margin: 0;
            font-size: 18px;
            color: #887c3d;
        }

        header p {
            font-size: 12px;
            margin: 5px 0;
        }

        h2 {
            text-align: center;
            color: #50ad66;
            margin: 10px 0;
            font-size: 16px;
        }

        .report-date {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-bottom: 10px;
        }

        .table-container {
            margin: 10px;
            border-radius: 5px;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        table {
            width: 98%;
            margin: 10px auto;
            border-collapse: collapse;
            background-color: white;
            font-size: 11px;
        }

        th,
        td {
            padding: 6px 8px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #000000;
            color: white;
        }

        td {
            background-color: #f9f9f9;
        }

        tr:nth-child(even) td {
            background-color: #f1f1f1;
        }

        tr:hover td {
            background-color: #f0f0f0;
        }

        .no-data {
            text-align: center;
            font-style: italic;
            color: #888;
        }

        img.user-photo {
            width: 40px;
            height: auto;
            border-radius: 4px;
            object-fit: cover;
        }

        footer {
            background-color: #000000;
            color: white;
            text-align: center;
            padding: 8px 0;
            font-size: 12px;
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <header>
        <img src="{{ public_path('vendor/adminlte/dist/img/SEDEGESLOGOBLACK.png') }}" alt="Logo">
        <h1>Servicio Departamental de Gestión Social (SEDEGES)</h1>
        <p>Capacitaciones de Adoptantes</p>
    </header>

    <h2>Reporte de Capacitaciones por Adoptante</h2>
    <p class="report-date">Fecha de Reporte: {{ date('d/m/Y') }}</p>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Nro</th>
                    <th>Foto</th>
                    <th>Nombre Completo</th>
                    <th>Código</th>
                    <th>Capacitación</th>
                    <th>Institución</th>
                    <th>Modalidad</th>
                    <th>Sesión</th>
                    <th>Fecha Sesión</th>
                    <th>Asistió</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reporte2 as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            @if ($item->ruta_foto && file_exists(public_path('storage/' . $item->ruta_foto)))
                                <img src="{{ public_path('storage/' . $item->ruta_foto) }}" class="user-photo" alt="Foto">
                            @else
                                <span>Sin foto</span>
                            @endif
                        </td>
                        <td>{{ $item->name }} {{ $item->apellidos }}</td>
                        <td>{{ $item->cod_usu }}</td>
                        <td>{{ $item->capacitacion_nombre }}</td>
                        <td>{{ $item->institucion }}</td>
                        <td>{{ ucfirst($item->modalidad) }}</td>
                        <td>{{ $item->tema }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->fecha)->format('d/m/Y') }}</td>
                        <td>{{ $item->asistencia ? 'Sí' : 'No' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="no-data">No hay registros de asistencias.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <footer>
        <p>&copy; 2025 SEDEGES - Todos los derechos reservados</p>
    </footer>

</body>

</html>
