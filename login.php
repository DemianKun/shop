<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Delivery Warrior</title>
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
                <div class="col-lg-5 col-md-7">
                    <div class="auth-card">
                        <!-- Logo -->
                        <div class="auth-logo">
                            <img src="WhatsApp_Image_2025-06-18_at_6.07.39_PM__1_-removebg-preview.png" alt="Delivery Warrior">
                        </div>
                        
                        <!-- Header -->
                        <div class="auth-header">
                            <h2 class="auth-title">Iniciar Sesión</h2>
                            <p class="auth-subtitle">Accede a tu cuenta de Delivery Warrior</p>
                        </div>
                        
                        <!-- Mensajes de error/éxito -->
                        <?php if (isset($_GET['error'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <?php 
                                if ($_GET['error'] == 'credenciales') {
                                    echo "Correo o contraseña incorrectos";
                                } elseif ($_GET['error'] == 'campos') {
                                    echo "Por favor completa todos los campos";
                                } else {
                                    echo htmlspecialchars($_GET['error']);
                                }
                                ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (isset($_GET['registro'])): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                Registro exitoso. Por favor inicia sesión.
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Formulario -->
                        <form action="procesar_login.php" method="POST" class="auth-form">
                            <div class="mb-4">
                                <label for="correo" class="form-label">
                                    <i class="fas fa-envelope me-2"></i>Correo Electrónico
                                </label>
                                <input type="email" class="form-control auth-input" id="correo" name="correo" required>
                            </div>
                            
                            <div class="mb-4">
                                <label for="contrasena" class="form-label">
                                    <i class="fas fa-lock me-2"></i>Contraseña
                                </label>
                                <div class="password-wrapper">
                                    <input type="password" class="form-control auth-input" id="contrasena" name="contrasena" required>
                                    <button type="button" class="password-toggle" onclick="togglePassword('contrasena')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="mb-4 d-flex justify-content-between align-items-center">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="recordar" name="recordar">
                                    <label class="form-check-label" for="recordar">
                                        Recordarme
                                    </label>
                                </div>
                                <a href="#" class="auth-link">¿Olvidaste tu contraseña?</a>
                            </div>
                            
                            <button type="submit" class="btn auth-btn-submit w-100 mb-3">
                                <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                            </button>
                        </form>
                        
                        <!-- Footer -->
                        <div class="auth-footer">
                            <p>¿No tienes cuenta? <a href="registro.php" class="auth-link-bold">Regístrate aquí</a></p>
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
    </script>
</body>
</html>
