<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Centros</title>
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
            /* Dorado */
        }

        header p {
            font-size: 12px;
            margin: 5px 0;
        }

        h2 {
            text-align: center;
            color: #50ad66;
            /* Verde */
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
            padding: 6px 10px;
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

        img.img-thumbnail,
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
        <!-- Logo -->
        <img src="{{ asset('vendor/adminlte/dist/img/SEDEGESLOGOBLACK.png') }}" alt="Logo">
        <h1>Servicio Departamental de Gestión Social (SEDEGES)</h1>
        <p>Centro de Niñez y Adolescencia</p>
    </header>

    <h2>Reporte de Postulantes de adopción Registrados</h2>

    <p class="report-date">Fecha de Reporte: {{ date('d/m/Y') }}</p>

    <div class="table-container">
        <table class="table tablesorter" id="tablaUsuarios">
            <thead class="text-primary">
                <tr>
                    <th>Nro</th>
                    <th>Fotografía</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Identificación</th>
                    <th>Contacto</th>
                    <th>Dirección (Usuario)</th>
                    <th>Email</th>
                    <th>País</th>
                    <th>Nacionalidad</th>
                    <th>Estado Civil</th>
                    <th>Nivel Educativo</th>
                    <th>Ocupación</th>
                    <th>Ingresos Mensuales</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($adoptantes as $adoptante)
                    <tr>
                        <td>{{ $adoptante->id }}</td>
                        <td class="photo-cell">
                            @if ($adoptante->user->ruta_foto && file_exists(public_path('storage/' . $adoptante->user->ruta_foto)))
                                <img src="{{ public_path('storage/' . $adoptante->user->ruta_foto) }}" alt="Foto"
                                    class="user-photo">
                            @else
                                <span>Sin foto</span>
                            @endif
                        </td>
                        <td>{{ $adoptante->user->name ?? '-' }}</td>
                        <td>{{ $adoptante->user->apellidos ?? '-' }}</td>
                        <td>{{ $adoptante->user->identificacion ?? '-' }}</td>
                        <td>{{ $adoptante->user->contacto ?? '-' }}</td>
                        <td>{{ $adoptante->user->direccion ?? '-' }}</td>
                        <td>{{ $adoptante->user->email ?? '-' }}</td>
                        <td>{{ $adoptante->pais ?? '-' }}</td>
                        <td>{{ $adoptante->nacionalidad ?? '-' }}</td>
                        <td>{{ $adoptante->estado_civil ?? '-' }}</td>
                        <td>{{ $adoptante->nivel_educativo ?? '-' }}</td>
                        <td>{{ $adoptante->ocupacion ?? '-' }}</td>
                        <td>{{ number_format($adoptante->ingresos_mensuales ?? 0, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="14" class="no-data">No hay adoptantes registrados.</td>
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
