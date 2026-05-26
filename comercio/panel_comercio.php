<?php
session_start();
require_once '../config.php';

// Verificar sesión y rol
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] != 2) {
    header('Location: ../login.php');
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$usuario_nombre = $_SESSION['nombre'];

// Obtener datos del comercio
$stmt = $pdo->prepare("
    SELECT c.*, d.calle, d.numero, d.colonia, d.municipio, d.estado, d.codigo_postal
    FROM comercio c
    LEFT JOIN direccion d ON d.id_direccion = c.id_direccion
    WHERE c.id_usuario = ?
");
$stmt->execute([$usuario_id]);
$comercio = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$comercio) {
    die("Error: No se encontró el comercio asociado");
}

// Obtener estadísticas del comercio
$stmt = $pdo->prepare("
    SELECT
        COUNT(*) as total_pedidos,
        SUM(CASE WHEN DATE(e.fecha_entrega) = CURDATE() THEN 1 ELSE 0 END) as pedidos_hoy,
        SUM(e.valor) as valor_total
    FROM envios e
    WHERE e.id_comercio = ?
");
$stmt->execute([$comercio['id_comercio']]);
$stats = $stmt->fetch(PDO::FETCH_ASSOC);

// Obtener pedidos recientes del comercio
$stmt = $pdo->prepare("
    SELECT
        e.*,
        d.calle as destino_calle,
        d.colonia as destino_colonia,
        d.municipio as destino_municipio,
        ee.nuevo_estado,
        ee.fecha as estado_fecha
    FROM envios e
    LEFT JOIN destino d ON d.id_destino = e.id_destino
    LEFT JOIN estado_envio ee ON ee.id_envio = e.id_envio AND ee.id_estado = (
        SELECT MAX(id_estado) FROM estado_envio WHERE id_envio = e.id_envio
    )
    WHERE e.id_comercio = ?
    ORDER BY e.fecha_entrega DESC
    LIMIT 10
");
$stmt->execute([$comercio['id_comercio']]);
$pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Comercio - Delivery Warrior</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/dashboard/comercio.css">
</head>
<body class="dashboard-body">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark dashboard-navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-store me-2"></i>
                <span>Panel de Comercio</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="panel_comercio.php">
                            <i class="fas fa-chart-line"></i> Panel
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#nuevoPedidoModal">
                            <i class="fas fa-plus-circle"></i> Solicitar Envío
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-tie"></i> <?php echo htmlspecialchars($comercio['nombre_responsable']); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-store-alt"></i> Mi Comercio</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog"></i> Configuración</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="../logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="dashboard-container">
        <div class="container-fluid py-4">
            <!-- Header -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="welcome-card">
                        <div class="welcome-content">
                            <h1 class="welcome-title"><?php echo htmlspecialchars($comercio['nombre_responsable']); ?></h1>
                            <p class="welcome-subtitle">
                                <i class="fas fa-store me-2"></i><?php echo htmlspecialchars($comercio['tipo_comercio']); ?>
                                <span class="ms-3"><i class="fas fa-map-marker-alt me-2"></i><?php echo htmlspecialchars($comercio['colonia'] . ', ' . $comercio['municipio']); ?></span>
                            </p>
                            <div class="business-hours mt-2">
                                <i class="fas fa-clock me-2"></i>
                                <strong>Horario:</strong>
                                <?php echo date('H:i', strtotime($comercio['horario_apertura'])); ?> -
                                <?php echo date('H:i', strtotime($comercio['horario_cierre'])); ?>
                                <span class="ms-2">(<?php echo htmlspecialchars($comercio['dias_operacion']); ?>)</span>
                            </div>
                        </div>
                        <div class="welcome-icon">
                            <i class="fas fa-store-alt"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <div class="stat-card stat-primary">
                        <div class="stat-icon">
                            <i class="fas fa-boxes"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number"><?php echo $stats['total_pedidos'] ?? 0; ?></h3>
                            <p class="stat-label">Total de Envíos</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="stat-card stat-success">
                        <div class="stat-icon">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number"><?php echo $stats['pedidos_hoy'] ?? 0; ?></h3>
                            <p class="stat-label">Envíos de Hoy</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="stat-card stat-warning">
                        <div class="stat-icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number">$<?php echo number_format($stats['valor_total'] ?? 0, 2); ?></h3>
                            <p class="stat-label">Valor Total Enviado</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="actions-card">
                        <h2 class="section-title">
                            <i class="fas fa-bolt me-2"></i>Acciones Rápidas
                        </h2>
                        <div class="row mt-3">
                            <div class="col-md-3 col-sm-6 mb-3">
                                <button class="action-btn" data-bs-toggle="modal" data-bs-target="#nuevoPedidoModal">
                                    <i class="fas fa-shipping-fast"></i>
                                    <span>Solicitar Envío</span>
                                </button>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-3">
                                <button class="action-btn" onclick="alert('Próximamente')">
                                    <i class="fas fa-history"></i>
                                    <span>Historial Completo</span>
                                </button>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-3">
                                <button class="action-btn" onclick="alert('Próximamente')">
                                    <i class="fas fa-chart-bar"></i>
                                    <span>Reportes</span>
                                </button>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-3">
                                <a href="../index.php#contact" class="action-btn">
                                    <i class="fas fa-headset"></i>
                                    <span>Soporte</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Orders Table -->
            <div class="row">
                <div class="col-12">
                    <div class="table-card">
                        <h2 class="section-title">
                            <i class="fas fa-list-ul me-2"></i>Pedidos Recientes
                        </h2>
                        <?php if (count($pedidos) > 0): ?>
                        <div class="table-responsive">
                            <table class="table custom-table">
                                <thead>
                                    <tr>
                                        <th>Referencia</th>
                                        <th>Destino</th>
                                        <th>Tipo Paquete</th>
                                        <th>Valor</th>
                                        <th>Fecha Entrega</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($pedidos as $pedido): ?>
                                    <tr>
                                        <td><strong><?php echo htmlspecialchars($pedido['n_referencia']); ?></strong></td>
                                        <td>
                                            <i class="fas fa-map-marker-alt text-primary me-1"></i>
                                            <?php echo htmlspecialchars($pedido['destino_colonia'] . ', ' . $pedido['destino_municipio']); ?>
                                        </td>
                                        <td>
                                            <span class="badge-package"><?php echo htmlspecialchars($pedido['tipo_paquete']); ?></span>
                                        </td>
                                        <td class="text-success fw-bold">$<?php echo number_format($pedido['valor'], 2); ?></td>
                                        <td><?php echo date('d/m/Y', strtotime($pedido['fecha_entrega'])); ?></td>
                                        <td>
                                            <?php
                                            $estado = $pedido['nuevo_estado'] ?? 'Pendiente';
                                            $badge_class = 'badge-pending';
                                            if ($estado == 'Entregado') $badge_class = 'badge-delivered';
                                            elseif ($estado == 'En tránsito') $badge_class = 'badge-transit';
                                            elseif ($estado == 'Fallido') $badge_class = 'badge-failed';
                                            ?>
                                            <span class="status-badge <?php echo $badge_class; ?>"><?php echo htmlspecialchars($estado); ?></span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="verDetalle(<?php echo $pedido['id_envio']; ?>)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-box-open"></i>
                            <p>No tienes pedidos registrados</p>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoPedidoModal">
                                Crear Primer Pedido
                            </button>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Nuevo Pedido -->
    <div class="modal fade" id="nuevoPedidoModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-shipping-fast me-2"></i>Solicitar Nuevo Envío
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="procesar_envio.php" method="POST">
                    <div class="modal-body">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Origen:</strong> <?php echo htmlspecialchars($comercio['calle'] . ' ' . $comercio['numero'] . ', ' . $comercio['colonia']); ?>
                        </div>

                        <h6 class="border-bottom pb-2 mb-3"><i class="fas fa-flag-checkered me-2"></i>Dirección de Destino</h6>
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Calle</label>
                                <input type="text" class="form-control" name="destino_calle" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Número</label>
                                <input type="text" class="form-control" name="destino_numero" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Colonia</label>
                                <input type="text" class="form-control" name="destino_colonia" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Código Postal</label>
                                <input type="text" class="form-control" name="destino_cp" required>
                            </div>
                        </div>

                        <h6 class="border-bottom pb-2 mb-3"><i class="fas fa-box me-2"></i>Detalles del Paquete</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tipo de Paquete</label>
                                <select class="form-select" name="tipo_paquete" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="Sobre Pequeño">Sobre Pequeño</option>
                                    <option value="Caja Pequeña">Caja Pequeña</option>
                                    <option value="Caja Mediana">Caja Mediana</option>
                                    <option value="Caja Grande">Caja Grande</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Valor Declarado ($)</label>
                                <input type="number" step="0.01" class="form-control" name="valor" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Empresa/Cliente</label>
                                <input type="text" class="form-control" name="empresa" placeholder="Nombre del cliente" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Fecha de Entrega Deseada</label>
                                <input type="date" class="form-control" name="fecha_entrega" min="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Instrucciones Especiales</label>
                                <textarea class="form-control" name="instrucciones" rows="3"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane me-2"></i>Solicitar Envío
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function verDetalle(id) {
        alert('Ver detalle del pedido #' + id + '\n\nEsta función estará disponible próximamente.');
    }
    </script>
</body>
</html>