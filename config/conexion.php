<?php
function conectarBD() {
    $conn_string = "host=localhost port=5432 dbname=tipon user=postgres password=123456";
    $conexion = pg_connect($conn_string);

    if (!$conexion) {
        die("Error al conectar a la base de datos PostgreSQL: " . pg_last_error());
    }
    return $conexion;
}