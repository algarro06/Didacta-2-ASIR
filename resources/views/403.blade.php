<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Error 403</title>

<!-- CSS -->
<link rel="stylesheet" href="{{ asset('recursos/css/error.css') }}">

</head>

<body>

<div class="container" id="animacion">

  <h1 class="titulo">403</h1>

  <p class="subtitulo">
    Acceso denegado.<br>
    No estás matriculado en este curso<br>
    o no tienes permiso para acceder.
  </p>

  <hr class="linea">

  <nav class="menu">
    <div class="menu-item">
      <a href="{{ url('/home') }}">← Volver a cursos</a>
    </div>
  </nav>

</div>

</body>
</html>