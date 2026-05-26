        <!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Warrior - Integra tu Negocio</title>
    <!-- Google Fonts para tipografía profesional -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Leaflet CSS para el mapa -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"/>
    <link rel="icon" href="WhatsApp_Image_2025-06-18_at_6.07.39_PM__1_-removebg-preview.png" type="image/png">
    <link rel="shortcut icon" href="WhatsApp_Image_2025-06-18_at_6.07.39_PM__1_-removebg-preview.png" type="image/png">
    <link rel="apple-touch-icon" href="WhatsApp_Image_2025-06-18_at_6.07.39_PM__1_-removebg-preview.png" sizes="180x180">
    <meta name="theme-color" content="#14100d">
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/navbar.css">
    <link rel="stylesheet" href="css/integrate.css">
    <link rel="stylesheet" href="css/footer.css">
</head>
<body>
    <?php include 'components/navbar.php'; ?>

    <!-- Sección Hero -->
    <section class="hero-integrate">
        <div class="container">
            <h1 class="hero-integrate-title">INTEGRA TU NEGOCIO</h1>
            <p class="lead">Conecta tu negocio con nuestra red de repartidores y haz crecer tus ventas</p>
        </div>
    </section>

    <!-- Formulario de integración -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <?php include 'components/integrate_form.php'; ?>
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
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAbXYhZchplfS3rbCxCMtocR9aOx7vpv2w&callback=initMap" async defer></script>
     <script>
      
        // Geocodificar una posición y actualizar el formulario
        function geocodePosition(position) {
            geocoder.geocode({ location: position }, (results, status) => {
                if (status === "OK") {
                    if (results[0]) {
                        updateFormFieldsFromResult(results[0]);
                    }
                } else {
                    console.error("Geocoder failed due to: " + status);
                }
            });
        }
        
        // Actualizar campos del formulario desde un resultado de geocodificación
        function updateFormFieldsFromResult(result) {
            // Extraer componentes de la dirección
            const addressComponents = {};
            result.address_components.forEach(component => {
                component.types.forEach(type => {
                    addressComponents[type] = component.long_name;
                });
            });
            
            // Actualizar campos del formulario
            document.getElementById("latitud").value = result.geometry.location.lat();
            document.getElementById("longitud").value = result.geometry.location.lng();
            
            if (addressComponents["route"]) document.getElementById("calle").value = addressComponents["route"];
            if (addressComponents["street_number"]) document.getElementById("numero").value = addressComponents["street_number"];
            if (addressComponents["postal_code"]) document.getElementById("codigo_postal").value = addressComponents["postal_code"];
            if (addressComponents["sublocality"]) document.getElementById("colonia").value = addressComponents["sublocality"];
            if (addressComponents["locality"]) document.getElementById("municipio").value = addressComponents["locality"];
            if (addressComponents["administrative_area_level_1"]) document.getElementById("estado").value = addressComponents["administrative_area_level_1"];
            
            // Mostrar detalles en el infowindow
            document.getElementById("infowindow-address").textContent = result.formatted_address;
            infowindow.setContent(document.getElementById("infowindow-content"));
            infowindow.open(map, marker);
        }
        
        // Actualizar campos desde un lugar de Places API
        function updateFormFieldsFromPlace(place) {
            document.getElementById("latitud").value = place.geometry.location.lat();
            document.getElementById("longitud").value = place.geometry.location.lng();
            
            // Extraer componentes de la dirección
            const addressComponents = {};
            place.address_components.forEach(component => {
                component.types.forEach(type => {
                    addressComponents[type] = component.long_name;
                });
            });
            
            if (addressComponents["route"]) document.getElementById("calle").value = addressComponents["route"];
            if (addressComponents["street_number"]) document.getElementById("numero").value = addressComponents["street_number"];
            if (addressComponents["postal_code"]) document.getElementById("codigo_postal").value = addressComponents["postal_code"];
            if (addressComponents["sublocality"]) document.getElementById("colonia").value = addressComponents["sublocality"];
            if (addressComponents["locality"]) document.getElementById("municipio").value = addressComponents["locality"];
            if (addressComponents["administrative_area_level_1"]) document.getElementById("estado").value = addressComponents["administrative_area_level_1"];
            
            // Mostrar detalles en el infowindow
            document.getElementById("infowindow-address").textContent = place.formatted_address || place.name;
            infowindow.setContent(document.getElementById("infowindow-content"));
            infowindow.open(map, marker);
        }
        
        // Mostrar/ocultar campo para otro giro comercial
        document.querySelectorAll('input[name="giro_comercial"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const otroGiroContainer = document.getElementById('otroGiroContainer');
                otroGiroContainer.style.display = this.value === 'otro' ? 'block' : 'none';
            });
        });
        
        // Validación del formulario
        document.getElementById('integrateForm').addEventListener('submit', function(e) {
            if(!document.getElementById('latitud').value || !document.getElementById('longitud').value) {
                e.preventDefault();
                alert('Por favor selecciona una ubicación en el mapa para tu negocio.');
                return false;
            }
            
            if(document.querySelector('input[name="giro_comercial"]:checked').value === 'otro' && 
               !document.querySelector('input[name="otro_giro"]').value) {
                e.preventDefault();
                alert('Por favor especifica el giro de tu negocio.');
                return false;
            }
            
            return true;
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
    
    <!-- Contenido para el infowindow -->
    <div id="infowindow-content" style="display: none;">
        <span id="infowindow-address"></span>
</body>
</html>