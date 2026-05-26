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
$email_post = $_POST['correo'] ?? ''; // El nombre que uses en el bloque 'unir'
$base64Data = $_POST['image'] ?? '';

// 3. LIMPIEZA Y CARPETA (TAREAS CRÍTICAS)
$email = trim($email_post);
$safeEmail = str_replace(['@', '.'], '_', $email);
$path = "FotoPerfil/" . $safeEmail;

if (!file_exists($path)) {
    mkdir($path, 0777, true);
}

// 4. REPARACIÓN DE LA IMAGEN (Para evitar que salga rota)
// Revertimos el cambio de '+' por espacios que hace App Inventor
$base64Data = str_replace(' ', '+', $base64Data);
$base64Data = trim($base64Data);

// 5. GUARDAR ARCHIVO FÍSICO
$fullPath = $path . "/foto_perfil.jpg";
$imageBinary = base64_decode($base64Data);

if (file_put_contents($fullPath, $imageBinary)) {
    
    // 6. REGISTRO EN MYSQL (Guardamos la RUTA, no el archivo pesado)
    // Esto permite "llamar" a la imagen fácilmente después.
    $sql = "UPDATE usuarios SET ruta_foto = '$fullPath' WHERE email = '$email'";
    
    if (mysqli_query($conn, $sql)) {
        echo "Éxito: Imagen guardada y vinculada a MySQL para: " . $email;
    } else {
        echo "Archivo guardado, pero error en MySQL: " . mysqli_error($conn);
    }
    
} else {
    echo "Error al escribir el archivo físico.";
}

mysqli_close($conn);
?>