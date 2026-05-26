<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Delivery Warrior</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="WhatsApp_Image_2025-06-18_at_6.07.39_PM__1_-removebg-preview.png" type="image/png">
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/auth.css">
</head>
<body class="auth-body">
    <div class="auth-container">
        <div class="auth-overlay"></div>
        
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div class="auth-card">
                        <!-- Logo -->
                        <div class="auth-logo">
                            <img src="WhatsApp_Image_2025-06-18_at_6.07.39_PM__1_-removebg-preview.png" alt="Delivery Warrior">
                        </div>
                        
                        <!-- Header -->
                        <div class="auth-header">
                            <h2 class="auth-title">Crear Cuenta</h2>
                            <p class="auth-subtitle">Únete a la comunidad de Delivery Warrior</p>
                        </div>
                        
                        <!-- Mensajes de error -->
                        <?php if (isset($_GET['error'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <?php echo htmlspecialchars($_GET['error']); ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Formulario -->
                        <form action="procesar_registro.php" method="POST" class="auth-form" id="registroForm">
                            <!-- Selección de Tipo de Usuario -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">
                                    <i class="fas fa-user-tag me-2"></i>Tipo de Usuario
                            </label>
                            <div class="role-selector">
                                <input type="radio" class="btn-check" name="id_rol" id="rol_usuario" value="4" checked>
                                <label class="btn role-option" for="rol_usuario">
                                    <i class="fas fa-user fa-2x mb-2"></i>
                                    <span>Usuario</span>
                                </label>
                                
                                <input type="radio" class="btn-check" name="id_rol" id="rol_comercio" value="2">
                                <label class="btn role-option" for="rol_comercio">
                                    <i class="fas fa-store fa-2x mb-2"></i>
                                    <span>Comercio</span>
                                </label>
                                
                                <input type="radio" class="btn-check" name="id_rol" id="rol_repartidor" value="3">
                                <label class="btn role-option" for="rol_repartidor">
                                    <i class="fas fa-motorcycle fa-2x mb-2"></i>
                                    <span>Repartidor</span>
                                </label>
                            </div>
                        </div>                            <!-- Datos Básicos -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nombre" class="form-label">Nombre Completo</label>
                                    <input type="text" class="form-control auth-input" id="nombre" name="nombre" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="correo" class="form-label">Correo Electrónico</label>
                                    <input type="email" class="form-control auth-input" id="correo" name="correo" required>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="contrasena" class="form-label">Contraseña</label>
                                    <div class="password-wrapper">
                                        <input type="password" class="form-control auth-input" id="contrasena" name="contrasena" required>
                                        <button type="button" class="password-toggle" onclick="togglePassword('contrasena')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="confirmar_contrasena" class="form-label">Confirmar Contraseña</label>
                                    <div class="password-wrapper">
                                        <input type="password" class="form-control auth-input" id="confirmar_contrasena" name="confirmar_contrasena" required>
                                        <button type="button" class="password-toggle" onclick="togglePassword('confirmar_contrasena')">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Campos específicos de Comercio -->
                            <div id="campos_comercio" style="display: none;">
                                <hr class="my-4">
                                <h5 class="mb-3"><i class="fas fa-store me-2"></i>Datos del Comercio</h5>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nombre_responsable" class="form-label">Nombre del Responsable</label>
                                        <input type="text" class="form-control auth-input" id="nombre_responsable" name="nombre_responsable">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="tipo_comercio" class="form-label">Tipo de Comercio</label>
                                        <select class="form-select auth-input" id="tipo_comercio" name="tipo_comercio">
                                            <option value="">Seleccionar...</option>
                                            <option value="Restaurante">Restaurante</option>
                                            <option value="Farmacia">Farmacia</option>
                                            <option value="Supermercado">Supermercado</option>
                                            <option value="Tienda de Ropa">Tienda de Ropa</option>
                                            <option value="Electrónica">Electrónica</option>
                                            <option value="Librería">Librería</option>
                                            <option value="Otro">Otro</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="horario_apertura" class="form-label">Horario de Apertura</label>
                                        <input type="time" class="form-control auth-input" id="horario_apertura" name="horario_apertura">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="horario_cierre" class="form-label">Horario de Cierre</label>
                                        <input type="time" class="form-control auth-input" id="horario_cierre" name="horario_cierre">
                                    </div>
                                </div>
                                
                                <h6 class="mb-3"><i class="fas fa-map-marker-alt me-2"></i>Dirección del Comercio</h6>
                                <div class="row">
                                    <div class="col-md-8 mb-3">
                                        <label for="calle" class="form-label">Calle</label>
                                        <input type="text" class="form-control auth-input" id="calle" name="calle">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="numero" class="form-label">Número</label>
                                        <input type="text" class="form-control auth-input" id="numero" name="numero">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label for="manzana" class="form-label">Manzana</label>
                                        <input type="text" class="form-control auth-input" id="manzana" name="manzana">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="lote" class="form-label">Lote</label>
                                        <input type="text" class="form-control auth-input" id="lote" name="lote">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="colonia" class="form-label">Colonia</label>
                                        <input type="text" class="form-control auth-input" id="colonia" name="colonia">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="municipio" class="form-label">Municipio</label>
                                        <input type="text" class="form-control auth-input" id="municipio" name="municipio">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="estado" class="form-label">Estado</label>
                                        <input type="text" class="form-control auth-input" id="estado" name="estado">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="codigo_postal" class="form-label">Código Postal</label>
                                        <input type="text" class="form-control auth-input" id="codigo_postal" name="codigo_postal">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Campos específicos de Repartidor -->
                            <div id="campos_repartidor" style="display: none;">
                                <hr class="my-4">
                                <h5 class="mb-3"><i class="fas fa-motorcycle me-2"></i>Datos del Vehículo</h5>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="tipo_vehiculo" class="form-label">Tipo de Vehículo</label>
                                        <select class="form-select auth-input" id="tipo_vehiculo" name="tipo_vehiculo">
                                            <option value="">Seleccionar...</option>
                                            <option value="Moto">Moto</option>
                                            <option value="Carro">Carro</option>
                                            <option value="Bicicleta">Bicicleta</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="marca" class="form-label">Marca</label>
                                        <input type="text" class="form-control auth-input" id="marca" name="marca">
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="modelo" class="form-label">Modelo</label>
                                        <input type="text" class="form-control auth-input" id="modelo" name="modelo">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="color" class="form-label">Color</label>
                                        <input type="text" class="form-control auth-input" id="color" name="color">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="matricula" class="form-label">Matrícula</label>
                                        <input type="text" class="form-control auth-input" id="matricula" name="matricula">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Términos y condiciones -->
                            <div class="mb-4 mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terminos" required>
                                    <label class="form-check-label" for="terminos">
                                        Acepto los <a href="#" class="auth-link">Términos y Condiciones</a> y la <a href="#" class="auth-link">Política de Privacidad</a>
                                    </label>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn auth-btn-submit w-100 mb-3">
                                <i class="fas fa-user-plus me-2"></i>Crear Cuenta
                            </button>
                        </form>
                        
                        <!-- Footer -->
                        <div class="auth-footer">
                            <p>¿Ya tienes cuenta? <a href="login.php" class="auth-link-bold">Inicia sesión aquí</a></p>
                        </div>
                        
                        <div class="auth-back">
                            <a href="index.php" class="auth-link">
                                <i class="fas fa-arrow-left me-2"></i>Volver al inicio
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mostrar/ocultar campos según el rol seleccionado
        document.querySelectorAll('input[name="id_rol"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const camposComercio = document.getElementById('campos_comercio');
                const camposRepartidor = document.getElementById('campos_repartidor');
                
                // Ocultar todos
                camposComercio.style.display = 'none';
                camposRepartidor.style.display = 'none';
                
                // Mostrar según selección
                if (this.value === '2') { // Comercio
                    camposComercio.style.display = 'block';
                    setRequired(camposComercio, true);
                    setRequired(camposRepartidor, false);
                } else if (this.value === '3') { // Repartidor
                    camposRepartidor.style.display = 'block';
                    setRequired(camposRepartidor, true);
                    setRequired(camposComercio, false);
                } else {
                    setRequired(camposComercio, false);
                    setRequired(camposRepartidor, false);
                }
            });
        });
        
        function setRequired(container, required) {
            container.querySelectorAll('input, select').forEach(input => {
                if (required) {
                    input.setAttribute('required', 'required');
                } else {
                    input.removeAttribute('required');
                }
            });
        }
        
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = event.currentTarget.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
        
        // Validar contraseñas
        document.getElementById('registroForm').addEventListener('submit', function(e) {
            const contrasena = document.getElementById('contrasena').value;
            const confirmar = document.getElementById('confirmar_contrasena').value;
            
            if (contrasena !== confirmar) {
                e.preventDefault();
                alert('Las contraseñas no coinciden');
                return false;
            }
        });
    </script>
</body>
</html>
