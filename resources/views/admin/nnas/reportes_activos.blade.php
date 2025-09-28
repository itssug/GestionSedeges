<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Niños, niñas y adolescentes </title>
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

<h2>Reporte de niños, niñas y adolescentes activos</h2>

<p class="report-date">Fecha de Reporte: {{ date('d/m/Y') }}</p>

<table class="table table-hover align-middle table-bordered table-striped" id="tablaActivos">
                    <thead class="table-light text-center">
                        <tr>
                            <th>#</th>

                            <th>Código</th>
                            <th>Foto</th>
                            <th>Nombre Completo</th>

                            <th>Identificación</th>
                            <th>Centro de Acogida</th>
                            <th>Fecha Nac.</th>
                            <th>Género</th>
                            <th>Nacionalidad</th>
                            <th>Situación Jurídica</th>
                            <th>Nivel Educativo</th>
                            <th>Motivo Ingreso</th>
                            <th>Fecha Ingreso</th>
                            <th>Fecha Salida</th>
                            <th>Observaciones</th>
                            <th>Discapacidad</th>
                            <th>Tipo Discapacidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($nnas->where('estado', true) as $nna)
                            <tr class="text-center">
                                <td>{{ $nna->id }}</td>
                                <td>{{ $nna->cod_nna ?? '-' }}</td>
                                <td>
                                    @if ($nna->ruta_foto)
                                        <img src="{{ asset('storage/' . $nna->ruta_foto) }}" alt="Foto" width="50"
                                            style="cursor:pointer;" class="img-thumbnail fotoModalTrigger"
                                            data-foto="{{ asset('storage/' . $nna->ruta_foto) }}">
                                    @else
                                        Sin foto
                                    @endif
                                </td>
                                <td>{{ $nna->nombres }} {{ $nna->apellidos }}</td>


                                <td>{{ $nna->tipo_identificacion }}:{{ $nna->identificacion ?? '----' }}</td>

                                <td>{{ $nna->centro->nombre_centro ?? 'Sin centro' }}</td>

                                <td>{{ $nna->fecha_nac }}</td>
                                <td>{{ $nna->sexo }}</td>
                                <td>{{ $nna->nacionalidad ?? '-' }}</td>
                                <td>{{ $nna->situacion_juridica }}</td>
                                <td>{{ $nna->nivel_educativo ?? '-' }}</td>

                                <td>{{ $nna->motivo_ingreso }}</td>
                                <td>{{ $nna->fecha_ingreso ?? '-' }}</td>
                                <td>{{ $nna->fecha_salida ?? '-' }}</td>
                                <td>{{ $nna->observaciones }}</td>
                                <td>{{ $nna->discapacidad ? 'Sí' : 'No' }}</td>
                                <td>{{ $nna->tipo_discapacidad ?? '-' }}</td>
                            
                            </tr>
                        @endforeach
                    </tbody>
                </table>
</div>

<footer>
    <p>&copy; 2025 SEDEGES - Todos los derechos reservados</p>
</footer>

</body>
</html>
