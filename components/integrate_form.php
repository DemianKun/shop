<div class="integrate-form-container">
    <!-- Contenedor del formulario con marca de agua -->
    <div class="join-form-container position-relative overflow-hidden py-4 px-3">

        <div class="watermark-logo">
            <img src="WhatsApp_Image_2025-06-18_at_6.07.39_PM__1_-removebg-preview.png" 
                 alt="Delivery Warrior" 
                 style="opacity: 0.08; width: 1000px;">
        </div>
        <h2 class="form-title">REGISTRO DE NEGOCIO</h2>
        <form id="integrateForm" action="procesar_integrate.php" method="POST">
            
            <!-- Sección de Información del Negocio -->
            <div class="business-section position-relative overflow-hidden">
                <h3 class="section-title">
                    <div class="watermark-logo-top">
                        <img src="WhatsApp_Image_2025-06-19_at_12.25.35_PM-removebg-preview.png" 
                             alt="Delivery Warrior" 
                             style="opacity: 0.08; width: 300px;">
                    </div>
                    <i class="fas fa-store"></i> INFORMACIÓN DEL NEGOCIO
                </h3>
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="nombre_negocio" placeholder="NOMBRE DEL NEGOCIO" required>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="nombre_responsable" placeholder="NOMBRE DEL RESPONSABLE" required>
                    </div>
                    <div class="col-md-6">
                        <input type="email" class="form-control" name="email_negocio" placeholder="CORREO ELECTRÓNICO" required>
                    </div>
                    <div class="col-md-6">
                        <input type="tel" class="form-control" name="telefono_negocio" placeholder="TELÉFONO DEL NEGOCIO" required>
                    </div>
                    <div class="col-md-12">
                        <input type="text" class="form-control" name="sitio_web" placeholder="SITIO WEB (OPCIONAL)">
                    </div>
                </div>
            </div>
            
            <!-- Sección de Giro Comercial -->
            <div class="business-section">
                <h3 class="section-title">
                    <i class="fas fa-tags"></i> GIRO COMERCIAL
                </h3>
                <p class="mb-3">Selecciona el giro principal de tu negocio:</p>
                
                <div class="business-type-options">
                    <label class="business-type-option">
                        <input type="radio" name="giro_comercial" value="restaurante" required>
                        <div class="business-type-content">
                            <i class="fas fa-utensils business-type-icon"></i>
                            <p>RESTAURANTE</p>
                        </div>
                    </label>
                    <label class="business-type-option">
                        <input type="radio" name="giro_comercial" value="tienda" required>
                        <div class="business-type-content">
                            <i class="fas fa-shopping-bag business-type-icon"></i>
                            <p>TIENDA</p>
                        </div>
                    </label>
                    <label class="business-type-option">
                        <input type="radio" name="giro_comercial" value="farmacia" required>
                        <div class="business-type-content">
                            <i class="fas fa-prescription-bottle-alt business-type-icon"></i>
                            <p>FARMACIA</p>
                        </div>
                    </label>
                    <label class="business-type-option">
                        <input type="radio" name="giro_comercial" value="supermercado" required>
                        <div class="business-type-content">
                            <i class="fas fa-shopping-cart business-type-icon"></i>
                            <p>SUPERMERCADO</p>
                        </div>
                    </label>
                    <label class="business-type-option">
                        <input type="radio" name="giro_comercial" value="floreria" required>
                        <div class="business-type-content">
                            <i class="fas fa-spa business-type-icon"></i>
                            <p>FLORERÍA</p>
                        </div>
                    </label>
                    <label class="business-type-option">
                        <input type="radio" name="giro_comercial" value="otro" required>
                        <div class="business-type-content">
                            <i class="fas fa-ellipsis-h business-type-icon"></i>
                            <p>OTRO</p>
                        </div>
                    </label>
                </div>
                
                <div id="otroGiroContainer" style="display: none;">
                    <input type="text" class="form-control" name="otro_giro" placeholder="ESPECIFICA EL GIRO DE TU NEGOCIO">
                </div>
            </div>
            
            <!-- Sección de Dirección -->
            <div class="business-section">
                <h3 class="section-title">
                    <i class="fas fa-map-marked-alt"></i> DIRECCIÓN DEL NEGOCIO
                </h3>
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="codigo_postal" name="codigo_postal" placeholder="CÓDIGO POSTAL" required>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="calle" name="calle" placeholder="CALLE" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="numero" name="numero" placeholder="NÚMERO" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="manzana" name="manzana" placeholder="MANZANA">
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" id="lote" name="lote" placeholder="LOTE">
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="colonia" name="colonia" placeholder="COLONIA" required>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" id="municipio" name="municipio" placeholder="MUNICIPIO/ALCALDÍA" required>
                    </div>
                    <div class="col-md-12">
                        <input type="text" class="form-control" id="estado" name="estado" placeholder="ESTADO" required>
                    </div>
                    <div class="col-md-12">
                        <label for="referencias" class="form-label">REFERENCIAS PARA LLEGAR</label>
                        <textarea class="form-control" id="referencias" name="referencias" rows="2" placeholder="Ej: Entre calles, puntos de referencia, etc."></textarea>
                    </div>
                </div>
            </div>
            
            <!-- Horarios de atención -->
            <div class="row mt-4">
                <div class="col-md-12">
                    <h3 class="section-title">
                        <i class="fas fa-clock"></i> HORARIOS DE ATENCIÓN
                    </h3>
                </div>
                <div class="col-md-4">
                    <label for="hora_apertura" class="form-label">HORA DE APERTURA</label>
                    <input type="time" class="form-control" id="hora_apertura" name="hora_apertura" required>
                </div>
                <div class="col-md-4">
                    <label for="hora_cierre" class="form-label">HORA DE CIERRE</label>
                    <input type="time" class="form-control" id="hora_cierre" name="hora_cierre" required>
                </div>
                <div class="col-md-4">
                    <label for="dias_operacion" class="form-label">DÍAS DE OPERACIÓN</label>
                    <select class="form-select" id="dias_operacion" name="dias_operacion" required>
                        <option value="L-V">Lunes a Viernes</option>
                        <option value="L-S">Lunes a Sábado</option>
                        <option value="L-D">Todos los días</option>
                        <option value="otros">Otros (especificar)</option>
                    </select>
                </div>
            </div>

            <div class="form-check mt-4 mb-4">
                <input class="form-check-input" type="checkbox" id="termsCheck" required>
                <label class="form-check-label" for="termsCheck">
                    Acepto los <a href="#" style="color: var(--verde);">términos y condiciones</a> y autorizo el uso de mis datos para fines comerciales
                </label>
            </div>

            <button type="submit" class="btn btn-integrate">REGISTRAR MI NEGOCIO</button>
        </form>
    </div>
</div>