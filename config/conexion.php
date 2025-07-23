<?php
function conectarBD() {
    $host = 'dpg-d20fioeuk2gs73c7q290-a'; 
    $port = '5432';
    $dbname = 'entrada_tipon';
    $user = 'entrada_tipon_user';
    $password = 'i4Fv9qZLR9C3THiUGU8LLFNhUypiKR8y';

    $conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

    if (!$conn) {
        die('Error de conexión: ' . pg_last_error());
    }

    return $conn;
}
?>
