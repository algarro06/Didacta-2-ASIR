<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plataforma Educativa</title>

    <!-- Bootstrap (opcional pero recomendado) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand" href="/home">Plataforma Educativa</a>

            <div>
                <a class="btn btn-light btn-sm" href="/community">Foro</a>
                <a class="btn btn-light btn-sm" href="/courses">Cursos</a>
                <a class="btn btn-light btn-sm" href="/events">Eventos</a>
                <a class="btn btn-light btn-sm" href="/news">Noticias</a>

                <form action="/logout" method="POST" class="d-inline">
                    @csrf
                    <button class="btn btn-danger btn-sm">Salir</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- CONTENIDO -->
    <div class="container">
        @yield('content')
    </div>

</body>
</html>
