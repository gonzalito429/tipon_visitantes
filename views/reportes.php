<?php 
session_start(); 

// Verificar autenticación
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Obtener datos del reporte de la sesión (pasados desde el controlador)
$reporte_data = isset($_SESSION['reporte_data']) ? $_SESSION['reporte_data'] : null;
$fecha_seleccionada = $reporte_data['fecha'] ?? date('Y-m-d');
$total_visitantes = $reporte_data['total'] ?? 0;
$tabla_resumen = $reporte_data['tabla'] ?? [];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes - Parque Tipón</title>
    <link rel="stylesheet" href="../public/styles.css">
</head>
<body>
    <div class="container">
        <h1> Reportes de Visitantes</h1>
        
        <!-- Navegación -->
        <div class="nav-links">
            <a href="index.php">Inicio</a> |
            <a href="registrar.php"> Registrar Entrada</a>
            <a href="salida.php"> Registrar Salida</a>
            <a href="reportes.php" class="active"> Reportes</a>
            <a href="../controllers/logout.php">Cerrar Sesión</a>
        </div>
        
        <!-- Panel de filtros -->
        <div class="report-filters">
            <h2> Generar Reporte</h2>
            <form action="../controllers/reportes.php" method="POST" class="filter-form">
                <div class="form-group">
                    <label for="fecha"> Seleccionar Fecha:</label>
                    <input type="date" 
                           id="fecha" 
                           name="fecha" 
                           value="<?= htmlspecialchars($fecha_seleccionada, ENT_QUOTES, 'UTF-8') ?>"
                           max="<?= date('Y-m-d') ?>">
                    <button type="submit" class="btn btn-secondary"> Generar Reporte</button>
                </div>
            </form>
        </div>
        
        <!-- Estadísticas principales -->
        <?php if ($reporte_data): ?>
            <div class="stats-cards">
                <div class="stat-card">
                    <h3> Fecha Seleccionada</h3>
                    <p class="stat-number"><?= htmlspecialchars($fecha_seleccionada, ENT_QUOTES, 'UTF-8') ?></p>
                </div>
                <div class="stat-card">
                    <h3> Visitantes</h3>
                    <p class="stat-number"><?= $total_visitantes ?></p>
                </div>
                <div class="stat-card">
                    <h3> Promedio Diario</h3>
                    <p class="stat-number">
                        <?php 
                        $promedio = !empty($tabla_resumen) ? 
                            round(array_sum(array_column($tabla_resumen, 'cantidad')) / count($tabla_resumen), 1) : 0;
                        echo $promedio;
                        ?>
                    </p>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Tabla de resumen -->
        <div class="report-section">
            <h2>Días con Más Visitantes</h2>
            
            <?php if (empty($tabla_resumen)): ?>
                <div class="alert alert-info">
                    No hay datos disponibles para mostrar.
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th> Fecha</th>
                                <th>Cantidad de Visitantes</th>
                                <th> Porcentaje</th>
                                <th> Posición</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $max_cantidad = !empty($tabla_resumen) ? max(array_column($tabla_resumen, 'cantidad')) : 1;
                            $posicion = 1;
                            ?>
                            <?php foreach ($tabla_resumen as $row): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['fecha'], ENT_QUOTES, 'UTF-8') ?></td>
                                    <td>
                                        <strong><?= htmlspecialchars($row['cantidad'], ENT_QUOTES, 'UTF-8') ?></strong>
                                    </td>
                                    <td>
                                        <?php 
                                        $porcentaje = round(($row['cantidad'] / $max_cantidad) * 100, 1);
                                        echo $porcentaje . '%';
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                        switch ($posicion) {
                                            case 1: echo '🥇'; break;
                                            case 2: echo '🥈'; break;
                                            case 3: echo '🥉'; break;
                                            default: echo '#' . $posicion;
                                        }
                                        $posicion++;
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Gráfica simple (opcional) -->
        <?php if (!empty($tabla_resumen)): ?>
            <div class="report-section">
                <h2> Vista General</h2>
                <div class="chart-placeholder">
                    <p> Gráfica de visitantes por día (últimos 10 días)</p>
                    <!-- Aquí podrías integrar una librería de gráficos como Chart.js -->
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Exportar datos -->
        <div class="report-actions">
            <h3> Exportar Reporte</h3>
            <div class="export-buttons">
                <button onclick="window.print()" class="btn btn-secondary"> Imprimir</button>
                <button onclick="exportToCSV()" class="btn btn-secondary" disabled> Exportar CSV</button>
                <button onclick="exportToPDF()" class="btn btn-secondary" disabled> Exportar PDF</button>
            </div>
        </div>
    </div>
    
    <script src="../public/script.js"></script>
    <script>
        // Funciones para exportar datos (puedes implementarlas según necesites)
        function exportToCSV() {
            alert('Funcionalidad de exportar CSV en desarrollo');
        }
        
        function exportToPDF() {
            alert('Funcionalidad de exportar PDF en desarrollo');
        }
        
        // Validación de fecha
        document.addEventListener('DOMContentLoaded', function() {
            const fechaInput = document.getElementById('fecha');
            const hoy = new Date().toISOString().split('T')[0];
            fechaInput.max = hoy;
        });
    </script>
</body>
</html>