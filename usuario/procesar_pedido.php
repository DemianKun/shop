<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] != 1) {
    header('Location: ../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $pdo->beginTransaction();
        
        $usuario_id = $_SESSION['usuario_id'];
        
        // Insertar dirección de origen
        $stmt = $pdo->prepare("
            INSERT INTO direccion (calle, numero, colonia, codigo_postal, municipio, estado)
            VALUES (?, ?, ?, ?, 'Ixtapaluca', 'México')
        ");
        $stmt->execute([
            $_POST['origen_calle'],
            $_POST['origen_numero'],
            $_POST['origen_colonia'],
            $_POST['origen_cp']
        ]);
        $id_origen = $pdo->lastInsertId();
        
        // Insertar dirección de destino
        $stmt = $pdo->prepare("
            INSERT INTO destino (calle, numero, colonia, codigo_postal, municipio, estado, instrucciones)
            VALUES (?, ?, ?, ?, 'Ixtapaluca', 'México', ?)
        ");
        $stmt->execute([
            $_POST['destino_calle'],
            $_POST['destino_numero'],
            $_POST['destino_colonia'],
            $_POST['destino_cp'],
            $_POST['instrucciones'] ?? ''
        ]);
        $id_destino = $pdo->lastInsertId();
        
        // Crear el envío (sin empresa ni comercio por ahora)
        $stmt = $pdo->prepare("
            INSERT INTO envios (
                empresa, valor, fecha_entrega, n_referencia, 
                tipo_paquete, id_direccion, id_destino
            ) VALUES (
                'Usuario Particular', ?, DATE_ADD(CURDATE(), INTERVAL 2 DAY), 
                CONCAT('USR-', LPAD(?, 6, '0'), '-', YEAR(NOW())), 
                ?, ?, ?
            )
        ");
        $stmt->execute([
            $_POST['valor'],
            $usuario_id,
            $_POST['tipo_paquete'],
            $id_origen,
            $id_destino
        ]);
        
        $pdo->commit();
        header('Location: panel_usuario.php?pedido=exitoso');
        exit();
        
    } catch (Exception $e) {
        $pdo->rollback();
        header('Location: panel_usuario.php?error=' . urlencode($e->getMessage()));
        exit();
    }
} else {
    header('Location: panel_usuario.php');
    exit();
}
?>
