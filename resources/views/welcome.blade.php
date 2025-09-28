<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SEDEGES - Sistema de Gestión</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <style>
        body {
            margin: 0;
            font-family: 'Figtree', sans-serif;
            background: linear-gradient(135deg, #0f0f0f, #1b4332); /* negro a verde oscuro */
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            color: #f3f4f6;
        }

        .container {
            text-align: center;
            padding: 2rem;
            max-width: 700px;
            background: rgba(0, 0, 0, 0.8);
            border: 2px solid #d4af37; /* dorado */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.6);
            border-radius: 1rem;
        }

        .title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #d4af37;
            margin-bottom: 0.5rem;
        }

        .subtitle {
            font-size: 1.2rem;
            color: #cbd5e1;
            margin-bottom: 1.5rem;
        }

        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            background-color: #2d6a4f;
            color: white;
            text-decoration: none;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            margin: 0.5rem;
            border: 1px solid #d4af37;
        }

        .btn:hover {
            background-color: #40916c;
            transform: scale(1.05);
        }

        .btn:focus {
            outline: 2px solid #d4af37;
            outline-offset: 2px;
        }

        img {
            width: 100%;
            max-width: 250px;
            margin-top: 1.5rem;
            border-radius: 0.5rem;
        }

        @media (max-width: 600px) {
            .title {
                font-size: 2rem;
            }

            .subtitle {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="title">Sistema de Gestión SEDEGES</div>
        <div class="subtitle">Gestión y seguimiento eficiente de procesos de adopción y atención social.</div>

        @if (Route::has('login'))
            @auth
                <a href="{{ url('/home') }}" class="btn">Ir al Panel</a>
            @else
                <a href="{{ route('login') }}" class="btn">Iniciar Sesión</a>
                {{-- @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn">Registrarse</a>
                @endif --}}
            @endauth
        @endif

        <img src="{{ asset('vendor/adminlte/dist/img/SEDEGESLOGOBLACK.png') }}" alt="Logo SEDEGES">
    </div>
</body>
</html>
