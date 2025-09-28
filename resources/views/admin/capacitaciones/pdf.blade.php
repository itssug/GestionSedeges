<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Capacitaciones</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #000000;
            color: white;
            padding: 20px;
            text-align: center;
        }

        header img {
            display: block;
            margin: 0 auto 10px;
            width: 80px;
            height: 80px;
        }

        header h1 {
            margin: 0;
            color: #887c3d; /* Dorado */
        }

        header p {
            font-size: 14px;
            margin: 10px 0;
        }

        h2 {
            text-align: center;
            color: #50ad66; /* Verde */
            margin: 20px 0;
        }

        .report-date {
            text-align: center;
            font-size: 14px;
            color: #777;
            margin-bottom: 20px;
        }

        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 8px 10px;
            text-align: center;
            border: 1px solid #ddd;
            font-size: 10px;
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

        footer {
            background-color: #000000;
            color: white;
            text-align: center;
            padding: 10px 0;
            margin-top: 20px;
            font-size: 10px;
        }
    </style>
</head>
<body>

    <header>
        <img src="{{ public_path('vendor/adminlte/dist/img/SEDEGESLOGOBLACK.png') }}" alt="Logo SEDEGES">
        <h1>SEDEGES</h1>
        <p>Servicio Departamental de Gestión Social</p>
    </header>

    <h2>Reporte de Capacitaciones</h2>
    <div class="report-date">
        Fecha del Reporte: {{ \Carbon\Carbon::now()->format('d/m/Y') }}
    </div>

    @if($capacitaciones->count())
        <table>
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Fotografia</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Inicio</th>
                    <th>Fin</th>
                    <th>Duración</th>
                    <th>Modalidad</th>
                    <th>Institución</th>
                    <th>Dirección</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($capacitaciones as $i => $cap)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $cap->nombre }}</td>
                        <td>{{ $cap->descripcion }}</td>
                        <td>{{ $cap->fecha_inicio }}</td>
                        <td>{{ $cap->fecha_fin }}</td>
                        <td>{{ $cap->duracion }} hrs</td>
                        <td>{{ $cap->modalidad }}</td>
                        <td>{{ $cap->institucion }}</td>
                        <td>{{ $cap->direccion }}</td>
                        <td>{{ $cap->estado ? 'Activo' : 'Inactivo' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="no-data">No hay capacitaciones registradas.</p>
    @endif

    <footer>
        Sistema de Gestión de Capacitaciones - SEDEGES &copy; {{ date('Y') }}
    </footer>

</body>
</html>
