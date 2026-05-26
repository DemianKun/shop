# Delivery Warrior - Sistema de Gestión de Envíos

## 🚀 Sistema Completo Implementado

### Estructura de Carpetas por Roles

```
delivery/
├── administrador/
│   └── dashboard.php          # Dashboard para administradores
├── usuario/
│   ├── dashboard.php          # Dashboard para usuarios
│   └── procesar_pedido.php    # Procesador de pedidos
├── comercio/
│   ├── dashboard.php          # Dashboard para comercios
│   └── procesar_envio.php     # Procesador de envíos
├── repartidor/
│   ├── dashboard.php          # Dashboard para repartidores
│   └── actualizar_estado.php  # Actualización de estados
├── css/
│   └── dashboard/
│       ├── admin.css          # Estilos dashboard administrador
│       ├── usuario.css        # Estilos dashboard usuario
│       ├── comercio.css       # Estilos dashboard comercio
│       └── repartidor.css     # Estilos dashboard repartidor
├── login.php                  # Página de inicio de sesión
├── registro.php               # Página de registro
├── logout.php                 # Cerrar sesión
├── procesar_login.php         # Procesador login (con password_verify)
├── procesar_registro.php      # Procesador registro (con password_hash)
├── procesar_integrate.php     # Procesador integrate (con password_hash)
├── update_database.php        # Script para actualizar BD
└── config.php                 # Configuración de base de datos
```

---

## 📊 Dashboards por Tipo de Usuario

### 1️⃣ Dashboard de USUARIO (Rol ID: 1)
**Ruta:** `usuario/dashboard.php`

**Características:**
- ✅ **Crear Nuevos Pedidos:** Modal completo con formulario de envío
- ✅ **Estadísticas:** Total cotizaciones, mensajes enviados, pedidos activos
- ✅ **Historial de Cotizaciones:** Tabla con últimas 5 cotizaciones
- ✅ **Acciones Rápidas:** Nuevo pedido, cotizar envío, rastrear, soporte
- ✅ **Formulario de Pedido:**
  - Direcciones de origen y destino (calle, número, colonia, CP)
  - Tipo de paquete (Sobre, Caja pequeña, mediana, grande)
  - Valor declarado
  - Instrucciones especiales

**Colores:** Naranja (#fe810d) - Fondo oscuro (#0d1726)

---

### 2️⃣ Dashboard de COMERCIO (Rol ID: 2)
**Ruta:** `comercio/dashboard.php`

**Características:**
- ✅ **Información del Comercio:** Nombre responsable, tipo, horarios, ubicación
- ✅ **Estadísticas:**
  - Total de envíos realizados
  - Envíos del día
  - Valor total enviado
- ✅ **Gestión de Pedidos:** Tabla con pedidos recientes
- ✅ **Estados de Envío:** Pendiente, En tránsito, Entregado, Fallido
- ✅ **Solicitar Envíos:**
  - Origen automático (dirección del comercio)
  - Destino configurable
  - Empresa/Cliente
  - Tipo de paquete y valor
  - Fecha de entrega deseada

**Colores:** Verde (#28a745) - Fondo oscuro (#0a1e1a)

---

### 4️⃣ Dashboard de ADMINISTRADOR (Rol ID: 4)
**Ruta:** `administrador/dashboard.php`

**Características:**
- ✅ **Estadísticas Globales:** Total usuarios, comercios, repartidores, envíos
- ✅ **Gestión de Usuarios:** Tabla con todos los usuarios registrados
- ✅ **Gráficos Interactivos:** Usuarios por rol, envíos por estado
- ✅ **Ingresos Totales:** Suma de valores de todos los envíos
- ✅ **Panel de Control:** Vista general del sistema completo
- ✅ **Funciones Administrativas:** (Próximamente: editar usuarios, gestionar roles)

**Colores:** Morado (#6f42c1) - Gradiente premium

---

## 🔐 Sistema de Autenticación

### Seguridad Implementada
- ✅ **Password Hashing:** `password_hash()` con `PASSWORD_DEFAULT`
- ✅ **Password Verification:** `password_verify()` en login
- ✅ **Sesiones PHP:** Datos del usuario en `$_SESSION`
- ✅ **Transacciones SQL:** Para mantener integridad de datos
- ✅ **Redirección por Rol:** Cada usuario va a su dashboard correspondiente

### Archivos de Procesamiento
2. **procesar_login.php**
   - Valida credenciales con `password_verify()`
   - Crea sesión con 5 variables
   - Redirige según `id_rol`: 1→administrador/, 2→comercio/, 3→repartidor/, 4→usuario/

3. **procesar_registro.php**
   - Hashea contraseña con `password_hash()`
   - Inserciones por rol:
     - **Usuario (4):** Solo tabla `usuario`
     - **Comercio (2):** `usuario` → `direccion` → `comercio`
     - **Repartidor (3):** `usuario` → `vehiculo` → `repartidor`

4. **procesar_integrate.php**
   - Crea comercios desde formulario público
   - Genera contraseña aleatoria hasheada
   - Devuelve password temporal al usuario

5. **update_database.php**
   - Actualiza la base de datos con nuevos roles
   - Agrega rol Administrador y usuario de prueba
   - Ejecutar después de actualizar `bd.sql`

---

## 🗄️ Base de Datos

### Tablas Principales
- `usuario` - Usuarios del sistema
- `rol` - Tipos de usuario (1=Administrador, 2=Comercio, 3=Repartidor, 4=Usuario)
- `comercio` - Datos de comercios
- `repartidor` - Datos de repartidores
- `direccion` - Direcciones de origen
- `destino` - Direcciones de destino
- `vehiculo` - Vehículos de repartidores
- `envios` - Pedidos/envíos
- `estado_envio` - Historial de estados
- `cotizaciones` - Cotizaciones realizadas
- `contactos` - Mensajes de contacto

### Relaciones
```
usuario (1) → (N) comercio
usuario (1) → (N) repartidor
comercio (1) → (N) envios
repartidor (1) → (N) envios
direccion (1) → (N) envios (origen)
destino (1) → (N) envios (destino)
vehiculo (1) → (N) repartidor
envios (1) → (N) estado_envio
```

---

## 🎨 Diseño Premium

### Características de Diseño
- **Glassmorphism:** Tarjetas con `backdrop-filter: blur()`
- **Gradientes:** Fondos con degradados oscuros
- **Iconos:** Font Awesome 6.4.0
- **Responsive:** Bootstrap 5.3.3 + Media Queries
- **Animaciones:** Hover effects con `transform` y `box-shadow`
- **Colores por Rol:**
  - Administrador: Morado (#6f42c1)
  - Comercio: Verde (#28a745)
  - Repartidor: Azul (#007bff)
  - Usuario: Naranja (#fe810d)

---

## 📝 Funcionalidades Implementadas

### ✅ Administrador
1. Ver estadísticas globales del sistema
2. Gestionar usuarios (ver todos los registros)
3. Gráficos interactivos de usuarios y envíos
4. Monitorear ingresos totales
5. Panel de control completo

### ✅ Comercio
1. Ver información del negocio
2. Estadísticas de envíos y valor total
3. Solicitar nuevos envíos
4. Ver historial de pedidos con estados
5. Origen automático desde dirección registrada

### ✅ Repartidor
1. Ver información del vehículo
2. Estadísticas de entregas y tasa de éxito
3. Ver entregas asignadas
4. Ver detalles completos de cada entrega
5. Actualizar estado (Entregado/Fallido)
6. Instrucciones especiales de entrega

### ✅ Usuario
1. Ver estadísticas personales
2. Crear nuevos pedidos con direcciones completas
3. Ver historial de cotizaciones
4. Acceso a cotizador y soporte

---

## 🔧 Configuración

### Archivo config.php
```php
<?php
// Configuración PDO
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'u975895695_deleveryu');
define('DB_PASSWORD', 'Admin585/52@');
define('DB_NAME', 'u975895695_delevery');

$pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, 
               DB_USERNAME, DB_PASSWORD);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
```

**Nota:** También existe conexión MySQLi en `$conn` para archivos legacy.

### Usuario Administrador de Prueba
- **Email:** admin@delivery.com
- **Contraseña:** admin123
- **Rol:** Administrador (ID: 1)

---

## 🚦 Estados de Envío

| Estado | Color | Descripción |
|--------|-------|-------------|
| Pendiente | Amarillo | Envío registrado, esperando asignación |
| En tránsito | Azul | Repartidor en camino |
| Entregado | Verde | Entrega completada exitosamente |
| Fallido | Rojo | Entrega no realizada |

---

## 📱 Responsive Design

### Breakpoints
- **Desktop:** > 992px - Vista completa
- **Tablet:** 768px - 992px - Grid adaptado
- **Mobile:** < 768px - Columna única, menú colapsado

---

## 🔄 Próximas Funcionalidades

### En Desarrollo
- [ ] Mapa de rutas para repartidores
- [ ] Sistema de QR para escaneo de paquetes
- [ ] Notificaciones en tiempo real
- [ ] Chat de soporte
- [ ] Reportes avanzados
- [ ] Sistema de calificaciones
- [ ] Recuperación de contraseña
- [ ] Edición de perfil
- [ ] Gestión de múltiples direcciones

---

## 👥 Roles del Sistema

| ID | Tipo | Dashboard | Funciones Principales |
|----|------|-----------|----------------------|
| 1 | Administrador | `administrador/dashboard.php` | Gestión global, estadísticas sistema |
| 2 | Comercio | `comercio/dashboard.php` | Solicitar envíos, ver estadísticas |
| 3 | Repartidor | `repartidor/dashboard.php` | Ver asignaciones, actualizar estados |
| 4 | Usuario | `usuario/dashboard.php` | Crear pedidos, ver cotizaciones |

---

## 📞 Soporte

Para cualquier duda o problema, contacta al equipo de Delivery Warrior a través del formulario de contacto en el sitio web.

---

**Delivery Warrior** - Sistema completo de gestión de envíos con dashboards personalizados por rol.
