<?php
$nombre   = $_POST['nombre'];
$apellido = $_POST['surname'];
$mail     = $_POST['mail'];
$clave    = $_POST['clave'];

$clave_segura = password_hash($clave, PASSWORD_DEFAULT);

$conexion = pg_connect("host=localhost port=5432 dbname=proyecto_alival user=postgres password=vocabulario");

if (!$conexion) {
    die("Error de conexión");
}

$sql = "INSERT INTO userr (name, surname, mail, password, registration_date, status, id_role, full_name)
        VALUES ($1, $2, $3, $4, NOW(), 'Activo', 1, $5)";

$fullname = $nombre . " " . $apellido;

$resultado = pg_query_params($conexion, $sql, array($nombre, $apellido, $mail, $clave_segura, $fullname));

if ($resultado) {
    header("Location: registro.html");
    exit();
} else {
    echo "Error al registrar";
}
?>
