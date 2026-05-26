<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] != 3) {
    header('Location: ../login.php');
    exit();
}

if (!isset($_GET['id']) || !isset($_GET['estado'])) {
    header('Location: panel_repartidor.php?error=parametros_invalidos');
    exit();
}

$id_envio = $_GET['id'];
$nuevo_estado = $_GET['estado'] == 'entregado' ? 'Entregado' : 'Fallido';

try {
    $stmt = $pdo->prepare("
        INSERT INTO estado_envio (id_envio, fecha, hora, nuevo_estado, observaciones)
        VALUES (?, CURDATE(), TIME_FORMAT(NOW(), '%H:%i'), ?, 'Actualizado por repartidor')
    ");
    $stmt->execute([$id_envio, $nuevo_estado]);
    
    header('Location: panel_repartidor.php?actualizacion=exitosa');
    exit();
    
} catch (Exception $e) {
    header('Location: panel_repartidor.php?error=' . urlencode($e->getMessage()));
    exit();
}
?>
