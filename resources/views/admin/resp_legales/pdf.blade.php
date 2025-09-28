<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte de Responsables Legales</title>
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
            table-layout: fixed;
        }

        th, td {
            padding: 8px 10px;
            border: 1px solid #ddd;
            font-size: 10px;
            word-wrap: break-word;
            vertical-align: middle;
            text-align: center;
        }

        th {
            background-color: #000000;
            color: white;
        }

        tbody tr:nth-child(even) td {
            background-color: #f1f1f1;
        }

        tbody tr:hover td {
            background-color: #f0f0f0;
        }

        td.photo-cell {
            width: 60px;
        }

        img.user-photo {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
            display: block;
            margin: 0 auto;
            border: 1px solid #ccc;
        }

        .no-data {
            text-align: center;
            font-style: italic;
            color: #888;
            margin-top: 20px;
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

    <h2>Reporte de Responsables Legales</h2>
    <div class="report-date">
        Fecha del Reporte: {{ \Carbon\Carbon::now()->format('d/m/Y') }}
    </div>

    @if ($usuarios->count())
        <table>
            <thead>
                <tr>
                    <th style="width:30px;">N°</th>
                    <th class="photo-cell">Foto</th>
                    <th>Nombre Completo</th>
                    <th>Fecha Nac.</th>
                    <th>Identificación</th>
                    <th>Contacto</th>
                    <th>Email</th>
                    <th>Especialidad</th>
                    <th>Dirección Oficina</th>
                    <th>Horarios Atención</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $i => $user)
    <tr>
        <td>{{ $i + 1 }}</td>
        <td class="photo-cell">
            @if ($user->user->ruta_foto && file_exists(public_path('storage/' . $user->user->ruta_foto)))
                <img src="{{ public_path('storage/' . $user->user->ruta_foto) }}" alt="Foto" class="user-photo">
            @else
                <span>Sin foto</span>
            @endif
        </td>
        <td>{{ $user->user->name }} {{ $user->user->apellidos }}</td>
        <td>{{ \Carbon\Carbon::parse($user->user->fecha_nac)->format('d/m/Y') }}</td>
        <td>{{ $user->user->identificacion }}</td>
        <td>{{ $user->user->contacto }}</td>
        <td>{{ $user->user->email }}</td>
        <td>{{ $user->especialidad ?? '-' }}</td>
        <td>{{ $user->direccion_oficina ?? '-' }}</td>
        <td>{{ $user->horarios_atencion ?? '-' }}</td>
    </tr>
@endforeach
            </tbody>
        </table>
    @else
        <p class="no-data">No hay responsables legales registrados.</p>
    @endif

    <footer>
        Sistema de Gestión SEDEGES &copy; {{ date('Y') }}
    </footer>

</body>

</html>
