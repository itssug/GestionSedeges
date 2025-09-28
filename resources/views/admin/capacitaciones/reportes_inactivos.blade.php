<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Capacitaciones</title>
     <style>
    body {
        font-family: 'Arial', sans-serif;
        color: #333;
        margin: 0;
        padding: 0;
        font-size: 10px;
    }

    header {
        background-color: #000;
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
        font-size: 16px;
        margin: 0;
        color: #887c3d;
    }

    header p {
        font-size: 10px;
        margin: 5px 0;
    }

    h2 {
        text-align: center;
        color: #50ad66;
        font-size: 14px;
        margin: 10px 0;
    }

    .report-date {
        text-align: center;
        font-size: 10px;
        color: #777;
        margin-bottom: 10px;
    }

    table {
        width: 100%;
        margin: 0 auto;
        border-collapse: collapse;
        font-size: 9px;
    }

    th, td {
        padding: 4px;
        text-align: center;
        border: 1px solid #999;
    }

    th {
        background-color: #000;
        color: white;
    }

    td {
        background-color: #f9f9f9;
    }

    tr:nth-child(even) td {
        background-color: #f1f1f1;
    }

    img {
        width: 40px;
        height: auto;
    }

    footer {
        background-color: #000;
        color: white;
        text-align: center;
        padding: 5px 0;
        font-size: 9px;
    }

    .btn, .form {
        display: none; /* Oculta botones/acciones al imprimir o generar PDF */
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
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Inicio</th>
                    <th>Fin</th>
                    <th>Duración</th>
                    <th>Modalidad</th>
                    <th>Institución</th>
                    <th>Dirección</th>

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
