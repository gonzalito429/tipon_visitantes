?php
class Database {
    // --- MODIFICA ESTOS DATOS CON LOS TUYOS ---
    private $host = 'dpg-d20fioeuk2gs73c7q290-a';          // Host de PostgreSQL
    private $db_name = 'entrada_tipon';     // Nombre de tu base de datos
    private $username = 'entrada_tipon_user';       // Tu usuario de PostgreSQL
    private  $password = 'i4Fv9qZLR9C3THiUGU8LLFNhUypiKR8y';  // Tu contraseña de PostgreSQL
    private $port = '5432';               // Puerto (usualmente 5432)
    // -----------------------------------------

    private $conn;

    public function connect() {
        if ($this->conn) {
            return $this->conn;
        }

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
