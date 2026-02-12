<?php
session_start();

$mail  = $_POST['mail'];
$clave = $_POST['cla'];

$conexion = pg_connect("host=localhost port=5432 dbname=proyecto_alival user=postgres password=vocabulario");

if (!$conexion) {
    die("Error de conexión");
}

$sql = "SELECT * FROM userr WHERE mail = $1";
$resultado = pg_query_params($conexion, $sql, array($mail));

if ($resultado && pg_num_rows($resultado) == 1) {

    $usuario = pg_fetch_assoc($resultado);

    if (password_verify($clave, $usuario['password'])) {
        $_SESSION['user'] = $usuario['mail'];
        header("Location: principal.html");
        exit();
    }
}

header("Location: error.html");
exit();
?>
