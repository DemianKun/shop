<?php
// Script para actualizar la base de datos con el nuevo rol de Administrador
require_once 'config.php';

echo "<h2>Actualizando base de datos - Agregando rol Administrador</h2>";

// Verificar si el rol Administrador ya existe
$result = $conn->query("SELECT id_rol FROM rol WHERE id_rol = 1 AND tipo_rol = 'Administrador'");
if ($result->num_rows == 0) {
    // Actualizar el rol 1 a Administrador
    $conn->query("UPDATE rol SET tipo_rol = 'Administrador' WHERE id_rol = 1");
    echo "<p style='color: green;'>✅ Rol 1 actualizado a 'Administrador'</p>";
} else {
    echo "<p style='color: blue;'>ℹ️ El rol 1 ya es 'Administrador'</p>";
}

// Verificar si el rol Usuario existe en ID 4
$result = $conn->query("SELECT id_rol FROM rol WHERE id_rol = 4");
if ($result->num_rows == 0) {
    // Agregar el rol Usuario en ID 4
    $conn->query("INSERT INTO rol (id_rol, tipo_rol) VALUES (4, 'Usuario')");
    echo "<p style='color: green;'>✅ Rol 'Usuario' agregado en ID 4</p>";
} else {
    // Asegurar que ID 4 sea Usuario
    $conn->query("UPDATE rol SET tipo_rol = 'Usuario' WHERE id_rol = 4");
    echo "<p style='color: green;'>✅ Rol 4 actualizado a 'Usuario'</p>";
}

// Verificar si el usuario administrador existe
$result = $conn->query("SELECT id_usuario FROM usuario WHERE correo = 'admin@delivery.com'");
if ($result->num_rows == 0) {
    // Crear usuario administrador
    $hashed_password = password_hash('admin123', PASSWORD_DEFAULT);
    $conn->query("INSERT INTO usuario (nombre, correo, contrasena, fecha_registro, id_rol) VALUES ('Admin', 'admin@delivery.com', '$hashed_password', '2025-12-01 10:00:00', 1)");
    echo "<p style='color: green;'>✅ Usuario administrador creado: admin@delivery.com / admin123</p>";
} else {
    // Actualizar rol del admin existente a 1
    $conn->query("UPDATE usuario SET id_rol = 1 WHERE correo = 'admin@delivery.com'");
    echo "<p style='color: blue;'>ℹ️ Usuario administrador actualizado a rol 1</p>";
}

// Actualizar usuario Alberto a rol 4 (Usuario)
$conn->query("UPDATE usuario SET id_rol = 4 WHERE correo = 'al89@gmail.com'");
echo "<p style='color: green;'>✅ Alberto actualizado a rol Usuario (ID: 4)</p>";

// Actualizar AUTO_INCREMENT si es necesario
$conn->query("ALTER TABLE rol AUTO_INCREMENT = 5");
$conn->query("ALTER TABLE usuario AUTO_INCREMENT = 14");

echo "<h3>Resumen de roles:</h3>";
$result = $conn->query("SELECT id_rol, tipo_rol FROM rol ORDER BY id_rol");
echo "<ul>";
while ($row = $result->fetch_assoc()) {
    echo "<li><strong>ID {$row['id_rol']}:</strong> {$row['tipo_rol']}</li>";
}
echo "</ul>";

echo "<p><a href='test_login.php'>Probar login con todos los roles</a></p>";
echo "<p><a href='login.php'>Ir al login</a></p>";

$conn->close();
?>