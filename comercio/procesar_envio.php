<?php
session_start();
require_once '../config.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] != 2) {
    header('Location: ../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $pdo->beginTransaction();
        
        // Obtener id_comercio del usuario
        $stmt = $pdo->prepare("SELECT id_comercio, id_direccion FROM comercio WHERE id_usuario = ?");
        $stmt->execute([$_SESSION['usuario_id']]);
        $comercio = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$comercio) {
            throw new Exception("Comercio no encontrado");
        }
        
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
        
        // Generar número de referencia
        $n_referencia = 'COM-' . str_pad($comercio['id_comercio'], 4, '0', STR_PAD_LEFT) . '-' . date('Ymd') . '-' . rand(100, 999);
        
        // Crear el envío
        $stmt = $pdo->prepare("
            INSERT INTO envios (
                empresa, valor, fecha_entrega, n_referencia, horario_recoger,
                tipo_paquete, id_direccion, id_destino, id_comercio
            ) VALUES (?, ?, ?, ?, '09:00-18:00', ?, ?, ?, ?)
        ");
        $stmt->execute([
            $_POST['empresa'],
            $_POST['valor'],
            $_POST['fecha_entrega'],
            $n_referencia,
            $_POST['tipo_paquete'],
            $comercio['id_direccion'],
            $id_destino,
            $comercio['id_comercio']
        ]);
        
        $id_envio = $pdo->lastInsertId();
        
        // Registrar estado inicial
        $stmt = $pdo->prepare("
            INSERT INTO estado_envio (id_envio, fecha, hora, nuevo_estado, observaciones)
            VALUES (?, CURDATE(), TIME_FORMAT(NOW(), '%H:%i'), 'Pendiente', 'Envío registrado')
        ");
        $stmt->execute([$id_envio]);
        
        $pdo->commit();
        header('Location: panel_comercio.php?envio=exitoso');
        exit();
        
    } catch (Exception $e) {
        $pdo->rollback();
        header('Location: panel_comercio.php?error=' . urlencode($e->getMessage()));
        exit();
    }
} else {
    header('Location: panel_comercio.php');
    exit();
}
?>
