<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Requerimientos</title>
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

    <h2>Reporte de Trámites</h2>
    <div class="report-date">
        Fecha del Reporte: {{ \Carbon\Carbon::now()->format('d/m/Y') }}
    </div>

    @if($tramites->count())
        <table>
            <thead>
                <tr>
                    <th>N°</th>
                    <th>Nombre</th>
                    <th>Institucion</th>
                    <th>Descripción</th>
                    <th>Tipo</th>
                    <th>Estado</th>
        
                </tr>
            </thead>
            <tbody>
                @foreach($tramites as $i => $tramite)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $tramite->nombre }}</td>
                        <td>{{ $tramite->institucion }}</td>
                        <td>{{ $tramite->descripcion }}</td>
                        <td>{{ ucfirst($tramite->tipo) }}</td>
                        <td>{{ $tramite->estado ? 'Activo' : 'Inactivo' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="no-data">No hay trámites registrados.</p>
    @endif

    <footer>
        Sistema de Gestión de Trámites - SEDEGES &copy; {{ date('Y') }}
    </footer>

</body>
</html>
