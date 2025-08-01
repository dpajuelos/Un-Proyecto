<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | HPP</title>
     <link rel="icon" type="image/png" href="{{ asset('img/hpp.png') }}">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #111;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #171717;
            padding: 2em;
            border-radius: 25px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 400px;
            transition: transform 0.4s ease-in-out;
        }

        .login-container:hover {
            transform: scale(1.03);
        }

        .logo {
            display: flex;
            justify-content: center;
            margin-bottom: 1em;
        }

        .logo img {
            max-width: 120px;
            border-radius: 50%;
        }

        #heading {
            text-align: center;
            color: #fff;
            font-size: 1.5em;
            margin-bottom: 1em;
        }

        .field {
            display: flex;
            align-items: center;
            gap: 0.5em;
            border-radius: 25px;
            padding: 0.6em 1em;
            background-color: #1f1f1f;
            margin-bottom: 1em;
            box-shadow: inset 2px 5px 10px #050505;
        }

        .input-icon {
            width: 1.3em;
            height: 1.3em;
            fill: #fff;
        }

        .input-field {
            background: none;
            border: none;
            outline: none;
            width: 100%;
            color: #d3d3d3;
        }

        .btn {
            text-align: center;
        }

        .button1 {
            background-color: #252525;
            color: white;
            padding: 0.6em 2em;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: background 0.3s ease-in-out;
        }

        .button1:hover {
            background-color: black;
        }

        .error-box {
            color: #ff6b6b;
            background: #222;
            border-radius: 8px;
            padding: 10px;
            text-align: center;
            margin-bottom: 1em;
        }

        .error-text {
            color: #ff6b6b;
            text-align: center;
            margin-top: -0.5em;
            margin-bottom: 1em;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <!-- LOGO -->
        <div class="logo">
            <img src="{{ asset('img/hpp.png') }}" alt="Logo">
        </div>

        <!-- FORMULARIO -->
        <form method="POST" action="{{ route('login') }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <p id="heading">Iniciar sesión</p>

            {{-- Mostrar errores generales --}}
            @if ($errors->any())
                <div class="error-box">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <!-- Campo usuario -->
            <div class="field">
                <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
                    <path
                        d="M13.106 7.222c0-2.967-2.249-5.032-5.482-5.032-3.35 0-5.646 2.318-5.646 5.702 0 3.493 2.235 5.708 5.762 5.708.862 0 1.689-.123 2.304-.335v-.862c-.43.199-1.354.328-2.29.328-2.926 0-4.813-1.88-4.813-4.798 0-2.844 1.921-4.881 4.594-4.881 2.735 0 4.608 1.688 4.608 4.156 0 1.682-.554 2.769-1.416 2.769-.492 0-.772-.28-.772-.76V5.206H8.923v.834h-.11c-.266-.595-.881-.964-1.6-.964-1.4 0-2.378 1.162-2.378 2.823 0 1.737.957 2.906 2.379 2.906.8 0 1.415-.39 1.709-1.087h.11c.081.67.703 1.148 1.503 1.148 1.572 0 2.57-1.415 2.57-3.643zm-7.177.704c0-1.197.54-1.907 1.456-1.907.93 0 1.524.738 1.524 1.907S8.308 9.84 7.371 9.84c-.895 0-1.442-.725-1.442-1.914z">
                    </path>
                </svg>
                <input autocomplete="off" placeholder="Nombre de usuario" name="nombre_usuario"
                    class="input-field" type="text" value="{{ old('nombre_usuario') }}">
            </div>
            @error('nombre_usuario')
                <div class="error-text">{{ $message }}</div>
            @enderror

            <!-- Campo contraseña -->
            <div class="field">
                <svg class="input-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
                    <path
                        d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z">
                    </path>
                </svg>
                <input placeholder="Contraseña" class="input-field" name="contrasena" type="password">
            </div>
            @error('contrasena')
                <div class="error-text">{{ $message }}</div>
            @enderror

            <!-- Botón de envío -->
            <div class="btn">
                <button type="submit" class="button1">Iniciar sesión</button>
            </div>
        </form>
    </div>

</body>

</html>
