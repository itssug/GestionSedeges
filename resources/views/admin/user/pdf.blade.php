<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        img.img-thumbnail {
            width: 40px;
            height: auto;
            border-radius: 4px;
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
        <img src="C:\laragon\www\AdminSedeges\public\vendor\adminlte\dist\img\SEDEGESLOGOBLACK.png" alt="Logo">
        <h1>Servicio Departamental de Gestión Social (SEDEGES)</h1>
        <p>Centro de Niñez y Adolescencia</p>
    </header>

    <h2>Reporte de Usuarios registrados</h2>

    <p class="report-date">Fecha de Reporte: {{ date('d/m/Y') }}</p>

    <div class="table-container">
        <table class="table tablesorter">
            <thead class="text-primary">
                <tr>
                    <th><center>Nro</center></th>
                    <th><center>Cod</center></th>
                    <th><center>Identificación</center></th>
                    <th><center>Nombres</center></th>
                    <th><center>Apellidos</center></th>
                    <th><center>Fecha Nacimiento</center></th>
                    <th><center>Contacto</center></th>
                    <th><center>Dirección</center></th>
                    <th><center>Email</center></th>
                    <th><center>contrasena</center></th>
                    <th><center>Rol</center></th>
                    <th><center>Estado</center></th>
                </tr>
            </thead>

            <tbody>
                @forelse ($user as $usuario)
                    <tr>
                        <td><center>{{ $usuario->id }}</center></td>
                        <td><center>{{ $usuario->cod_usu }}</center></td>
                        <td><center>{{ $usuario->identificacion }}</center></td>
                        <td><center>{{ $usuario->name }}</center></td>
                        <td><center>{{ $usuario->apellidos }}</center></td>
                        <td><center>{{ $usuario->fecha_nac ?? '-' }}</center></td>
                        <td><center>{{ $usuario->contacto }}</center></td>
                        <td><center>{{ $usuario->direccion }}</center></td>
                        <td><center>{{ $usuario->email }}</center></td>
                        <!-- Se reemplaza la contraseña por ****** -->
                        <td><center>******</center></td>
                        <td><center>{{ $usuario->rol_id }}</center></td>
                        <td><center>{{ $usuario->estado_usu }}</center></td>


                    </tr>
                @empty
                    <tr>
                        <td colspan="11"><center>No hay usuarios registrados.</center></td>
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
