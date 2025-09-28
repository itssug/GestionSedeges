<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <title>Reporte de Asistentes por Capacitación</title>
    <style>
        @page {
            size: landscape;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
            color: #333;
            background-color: #f4f4f4;
        }

        header {
            background-color: #000;
            color: #fff;
            text-align: center;
            padding: 10px;
        }

        header img {
            width: 60px;
            height: 60px;
            margin-bottom: 5px;
        }

        h1 {
            margin: 0;
            color: #887c3d;
            font-size: 18px;
        }

        h2 {
            text-align: center;
            color: #50ad66;
            margin: 15px 0;
            font-size: 16px;
        }

        .info-capacitacion {
            width: 90%;
            margin: 0 auto 20px auto;
            background-color: #fff;
            padding: 10px;
            border-radius: 6px;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }

        .info-capacitacion p {
            margin: 4px 0;
        }

        table {
            width: 95%;
            margin: 0 auto 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 8px 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #000;
            color: #fff;
        }

        tr:nth-child(even) {
            background-color: #f1f1f1;
        }

        img.user-photo {
            width: 50px;
            height: 50px;
            border-radius: 5px;
            object-fit: cover;
        }
    </style>
</head>

<body>

    <header>
        <img src="{{ public_path('vendor/adminlte/dist/img/SEDEGESLOGOBLACK.png') }}" alt="Logo">
        <h1>Servicio Departamental de Gestión Social (SEDEGES)</h1>
        <p>Reporte de Asistentes por Capacitación</p>
    </header>

    @if($capacitacion)
    <div class="info-capacitacion">
        <h2>{{ $capacitacion->capacitacion_nombre }}</h2>
        <p><strong>Fecha Inicio:</strong> {{ \Carbon\Carbon::parse($capacitacion->fecha_inicio)->format('d/m/Y') }}</p>
        <p><strong>Fecha Fin:</strong> {{ \Carbon\Carbon::parse($capacitacion->fecha_fin)->format('d/m/Y') }}</p>
        <p><strong>Modalidad:</strong> {{ ucfirst($capacitacion->modalidad) }}</p>
        <p><strong>Institución:</strong> {{ $capacitacion->institucion }}</p>
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Nro</th>
                <th>Foto</th>
                <th>Nombre Completo</th>
                <th>Código</th>
                <th>Tema Sesión</th>
                <th>Fecha Sesión</th>
                <th>Asistió</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reporte1 as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        @if ($item->ruta_foto && file_exists(public_path('storage/' . $item->ruta_foto)))
                            <img src="{{ public_path('storage/' . $item->ruta_foto) }}" alt="Foto" class="user-photo">
                        @else
                            <span>Sin foto</span>
                        @endif
                    </td>
                    <td>{{ $item->name }} {{ $item->apellidos }}</td>
                    <td>{{ $item->cod_usu }}</td>
                    <td>{{ $item->tema }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->fecha)->format('d/m/Y') }}</td>
                    <td>{{ $item->asistencia ? 'Sí' : 'No' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">No hay registros de asistencia.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
