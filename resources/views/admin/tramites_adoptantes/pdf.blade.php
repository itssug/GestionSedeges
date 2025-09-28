<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Trámites de Adoptantes</title>
    <style>
        @page { size: landscape; }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #000;
            color: white;
            text-align: center;
            padding: 10px;
        }

        header img {
            width: 60px;
            height: 60px;
            margin-bottom: 5px;
        }

        header h1 {
            margin: 0;
            font-size: 18px;
            color: #c9a634;
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
            margin-bottom: 10px;
        }

        table {
            width: 98%;
            margin: 0 auto 10px;
            border-collapse: collapse;
            font-size: 11px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #000;
            color: #fff;
        }

        tr:nth-child(even) td {
            background-color: #f1f1f1;
        }

        .no-data {
            text-align: center;
            font-style: italic;
            color: #888;
        }

        footer {
            background-color: #000;
            color: white;
            text-align: center;
            padding: 8px 0;
            font-size: 12px;
        }
    </style>
</head>

<body>

    <header>
        <img src="{{ public_path('vendor/adminlte/dist/img/SEDEGESLOGOBLACK.png') }}" alt="Logo">
        <h1>Servicio Departamental de Gestión Social (SEDEGES)</h1>
        <p>Reporte de Trámites de Adoptantes</p>
    </header>

    <h2>Listado de Trámites por Adoptante</h2>
    <p class="report-date">Fecha de Reporte: {{ date('d/m/Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>Nro</th>
                <th>Nombre Adoptante</th>
                <th>Apellidos</th>
                <th>Tipo de Trámite</th>
                <th>Institución</th>
                <th>Descripción</th>
                <th>Estado del Documento</th>
                <th>Observaciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tramitesAdoptantes as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->adoptante->usuario->name ?? '-' }}</td>
                    <td>{{ $item->adoptante->usuario->apellidos ?? '-' }}</td>
                    <td>{{ $item->tramite->tipo ?? '-' }}</td>
                    <td>{{ $item->tramite->institucion ?? '-' }}</td>
                    <td>{{ $item->tramite->descripcion ?? '-' }}</td>
                    <td>{{ $item->documentoAdoptante->estado_doc }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="no-data">No hay datos de trámites disponibles.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <footer>
        <p>&copy; 2025 SEDEGES - Todos los derechos reservados</p>
    </footer>

</body>

</html>
