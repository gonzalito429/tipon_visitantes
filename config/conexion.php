<?php
class Database {
    private $host = 'dpg-d20fioeuk2gs73c7q290-a';
    private $db_name = 'entrada_tipon';
    private $username = 'entrada_tipon_user';
    private $password = 'i4Fv9qZLR9C3THiUGU8LLFNhUypiKR8y';
    private $port = '5432';
    private $conn;

    public function conectar() {
        if ($this->conn) return $this->conn;

        $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->db_name}";

        try {
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die('Error de Conexión: ' . $e->getMessage());
        }

        return $this->conn;
    }
}
