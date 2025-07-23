<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login - Parque Tipón</title>
  <link rel="stylesheet" href="../public/styles.css">
</head>
<body>
  <h1> Sistema - Parque Tipón</h1>
  <form action="../controllers/login.php" method="POST">
    <label for="usuario">Usuario:</label>
    <input type="text" name="usuario" required>

    <label for="clave">Contraseña:</label>
    <input type="password" name="clave" required>

    <button type="submit">Ingresar</button>
  </form>
</html>
