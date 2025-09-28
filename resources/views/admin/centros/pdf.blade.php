<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Centros</title>
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
            padding: 12px 20px;
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

        .table-container {
            margin: 20px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        footer {
            background-color: #000000;
            color: white;
            text-align: center;
            padding: 10px 0;
            margin-top: 20px;
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

<h2>Reporte de Centros Registrados</h2>

<p class="report-date">Fecha de Reporte: {{ date('d/m/Y') }}</p>

<div class="table-container">
    <table id="tablaCentros">
        <thead>
            <tr>
                <th>Nro</th>
                <th>Código Centro</th>
                <th>Nombre Centro</th>
                <th>Dirección</th>
                <th>Contacto</th>
                <th>Capacidad</th>
            </tr>
        </thead>
        <tbody>
            @forelse($centros as $centro)
                <tr>
                    <td>{{ $centro->id }}</td>
                    <td>{{ $centro->cod_centro }}</td>
                    <td>{{ $centro->nombre_centro }}</td>
                    <td>{{ $centro->direccion_centro }}</td>
                    <td>{{ $centro->contacto }}</td>
                    <td>{{ $centro->capacidad }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="no-data">No hay centros registrados.</td>
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
