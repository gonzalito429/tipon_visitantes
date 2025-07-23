<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit(); // Asegura que el script termine aquí si no hay sesión
}

// Incluir el archivo de conexión
require_once '../config/conexion.php'; // Usa require_once para asegurarte de que se incluya correctamente

// Llamar a la función conectarBD() y almacenar la conexión en una variable
$conexion = conectarBD();

// Realizar la consulta
$consulta = pg_query($conexion, "SELECT * FROM visitantes ORDER BY fecha DESC, hora_entrada DESC");

// Verificar si la consulta fue exitosa
if (!$consulta) {
    die("Error en la consulta: " . pg_last_error($conexion));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel de Control - Tipón</title>
  <link rel="stylesheet" href="../public/styles.css">
</head>
<body>
  <h1> Registro de Visitantes</h1>

  <p>
    <a href="index.php"> Inicio</a> |
    <a href="registrar.php"> Registrar Entrada</a> |
    <a href="salida.php"> Registrar Salida</a> |
    <a href="../controllers/reportes.php"> Reportes</a> |
    <a href="../controllers/logout.php"> Cerrar Sesión</a>
  </p>

  <table border ="1">
    <tr>
      <th>DNI</th>
      <th>Nombre</th>
      <th>Fecha</th>
      <th>Hora Entrada</th>
      <th>Hora Salida</th>
    </tr>
    <?php while ($row = pg_fetch_assoc($consulta)): ?>
      <tr>
        <td><?= htmlspecialchars($row['dni']) ?></td>
        <td><?= htmlspecialchars($row['nombre']) ?></td>
        <td><?= htmlspecialchars($row['fecha']) ?></td>
        <td><?= htmlspecialchars($row['hora_entrada']) ?></td>
        <td><?= $row['hora_salida'] ?: '<i>No registrada</i>' ?></td>
      </tr>
    <?php endwhile; ?>
  </table>
</body>
</html>
