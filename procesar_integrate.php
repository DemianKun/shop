<?php
require_once 'config.php';

// Validar que se recibieron los datos
if (!isset($_POST['nombre_negocio']) || !isset($_POST['email_negocio'])) {
    header('Location: integrate.php?error=Faltan campos obligatorios');
    exit();
}

// Recuperar datos del formulario
$nombre_negocio = trim($_POST['nombre_negocio']);
$nombre_responsable = trim($_POST['nombre_responsable']);
$email_negocio = trim($_POST['email_negocio']);
$telefono_negocio = trim($_POST['telefono_negocio']);
$giro_comercial = trim($_POST['giro_comercial']);
$otro_giro = ($giro_comercial === 'otro') ? trim($_POST['otro_giro']) : '';
$tipo_comercio = ($giro_comercial === 'otro') ? $otro_giro : $giro_comercial;

// Dirección
$codigo_postal = trim($_POST['codigo_postal']);
$calle = trim($_POST['calle']);
$numero = trim($_POST['numero']);
$manzana = trim($_POST['manzana']);
$lote = trim($_POST['lote']);
$colonia = trim($_POST['colonia']);
$municipio = trim($_POST['municipio']);
$estado = trim($_POST['estado']);
$referencias = trim($_POST['referencias']);

// Horarios
$hora_apertura = trim($_POST['hora_apertura']);
$hora_cierre = trim($_POST['hora_cierre']);
$dias_operacion = trim($_POST['dias_operacion']);

// Verificar si el correo ya existe
$sql_check = "SELECT id_usuario FROM usuario WHERE correo = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("s", $email_negocio);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    header('Location: integrate.php?error=' . urlencode('El correo ya está registrado. Por favor usa otro correo o inicia sesión.'));
    exit();
}
$stmt_check->close();

// Iniciar transacción
$conn->begin_transaction();

try {
    // 1. Crear usuario (con contraseña temporal)
    $contrasena_temporal = bin2hex(random_bytes(8)); // Generar contraseña aleatoria
    $contrasena_hash = password_hash($contrasena_temporal, PASSWORD_DEFAULT);
    $id_rol = 2; // Comercio
    
    $sql_usuario = "INSERT INTO usuario (nombre, correo, contrasena, id_rol) VALUES (?, ?, ?, ?)";
    $stmt_usuario = $conn->prepare($sql_usuario);
    $stmt_usuario->bind_param("sssi", $nombre_negocio, $email_negocio, $contrasena_hash, $id_rol);
    $stmt_usuario->execute();
    $id_usuario = $conn->insert_id;
    $stmt_usuario->close();
    
    // 2. Insertar dirección
    $sql_direccion = "INSERT INTO direccion (codigo_postal, calle, numero, manzana, lote, colonia, municipio, estado, referencias) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_direccion = $conn->prepare($sql_direccion);
    $stmt_direccion->bind_param("sssssssss", $codigo_postal, $calle, $numero, $manzana, $lote, $colonia, $municipio, $estado, $referencias);
    $stmt_direccion->execute();
    $id_direccion = $conn->insert_id;
    $stmt_direccion->close();
    
    // 3. Insertar comercio
    $sql_comercio = "INSERT INTO comercio (nombre_responsable, tipo_comercio, horario_apertura, horario_cierre, dias_operacion, id_usuario, id_direccion) 
                     VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt_comercio = $conn->prepare($sql_comercio);
    $stmt_comercio->bind_param("sssssii", $nombre_responsable, $tipo_comercio, $hora_apertura, $hora_cierre, $dias_operacion, $id_usuario, $id_direccion);
    $stmt_comercio->execute();
    $stmt_comercio->close();
    
    // Confirmar transacción
    $conn->commit();
    
    // Enviar email con contraseña (opcional - implementar después)
    // mail($email_negocio, "Bienvenido a Delivery Warrior", "Tu contraseña temporal es: " . $contrasena_temporal);
    
    // Redirigir con mensaje de éxito
    header('Location: integrate.php?success=1&password=' . urlencode($contrasena_temporal));
    exit();
    
} catch (Exception $e) {
    // Revertir cambios en caso de error
    $conn->rollback();
    header('Location: integrate.php?error=' . urlencode('Error al procesar el registro: ' . $e->getMessage()));
    exit();
}

$conn->close();
?>
