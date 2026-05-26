
<?php
// Configuración de la base de datos
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'u975895695_deleveryu');
define('DB_PASSWORD', 'Pagina_2025*');
define('DB_NAME', 'u975895695_delevery');

// Intentar conexión
try {
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("ERROR: No se pudo conectar con PDO. " . $e->getMessage());
}

// Conexión MySQLi (para procesadores que usan MySQLi)
$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Verificar conexión MySQLi
if ($conn->connect_error) {
    die("ERROR: No se pudo conectar con MySQLi. " . $conn->connect_error);
}

// Configurar charset UTF-8 para MySQLi
$conn->set_charset("utf8mb4");
?>