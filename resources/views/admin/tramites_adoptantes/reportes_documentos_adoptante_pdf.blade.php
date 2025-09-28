<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Documentos del Adoptante</title>
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

        .info-adoptante {
            margin: 10px auto;
            width: 90%;
            font-size: 12px;
        }

        .info-adoptante p {
            margin: 4px 0;
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
        <p>Reporte de Documentos de Adoptante</p>
    </header>

    <h2>Documentos Registrados</h2>
    <p class="report-date">Fecha de Reporte: {{ date('d/m/Y') }}</p>

    <div class="info-adoptante">
        <p><strong>Nombre:</strong> {{ $adoptante->name ?? '-' }}</p>
        <p><strong>Email:</strong> {{ $adoptante->email ?? '-' }}</p>
        <p><strong>Estado:</strong> {{ $adoptante->estado ?? 'en proceso' }}</p>
        <p><strong>Teléfono:</strong> {{ $adoptante->contacto ?? '-' }}</p>
        <p><strong>Dirección:</strong> {{ $adoptante->direccion ?? '-' }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Nro</th>
                <th>Nombre Documento</th>
                <th>Tipo</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Fecha Emisión</th>
                <th>Fecha Vencimiento</th>
            </tr>
        </thead>
        <tbody>
            @forelse($documentos as $index => $doc)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $doc->nombre }}</td>
                    <td>{{ $doc->tipo }}</td>
                    <td>{{ $doc->descripcion }}</td>
                    <td>
                        @if($doc->estado == 1)
                            Entregado
                        @else
                            Pendiente
                        @endif
                    </td>
                    <td>{{ \Carbon\Carbon::parse($doc->fecha_emision)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($doc->fecha_vencimiento)->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="no-data">No hay documentos registrados para este adoptante.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <footer>
        <p>&copy; 2025 SEDEGES - Todos los derechos reservados</p>
    </footer>

</body>

</html>
