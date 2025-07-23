<?php session_start(); if (!isset($_SESSION['user_id'])) header("Location: login.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registrar Entrada</title>
  <link rel="stylesheet" href="../public/styles.css">
</head>
<body>
  <h1>Ingreso de Visitante</h1>
   <p>
    <a href="index.php"> Inicio</a> |
    <a href="registrar.php"> Registrar Entrada</a> |
    <a href="salida.php"> Registrar Salida</a> |
    <a href="../controllers/logout.php"> Cerrar Sesión</a>
  </p>
  <form action="../controllers/visitantes.php" method="POST">
    <input type="hidden" name="accion" value="entrada">

    <label>Nombre:</label>
    <input type="text" name="nombre" required>

    <label>DNI:</label>
    <input type="text" name="dni" maxlength="8" required>

    <label>Fecha:</label>
    <input type="date" name="fecha" value="<?= date('Y-m-d') ?>" required>

    <label>Hora de entrada:</label>
    <input type="time" name="hora" value="<?= date('H:i') ?>" required>

    <button type="submit">Registrar Entrada</button>
  </form>
</body>
</html>
