<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Delivery Warrior: Servicio de logística especializada en ecommerce. Entregas rápidas, confiables y seguras para tu negocio.">
    <meta name="keywords" content="delivery, logística, ecommerce, envíos, repartidores, México">
    <meta name="author" content="Delivery Warrior">
    <title>Delivery Warrior - Servicio de Logística Ecommerce</title>
    <!-- Google Fonts para tipografía profesional -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="WhatsApp_Image_2025-06-18_at_6.07.39_PM__1_-removebg-preview.png" type="image/png">
    <link rel="shortcut icon" href="WhatsApp_Image_2025-06-18_at_6.07.39_PM__1_-removebg-preview.png" type="image/png">
    <link rel="apple-touch-icon" href="WhatsApp_Image_2025-06-18_at_6.07.39_PM__1_-removebg-preview.png" sizes="180x180">
    <meta name="theme-color" content="#14100d">
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/footer.css">
        <!-- Fallback CSS para usuarios sin JS -->
        <noscript>
            <style>
                .reveal-section { opacity: 1 !important; transform: none !important; }
            </style>
        </noscript>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </head>
<body>
    <?php include 'components/navbar.php'; ?>

    <!-- Toast de notificación -->
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1055;">
        <div id="statusToast" class="toast align-items-center text-white bg-<?php echo isset($_GET['status']) && $_GET['status'] === 'success' ? 'success' : 'danger'; ?> border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-<?php echo isset($_GET['status']) && $_GET['status'] === 'success' ? 'check-circle' : 'exclamation-triangle'; ?> me-2"></i>
                    <?php 
                    if (isset($_GET['status']) && $_GET['status'] === 'success') {
                        echo "¡Mensaje enviado correctamente! Nos pondremos en contacto contigo pronto.";
                    } elseif (isset($_GET['status'])) {
                        echo "Error: " . htmlspecialchars($_GET['message'] ?? 'Ha ocurrido un error');
                    }
                    ?>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <main>    <!-- Sección Hero Mejorada -->
    <section class="hero-enhanced reveal-section soft-section" style="--bg:#1a130d; --bg-prev:#1a130d; --bg-next: var(--azul-marino);">
        <div class="hero-bg-enhanced"></div>
        <div class="hero-particles"></div>
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-6 text-white py-5 hero-content-enhanced">
                    <div class="hero-title-enhanced">DELIVERY WARRIOR</div>
                    <br>
                    <p class="hero-subtitle-enhanced">SERVICIO DE LOGÍSTICA ESPECIALIZADA EN ECOMMERCE</p>
                   <button class="btn btn-enhanced" onclick="smoothScroll('.contact-section')">CONTÁCTANOS</button>
                </div>
                <div class="col-lg-6">
                    <div class="services-card-enhanced">
                        <div class="text-center">
                            <i class="fas fa-shipping-fast services-icon-enhanced"></i>
                            <h3 class="text-uppercase" style="color: var(--verde);">ENVÍOS</h3>
                            <p>Soluciones de entrega rápida y confiable para tu ecommerce.</p>
                        </div>
                    </div>
                    <div class="services-card-enhanced mt-4">
                        <div class="text-center">
                            <i class="fas fa-motorcycle services-icon-enhanced"></i>
                            <h3 class="text-uppercase" style="color: var(--verde);">REPARTOS</h3>
                            <p>Red de repartidores profesionales para tus entregas.</p>
                        </div>
                    </div>
                    <div class="services-card-enhanced mt-4">
                        <div class="text-center">
                            <i class="fas fa-shield-alt services-icon-enhanced"></i>
                            <h3 class="text-uppercase" style="color: var(--verde);">SEGUROS</h3>
                            <p>Protección para tus envíos y tranquilidad para tus clientes.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include 'components/mission_vision.php'; ?>

    <!-- Sección Delivery Warrior Express -->
    <section class="express-section-premium reveal-section soft-section" style="--bg:#001a36; --bg-prev: var(--azul-marino); --bg-next: var(--verde);">
        <div class="express-bg-overlay"></div>
        <div class="container">
            <!-- Header Premium -->
            <div class="express-header-premium">
                <div class="express-badge-premium">
                    <i class="fas fa-bolt"></i>
                    <span>Logística de Alto Rendimiento</span>
                </div>
                <h2 class="express-title-premium">DELIVERY WARRIOR EXPRESS</h2>
                <p class="express-subtitle-premium">Tecnología de punta y procesos optimizados para llevar tus envíos al siguiente nivel</p>
            </div>

            <!-- Video Container Premium -->
            <div class="express-video-container">
                <div class="video-wrapper-premium">
                    <video autoplay muted loop playsinline>
                        <source src="Animacion1.mp4" type="video/mp4"> 
                        Tu navegador no soporta videos HTML5
                    </video>
                    <div class="video-overlay-premium"></div>
                </div>
            </div>

            <!-- Features Grid Premium -->
            <div class="express-features-grid">
                <div class="express-feature-card">
                    <div class="feature-icon-wrapper">
                        <div class="feature-icon-glow" style="--glow-color: #fe810d;"></div>
                        <div class="feature-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                    <h4 class="feature-title">Tracking en Tiempo Real</h4>
                    <p class="feature-description">Seguimiento preciso de cada envío con actualizaciones instantáneas y notificaciones automáticas.</p>
                </div>

                <div class="express-feature-card">
                    <div class="feature-icon-wrapper">
                        <div class="feature-icon-glow" style="--glow-color: #007bff;"></div>
                        <div class="feature-icon">
                            <i class="fas fa-box-open"></i>
                        </div>
                    </div>
                    <h4 class="feature-title">Entregas Express</h4>
                    <p class="feature-description">Servicio de entrega ultrarrápida con garantía de cumplimiento en 24-48 horas.</p>
                </div>

                <div class="express-feature-card">
                    <div class="feature-icon-wrapper">
                        <div class="feature-icon-glow" style="--glow-color: #00bcd4;"></div>
                        <div class="feature-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                    </div>
                    <h4 class="feature-title">Fecha Garantizada</h4>
                    <p class="feature-description">Cumplimiento del 99.8% en plazos de entrega con compensación en caso de retraso.</p>
                </div>

                <div class="express-feature-card">
                    <div class="feature-icon-wrapper">
                        <div class="feature-icon-glow" style="--glow-color: #ff8a00;"></div>
                        <div class="feature-icon">
                            <i class="fas fa-box"></i>
                        </div>
                    </div>
                    <h4 class="feature-title">Empaque Premium</h4>
                    <p class="feature-description">Soluciones de empaque especializadas con materiales de alta protección.</p>
                </div>

                <div class="express-feature-card">
                    <div class="feature-icon-wrapper">
                        <div class="feature-icon-glow" style="--glow-color: #22c55e;"></div>
                        <div class="feature-icon">
                            <i class="fas fa-truck"></i>
                        </div>
                    </div>
                    <h4 class="feature-title">Distribución Inteligente</h4>
                    <p class="feature-description">Red logística optimizada con algoritmos de ruta para máxima eficiencia.</p>
                </div>

                <div class="express-feature-card">
                    <div class="feature-icon-wrapper">
                        <div class="feature-icon-glow" style="--glow-color: #8b5cf6;"></div>
                        <div class="feature-icon">
                            <i class="fas fa-warehouse"></i>
                        </div>
                    </div>
                    <h4 class="feature-title">Almacenamiento Seguro</h4>
                    <p class="feature-description">Instalaciones de última generación con control de clima y seguridad 24/7.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Sección de clientes -->
    <section class="clients-section text-center reveal-section soft-section" style="--bg: var(--azul-marino); --bg-prev: var(--verde); --bg-next:#f8f9fa;">
        <div class="container">
            <h1 class=""> ALGUNOS DE NUESTROS CLIENTES </h1>
            <?php include 'slider-local.php'; ?>
        </div>
    </section>
    <!-- Sección de socios - Rediseño profesional -->
<section class="partners-section reveal-section soft-section" style="--bg:#f8f9fa; --bg-prev: var(--azul-marino); --bg-next: var(--azul-marino-light);">
        <div class="container">
            <!-- Encabezado de sección -->
            <div class="partners-header-redesign">
                <h2 class="partners-title-redesign">SERVICIOS EN COLABORACIÓN</h2>
                <p class="partners-subtitle-redesign">Aliados estratégicos para servicios integrales</p>
            </div>
            
            <!-- Grid de tarjetas de aliados -->
            <div class="row g-4 justify-content-center">
                <!-- Tarjeta 1: Médico General -->
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="partner-card-redesign">
                        <div class="partner-emblem medical">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <h5 class="partner-name-redesign">Dr. Henrrie Angeles</h5>
                        <p class="partner-service-type">MÉDICO GENERAL</p>
                        <p class="partner-description-short">Atención médica integral y especializada</p>
                        <a href="https://doctorhenrry.bdosoluciones.com/" class="btn-visit-redesign" target="_blank">
                            <i class="fas fa-external-link-alt me-2"></i>Visitar
                        </a>
                    </div>
                </div>
                
                <!-- Tarjeta 2: Servicio de Cobranza -->
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="partner-card-redesign">
                        <div class="partner-emblem finance">
                            <i class="fas fa-hand-holding-usd"></i>
                        </div>
                        <h5 class="partner-name-redesign">BDO Soluciones Efectivas</h5>
                        <p class="partner-service-type">SERVICIO DE COBRANZA</p>
                        <p class="partner-description-short">Gestión profesional de cobranza empresarial</p>
                        <a href="https://bdosoluciones.com/cobranza" class="btn-visit-redesign" target="_blank">
                            <i class="fas fa-external-link-alt me-2"></i>Visitar
                        </a>
                    </div>
                </div>
                
                <!-- Tarjeta 3: Servicio de Facturación -->
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="partner-card-redesign">
                        <div class="partner-emblem invoice">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                        <h5 class="partner-name-redesign">BDO Soluciones Efectivas</h5>
                        <p class="partner-service-type">SERVICIO DE FACTURACIÓN</p>
                        <p class="partner-description-short">Facturación electrónica eficiente y confiable</p>
                        <a href="https://bdosoluciones.com/facturacion" class="btn-visit-redesign" target="_blank">
                            <i class="fas fa-external-link-alt me-2"></i>Visitar
                        </a>
                    </div>
                </div>
                
                <!-- Tarjeta 4: Servicio de Marketing -->
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="partner-card-redesign">
                        <div class="partner-emblem marketing">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h5 class="partner-name-redesign">BDO Soluciones Efectivas</h5>
                        <p class="partner-service-type">SERVICIO DE MARKETING</p>
                        <p class="partner-description-short">Estrategias digitales para crecer tu negocio</p>
                        <a href="https://bdosoluciones.com/marqueting" class="btn-visit-redesign" target="_blank">
                            <i class="fas fa-external-link-alt me-2"></i>Visitar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección de contacto -->
    <section class="contact-section-modern reveal-section" style="--bg: #1a2942; --bg-prev:#f8f9fa; --bg-next: var(--azul-marino-light);">
        <div class="contact-bg-overlay"></div>
        <div class="container">
            <div class="row align-items-center g-5">
                <!-- Columna izquierda: Por qué elegirnos -->
                <div class="col-lg-5">
                    <div class="contact-hero-card">
                        <div class="contact-badge">
                            <i class="fas fa-shipping-fast"></i>
                            <span>Logística Profesional</span>
                        </div>
                        <h2 class="contact-hero-title">¿Listo para optimizar tus entregas?</h2>
                        <p class="contact-hero-subtitle">Únete a cientos de negocios que ya confían en nuestra plataforma para sus entregas.</p>
                        
                        <div class="contact-stats-grid">
                            <div class="contact-stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-bolt"></i>
                                </div>
                                <div class="stat-content">
                                    <h4>99.8%</h4>
                                    <p>Entregas exitosas</p>
                                </div>
                            </div>
                            
                            <div class="contact-stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="stat-content">
                                    <h4>24/7</h4>
                                    <p>Soporte disponible</p>
                                </div>
                            </div>
                            
                            <div class="contact-stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-shield-alt"></i>
                                </div>
                                <div class="stat-content">
                                    <h4>100%</h4>
                                    <p>Envíos asegurados</p>
                                </div>
                            </div>
                            
                            <div class="contact-stat-card">
                                <div class="stat-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="stat-content">
                                    <h4>500+</h4>
                                    <p>Clientes satisfechos</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="contact-benefits">
                            <div class="benefit-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Respuesta en menos de 24 horas</span>
                            </div>
                            <div class="benefit-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Cotización sin compromiso</span>
                            </div>
                            <div class="benefit-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Soluciones personalizadas</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Columna derecha: Formulario -->
                <div class="col-lg-7">
                    <div class="contact-form-card">
                        <h3 class="contact-form-title">Envíanos un mensaje</h3>
                        <p class="contact-form-desc">Completa el formulario y nos pondremos en contacto contigo lo antes posible.</p>
                        
                        <form class="contact-form-modern" action="procesar_formulario.php" method="POST">
                            <div class="row g-3">
                                <!-- Selección de tipo -->
                                <div class="col-12">
                                    <div class="tipo-seleccion mb-4">
                                        <label class="form-label-modern mb-3">
                                            <i class="fas fa-question-circle"></i> ¿Qué tipo de consulta tienes?
                                        </label>
                                        <div class="d-flex flex-wrap gap-3 justify-content-center">
                                            <input type="radio" class="btn-check" name="tipo" id="cotizar_envio" value="cotizar_envio" autocomplete="off" checked>
                                            <label class="btn btn-tipo" for="cotizar_envio">
                                                <i class="fas fa-calculator me-2"></i>Cotizar un envío
                                            </label>

                                            <input type="radio" class="btn-check" name="tipo" id="negocio" value="negocio" autocomplete="off">
                                            <label class="btn btn-tipo" for="negocio">
                                                <i class="fas fa-building me-2"></i>Negocio
                                            </label>

                                            <input type="radio" class="btn-check" name="tipo" id="repartidor" value="repartidor" autocomplete="off">
                                            <label class="btn btn-tipo" for="repartidor">
                                                <i class="fas fa-motorcycle me-2"></i>Repartidor
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label for="nombre" class="form-label-modern">
                                            <i class="fas fa-user"></i> Nombre completo
                                        </label>
                                        <input type="text" id="nombre" class="form-control-modern" name="nombre" placeholder="Tu nombre completo" required 
                                               value="<?php echo isset($_POST['nombre']) ? htmlspecialchars($_POST['nombre']) : ''; ?>">
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group-modern">
                                        <label for="email" class="form-label-modern">
                                            <i class="fas fa-envelope"></i> Correo electrónico
                                        </label>
                                        <input type="email" id="email" class="form-control-modern" name="email" placeholder="correo@ejemplo.com" required
                                               value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="form-group-modern">
                                        <label for="telefono" class="form-label-modern">
                                            <i class="fas fa-phone"></i> Teléfono
                                        </label>
                                        <input type="tel" id="telefono" class="form-control-modern" name="telefono" placeholder="5512345678" required
                                               value="<?php echo isset($_POST['telefono']) ? htmlspecialchars($_POST['telefono']) : ''; ?>">
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="form-group-modern">
                                        <label for="mensaje" class="form-label-modern">
                                            <i class="fas fa-comment-dots"></i> ¿En qué podemos ayudarte?
                                        </label>
                                        <textarea id="mensaje" class="form-control-modern" name="mensaje" rows="5" placeholder="Cuéntanos sobre tu proyecto o necesidades logísticas..." required><?php echo isset($_POST['mensaje']) ? htmlspecialchars($_POST['mensaje']) : ''; ?></textarea>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <button type="submit" class="btn-submit-modern">
                                        <span>Enviar mensaje</span>
                                        <i class="fas fa-paper-plane"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </main>

    <?php include 'components/footer.php'; ?>
    <!-- Colocar antes del cierre </body> -->
<div class="moto-container-rtl">
  <div class="polvo-estela-rtl"></div>
  <img src="WhatsApp_Image_2025-06-19_at_12.25.35_PM-removebg-preview.png" alt="Moto Delivery" class="moto-animada-rtl">
</div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Scroll Reveal Observer -->
    <script>
    document.addEventListener('DOMContentLoaded', function(){
        const sections = document.querySelectorAll('.reveal-section');
        const prefersReduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        // Set common staggered children selectors
        const staggerChildrenSelectors = ['.express-item', '.services-card-enhanced', '.mv-card-horizontal', '.partner-card', '.client-logo', '.hero-content-enhanced > *'];

        // Helper: add small delays to child elements inside the section
        function setStaggerDelays(section){
            const selector = staggerChildrenSelectors.join(', ');
            const children = section.querySelectorAll(selector);
            children.forEach((el, idx) => {
                el.classList.add('staggered');
                el.style.transitionDelay = `${idx * 120}ms`;
            });
        }

        sections.forEach(s => setStaggerDelays(s));

        // If the user prefers reduced motion, reveal sections immediately but avoid adding observers
        if (prefersReduced) {
            sections.forEach(s => s.classList.add('is-visible'));
            // Also mark the first section as active for visual consistency
            if (sections.length) sections[0].classList.add('active-section');
            return; // skip observers to respect reduced-motion but ensure content is visible
        }

        try {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                    } else {
                        entry.target.classList.remove('is-visible');
                    }
                });
            }, { threshold: 0.12 });

            // Active section observer (most visible becomes active)
            const activeObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.intersectionRatio >= 0.5) {
                        sections.forEach(s => s.classList.remove('active-section'));
                        entry.target.classList.add('active-section');
                    } else if (entry.intersectionRatio < 0.5 && entry.target.classList.contains('active-section')){
                        entry.target.classList.remove('active-section');
                    }
                });
            }, { threshold: [0.5] });

            sections.forEach(s => { observer.observe(s); activeObserver.observe(s); });
        } catch (err) {
            // If observer creation failed for any reason, fall back to showing all sections
            sections.forEach(s => s.classList.add('is-visible'));
            if (sections.length) sections[0].classList.add('active-section');
            console.error('Fallback: IntersectionObserver failed', err);
        }
    });
    </script>
    <script>
    // Ensure marquee has enough repeated items to create a smooth, seamless loop on narrow screens
    document.addEventListener('DOMContentLoaded', function() {
        const marqueeContainers = document.querySelectorAll('.marque-container');
        marqueeContainers.forEach(container => {
            const content = container.querySelector('.Marquee-content');
            if (!content) return;
            const containerWidth = container.offsetWidth;
            let contentWidth = content.scrollWidth;

            // Clone until content width > container width * 2
            while (contentWidth < containerWidth * 2) {
                const children = Array.from(content.children);
                children.forEach(child => content.appendChild(child.cloneNode(true)));
                contentWidth = content.scrollWidth;
            }
        });
        
        // Pause marquee when not visible to save CPU
        const marqueeObserver = new IntersectionObserver((entries) => {
            entries.forEach(en => {
                const content = en.target.querySelector('.Marquee-content');
                if (!content) return;
                if (en.isIntersecting) {
                    content.style.animationPlayState = 'running';
                } else {
                    content.style.animationPlayState = 'paused';
                }
            });
        }, { threshold: 0.05 });
        marqueeContainers.forEach(c => marqueeObserver.observe(c));
    });
    </script>
    <script>
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


//solo para bajar hasta contacto
function smoothScroll(selector) {
    const element = document.querySelector(selector); // Usa querySelector para clases
    if (element) {
        const offset = 80; // Ajusta según tu navbar fijo (si existe)
        const position = element.getBoundingClientRect().top + window.pageYOffset - offset;
        
        window.scrollTo({
            top: position,
            behavior: 'smooth'
        });
    }
}

// Mostrar toast de notificación si hay status
<?php if (isset($_GET['status'])): ?>
document.addEventListener('DOMContentLoaded', function() {
    var toastEl = document.getElementById('statusToast');
    var toast = new bootstrap.Toast(toastEl, { autohide: true, delay: 5000 });
    toast.show();
});
<?php endif; ?>
</script>
</body>
</html>