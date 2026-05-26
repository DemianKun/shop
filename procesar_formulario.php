<?php
require_once 'config.php';

// Procesar formulario de contacto
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar y sanitizar datos
    $nombre = htmlspecialchars(trim($_POST['nombre']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $telefono = htmlspecialchars(trim($_POST['telefono']));
    $mensaje = htmlspecialchars(trim($_POST['mensaje']));
    $tipo = htmlspecialchars(trim($_POST['tipo'] ?? 'general'));
    
    // Validaciones básicas
    $errores = [];
    
    if (empty($nombre)) {
        $errores[] = "El nombre es obligatorio";
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El email no es válido";
    }
    
    if (empty($telefono)) {
        $errores[] = "El teléfono es obligatorio";
    }
    
    if (empty($mensaje)) {
        $errores[] = "El mensaje es obligatorio";
    }
    
    if (empty($tipo) || !in_array($tipo, ['cotizar_envio', 'negocio', 'repartidor'])) {
        $errores[] = "Selecciona un tipo de consulta válido";
    }
    
    // Si no hay errores, insertar en la base de datos
    if (empty($errores)) {
        $stmt = $conn->prepare("INSERT INTO contactos (nombre, email, telefono, mensaje, tipo) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nombre, $email, $telefono, $mensaje, $tipo);
        
        if ($stmt->execute()) {
            // Preparar mensaje para WhatsApp
            $numero_whatsapp = "525515280675"; // REEMPLAZA CON TU NÚMERO DE WHATSAPP (incluye código de país sin +)
            
            $tipo_texto = '';
            switch ($tipo) {
                case 'cotizar_envio':
                    $tipo_texto = 'Cotizar un envío';
                    break;
                case 'negocio':
                    $tipo_texto = 'Negocio';
                    break;
                case 'repartidor':
                    $tipo_texto = 'Repartidor';
                    break;
                default:
                    $tipo_texto = 'General';
            }
            
            $mensaje_whatsapp = "Buenas, Me gustaría más información sobre su servicio de Delivery.%0A%0A";
            $mensaje_whatsapp .= "Tipo de consulta: " . urlencode($tipo_texto) . "%0A%0A";
            $mensaje_whatsapp .= "Mis datos son los siguientes:%0A%0A";
            $mensaje_whatsapp .= "Nombre: " . urlencode($nombre) . "%0A";
            $mensaje_whatsapp .= "Email: " . urlencode($email) . "%0A";
            $mensaje_whatsapp .= "📱 Teléfono: " . urlencode($telefono) . "%0A%0A";
            $mensaje_whatsapp .= "" . urlencode($mensaje);
            
            // URL de WhatsApp
            $whatsapp_url = "https://wa.me/{$numero_whatsapp}?text={$mensaje_whatsapp}";
            
            // Éxito - redirigir directamente a WhatsApp
            header("Location: " . $whatsapp_url);
            exit();
        } else {
            // Error en la base de datos
            header("Location: index.php?status=error&message=" . urlencode("Error al guardar los datos"));
            exit();
        }
        
        $stmt->close();
    } else {
        // Hay errores de validación
        $error_message = implode(", ", $errores);
        header("Location: index.php?status=error&message=" . urlencode($error_message));
        exit();
    }
}

$conn->close();
?>