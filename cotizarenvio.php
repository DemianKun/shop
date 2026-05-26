<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Warrior - Cotizar Envío</title>
    <!-- Google Fonts para tipografía profesional -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" href="WhatsApp_Image_2025-06-18_at_6.07.39_PM__1_-removebg-preview.png" type="image/png">
    <link rel="shortcut icon" href="WhatsApp_Image_2025-06-18_at_6.07.39_PM__1_-removebg-preview.png" type="image/png">
    <link rel="apple-touch-icon" href="WhatsApp_Image_2025-06-18_at_6.07.39_PM__1_-removebg-preview.png" sizes="180x180">
    <meta name="theme-color" content="#14100d">
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/quote.css">
    <link rel="stylesheet" href="css/footer.css">
</head>
<body>
    <?php include 'components/navbar.php'; ?>

    <!-- Sección Hero -->
    <section class="hero-quote">
        <div class="container">
            <div class="floating-logo">
            <h1 class="hero-quote-title">COTIZA TU ENVÍO</h1>
            <p class="lead">Obtén un precio estimado para tu envío en segundos</p>
        </div>
        </div>
   </section>
    <!-- Formulario de cotización -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <?php include 'components/quote_form.php'; ?>
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
            // Validación adicional del formulario
            document.getElementById('quoteForm').addEventListener('submit', function(e) {
                // Validar que la fecha de entrega sea futura
                const fechaEntrega = new Date(this.elements['fecha_entrega'].value);
                const hoy = new Date();
                
                if(fechaEntrega <= hoy) {
                    e.preventDefault();
                    alert('Por favor selecciona una fecha futura para la entrega.');
                    return false;
                }
                
                // Validar que el correo electrónico tenga formato válido
                const email = this.elements['email_cliente'].value;
                if(!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                    e.preventDefault();
                    alert('Por favor ingresa un correo electrónico válido.');
                    return false;
                }
                
                return true;
            });
            
            // Autocompletar municipio/estado basado en código postal (ejemplo con API)
            const cpOrigen = document.querySelector('input[name="origen_codigo_postal"]');
            const cpDestino = document.querySelector('input[name="destino_codigo_postal"]');
            
            [cpOrigen, cpDestino].forEach(cp => {
                cp.addEventListener('blur', function() {
                    if(this.value.length === 5) { // Asumiendo códigos postales de 5 dígitos
                        const prefix = this.name.includes('origen') ? 'origen' : 'destino';
                        // Simulación de llamada a API (en producción usarías una API real)
                        setTimeout(() => {
                            document.querySelector(`input[name="${prefix}_municipio"]`).value = "Ejemplo Municipio";
                            document.querySelector(`input[name="${prefix}_estado"]`).value = "Ejemplo Estado";
                        }, 500);
                    }
                });
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