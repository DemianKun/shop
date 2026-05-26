<?php
session_start();
require_once '../config.php';

// Verificar sesión y rol
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] != 3) {
    header('Location: ../login.php');
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$usuario_nombre = $_SESSION['nombre'];

// Obtener datos del repartidor
$stmt = $pdo->prepare("
    SELECT r.*, v.tipo_vehiculo, v.marca, v.modelo, v.color, v.matricula
    FROM repartidor r
    LEFT JOIN vehiculo v ON v.id_vehiculo = r.id_vehiculo
    WHERE r.id_usuario = ?
");
$stmt->execute([$usuario_id]);
$repartidor = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$repartidor) {
    die("Error: No se encontró el perfil de repartidor");
}

// Obtener estadísticas del repartidor
$stmt = $pdo->prepare("
    SELECT
        COUNT(*) as total_entregas,
        SUM(CASE WHEN ee.nuevo_estado = 'Entregado' THEN 1 ELSE 0 END) as entregas_exitosas,
        SUM(CASE WHEN ee.nuevo_estado = 'En tránsito' THEN 1 ELSE 0 END) as en_transito,
        SUM(CASE WHEN DATE(ee.fecha) = CURDATE() THEN 1 ELSE 0 END) as entregas_hoy
    FROM repartidor r
    INNER JOIN envios e ON e.id_envio = r.id_envio
    LEFT JOIN estado_envio ee ON ee.id_envio = e.id_envio AND ee.id_estado = (
        SELECT MAX(id_estado) FROM estado_envio WHERE id_envio = e.id_envio
    )
    WHERE r.id_usuario = ?
");
$stmt->execute([$usuario_id]);
$stats = $stmt->fetch(PDO::FETCH_ASSOC);

// Obtener envíos asignados al repartidor
$stmt = $pdo->prepare("
    SELECT
        e.*,
        d.calle as origen_calle,
        d.colonia as origen_colonia,
        d.numero as origen_numero,
        dest.calle as destino_calle,
        dest.colonia as destino_colonia,
        dest.numero as destino_numero,
        dest.instrucciones,
        ee.nuevo_estado,
        ee.fecha as estado_fecha,
        c.nombre_responsable as comercio_nombre,
        c.tipo_comercio
    FROM repartidor r
    INNER JOIN envios e ON e.id_envio = r.id_envio
    LEFT JOIN direccion d ON d.id_direccion = e.id_direccion
    LEFT JOIN destino dest ON dest.id_destino = e.id_destino
    LEFT JOIN comercio c ON c.id_comercio = e.id_comercio
    LEFT JOIN estado_envio ee ON ee.id_envio = e.id_envio AND ee.id_estado = (
        SELECT MAX(id_estado) FROM estado_envio WHERE id_envio = e.id_envio
    )
    WHERE r.id_usuario = ?
    ORDER BY e.fecha_entrega ASC
    LIMIT 15
");
$stmt->execute([$usuario_id]);
$entregas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Calcular tasa de éxito
$tasa_exito = $stats['total_entregas'] > 0
    ? round(($stats['entregas_exitosas'] / $stats['total_entregas']) * 100, 1)
    : 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Repartidor - Delivery Warrior</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/dashboard/repartidor.css">
</head>
<body class="dashboard-body">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark dashboard-navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-motorcycle me-2"></i>
                <span>Panel de Repartidor</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="panel_repartidor.php">
                            <i class="fas fa-route"></i> Mis Rutas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="alert('Próximamente')">
                            <i class="fas fa-map-marked-alt"></i> Mapa
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle"></i> <?php echo htmlspecialchars($usuario_nombre); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-car"></i> Mi Vehículo</a></li>
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
                            <h1 class="welcome-title">¡Hola, <?php echo htmlspecialchars($usuario_nombre); ?>!</h1>
                            <p class="welcome-subtitle">
                                <i class="fas fa-car me-2"></i><?php echo htmlspecialchars($repartidor['tipo_vehiculo'] . ' ' . $repartidor['marca'] . ' ' . $repartidor['modelo']); ?>
                                <span class="ms-3"><i class="fas fa-palette me-2"></i><?php echo htmlspecialchars($repartidor['color']); ?></span>
                                <span class="ms-3"><i class="fas fa-id-card me-2"></i><?php echo htmlspecialchars($repartidor['matricula']); ?></span>
                            </p>
                        </div>
                        <div class="welcome-icon">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <div class="stat-card stat-primary">
                        <div class="stat-icon">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number"><?php echo $stats['total_entregas'] ?? 0; ?></h3>
                            <p class="stat-label">Total Entregas</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="stat-card stat-success">
                        <div class="stat-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number"><?php echo $stats['entregas_exitosas'] ?? 0; ?></h3>
                            <p class="stat-label">Completadas</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="stat-card stat-warning">
                        <div class="stat-icon">
                            <i class="fas fa-truck-loading"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number"><?php echo $stats['en_transito'] ?? 0; ?></h3>
                            <p class="stat-label">En Tránsito</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="stat-card stat-info">
                        <div class="stat-icon">
                            <i class="fas fa-percentage"></i>
                        </div>
                        <div class="stat-content">
                            <h3 class="stat-number"><?php echo $tasa_exito; ?>%</h3>
                            <p class="stat-label">Tasa de Éxito</p>
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
                                <button class="action-btn" onclick="alert('Próximamente')">
                                    <i class="fas fa-qrcode"></i>
                                    <span>Escanear QR</span>
                                </button>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-3">
                                <button class="action-btn" onclick="alert('Próximamente')">
                                    <i class="fas fa-map-marked-alt"></i>
                                    <span>Ver Ruta Óptima</span>
                                </button>
                            </div>
                            <div class="col-md-3 col-sm-6 mb-3">
                                <button class="action-btn" onclick="alert('Próximamente')">
                                    <i class="fas fa-history"></i>
                                    <span>Historial</span>
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

            <!-- Deliveries Table -->
            <div class="row">
                <div class="col-12">
                    <div class="table-card">
                        <h2 class="section-title">
                            <i class="fas fa-clipboard-list me-2"></i>Entregas Asignadas
                        </h2>
                        <?php if (count($entregas) > 0): ?>
                        <div class="table-responsive">
                            <table class="table custom-table">
                                <thead>
                                    <tr>
                                        <th>Referencia</th>
                                        <th>Origen</th>
                                        <th>Destino</th>
                                        <th>Tipo</th>
                                        <th>Fecha</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($entregas as $entrega): ?>
                                    <tr>
                                        <td><strong><?php echo htmlspecialchars($entrega['n_referencia']); ?></strong></td>
                                        <td>
                                            <i class="fas fa-store text-success me-1"></i>
                                            <?php echo htmlspecialchars($entrega['origen_colonia'] ?? 'N/A'); ?>
                                        </td>
                                        <td>
                                            <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                            <?php echo htmlspecialchars($entrega['destino_calle'] . ' ' . $entrega['destino_numero'] . ', ' . $entrega['destino_colonia']); ?>
                                        </td>
                                        <td>
                                            <span class="badge-package"><?php echo htmlspecialchars($entrega['tipo_paquete']); ?></span>
                                        </td>
                                        <td><?php echo date('d/m/Y', strtotime($entrega['fecha_entrega'])); ?></td>
                                        <td>
                                            <?php
                                            $estado = $entrega['nuevo_estado'] ?? 'Pendiente';
                                            $badge_class = 'badge-pending';
                                            if ($estado == 'Entregado') $badge_class = 'badge-delivered';
                                            elseif ($estado == 'En tránsito') $badge_class = 'badge-transit';
                                            elseif ($estado == 'Fallido') $badge_class = 'badge-failed';
                                            ?>
                                            <span class="status-badge <?php echo $badge_class; ?>"><?php echo htmlspecialchars($estado); ?></span>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" onclick="verDetalles(<?php echo $entrega['id_envio']; ?>)">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <?php if ($estado != 'Entregado' && $estado != 'Fallido'): ?>
                                            <button class="btn btn-sm btn-outline-success" onclick="marcarEntregado(<?php echo $entrega['id_envio']; ?>)">
                                                <i class="fas fa-check"></i>
                                            </button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-truck"></i>
                            <p>No tienes entregas asignadas en este momento</p>
                            <p class="text-muted">Contacta con tu supervisor para recibir nuevas asignaciones</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detalles -->
    <div class="modal fade" id="detallesModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-info-circle me-2"></i>Detalles de la Entrega
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="detallesContent">
                    <!-- Contenido dinámico -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    const entregas = <?php echo json_encode($entregas); ?>;

    function verDetalles(id) {
        const entrega = entregas.find(e => e.id_envio == id);
        if (!entrega) return;

        const content = `
            <div class="delivery-details">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6><i class="fas fa-hashtag me-2"></i>Referencia</h6>
                        <p>${entrega.n_referencia}</p>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-box me-2"></i>Tipo de Paquete</h6>
                        <p>${entrega.tipo_paquete}</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <h6><i class="fas fa-store me-2"></i>Origen</h6>
                        <p>${entrega.origen_calle || ''} ${entrega.origen_numero || ''}, ${entrega.origen_colonia || 'N/A'}</p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <h6><i class="fas fa-map-marker-alt me-2"></i>Destino</h6>
                        <p>${entrega.destino_calle} ${entrega.destino_numero}, ${entrega.destino_colonia}</p>
                    </div>
                </div>
                ${entrega.instrucciones ? `
                <div class="row mb-3">
                    <div class="col-12">
                        <h6><i class="fas fa-sticky-note me-2"></i>Instrucciones</h6>
                        <p>${entrega.instrucciones}</p>
                    </div>
                </div>
                ` : ''}
                <div class="row">
                    <div class="col-md-6">
                        <h6><i class="fas fa-dollar-sign me-2"></i>Valor</h6>
                        <p>$${parseFloat(entrega.valor).toFixed(2)}</p>
                    </div>
                    <div class="col-md-6">
                        <h6><i class="fas fa-calendar me-2"></i>Fecha de Entrega</h6>
                        <p>${new Date(entrega.fecha_entrega).toLocaleDateString('es-MX')}</p>
                    </div>
                </div>
            </div>
        `;

        document.getElementById('detallesContent').innerHTML = content;
        new bootstrap.Modal(document.getElementById('detallesModal')).show();
    }

    function marcarEntregado(id) {
        if (confirm('¿Confirmar que este paquete fue entregado?')) {
            window.location.href = `actualizar_estado.php?id=${id}&estado=entregado`;
        }
    }
    </script>
</body>
</html>