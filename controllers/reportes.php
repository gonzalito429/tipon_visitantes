<?php
session_start();

// Verificar autenticación
if (!isset($_SESSION['user_id'])) {
    header("Location: ../views/login.php");
    exit;
}

// Incluir conexión
require_once '../config/conexion.php';

try {
    $conexion = conectarBD();
    
    // Validar y obtener fecha
    $fecha = isset($_POST['fecha']) ? trim($_POST['fecha']) : date('d-m-y');
    
    // Validar formato de fecha
    $fecha_obj = DateTime::createFromFormat('d-m-y', $fecha);
    if (!$fecha_obj) {
        $fecha = date('d-m-y'); // Usar fecha actual si hay error
    }
    
    $total = 0;
    
    // Obtener total de visitantes usando función SQL
    $result = pg_query_params($conexion, "SELECT total_visitantes_por_dia($1) AS total", array($fecha));
    if ($result && $row = pg_fetch_assoc($result)) {
        $total = (int)$row['total'];
    }
    
    // Ejecutar función con cursor
    $cursor_result = pg_query_params($conexion, "SELECT visitantes_por_dia_cursor($1)", array($fecha));
    if (!$cursor_result) {
        error_log("Error en función cursor: " . pg_last_error($conexion));
    }
    
    // Consulta resumen para tabla
    $resumen_query = "
        SELECT fecha, COUNT(*) AS cantidad
        FROM visitantes
        GROUP BY fecha
        ORDER BY cantidad DESC, fecha DESC
        LIMIT 10
    ";
    
    $resumen = pg_query($conexion, $resumen_query);
    if (!$resumen) {
        throw new Exception("Error en consulta de resumen: " . pg_last_error($conexion));
    }
    
    // Preparar datos para la vista
    $datos_tabla = [];
    while ($row = pg_fetch_assoc($resumen)) {
        $datos_tabla[] = [
            'fecha' => $row['fecha'],
            'cantidad' => (int)$row['cantidad']
        ];
    }
    
    // Guardar datos en sesión
    $_SESSION['reporte_data'] = [
        'fecha' => $fecha,
        'total' => $total,
        'tabla' => $datos_tabla,
        'timestamp' => time()
    ];
    
} catch (Exception $e) {
    error_log("Error en reportes: " . $e->getMessage());
    $_SESSION['mensaje_error'] = "Error al generar el reporte. Inténtalo más tarde.";
} finally {
    if (isset($conexion)) {
        pg_close($conexion);
    }
}

header("Location: ../views/reportes.php");
exit;
?>
