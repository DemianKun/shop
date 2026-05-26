<?php
session_start();
require_once 'config.php';

// Validar que se recibieron los datos
if (!isset($_POST['correo']) || !isset($_POST['contrasena'])) {
    header('Location: login.php?error=campos');
    exit();
}

$correo = trim($_POST['correo']);
$contrasena = trim($_POST['contrasena']);

// Validar campos vacíos
if (empty($correo) || empty($contrasena)) {
    header('Location: login.php?error=campos');
    exit();
}

// Buscar usuario en la base de datos
$sql = "SELECT u.*, r.tipo_rol 
        FROM usuario u 
        LEFT JOIN rol r ON u.id_rol = r.id_rol 
        WHERE u.correo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header('Location: login.php?error=credenciales');
    exit();
}

$usuario = $result->fetch_assoc();

// Verificar contraseña usando password_verify
if (!password_verify($contrasena, $usuario['contrasena'])) {
    header('Location: login.php?error=credenciales');
    exit();
}

// Login exitoso - guardar datos en sesión
$_SESSION['id_usuario'] = $usuario['id_usuario'];
$_SESSION['usuario_id'] = $usuario['id_usuario']; // Para compatibilidad con dashboards
$_SESSION['nombre'] = $usuario['nombre'];
$_SESSION['correo'] = $usuario['correo'];
$_SESSION['id_rol'] = $usuario['id_rol'];
$_SESSION['usuario_rol'] = $usuario['id_rol']; // Para compatibilidad con dashboards
$_SESSION['rol_nombre'] = $usuario['tipo_rol'];

// Recordar usuario si se seleccionó la opción
if (isset($_POST['recordar'])) {
    setcookie('usuario_correo', $correo, time() + (86400 * 30), "/"); // 30 días
}

// Redirigir según el rol
switch ($usuario['id_rol']) {
    case 1: // Administrador
        header('Location: administrador/panel_administrador.php');
        break;
    case 2: // Comercio
        header('Location: comercio/panel_comercio.php');
        break;
    case 3: // Repartidor
        header('Location: repartidor/panel_repartidor.php');
        break;
    case 4: // Usuario
        header('Location: usuario/panel_usuario.php');
        break;
    default:
        header('Location: index.php');
        break;
}

$stmt->close();
$conn->close();
exit();
?>
