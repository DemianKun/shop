<?php
session_start();
require_once '../config.php';

// Verificar sesión y rol
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] != 4) {
    header('Location: ../login.php');
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$usuario_nombre = $_SESSION['nombre'];

// Obtener estadísticas del usuario
$stmt = $pdo->prepare("
    SELECT
        COUNT(DISTINCT c.id) as total_cotizaciones,
        COUNT(DISTINCT co.id) as total_contactos
    FROM usuario u
    LEFT JOIN cotizaciones c ON c.id_usuario = u.id_usuario
    LEFT JOIN contactos co ON co.id_usuario = u.id_usuario
    WHERE u.id_usuario = ?
");
$stmt->execute([$usuario_id]);
$stats = $stmt->fetch(PDO::FETCH_ASSOC);

// Obtener últimas cotizaciones del usuario
$stmt = $pdo->prepare("
    SELECT id, origen, destino, peso, dimensiones, fecha_creacion, nombre, telefono
    FROM cotizaciones
    WHERE id_usuario = ?
    ORDER BY fecha_creacion DESC
    LIMIT 5
");
$stmt->execute([$usuario_id]);
$cotizaciones = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Obtener direcciones guardadas del usuario (si existen)
$stmt = $pdo->prepare("
    SELECT d.*
    FROM direccion d
    INNER JOIN comercio c ON c.id_direccion = d.id_direccion
    INNER JOIN usuario u ON u.id_usuario = c.id_usuario
    WHERE u.id_usuario = ?
    LIMIT 1
");
$stmt->execute([$usuario_id]);
$direccion_guardada = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Panel - Delivery Warrior</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/dashboard/usuario.css">
    <style>
        /* Estilos adicionales para el nuevo diseño */
        .hero-user-section {
            background: linear-gradient(135deg, #1a130d 0%, #14100d 100%);
            padding: 60px 0 40px;
            position: relative;
            overflow: hidden;
        }

        .hero-user-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M 40 0 L 0 0 0 40" fill="none" stroke="rgba(254,129,13,0.05)" stroke-width="1"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grid)"/></svg>');
        }

        .hero-user-content {
            position: relative;
            z-index: 1;
        }

        .hero-user-title {
            font-size: 3rem;
            font-weight: 900;
            background: linear-gradient(135deg, #fe810d, #ffb347);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .hero-user-subtitle {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 30px;
        }

        .quick-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }

        .quick-stat-item {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(254, 129, 13, 0.2);
            border-radius: 16px;
            padding: 25px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .quick-stat-item:hover {
            border-color: rgba(254, 129, 13, 0.5);
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(254, 129, 13, 0.2);
        }

        .quick-stat-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto 15px;
            background: linear-gradient(135deg, #fe810d, #ff9b3d);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: white;
        }

        .quick-stat-number {
            font-size: 2rem;
            font-weight: 900;
            color: var(--primary-color);
            margin: 10px 0 5px;
        }

        .quick-stat-label {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-top: 40px;
        }

        .service-card-modern {
            background: rgba(255, 255, 255, 0.04);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 35px;
            text-align: center;
            transition: all 0.4s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .service-card-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(254, 129, 13, 0.1), rgba(255, 155, 61, 0.1));
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .service-card-modern:hover {
            border-color: rgba(254, 129, 13, 0.5);
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(254, 129, 13, 0.3);
        }

        .service-card-modern:hover::before {
            opacity: 1;
        }

        .service-card-icon {
            position: relative;
            z-index: 1;
            width: 90px;
            height: 90px;
            margin: 0 auto 20px;
            background: linear-gradient(135deg, #fe810d, #ff9b3d);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: white;
            box-shadow: 0 10px 30px rgba(254, 129, 13, 0.4);
            transition: all 0.4s ease;
        }

        .service-card-modern:hover .service-card-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .service-card-title {
            position: relative;
            z-index: 1;
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        .service-card-desc {
            position: relative;
            z-index: 1;
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .service-card-btn {
            position: relative;
            z-index: 1;
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #fe810d, #ff9b3d);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .service-card-btn:hover {
            background: transparent;
            border-color: var(--primary-color);
            color: var(--primary-color);
            transform: scale(1.05);
        }

        .recent-activity-section {
            margin-top: 50px;
            background: rgba(255, 255, 255, 0.04);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 35px;
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .section-header h3 {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-color);
            margin: 0;
        }

        .activity-item {
            background: rgba(255, 255, 255, 0.03);
            border-left: 4px solid var(--primary-color);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .activity-item:hover {
            background: rgba(255, 255, 255, 0.06);
            transform: translateX(5px);
        }

        .activity-date {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.5);
            margin-bottom: 8px;
        }

        .activity-content {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            background: rgba(254, 129, 13, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-color);
        }

        .activity-details h5 {
            margin: 0 0 5px 0;
            color: white;
            font-size: 1rem;
        }

        .activity-details p {
            margin: 0;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .hero-user-title {
                font-size: 2rem;
            }

            .services-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body class="dashboard-body">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark dashboard-navbar">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-bolt me-2"></i>
                <span>DELIVERY WARRIOR</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="panel_usuario.php">
                            <i class="fas fa-home"></i> Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">
                            <i class="fas fa-globe"></i> Sitio Web
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle"></i> <?php echo htmlspecialchars($usuario_nombre); ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="fas fa-user-edit"></i> Mi Perfil</a></li>
                            <li><a class="dropdown-item" href="#"><i class="fas fa-cog"></i> Configuración</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="../logout.php"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-user-section">
        <div class="container">
            <div class="hero-user-content">
                <h1 class="hero-user-title">¡Bienvenido de vuelta!</h1>
                <p class="hero-user-subtitle">Hola, <strong><?php echo htmlspecialchars($usuario_nombre); ?></strong>. Gestiona tus envíos de manera rápida y eficiente.</p>

                <!-- Quick Stats -->
                <div class="quick-stats">
                    <div class="quick-stat-item">
                        <div class="quick-stat-icon">
                            <i class="fas fa-calculator"></i>
                        </div>
                        <div class="quick-stat-number"><?php echo $stats['total_cotizaciones'] ?? 0; ?></div>
                        <div class="quick-stat-label">Cotizaciones</div>
                    </div>

                    <div class="quick-stat-item">
                        <div class="quick-stat-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="quick-stat-number"><?php echo $stats['total_contactos'] ?? 0; ?></div>
                        <div class="quick-stat-label">Mensajes</div>
                    </div>

                    <div class="quick-stat-item">
                        <div class="quick-stat-icon">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <div class="quick-stat-number">0</div>
                        <div class="quick-stat-label">Pedidos Activos</div>
                    </div>

                    <div class="quick-stat-item">
                        <div class="quick-stat-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="quick-stat-number">0</div>
                        <div class="quick-stat-label">Completados</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container py-5">
        <!-- Services Section -->
        <div class="text-center mb-4">
            <h2 class="section-title" style="display: inline-block;">
                <i class="fas fa-rocket me-2"></i>¿Qué deseas hacer hoy?
            </h2>
        </div>

        <div class="services-grid">
            <!-- Nuevo Pedido -->
            <div class="service-card-modern" data-bs-toggle="modal" data-bs-target="#nuevoPedidoModal">
                <div class="service-card-icon">
                    <i class="fas fa-shipping-fast"></i>
                </div>
                <h3 class="service-card-title">Crear Pedido</h3>
                <p class="service-card-desc">Inicia un nuevo envío. Registra origen, destino y detalles del paquete.</p>
                <span class="service-card-btn">Comenzar <i class="fas fa-arrow-right ms-2"></i></span>
            </div>

            <!-- Cotizar Envío -->
            <div class="service-card-modern" onclick="window.location.href='../cotizarenvio.php'">
                <div class="service-card-icon">
                    <i class="fas fa-calculator"></i>
                </div>
                <h3 class="service-card-title">Cotizar Envío</h3>
                <p class="service-card-desc">Calcula el costo de tu envío antes de crear el pedido.</p>
                <a href="../cotizarenvio.php" class="service-card-btn">Cotizar Ahora <i class="fas fa-arrow-right ms-2"></i></a>
            </div>

            <!-- Rastrear Pedido -->
            <div class="service-card-modern" onclick="alert('Próximamente: Sistema de rastreo en tiempo real')">
                <div class="service-card-icon">
                    <i class="fas fa-map-marked-alt"></i>
                </div>
                <h3 class="service-card-title">Rastrear Pedido</h3>
                <p class="service-card-desc">Sigue tu paquete en tiempo real desde el origen hasta el destino.</p>
                <span class="service-card-btn">Rastrear <i class="fas fa-arrow-right ms-2"></i></span>
            </div>

            <!-- Soporte -->
            <div class="service-card-modern" onclick="window.location.href='../index.php#contact'">
                <div class="service-card-icon">
                    <i class="fas fa-headset"></i>
                </div>
                <h3 class="service-card-title">Soporte 24/7</h3>
                <p class="service-card-desc">¿Necesitas ayuda? Nuestro equipo está disponible para ti.</p>
                <a href="../index.php#contact" class="service-card-btn">Contactar <i class="fas fa-arrow-right ms-2"></i></a>
            </div>
        </div>

        <!-- Recent Activity -->
        <?php if (count($cotizaciones) > 0): ?>
        <div class="recent-activity-section">
            <div class="section-header">
                <h3><i class="fas fa-history me-2"></i>Actividad Reciente</h3>
                <a href="#" class="btn btn-outline-primary btn-sm">Ver Todo</a>
            </div>

            <?php foreach ($cotizaciones as $cot): ?>
            <div class="activity-item">
                <div class="activity-date">
                    <i class="fas fa-clock me-1"></i>
                    <?php echo date('d/m/Y - H:i', strtotime($cot['fecha_creacion'])); ?>
                </div>
                <div class="activity-content">
                    <div class="activity-icon">
                        <i class="fas fa-file-invoice"></i>
                    </div>
                    <div class="activity-details flex-grow-1">
                        <h5>Cotización de Envío</h5>
                        <p>
                            <i class="fas fa-map-marker-alt text-success me-1"></i>
                            <strong><?php echo htmlspecialchars($cot['origen']); ?></strong>
                            <i class="fas fa-arrow-right mx-2"></i>
                            <i class="fas fa-flag-checkered text-danger me-1"></i>
                            <strong><?php echo htmlspecialchars($cot['destino']); ?></strong>
                            <?php if($cot['peso']): ?>
                            | Peso: <?php echo $cot['peso']; ?> kg
                            <?php endif; ?>
                        </p>
                    </div>
                    <button class="btn btn-sm btn-outline-primary" onclick="alert('Próximamente: Ver detalles completos')">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="recent-activity-section text-center">
            <div style="font-size: 4rem; color: rgba(255,255,255,0.1); margin-bottom: 20px;">
                <i class="fas fa-inbox"></i>
            </div>
            <h4 style="color: rgba(255,255,255,0.7); margin-bottom: 15px;">No tienes actividad reciente</h4>
            <p style="color: rgba(255,255,255,0.5); margin-bottom: 25px;">Comienza creando tu primera cotización o pedido</p>
            <a href="../cotizarenvio.php" class="btn btn-primary btn-lg">
                <i class="fas fa-plus-circle me-2"></i>Crear Primera Cotización
            </a>
        </div>
        <?php endif; ?>
    </div>

    <!-- Modal Nuevo Pedido -->
    <div class="modal fade" id="nuevoPedidoModal" tabindex="-1" aria-labelledby="nuevoPedidoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nuevoPedidoLabel">
                        <i class="fas fa-shipping-fast me-2"></i>Crear Nuevo Pedido
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formNuevoPedido" action="procesar_pedido.php" method="POST">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nombre Completo</label>
                                <input type="text" class="form-control" name="nombre" value="<?php echo htmlspecialchars($usuario_nombre); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Teléfono de Contacto</label>
                                <input type="tel" class="form-control" name="telefono" required>
                            </div>
                        </div>

                        <h6 class="border-bottom pb-2 mb-3"><i class="fas fa-map-marker-alt me-2"></i>Dirección de Origen</h6>
                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label class="form-label">Calle</label>
                                <input type="text" class="form-control" name="origen_calle" value="<?php echo $direccion_guardada ? htmlspecialchars($direccion_guardada['calle']) : ''; ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Número</label>
                                <input type="text" class="form-control" name="origen_numero" value="<?php echo $direccion_guardada ? htmlspecialchars($direccion_guardada['numero']) : ''; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Colonia</label>
                                <input type="text" class="form-control" name="origen_colonia" value="<?php echo $direccion_guardada ? htmlspecialchars($direccion_guardada['colonia']) : ''; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Código Postal</label>
                                <input type="text" class="form-control" name="origen_cp" value="<?php echo $direccion_guardada ? htmlspecialchars($direccion_guardada['codigo_postal']) : ''; ?>" required>
                            </div>
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
                                    <option value="Paquete Especial">Paquete Especial</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Valor Declarado ($)</label>
                                <input type="number" step="0.01" class="form-control" name="valor" required>
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
                            <i class="fas fa-paper-plane me-2"></i>Crear Pedido
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>