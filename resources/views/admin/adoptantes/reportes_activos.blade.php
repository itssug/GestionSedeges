<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADOPTANTES</title>
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
        <!-- Logo -->
        <img src="C:\laragon\www\AdminSedeges\public\vendor\adminlte\dist\img\SEDEGESLOGOBLACK.png" alt="Logo">
        <h1>Servicio Departamental de Gestión Social (SEDEGES)</h1>
        <p>Centro de Niñez y Adolescencia</p>
    </header>

    <h2>Reporte de Postulantes de adopcion Activo</h2>

    <p class="report-date">Fecha de Reporte: {{ date('d/m/Y') }}</p>

    <div class="table-container">
        <table class="table tablesorter" id="tablaUsuarios">
            <thead class="text-primary">
                <tr>
                    <th>
                        <center>Nro</center>
                    </th>
                    <th>
                        <center>Nombre</center>
                    </th>
                    <th>
                        <center>Apellidos</center>
                    </th>
                    <th>
                        <center>Identificación</center>
                    </th>
                    <th>
                        <center>Contacto</center>
                    </th>
                    <th>
                        <center>Dirección (Usuario)</center>
                    </th>
                    <th>
                        <center>Email</center>
                    </th>
                    <th>
                        <center>Dirección </center>
                    </th>
                    <th>
                        <center>Foto</center>
                    </th>
                    <th>
                        <center>País</center>
                    </th>
                    <th>
                        <center>Nacionalidad</center>
                    </th>
                    <th>
                        <center>Estado Civil</center>
                    </th>
                    <th>
                        <center>Nivel Educativo</center>
                    </th>
                    <th>
                        <center>Ocupación</center>
                    </th>
                    <th>
                        <center>Ingresos Mensuales</center>
                    </th>

                </tr>
            </thead>

            <tbody>
                @forelse ($adoptantes as $adoptante)
                    <tr>
                        <td>
                            <center>{{ $adoptante->id }}</center>
                        </td>
                        <td>
                            <center>{{ $adoptante->usuario->name ?? '-' }}</center>
                        </td>
                        <td>
                            <center>{{ $adoptante->usuario->apellidos ?? '-' }}</center>
                        </td>
                        <td>
                            <center>{{ $adoptante->usuario->identificacion ?? '-' }}</center>
                        </td>
                        <td>
                            <center>{{ $adoptante->usuario->contacto ?? '-' }}</center>
                        </td>
                        <td>
                            <center>{{ $adoptante->usuario->direccion ?? '-' }}</center>
                        </td>
                        <td>
                            <center>{{ $adoptante->usuario->email ?? '-' }}</center>
                        </td>
                        <td>
                            <center>{{ $adoptante->telefono ?? '-' }}</center>
                        </td>
                        <td>
                            <center>
                                @if ($adoptante->ruta_foto)
                                    <img src="{{ asset('storage/' . $adoptante->ruta_foto) }}" alt="Foto"
                                        class="img-thumbnail" width="60">
                                @else
                                    <span>No Disponible</span>
                                @endif
                            </center>
                        </td>
                        <td>
                            <center>{{ $adoptante->pais }}</center>
                        </td>
                        <td>
                            <center>{{ $adoptante->nacionalidad }}</center>
                        </td>
                        <td>
                            <center>{{ $adoptante->estado_civil }}</center>
                        </td>
                        <td>
                            <center>{{ $adoptante->nivel_educativo }}</center>
                        </td>
                        <td>
                            <center>{{ $adoptante->ocupacion }}</center>
                        </td>
                        <td>
                            <center>{{ $adoptante->ingresos_mensuales }}</center>
                        </td>


                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <center>No hay adoptantes registrados.</center>
                        </td>
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
