<?php
session_start();
require_once 'controllers/conexion.php';

$conexion = conectarBD();

// Validar entrada del formulario
if (empty($_POST['usuario']) || empty($_POST['clave'])) {
    die("❗ Debes ingresar usuario y contraseña.");
}

$usuario = $_POST['usuario'];
$clave = $_POST['clave'];

$query = "SELECT id FROM usuarios WHERE username = $1 AND password = $2";
$result = pg_query_params($conexion, $query, array($usuario, $clave));

if (!$result) {
    die("❌ Error en la consulta: " . pg_last_error($conexion));
}

if (pg_num_rows($result) > 0) {
    $user = pg_fetch_assoc($result);
    $_SESSION['user_id'] = $user['id'];
    header("Location: ../views/index.php");
    exit;
} else {
    echo "❌ Usuario o contraseña incorrectos.";
}
?>
