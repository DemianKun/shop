<?php
// Script completo para probar login con contraseñas planas
require_once 'config.php';
session_start();

// Usuarios de prueba con contraseñas planas
$test_users = [
    ['correo' => 'admin@delivery.com', 'password' => 'admin123', 'rol' => 'Administrador', 'expected_rol' => 1],
    ['correo' => 'esme@gmail.com', 'password' => 'yuekdnsv6', 'rol' => 'Comercio', 'expected_rol' => 2],
    ['correo' => 'juan90ejemplo@gmail.com', 'password' => '98765430', 'rol' => 'Repartidor', 'expected_rol' => 3],
    ['correo' => 'al89@gmail.com', 'password' => 'bskdkb90', 'rol' => 'Usuario', 'expected_rol' => 4]
];

echo "<h2>🔍 Prueba Completa de Login con Contraseñas Planas</h2>";
echo "<p>Probando cada usuario con comparación directa de contraseñas...</p>";

$all_passed = true;

foreach ($test_users as $user) {
    echo "<div style='border: 2px solid #ddd; padding: 15px; margin: 10px 0; border-radius: 10px;'>";
    echo "<h3>👤 Probando: {$user['rol']} - {$user['correo']}</h3>";

    // Buscar usuario
    $stmt = $conn->prepare("SELECT id_usuario, contrasena, id_rol, tipo_rol FROM usuario u JOIN rol r ON u.id_rol = r.id_rol WHERE correo = ?");
    $stmt->bind_param("s", $user['correo']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();

        echo "<p><strong>✅ Usuario encontrado:</strong> ID {$usuario['id_usuario']}, Rol {$usuario['id_rol']} ({$usuario['tipo_rol']})</p>";
        echo "<p><strong>Contraseña almacenada:</strong> '{$usuario['contrasena']}'</p>";
        echo "<p><strong>Contraseña enviada:</strong> '{$user['password']}'</p>";

        // Verificar contraseña con comparación directa
        if ($user['password'] === $usuario['contrasena']) {
            echo "<p style='color: green; font-weight: bold;'>✅ Contraseña correcta</p>";

            // Verificar rol
            if ($usuario['id_rol'] == $user['expected_rol']) {
                echo "<p style='color: green; font-weight: bold;'>✅ Rol correcto: {$usuario['tipo_rol']}</p>";

                // Simular redirección
                $redirects = [
                    1 => 'administrador/panel_administrador.php',
                    2 => 'comercio/panel_comercio.php',
                    3 => 'repartidor/panel_repartidor.php',
                    4 => 'usuario/panel_usuario.php'
                ];

                $dashboard_path = $redirects[$usuario['id_rol']];
                echo "<p style='color: blue;'><strong>🔄 Redirigiría a:</strong> {$dashboard_path}</p>";

                // Verificar que el archivo existe
                $full_path = __DIR__ . '/' . $dashboard_path;
                if (file_exists($full_path)) {
                    echo "<p style='color: green;'>✅ Dashboard existe: {$dashboard_path}</p>";

                    // Verificar que el dashboard tiene verificación de sesión
                    $dashboard_content = file_get_contents($full_path);
                    if (strpos($dashboard_content, 'session_start()') !== false && strpos($dashboard_content, 'header(\'Location: ../login.php\')') !== false) {
                        echo "<p style='color: green;'>✅ Dashboard tiene verificación de sesión</p>";
                    } else {
                        echo "<p style='color: orange;'>⚠️ Dashboard podría no tener verificación de sesión correcta</p>";
                    }

                } else {
                    echo "<p style='color: red;'>❌ Dashboard NO existe: {$dashboard_path}</p>";
                    $all_passed = false;
                }

            } else {
                echo "<p style='color: red; font-weight: bold;'>❌ Rol incorrecto. Esperado: {$user['expected_rol']}, Actual: {$usuario['id_rol']}</p>";
                $all_passed = false;
            }
        } else {
            echo "<p style='color: red; font-weight: bold;'>❌ Contraseña incorrecta</p>";
            $all_passed = false;
        }
    } else {
        echo "<p style='color: red; font-weight: bold;'>❌ Usuario no encontrado</p>";
        $all_passed = false;
    }

    $stmt->close();
    echo "</div>";
}

echo "<hr>";
echo "<h3>📋 Resumen de Usuarios de Prueba:</h3>";
echo "<div style='background: #f8f9fa; padding: 15px; border-radius: 10px;'>";
echo "<table style='width: 100%; border-collapse: collapse;'>";
echo "<tr style='background: #007bff; color: white;'><th style='padding: 10px;'>Rol</th><th>Email</th><th>Contraseña</th><th>ID Rol</th></tr>";
foreach ($test_users as $user) {
    echo "<tr style='border-bottom: 1px solid #ddd;'>";
    echo "<td style='padding: 10px; font-weight: bold;'>{$user['rol']}</td>";
    echo "<td style='padding: 10px;'>{$user['correo']}</td>";
    echo "<td style='padding: 10px;'>{$user['password']}</td>";
    echo "<td style='padding: 10px;'>{$user['expected_rol']}</td>";
    echo "</tr>";
}
echo "</table>";
echo "</div>";

if ($all_passed) {
    echo "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 10px; margin: 20px 0;'>";
    echo "<h3>🎉 ¡Todas las pruebas pasaron exitosamente!</h3>";
    echo "<p>El sistema de login funciona correctamente con contraseñas planas.</p>";
    echo "</div>";
} else {
    echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 10px; margin: 20px 0;'>";
    echo "<h3>⚠️ Algunas pruebas fallaron</h3>";
    echo "<p>Revisa los errores arriba y corrige los problemas.</p>";
    echo "</div>";
}

echo "<p><a href='login.php' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Ir al formulario de login</a></p>";

$conn->close();
?>