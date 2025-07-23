<?php
function conectarBD() {
    $host = "localhost";
    $port = "5432";
    $dbname = "tipon_db";
    $user = "postgres";
    $password = "123456"; // reemplaza esto

    $conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

    if (!$conn) {
        die("❌ Error al conectar a la base de datos PostgreSQL.");
    }

    return $conn;
}
?>
