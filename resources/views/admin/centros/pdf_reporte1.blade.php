<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <title>Reporte de NNAs por Centro</title>
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

        .info-centro {
            width: 90%;
            margin: 0 auto 20px auto;
            background-color: #fff;
            padding: 10px;
            border-radius: 6px;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }

        .info-centro p {
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

        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            color: white;
            display: inline-block;
        }

        .bg-masculino {
            background-color: #007bff;
        }

        .bg-femenino {
            background-color: #e83e8c;
        }

        .footer {
            width: 95%;
            margin: 0 auto;
            font-size: 12px;
            text-align: right;
            color: #777;
            padding-top: 10px;
            border-top: 1px solid #ccc;
        }
    </style>
</head>

<body>

    <header>
        <img src="{{ public_path('vendor/adminlte/dist/img/SEDEGESLOGOBLACK.png') }}" alt="Logo">
        <h1>Servicio Departamental de Gestión Social (SEDEGES)</h1>
        <p>Reporte de NNAs por Centro</p>
    </header>

    @if($centro)
    <div class="info-centro">
        <h2>{{ $centro->nombre_centro }} ({{ $centro->cod_centro }})</h2>
        <p><strong>Dirección:</strong> {{ $centro->direccion_centro }}</p>
        <p><strong>Contacto:</strong> {{ $centro->contacto }}</p>
        <p><strong>Fecha de Reporte:</strong> {{ date('d/m/Y') }}</p>
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Nro</th>
                <th>Apellidos</th>
                <th>Nombres</th>
                <th>Sexo</th>
                <th>Código NNA</th>
                <th>Fecha Nacimiento</th>
            </tr>
        </thead>
        <tbody>
            @forelse($nnas as $index => $nna)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $nna->apellidos }}</td>
                    <td>{{ $nna->nombres }}</td>
                    <td>{{$nna->sexo}}
                    </td>
                    <td>{{ $nna->cod_nna }}</td>
                    <td>{{ \Carbon\Carbon::parse($nna->fecha_nac)->format('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No hay NNAs registrados en este centro.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p><strong>Total de NNAs:</strong> {{ $totalNnas }}</p>
        <p>Generado el: {{ date('d/m/Y H:i:s') }}</p>
    </div>

</body>
</html>
