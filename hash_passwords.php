<?php
// Script para hashear contraseñas planas existentes
require_once 'config.php';

echo "<h2>Hasheando contraseñas planas existentes...</h2>";

// Usuarios existentes con contraseñas en texto plano
$usuarios = [
    ['correo' => 'mper.13.tm@gmail.com', 'password' => 'Repartidor21'], 
    ['correo' => 'lopez2000ms05d17@gmail.com', 'password' => 'Abosu191730'], 
    ['correo' => 'lopez191730@gmail.com', 'password' => 'Abosu191730'], 
    ['correo' => 'lopez1917301@gmail.com', 'password' => 'Abosu191730'], 
    ['correo' => 'operativo@mftoy.com', 'password' => 'operativo532125/532@#'], 
    ['correo' => 'test@mftoy.com', 'password' => '123456789'] 
];

foreach ($usuarios as $usuario) {
    $hashed_password = password_hash($usuario['password'], PASSWORD_DEFAULT); // Hashear la contraseña

    $stmt = $conn->prepare("UPDATE usuario SET contrasena = ? WHERE correo = ?");
    $stmt->bind_param("ss", $hashed_password, $usuario['correo']);

    if ($stmt->execute()) {
        echo "<p style='color: green;'>✅ Contraseña hasheada para: {$usuario['correo']}</p>";
    } else {
        echo "<p style='color: red;'>❌ Error actualizando: {$usuario['correo']}</p>";
    }

    $stmt->close();
}

echo "<h3>Usuarios de prueba disponibles (contraseñas hasheadas):</h3>";
echo "<ul>";
echo "<li><strong>Administrador:</strong> admin@delivery.com</li>";
echo "<li><strong>Comercio:</strong> esme@gmail.com</li>";
echo "<li><strong>Repartidor:</strong> juan90ejemplo@gmail.com</li>";
echo "<li><strong>Usuario:</strong> al89@gmail.com</li>";
echo "<li><strong>Comercio:</strong> mari88@gmail.com</li>";
echo "<li><strong>Comercio:</strong> Sandra 99@gmail.com</li>";
echo "</ul>";
echo "<p><em>Las contraseñas han sido hasheadas por seguridad. Usa las mismas contraseñas que antes para iniciar sesión.</em></p>";

echo "<p><a href='login.php'>Ir al login</a></p>";
echo "<p><a href='test_login_simple.php'>Ejecutar pruebas de login</a></p>";

$conn->close();
?>