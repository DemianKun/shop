<?php
$servername = "localhost";
$username = "u975895695_deleveryu";
$password = "Pagina_2025*";
$dbname = "u975895695_delevery";

// Crear conexion
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode([
        "status"=>"error",
        "mensaje"=>"Error de conexión"
    ]));
}
?>