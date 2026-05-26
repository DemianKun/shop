<?php
// Script para probar el login de todos los roles y hashear contraseñas si es necesario
require_once 'config.php';
session_start();

echo "<h2>Prueba de Login por Roles</h2>";

// Usuarios de prueba
$test_users = [
    ['correo' => 'admin@delivery.com', 'password' => 'admin123', 'rol' => 'Administrador'],
    ['correo' => 'esme@gmail.com', 'password' => 'yuekdnsv6', 'rol' => 'Comercio'],
    ['correo' => 'juan90ejemplo@gmail.com', 'password' => '98765430', 'rol' => 'Repartidor'],
    ['correo' => 'al89@gmail.com', 'password' => 'bskdkb90', 'rol' => 'Usuario']
];

// Primero verificar si las contraseñas necesitan hasheo
echo "<h3>Verificando contraseñas...</h3>";
$needs_hashing = false;

foreach ($test_users as $user) {
    $stmt = $conn->prepare("SELECT contrasena FROM usuario WHERE correo = ?");
    $stmt->bind_param("s", $user['correo']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $stored_password = $row['contrasena'];

        echo "<p>Contraseña almacenada para {$user['correo']}: '{$stored_password}' (longitud: " . strlen($stored_password) . ")</p>";

        // Verificar si la contraseña está hasheada (password_hash produce strings de ~60 caracteres)
        if (strlen($stored_password) < 50 || !password_verify($user['password'], $stored_password)) {
            $needs_hashing = true;
            echo "<p style='color: orange;'>⚠️ Necesita hasheo</p>";
        } else {
            echo "<p style='color: green;'>✅ Ya hasheada correctamente</p>";
        }
    } else {
        echo "<p style='color: red;'>❌ Usuario no encontrado: {$user['correo']}</p>";
    }
    $stmt->close();
}

if ($needs_hashing) {
    echo "<p style='color: orange;'>⚠️ Las contraseñas no están hasheadas. Hasheando automáticamente...</p>";

    foreach ($test_users as $user) {
        $hashed_password = password_hash($user['password'], PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE usuario SET contrasena = ? WHERE correo = ?");
        $stmt->bind_param("ss", $hashed_password, $user['correo']);

        if ($stmt->execute()) {
            echo "<p style='color: green;'>✅ Contraseña hasheada para: {$user['correo']}</p>";
        } else {
            echo "<p style='color: red;'>❌ Error hasheando: {$user['correo']}</p>";
        }

        $stmt->close();
    }
} else {
    echo "<p style='color: green;'>✅ Las contraseñas ya están hasheadas correctamente.</p>";
}

echo "<hr>";

// Ahora probar el login
foreach ($test_users as $user) {
    echo "<h3>Probando login para {$user['rol']}: {$user['correo']}</h3>";

    // Buscar usuario en la base de datos
    $stmt = $conn->prepare("SELECT id_usuario, contrasena, id_rol FROM usuario WHERE correo = ?");
    $stmt->bind_param("s", $user['correo']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['contrasena'];
        $id_rol = $row['id_rol'];

        echo "<p>Hash obtenido: '{$hashed_password}' (longitud: " . strlen($hashed_password) . ")</p>";

        // Verificar contraseña
        if (password_verify($user['password'], $hashed_password)) {
            echo "<p style='color: green;'>✅ Contraseña correcta</p>";

            // Verificar rol
            $rol_names = [1 => 'Administrador', 2 => 'Comercio', 3 => 'Repartidor', 4 => 'Usuario'];
            $expected_rol = array_search($user['rol'], $rol_names);

            if ($id_rol == $expected_rol) {
                echo "<p style='color: green;'>✅ Rol correcto: {$rol_names[$id_rol]}</p>";

                // Simular redirección
                $redirects = [
                    1 => 'administrador/panel_administrador.php',
                    2 => 'comercio/panel_comercio.php',
                    3 => 'repartidor/panel_repartidor.php',
                    4 => 'usuario/panel_usuario.php'
                ];

                echo "<p style='color: blue;'>🔄 Redirigiría a: {$redirects[$id_rol]}</p>";
            } else {
                echo "<p style='color: red;'>❌ Rol incorrecto. Esperado: {$user['rol']}, Actual: {$rol_names[$id_rol]}</p>";
            }
        } else {
            echo "<p style='color: red;'>❌ Contraseña incorrecta</p>";
        }
    } else {
        echo "<p style='color: red;'>❌ Usuario no encontrado</p>";
    }

    $stmt->close();
    echo "<hr>";
}

echo "<p><a href='login.php'>Ir al login</a></p>";

$conn->close();
?>