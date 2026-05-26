<?php
session_start();

// Verificar si el usuario está logueado y es administrador
if (!isset($_SESSION['id_usuario']) || $_SESSION['id_rol'] != 1) {
    header("Location: ../login.php");
    exit();
}

require_once '../config.php';

try {
    // Estadísticas generales
    $stats = [];

    // Total de usuarios por rol
    $stmt = $pdo->query("SELECT r.tipo_rol, COUNT(u.id_usuario) as total FROM usuario u JOIN rol r ON u.id_rol = r.id_rol GROUP BY r.id_rol, r.tipo_rol");
    $stats['usuarios_por_rol'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Total de envíos
    $stmt = $pdo->query("SELECT COUNT(*) as total_envios FROM envios");
    $stats['total_envios'] = $stmt->fetchColumn();

    // Envíos por estado
    $stmt = $pdo->query("SELECT nuevo_estado, COUNT(*) as total FROM estado_envio GROUP BY nuevo_estado");
    $stats['envios_por_estado'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Total de comercios
    $stmt = $pdo->query("SELECT COUNT(*) as total_comercios FROM comercio");
    $stats['total_comercios'] = $stmt->fetchColumn();

    // Total de repartidores
    $stmt = $pdo->query("SELECT COUNT(*) as total_repartidores FROM repartidor");
    $stats['total_repartidores'] = $stmt->fetchColumn();

    // Ingresos totales (suma de valores de envíos)
    $stmt = $pdo->query("SELECT SUM(valor) as ingresos_totales FROM envios");
    $stats['ingresos_totales'] = $stmt->fetchColumn();

    // Mensajes de contacto recientes (últimos 10)
    $stmt = $pdo->query("SELECT id, nombre, email, telefono, mensaje, tipo, fecha_creacion FROM contactos ORDER BY fecha_creacion DESC LIMIT 10");
    $mensajes_contacto = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Total de mensajes de contacto
    $stmt = $pdo->query("SELECT COUNT(*) as total_contactos FROM contactos");
    $stats['total_contactos'] = $stmt->fetchColumn();

} catch (PDOException $e) {
    die("Error en la consulta: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control General - Delivery Warrior</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../css/dashboard/admin.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="fas fa-tachometer-alt"></i> Panel de Control General
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="panel_administrador.php">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#usuarios">
                            <i class="fas fa-users"></i> Usuarios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#comercios">
                            <i class="fas fa-store"></i> Comercios
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#repartidores">
                            <i class="fas fa-truck"></i> Repartidores
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#envios">
                            <i class="fas fa-box"></i> Envíos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contactos">
                            <i class="fas fa-envelope"></i> Contactos
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-shield"></i> <?php echo htmlspecialchars($_SESSION['nombre']); ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../logout.php">
                                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                            </a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Estadísticas principales -->
            <div class="col-md-12 mb-4">
                <h2><i class="fas fa-chart-line"></i> Resumen General del Sistema</h2>
                <div class="row">
                    <div class="col-md-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-users"></i> Total Usuarios</h5>
                                <h3><?php echo array_sum(array_column($stats['usuarios_por_rol'], 'total')); ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-store"></i> Comercios</h5>
                                <h3><?php echo $stats['total_comercios']; ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-truck"></i> Repartidores</h5>
                                <h3><?php echo $stats['total_repartidores']; ?></h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-box"></i> Total Envíos</h5>
                                <h3><?php echo $stats['total_envios']; ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Usuarios por rol -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-chart-pie"></i> Usuarios por Rol</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="usuariosChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Envíos por estado -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-chart-bar"></i> Envíos por Estado</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="enviosChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Tabla de usuarios recientes -->
            <div class="col-md-12 mb-4" id="usuarios">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-users"></i> Gestión de Usuarios</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Rol</th>
                                        <th>Fecha Registro</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = $pdo->query("
                                        SELECT u.id_usuario, u.nombre, u.correo, r.tipo_rol, u.fecha_registro
                                        FROM usuario u
                                        JOIN rol r ON u.id_rol = r.id_rol
                                        ORDER BY u.fecha_registro DESC
                                        LIMIT 10
                                    ");
                                    while ($usuario = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<tr>";
                                        echo "<td>{$usuario['id_usuario']}</td>";
                                        echo "<td>{$usuario['nombre']}</td>";
                                        echo "<td>{$usuario['correo']}</td>";
                                        echo "<td><span class='badge bg-primary'>{$usuario['tipo_rol']}</span></td>";
                                        echo "<td>{$usuario['fecha_registro']}</td>";
                                        echo "<td>
                                                <button class='btn btn-sm btn-outline-primary'>Editar</button>
                                                <button class='btn btn-sm btn-outline-danger'>Eliminar</button>
                                              </td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de mensajes de contacto -->
            <div class="col-md-12 mb-4" id="contactos">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5><i class="fas fa-envelope"></i> Mensajes de Contacto</h5>
                        <span class="badge bg-info"><?php echo $stats['total_contactos']; ?> Total</span>
                    </div>
                    <div class="card-body">
                        <?php if (count($mensajes_contacto) > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Email</th>
                                        <th>Teléfono</th>
                                        <th>Mensaje</th>
                                        <th>Fecha</th>
                                        <th>Tipo</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($mensajes_contacto as $contacto): ?>
                                    <tr>
                                        <td><?php echo $contacto['id']; ?></td>
                                        <td><strong><?php echo htmlspecialchars($contacto['nombre']); ?></strong></td>
                                        <td>
                                            <a href="mailto:<?php echo htmlspecialchars($contacto['email']); ?>" class="text-primary">
                                                <i class="fas fa-envelope me-1"></i><?php echo htmlspecialchars($contacto['email']); ?>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="https://wa.me/52<?php echo htmlspecialchars($contacto['telefono']); ?>" target="_blank" class="text-success">
                                                <i class="fab fa-whatsapp me-1"></i><?php echo htmlspecialchars($contacto['telefono']); ?>
                                            </a>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-info" onclick="verMensaje('<?php echo htmlspecialchars(addslashes($contacto['mensaje'])); ?>')">
                                                <i class="fas fa-eye"></i> Ver mensaje
                                            </button>
                                        </td>
                                        <td><?php echo date('d/m/Y H:i', strtotime($contacto['fecha_creacion'])); ?></td>
                                        <td><span class="badge bg-secondary"><?php echo htmlspecialchars(ucfirst(str_replace('_', ' ', $contacto['tipo']))); ?></span></td>
                                        <td>
                                            <a href="https://wa.me/52<?php echo htmlspecialchars($contacto['telefono']); ?>?text=Hola%20<?php echo urlencode($contacto['nombre']); ?>,%20gracias%20por%20contactarnos." 
                                               target="_blank" 
                                               class="btn btn-sm btn-success">
                                                <i class="fab fa-whatsapp"></i> WhatsApp
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No hay mensajes de contacto</p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para ver mensaje completo -->
    <div class="modal fade" id="mensajeModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-comment-dots me-2"></i>Mensaje Completo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p id="mensajeCompleto" style="white-space: pre-wrap;"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Gráfico de usuarios por rol
        const usuariosCtx = document.getElementById('usuariosChart').getContext('2d');
        const usuariosData = <?php echo json_encode($stats['usuarios_por_rol']); ?>;
        new Chart(usuariosCtx, {
            type: 'pie',
            data: {
                labels: usuariosData.map(item => item.tipo_rol),
                datasets: [{
                    data: usuariosData.map(item => item.total),
                    backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545']
                }]
            }
        });

        // Gráfico de envíos por estado
        const enviosCtx = document.getElementById('enviosChart').getContext('2d');
        const enviosData = <?php echo json_encode($stats['envios_por_estado']); ?>;
        new Chart(enviosCtx, {
            type: 'bar',
            data: {
                labels: enviosData.map(item => item.nuevo_estado),
                datasets: [{
                    label: 'Cantidad',
                    data: enviosData.map(item => item.total),
                    backgroundColor: '#17a2b8'
                }]
            }
        });

        // Función para ver mensaje completo
        function verMensaje(mensaje) {
            document.getElementById('mensajeCompleto').textContent = mensaje;
            new bootstrap.Modal(document.getElementById('mensajeModal')).show();
        }
    </script>
</body>
</html>