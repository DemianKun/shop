<div class="quote-form-container">

    <!-- Contenedor del formulario con marca de agua -->
    <div class="join-form-container position-relative overflow-hidden py-4 px-3">

        <div class="watermark-logo">
            <img src="WhatsApp_Image_2025-06-18_at_6.07.39_PM__1_-removebg-preview.png" 
                 alt="Delivery Warrior" 
                 style="opacity: 0.08; width: 800px;">
        </div>

        <h2 class="form-title">INFORMACIÓN DEL ENVÍO</h2>
        <form id="quoteForm" action="/wp-admin/admin-post.php" method="POST">
            <!-- Campos ocultos para WordPress -->
            <input type="hidden" name="action" value="procesar_cotizacion">
            <input type="hidden" name="form_type" value="cotizacion_envio">

            <!-- Sección de Información del Cliente -->
            <div class="address-section pickup-section">
                <h3 class="section-title">
                    <i class="fas fa-user"></i> INFORMACIÓN DEL CLIENTE
                </h3>
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="nombre_cliente" placeholder="NOMBRE COMPLETO" required>
                    </div>
                    <div class="col-md-6">
                        <input type="email" class="form-control" name="email_cliente" placeholder="CORREO ELECTRÓNICO" required>
                    </div>
                    <div class="col-md-6">
                        <input type="tel" class="form-control" name="telefono_cliente" placeholder="TELÉFONO" required>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="empresa" placeholder="EMPRESA (OPCIONAL)">
                    </div>
                </div>
            </div>

            <!-- Sección de Recogida -->
            <div class="address-section position-relative overflow-hidden">
                <h3 class="section-title">
                    <div class="watermark-logo-top">
                        <img src="WhatsApp_Image_2025-06-19_at_12.25.35_PM-removebg-preview.png" 
                             alt="Delivery Warrior" style="opacity: 0.08; width: 500px;">
                    </div>
                    <i class="fas fa-map-marker-alt"></i> DIRECCIÓN DE RECOGIDA
                </h3>
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="origen_codigo_postal" placeholder="CÓDIGO POSTAL" required>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="origen_calle" placeholder="CALLE" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="origen_numero" placeholder="NÚMERO" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="origen_manzana" placeholder="MANZANA">
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="origen_lote" placeholder="LOTE">
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="origen_colonia" placeholder="COLONIA" required>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="origen_municipio" placeholder="MUNICIPIO/ALCALDÍA" required>
                    </div>
                    <div class="col-md-12">
                        <input type="text" class="form-control" name="origen_estado" placeholder="ESTADO" required>
                    </div>
                    <div class="col-md-12">
                        <label for="origen_instrucciones" class="form-label">INSTRUCCIONES ESPECIALES PARA RECOGIDA</label>
                        <textarea class="form-control" id="origen_instrucciones" name="origen_instrucciones" rows="2" placeholder="Ej: Llamar antes de llegar, código de acceso, etc."></textarea>
                    </div>
                </div>
            </div>

            <!-- Sección de Destino -->
            <div class="address-section">
                <h3 class="section-title">
                    <i class="fas fa-flag-checkered"></i> DIRECCIÓN DE DESTINO
                </h3>
                <div class="row">
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="destino_codigo_postal" placeholder="CÓDIGO POSTAL" required>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="destino_calle" placeholder="CALLE" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="destino_numero" placeholder="NÚMERO" required>
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="destino_manzana" placeholder="MANZANA">
                    </div>
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="destino_lote" placeholder="LOTE">
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="destino_colonia" placeholder="COLONIA" required>
                    </div>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="destino_municipio" placeholder="MUNICIPIO/ALCALDÍA" required>
                    </div>
                    <div class="col-md-12">
                        <input type="text" class="form-control" name="destino_estado" placeholder="ESTADO" required>
                    </div>
                    <div class="col-md-12">
                        <label for="destino_instrucciones" class="form-label">INSTRUCCIONES ESPECIALES PARA ENTREGA</label>
                        <textarea class="form-control" id="destino_instrucciones" name="destino_instrucciones" rows="2" placeholder="Ej: Llamar al llegar, dejar con conserje, etc."></textarea>
                    </div>
                </div>
            </div>

            <!-- Información adicional del paquete -->
            <div class="row mt-4">
                <div class="col-md-4">
                    <label for="tipo_paquete" class="form-label">TIPO DE PAQUETE</label>
                    <select class="form-select" id="tipo_paquete" name="tipo_paquete" required>
                        <option value="" selected disabled>Selecciona una opción</option>
                        <option value="documento">Documento</option>
                        <option value="paquete_pequeno">Paquete pequeño (hasta 1kg)</option>
                        <option value="paquete_mediano">Paquete mediano (1-5kg)</option>
                        <option value="paquete_grande">Paquete grande (5-20kg)</option>
                        <option value="carga_especial">Carga especial</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="valor_asegurado" class="form-label">VALOR ASEGURADO (OPCIONAL)</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control" id="valor_asegurado" name="valor_asegurado" min="0" step="0.01">
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="fecha_entrega" class="form-label">FECHA DESEADA DE ENTREGA</label>
                    <input type="date" class="form-control" id="fecha_entrega" name="fecha_entrega" min="<?php echo date('Y-m-d'); ?>">
                </div>
            </div>

            <!-- Horario de recogida -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <label for="horario_recogida" class="form-label">HORARIO PREFERIDO DE RECOGIDA</label>
                    <select class="form-select" id="horario_recogida" name="horario_recogida">
                        <option value="" selected disabled>Selecciona un horario</option>
                        <option value="9-12">9:00 AM - 12:00 PM</option>
                        <option value="12-15">12:00 PM - 3:00 PM</option>
                        <option value="15-18">3:00 PM - 6:00 PM</option>
                        <option value="18-21">6:00 PM - 9:00 PM</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="referencia" class="form-label">NÚMERO DE REFERENCIA (OPCIONAL)</label>
                    <input type="text" class="form-control" id="referencia" name="referencia" placeholder="Ej: Pedido #12345">
                </div>
            </div>

            <div class="form-check mt-4 mb-4">
                <input class="form-check-input" type="checkbox" id="termsCheck" required>
                <label class="form-check-label" for="termsCheck">
                    Acepto los <a href="#" style="color: var(--verde);">términos y condiciones</a> y la <a href="#" style="color: var(--verde);">política de privacidad</a>
                </label>
            </div>

            <button type="submit" class="btn btn-quote">COTIZAR ENVÍO</button>
        </form>
    </div>
</div>