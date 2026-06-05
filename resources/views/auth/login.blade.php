<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Didacta</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ asset('recursos/css/login.css') }}">
</head>

<body>

<div class="page">

    <div class="login-box">

        <h2>Iniciar sesión</h2>

        <form method="POST" action="{{ url('/login') }}">
            @csrf

            <input type="email" name="mail" placeholder="Correo electrónico" required>
            <input type="password" name="password" placeholder="Contraseña" required>

            <button type="submit">Entrar</button>
        </form>

        @if(session('error'))
            <div class="alert-box alert-error">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="alert-box alert-success">
                {{ session('success') }}
            </div>
        @endif

    </div>

</div>

</body>
</html>
