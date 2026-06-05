<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Error 401</title>

<link rel="stylesheet" href="{{ asset('recursos/css/error.css') }}">

</head>

<body>

<div class="container" id="animacion">

  <h1 class="titulo">401</h1>

  <p class="subtitulo">
    Acceso no autorizado.<br>
    Las credenciales ingresadas no son correctas.<br>
    Verifica tu usuario y contraseña e intenta nuevamente.
  </p>

  <hr class="linea">

  <nav class="menu">
    <div class="menu-item">
      <a href="{{ url('/login') }}">Intentar nuevamente</a>
    </div>
  </nav>

</div>

</body>
</html>