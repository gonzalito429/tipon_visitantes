<?php
// Ruta correcta al archivo de conexión (ajústala según tu estructura)
require_once '../config/conexion.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];

    // Validación básica
    if (!empty($fecha_inicio) && !empty($fecha_fin)) {
        $conn = conectarBD();

        $query = "SELECT * FROM visitantes WHERE fecha_visita BETWEEN $1 AND $2";
        $result = pg_query_params($conn, $query, array($fecha_inicio, $fecha_fin));

        if ($result) {
            $visitantes = pg_fetch_all($result);
            $_SESSION['visitantes_filtrados'] = $visitantes;
            header("Location: ../views/reportes.php");
            exit;
        } else {
            echo "❌ Error en la consulta.";
        }
    } else {
        echo "❗ Por favor, completa ambas fechas.";
    }
} else {
    header("Location: ../views/reportes.php");
    exit;
}
