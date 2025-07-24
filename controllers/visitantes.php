<?php
session_start();
require_once '../config/conexion.php'; // Asegúrate de incluir el archivo

$conexion = conectarBD(); // ¡Aquí es donde defines $conexion!

$accion = $_POST['accion'];

if ($accion === 'entrada') {
    $nombre = $_POST['nombre'];
    $dni = $_POST['dni'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];

    // Verificar si ya existe entrada hoy
    $check = pg_query_params($conexion, "SELECT * FROM visitantes WHERE dni = $1 AND fecha = $2", [$dni, $fecha]);
    if (pg_num_rows($check) > 0) {
        echo "Este visitante ya tiene una entrada registrada hoy.";
        exit;
    }
$insert = "INSERT INTO visitantes (nombre, dni, fecha, hora_entrada) VALUES ($1, $2, $3, $4)";
$result = pg_query_params($conexion, $insert, [$nombre, $dni, $fecha, $hora]);

if ($result) {
    echo "Visitante registrado correctamente.";
} else {
    echo "Error al registrar entrada.";
}
}

if ($accion === 'salida') {
    $dni = $_POST['dni'];
    $fecha = $_POST['fecha'];
    $hora_salida = $_POST['hora_salida'];

    $check = pg_query_params($conexion, "SELECT * FROM visitantes WHERE dni = $1 AND fecha = $2", [$dni, $fecha]);
    if (pg_num_rows($check) === 0) {
        echo "No hay una entrada registrada para este visitante.";
        exit;
    }

    $update = pg_query_params($conexion, "UPDATE visitantes SET hora_salida = $1 WHERE dni = $2 AND fecha = $3", [$hora_salida, $dni, $fecha]);
    echo $update ? "Salida registrada correctamente." : "Error al registrar salida.";
}
?>
