<!doctype html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Reporte NNA</title>
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
            color: #887c3d;
            /* Dorado */
        }

        header p {
            font-size: 14px;
            margin: 10px 0;
        }

        h2 {
            text-align: center;
            color: #50ad66;
            /* Verde */
            margin: 20px 0;
        }

        .report-date {
            text-align: center;
            font-size: 14px;
            color: #777;
            margin-bottom: 20px;
        }

        .container {
            max-width: 900px;
            margin: 0 auto 40px;
            background: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            padding: 20px;
            display: flex;
            gap: 20px;
        }

        .foto {
            flex: 0 0 250px;
        }

        .foto img {
            width: 100%;
            border-radius: 8px;
            object-fit: cover;
            height: 320px;
            border: 1px solid #ddd;
        }

        .datos {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            font-size: 14px;
        }

        .datos h3 {
            margin-top: 0;
            color: #000000;
            border-bottom: 2px solid #887c3d;
            padding-bottom: 6px;
            margin-bottom: 12px;
        }

        .datos .fila {
            margin-bottom: 10px;
        }

        .datos .label {
            font-weight: bold;
            color: #555;
            width: 180px;
            display: inline-block;
        }

        .evaluaciones {
            max-width: 900px;
            margin: 0 auto 40px;
            background: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            padding: 20px;
        }

        .evaluacion-section {
            margin-bottom: 20px;
        }

        .evaluacion-section h3 {
            margin-top: 0;
            color: #000000;
            border-bottom: 2px solid #50ad66;
            padding-bottom: 6px;
            margin-bottom: 12px;
        }

        .evaluacion-section p {
            margin: 6px 0;
            line-height: 1.4;
        }

        .footer {
            background-color: #000000;
            color: white;
            text-align: center;
            padding: 10px 0;
            margin-top: 40px;
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

    <h2>Reporte de NNA</h2>
    <div class="report-date">
        Fecha del Reporte: {{ \Carbon\Carbon::now()->format('d/m/Y') }}
    </div>

    <div class="container">
        <div class="foto">
            @if ($resultado->ruta_foto)
                        <img src="{{ public_path('storage/' . $resultado->ruta_foto) }}" alt="Foto">
                    @else
                        Sin foto
                    @endif
        </div>
        <div class="datos">
            <h3>Datos Personales</h3>
            <div class="fila"><span class="label">Código:</span> {{ $resultado->cod_nna }}</div>
            <div class="fila"><span class="label">Nombres:</span> {{ $resultado->nombres }}
                {{ $resultado->apellidos }}</div>
            <div class="fila"><span class="label">Tipo de Identificación:</span>
                {{ $resultado->tipo_identificacion }}</div>
            <div class="fila"><span class="label">Número de Identificación:</span> {{ $resultado->identificacion }}
            </div>
            <div class="fila"><span class="label">Fecha de Nacimiento:</span>
                {{ \Carbon\Carbon::parse($resultado->fecha_nac)->format('d/m/Y') }}</div>
            <div class="fila"><span class="label">Sexo:</span> {{ $resultado->sexo }}</div>
            <div class="fila"><span class="label">Nacionalidad:</span> {{ $resultado->nacionalidad }}</div>
            <div class="fila"><span class="label">Situación Jurídica:</span> {{ $resultado->situacion_juridica }}
            </div>
            <div class="fila"><span class="label">Fecha de Ingreso:</span>
                {{ \Carbon\Carbon::parse($resultado->fecha_ingreso)->format('d/m/Y') }}</div>
            <div class="fila"><span class="label">Fecha de Salida:</span>
                {{ $resultado->fecha_salida ? \Carbon\Carbon::parse($resultado->fecha_salida)->format('d/m/Y') : 'N/A' }}
            </div>
            <div class="fila"><span class="label">Nivel Educativo:</span> {{ $resultado->nivel_educativo }}</div>
            <div class="fila"><span class="label">Motivo de Ingreso:</span> {{ $resultado->motivo_ingreso }}</div>
           <div class="fila">
    <span class="label">Discapacidad:</span>
    {{ $resultado->discapacidad ? 'Con discapacidad' : 'Sin discapacidad' }}
</div>
            <div class="fila"><span class="label">Centro:</span> {{ $resultado->nombre_centro }}</div>
        </div>
    </div>

    <div class="evaluaciones">
        <div class="evaluacion-section">
            <h3>Evaluación Psicológica</h3>
            <p><strong>Diagnóstico:</strong> {{ $resultado->diagnostico_psicologico ?? 'N/A' }}</p>
            <p><strong>Observaciones:</strong> {{ $resultado->observaciones_psicologicas ?? 'N/A' }}</p>
            <p><strong>Evaluador:</strong> {{ $resultado->evaluador_psicologico ?? 'N/A' }}</p>
        </div>

        <div class="evaluacion-section">
            <h3>Evaluación Médica</h3>
            <p><strong>Fecha:</strong>
                {{ $resultado->fecha_medica ? \Carbon\Carbon::parse($resultado->fecha_medica)->format('d/m/Y') : 'N/A' }}
            </p>
            <p><strong>Diagnóstico:</strong> {{ $resultado->diagnostico_medico ?? 'N/A' }}</p>
            <p><strong>Observaciones:</strong> {{ $resultado->observaciones_medicas ?? 'N/A' }}</p>
            <p><strong>Evaluador:</strong> {{ $resultado->evaluador_medico?? 'N/A' }}</p>
        </div>
    </div>

    <div class="footer">
        Sistema de Gestión - SEDEGES &copy; {{ date('Y') }}
    </div>

</body>

</html>
