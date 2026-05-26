<?php
session_start();
header("Content-Type: application/json");
require_once("conexion.php");

$token = $_POST['token'] ?? '';
$nueva = $_POST['nueva_contrasena'] ?? '';

if(empty($token) || empty($nueva)){
    echo json_encode(["status"=>"error","message"=>"Datos incompletos"]);
    exit;
}

// Buscar token válido
$sql = "SELECT usuario_id FROM tokens_recuperacion 
        WHERE token = ? AND expiracion > NOW() AND usado = 0";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $token);
$stmt->execute();
$resultado = $stmt->get_result();

if($resultado->num_rows === 1){

    $datos = $resultado->fetch_assoc();
    $usuario_id = $datos['usuario_id'];

    $hash = password_hash($nueva, PASSWORD_DEFAULT);

    // Actualizar contraseña
    $update = $conn->prepare("UPDATE usuario SET contrasena=? WHERE id_usuario=?");
    $update->bind_param("si", $hash, $usuario_id);
    $update->execute();

    // Marcar token como usado
    $marcar = $conn->prepare("UPDATE tokens_recuperacion SET usado=1 WHERE token=?");
    $marcar->bind_param("s", $token);
    $marcar->execute();

    echo json_encode(["status"=>"success","message"=>"Contraseña actualizada"]);

} else {
    echo json_encode(["status"=>"error","message"=>"Token inválido o expirado"]);
}

$conn->close();
?>