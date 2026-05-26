<?php
session_start();
$servername = "localhost";
$username = "u975895695_deleveryu";
$password = "Pagina_2025*";
$dbname = "u975895695_delevery";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$email = isset($_SESSION['email']) ? $_SESSION['email'] : $_POST['correo'];

if (empty($email)) {
    die("Error: No se identificó al usuario.");
}
// Recibir datos
$email_post = $_POST['correo'] ?? ''; 
$base64Data = $_POST['image'] ?? '';

// Limpieza de datos
$email = trim($email_post);
$safeEmail = str_replace(['@', '.'], '_', $email);
$path = "FotoValidacion/" . $safeEmail;

if (!file_exists($path)) {
    mkdir($path, 0777, true);
}

// REPARACIÓN VITAL: Revertir espacios a '+'
$base64Data = str_replace(' ', '+', $base64Data);
$imageBinary = base64_decode($base64Data);

// Guardar y Registrar en MySQL
$fullPath = $path . "/foto_registro.jpg";

if (file_put_contents($fullPath, $imageBinary)) {
    // Actualizar MySQL con la ruta
    $sql = "UPDATE usuarios SET ruta_foto = '$fullPath' WHERE email = '$email'";
    mysqli_query($conexion, $sql);
    echo "Imagen actualizada con éxito";
}
?>