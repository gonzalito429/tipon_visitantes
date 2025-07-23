<?php
session_start();
require_once '../controllers/Database.php';
$conexion = conectarBD();

// Procesar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nueva = $_POST['nueva_clave'];
    $confirmar = $_POST['confirmar_clave'];

    if (empty($nueva) || empty($confirmar)) {
        $mensaje = " Todos los campos son obligatorios.";
    } elseif ($nueva !== $confirmar) {
        $mensaje = " Las contraseñas no coinciden.";
    } else {
        $sql = "UPDATE usuarios SET password = $1 WHERE username = 'admin'";
        $res = pg_query_params($conexion, $sql, array($nueva));
        $mensaje = $res ? " Contraseña actualizada correctamente." : " Error al actualizar: " . pg_last_error($conexion);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Restablecer contraseña</title>
  <link rel="stylesheet" href="../public/styles.css">
</head>
<body>
  <h1> Restablecer contraseña de admin</h1>

  <?php if (isset($mensaje)) echo "<p>$mensaje</p>"; ?>

  <form method="POST" action="">
    <label>Nueva contraseña:</label>
    <input type="password" name="nueva_clave" required>

    <label>Confirmar nueva contraseña:</label>
    <input type="password" name="confirmar_clave" required>

    <button type="submit">Actualizar</button>
  </form>

  <p><a href="login.php">Volver al login</a></p>
</body>
</html>
