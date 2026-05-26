<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Warrior - Únete como Repartidor</title>
    <!-- Google Fonts para tipografía profesional -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/join.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="icon" href="WhatsApp_Image_2025-06-18_at_6.07.39_PM__1_-removebg-preview.png" type="image/png">
    <link rel="shortcut icon" href="WhatsApp_Image_2025-06-18_at_6.07.39_PM__1_-removebg-preview.png" type="image/png">
    <link rel="apple-touch-icon" href="WhatsApp_Image_2025-06-18_at_6.07.39_PM__1_-removebg-preview.png" sizes="180x180">
    <meta name="theme-color" content="#14100d">
</head>
<body>
    <?php include 'components/navbar.php'; ?>

    <!-- Sección Hero -->
    <section class="hero-join">
        <div class="container">
            <h1 class="hero-join-title">ÚNETE A NUESTRO EQUIPO</h1>
            <p class="lead">Conviértete en un Delivery Warrior y gana dinero con flexibilidad horaria</p>
        </div>
    </section>

    <!-- Formulario para unirse -->
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Contenedor del formulario con marca de agua -->
            <div class="join-form-container position-relative overflow-hidden py-4 px-3">

                    <div class="watermark-logo">
                    <img src="WhatsApp_Image_2025-06-18_at_6.07.39_PM__1_-removebg-preview.png" 
                         alt="Delivery Warrior" 
                         style="opacity: 0.08; width: 500px;">
                </div>
                
                    <h2 class="form-title">REGISTRO DE REPARTIDOR</h2>
                    <form id="joinForm" action="procesar-registro.php" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="nombre" placeholder="NOMBRE COMPLETO" required>
                            </div>
                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" placeholder="EMAIL" required>
                            </div>
                            <div class="col-md-6">
                                <input type="tel" class="form-control" name="telefono" placeholder="TELÉFONO" required>
                            </div>
                            <div class="col-md-6 birthdate-container">
                                <label for="fecha_nacimiento" class="birthdate-label">FECHA DE NACIMIENTO</label>
                                <span class="birthdate-warning" data-bs-toggle="tooltip" title="Debes ser mayor de 18 años para registrarte">
                                    <i class="fas fa-exclamation-circle"></i>
                                </span>
                                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
                                <span class="birthdate-requirement">* Debes ser mayor de 18 años</span>
                            </div>
                        </div>
                        
                        <h5 class="mb-3" style="color: var(--azul-marino);">TIPO DE VEHÍCULO</h5>
                        <div class="vehicle-options">
                            <label class="vehicle-option">
                                <input type="radio" name="vehiculo" value="carro" required>
                                <div class="vehicle-content">
                                    <i class="fas fa-car vehicle-icon"></i>
                                    <p>CARRO</p>
                                </div>
                            </label>
                            <label class="vehicle-option">
                                <input type="radio" name="vehiculo" value="motocicleta" required>
                                <div class="vehicle-content">
                                    <i class="fas fa-motorcycle vehicle-icon"></i>
                                    <p>MOTO</p>
                                </div>
                            </label>
                            <label class="vehicle-option">
                                <input type="radio" name="vehiculo" value="bicicleta" required>
                                <div class="vehicle-content">
                                    <i class="fas fa-bicycle vehicle-icon"></i>
                                    <p>BICICLETA</p>
                                </div>
                            </label>
                           
                        </div>
                        
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="checkbox" id="termsCheck" required>
                            <label class="form-check-label" for="termsCheck">
                                Acepto los <a href="#" style="color: var(--verde);">términos y condiciones</a> y la <a href="#" style="color: var(--verde);">política de privacidad</a>
                            </label>
                        </div>
                        
                        <button type="submit" class="btn btn-join">ENVIAR SOLICITUD</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include 'components/footer.php'; ?>
    <!-- Colocar antes del cierre </body> -->
<div class="moto-container-rtl">
  <div class="polvo-estela-rtl"></div>
  <img src="WhatsApp_Image_2025-06-19_at_12.25.35_PM-removebg-preview.png" alt="Moto Delivery" class="moto-animada-rtl">
</div>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Script para mejorar la experiencia del formulario -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Resaltar la opción de vehículo seleccionada
            const vehicleOptions = document.querySelectorAll('.vehicle-option input');
            vehicleOptions.forEach(option => {
                option.addEventListener('change', function() {
                    // Remover todas las clases activas primero
                    document.querySelectorAll('.vehicle-option').forEach(opt => {
                        opt.style.backgroundColor = '';
                    });
                    
                    // Resaltar la opción seleccionada
                    if(this.checked) {
                        this.closest('.vehicle-option').style.backgroundColor = 'rgba(76, 175, 80, 0.1)';
                    }
                });
            });
            
            // Inicializar tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Validación adicional del formulario
            document.getElementById('joinForm').addEventListener('submit', function(e) {
                const fechaInput = this.elements['fecha_nacimiento'];
                const fechaNacimiento = new Date(fechaInput.value);
                const hoy = new Date();
                let edad = hoy.getFullYear() - fechaNacimiento.getFullYear();
                const mes = hoy.getMonth() - fechaNacimiento.getMonth();
                
                if (mes < 0 || (mes === 0 && hoy.getDate() < fechaNacimiento.getDate())) {
                    edad--;
                }
                
                if(edad < 18) {
                    e.preventDefault();
                    // Crear elemento de alerta
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-danger mt-3';
                    alertDiv.innerHTML = '<i class="fas fa-exclamation-circle me-2"></i> Debes ser mayor de 18 años para registrarte como repartidor.';
                    
                    // Insertar después del campo
                    fechaInput.parentNode.appendChild(alertDiv);
                    
                    // Resaltar el campo
                    fechaInput.style.borderColor = '#dc3545';
                    fechaInput.style.backgroundColor = '#fff3f3';
                    
                    // Desaparecer después de 5 segundos
                    setTimeout(() => {
                        alertDiv.remove();
                        fechaInput.style.borderColor = '';
                        fechaInput.style.backgroundColor = '';
                    }, 5000);
                }
            });
        });
         // JavaScript para reiniciar animación al cambiar de sección
document.addEventListener('DOMContentLoaded', function() {
  const motoRTL = document.querySelector('.moto-container-rtl');
  
  function reiniciarAnimacionRTL() {
    motoRTL.style.animation = 'none';
    void motoRTL.offsetWidth;
    motoRTL.style.animation = 'moverMotoRTL 10s linear forwards';
  }
  
  // Disparadores
  reiniciarAnimacionRTL();
  window.addEventListener('hashchange', reiniciarAnimacionRTL); // Para SPA
});

    </script>
</body>
</html>
