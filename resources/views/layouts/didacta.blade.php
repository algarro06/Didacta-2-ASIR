<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Didacta</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="stylesheet" href="{{ asset('recursos/css/principal.css') }}">
</head>

<body>

<!-- HEADER -->
@include('includes.header')

<!-- CONTENIDO -->
<div class="forum-container">
    @yield('content')
</div>

<!-- FOOTER -->
@include('includes.footer')

<script src="{{ asset('recursos/js/principal.js') }}"></script>

</body>
</html>
