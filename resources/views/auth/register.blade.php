<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Registro</title>

<link rel="stylesheet" href="{{ asset('recursos/css/register.css') }}">
</head>

<body>

<div class="page-reg">

    <div class="register-box">

        <h2>Registro de usuario</h2>

        <form method="POST" action="{{ url('/admin/users') }}">
            @csrf

            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="text" name="surname" placeholder="Apellido" required>
            <input type="email" name="mail" placeholder="Email" required>
            <input type="password" name="clave" placeholder="Contraseña" required>

            <select name="status" required>
                <option value="" disabled selected>Estado</option>
                <option value="Activo">Activo</option>
                <option value="Pendiente">Pendiente</option>
                <option value="Inactivo">Inactivo</option>
            </select>

            <select name="rol" required>
                <option value="" disabled selected>Rol</option>
                <option value="1">Administrador</option>
                <option value="2">Profesor</option>
                <option value="3">Alumno</option>
            </select>

            <div class="buttons-row">
                <button type="submit" class="btn-registrar">Registrar</button>
                <button type="button" class="btn-cancelar" onclick="window.history.back()">Cancelar</button>
            </div>

        </form>

    </div>

</div>

</body>
</html>
