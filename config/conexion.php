<?php
function conectarBD() {
    $host = "dpg-d20fioeuk2gs73c7q290-a";   // Hostname correcto desde Render
    $port = "5432";
    $dbname = "entrada_tipon";
    $user = "entrada_tipon_user";
    $password = "i4Fv9qZLR9C3THiUGU8LLFNhUypiKR8y";

    $conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password";

    $conexion = pg_connect($conn_string);

    if (!$conexion) {
        die("❌ Error al conectar a la base de datos PostgreSQL");
    }

    return $conexion;
}
