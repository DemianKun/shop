<?php
require_once 'config.php';

// Validar que se recibieron los datos básicos
if (!isset($_POST['nombre']) || !isset($_POST['correo']) || !isset($_POST['contrasena']) || !isset($_POST['id_rol'])) {
    header('Location: registro.php?error=Faltan campos obligatorios');
    exit();
}

$nombre = trim($_POST['nombre']);
$correo = trim($_POST['correo']);
$contrasena = password_hash(trim($_POST['contrasena']), PASSWORD_DEFAULT); // Hashear la contraseña
$confirmar_contrasena = trim($_POST['confirmar_contrasena']);
$id_rol = intval($_POST['id_rol']);

// Validaciones básicas
if (empty($nombre) || empty($correo) || empty($_POST['contrasena'])) {
    header('Location: registro.php?error=Todos los campos son obligatorios');
    exit();
}

if (trim($_POST['contrasena']) !== $confirmar_contrasena) {
    header('Location: registro.php?error=Las contraseñas no coinciden');
    exit();
}

if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    header('Location: registro.php?error=Correo electrónico inválido');
    exit();
}

// Verificar si el correo ya existe
$sql_check = "SELECT id_usuario FROM usuario WHERE correo = ?";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bind_param("s", $correo);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    header('Location: registro.php?error=El correo ya está registrado');
    exit();
}
$stmt_check->close();

// Iniciar transacción
$conn->begin_transaction();

try {
    // Insertar usuario
    $sql_usuario = "INSERT INTO usuario (nombre, correo, contrasena, id_rol) VALUES (?, ?, ?, ?)";
    $stmt_usuario = $conn->prepare($sql_usuario);
    $stmt_usuario->bind_param("sssi", $nombre, $correo, $contrasena, $id_rol);
    $stmt_usuario->execute();
    $id_usuario = $conn->insert_id;
    $stmt_usuario->close();
    
// Procesar según el rol
    if ($id_rol == 2) { // Comercio
        // Validar campos requeridos para comercio
        if (!isset($_POST['calle']) || !isset($_POST['numero']) || !isset($_POST['colonia']) || !isset($_POST['municipio']) || !isset($_POST['estado']) || !isset($_POST['codigo_postal']) || !isset($_POST['nombre_responsable']) || !isset($_POST['tipo_comercio']) || !isset($_POST['horario_apertura']) || !isset($_POST['horario_cierre'])) {
            throw new Exception('Faltan campos requeridos para el registro de comercio');
        }
        
        // Insertar dirección
        $calle = trim($_POST['calle']);
        $numero = trim($_POST['numero']);
        $manzana = trim($_POST['manzana']);
        $lote = trim($_POST['lote']);
        $colonia = trim($_POST['colonia']);
        $municipio = trim($_POST['municipio']);
        $estado = trim($_POST['estado']);
        $codigo_postal = trim($_POST['codigo_postal']);
        
        $sql_direccion = "INSERT INTO direccion (calle, numero, manzana, lote, colonia, municipio, estado, codigo_postal) 
                          VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_direccion = $conn->prepare($sql_direccion);
        $stmt_direccion->bind_param("ssssssss", $calle, $numero, $manzana, $lote, $colonia, $municipio, $estado, $codigo_postal);
        $stmt_direccion->execute();
        $id_direccion = $conn->insert_id;
        $stmt_direccion->close();
        
        // Insertar comercio
        $nombre_responsable = trim($_POST['nombre_responsable']);
        $tipo_comercio = trim($_POST['tipo_comercio']);
        $horario_apertura = trim($_POST['horario_apertura']);
        $horario_cierre = trim($_POST['horario_cierre']);
        
        $sql_comercio = "INSERT INTO comercio (nombre_responsable, tipo_comercio, horario_apertura, horario_cierre, id_usuario, id_direccion) 
                         VALUES (?, ?, ?, ?, ?, ?)";
        $stmt_comercio = $conn->prepare($sql_comercio);
        $stmt_comercio->bind_param("ssssii", $nombre_responsable, $tipo_comercio, $horario_apertura, $horario_cierre, $id_usuario, $id_direccion);
        $stmt_comercio->execute();
        $stmt_comercio->close();
        
    } elseif ($id_rol == 3) { // Repartidor
        // Validar campos requeridos para repartidor
        if (!isset($_POST['tipo_vehiculo']) || !isset($_POST['marca']) || !isset($_POST['modelo']) || !isset($_POST['color']) || !isset($_POST['matricula'])) {
            throw new Exception('Faltan campos requeridos para el registro de repartidor');
        }
        
        // Insertar vehículo
        $tipo_vehiculo = trim($_POST['tipo_vehiculo']);
        $marca = trim($_POST['marca']);
        $modelo = trim($_POST['modelo']);
        $color = trim($_POST['color']);
        $matricula = trim($_POST['matricula']);
        
        $sql_vehiculo = "INSERT INTO vehiculo (tipo_vehiculo, marca, modelo, color, matricula) 
                         VALUES (?, ?, ?, ?, ?)";
        $stmt_vehiculo = $conn->prepare($sql_vehiculo);
        $stmt_vehiculo->bind_param("sssss", $tipo_vehiculo, $marca, $modelo, $color, $matricula);
        $stmt_vehiculo->execute();
        $id_vehiculo = $conn->insert_id;
        $stmt_vehiculo->close();
        
        // Insertar repartidor (sin id_envio por ahora, fecha_nac opcional)
        $sql_repartidor = "INSERT INTO repartidor (id_usuario, id_vehiculo) 
                           VALUES (?, ?)";
        $stmt_repartidor = $conn->prepare($sql_repartidor);
        $stmt_repartidor->bind_param("ii", $id_usuario, $id_vehiculo);
        $stmt_repartidor->execute();
        $stmt_repartidor->close();
    }
    
    // Confirmar transacción
    $conn->commit();
    
    // Redirigir al login con mensaje de éxito
    header('Location: login.php?registro=exitoso');
    exit();
    
} catch (Exception $e) {
    // Revertir cambios en caso de error
    $conn->rollback();
    header('Location: registro.php?error=' . urlencode('Error al procesar el registro: ' . $e->getMessage()));
    exit();
}

$conn->close();
?>
