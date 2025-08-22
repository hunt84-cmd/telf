# Sistema de Gestión de Emisoras de Radio

Sistema completo en Laravel para manejar teléfonos, líneas y paquetes de las emisoras de radio.

## Características del Sistema

### 🏢 Emisoras
- **Nombre** y **Responsable**
- Gestión completa de emisoras de radio
- Relación con personas, teléfonos y líneas

### 👥 Personas
- **Nombre**, **Apellidos**, **CI** y **Emisora** a la que pertenece
- Gestión de personal de las emisoras
- Asignación de teléfonos y líneas

### 📱 Teléfonos
- **Modelo** y **Estado técnico** (Bueno, Dañado, Roto)
- Sistema de almacén para teléfonos disponibles
- Asignación a personas específicas
- Control de fechas de ingreso y asignación

### 📞 Líneas
- **Número de teléfono**, **PIN** y **PUK**
- Sistema de almacén para líneas disponibles
- Asignación a personas
- **Paquetes** asignados (datos, minutos, SMS)
- Estados: Activa, Inactiva, Suspendida

### 📦 Paquetes
- **Cantidad de Datos** (GB)
- **Cantidad de Minutos**
- **Cantidad de SMS**
- **Precio de costo** del paquete
- Descripción detallada

## Requisitos del Sistema

- PHP 8.1 o superior
- Composer
- MySQL/MariaDB
- Node.js y NPM (para compilar assets)

## Instalación

### 1. Clonar el repositorio
```bash
git clone <url-del-repositorio>
cd sistema-emisoras
```

### 2. Instalar dependencias de PHP
```bash
composer install
```

### 3. Instalar dependencias de Node.js
```bash
npm install
```

### 4. Configurar variables de entorno
```bash
cp .env.example .env
```

Editar el archivo `.env` con la configuración de tu base de datos:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistema_emisoras
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_password
```

### 5. Generar clave de aplicación
```bash
php artisan key:generate
```

### 6. Ejecutar migraciones
```bash
php artisan migrate
```

### 7. Ejecutar seeders (datos de ejemplo)
```bash
php artisan db:seed
```

### 8. Compilar assets
```bash
npm run build
```

### 9. Iniciar servidor de desarrollo
```bash
php artisan serve
```

El sistema estará disponible en: `http://localhost:8000`

## Estructura de la Base de Datos

### Tabla: `emisoras`
- `id` - Identificador único
- `nombre` - Nombre de la emisora
- `responsable` - Persona responsable
- `created_at`, `updated_at` - Timestamps

### Tabla: `personas`
- `id` - Identificador único
- `nombre` - Nombre de la persona
- `apellidos` - Apellidos de la persona
- `ci` - Cédula de identidad
- `emisora_id` - Referencia a la emisora
- `created_at`, `updated_at` - Timestamps

### Tabla: `paquetes`
- `id` - Identificador único
- `nombre` - Nombre del paquete
- `cantidad_datos` - Cantidad de datos en GB
- `cantidad_minutos` - Cantidad de minutos
- `cantidad_sms` - Cantidad de SMS
- `precio_costo` - Precio del paquete
- `descripcion` - Descripción del paquete
- `created_at`, `updated_at` - Timestamps

### Tabla: `telefonos`
- `id` - Identificador único
- `modelo` - Modelo del teléfono
- `estado_tecnico` - Estado (Bueno, Dañado, Roto)
- `persona_id` - Referencia a la persona asignada (nullable)
- `fecha_ingreso_almacen` - Fecha de ingreso al almacén
- `fecha_asignacion` - Fecha de asignación (nullable)
- `observaciones` - Observaciones adicionales
- `created_at`, `updated_at` - Timestamps

### Tabla: `lineas`
- `id` - Identificador único
- `numero_telefono` - Número de teléfono
- `pin` - Código PIN
- `puk` - Código PUK
- `persona_id` - Referencia a la persona asignada (nullable)
- `paquete_id` - Referencia al paquete asignado (nullable)
- `estado` - Estado de la línea (Activa, Inactiva, Suspendida)
- `fecha_ingreso_almacen` - Fecha de ingreso al almacén
- `fecha_asignacion` - Fecha de asignación (nullable)
- `observaciones` - Observaciones adicionales
- `created_at`, `updated_at` - Timestamps

## Funcionalidades del Sistema

### Dashboard Principal
- Estadísticas generales del sistema
- Estado del inventario (almacén vs asignado)
- Actividad reciente
- Acciones rápidas

### Gestión de Emisoras
- Crear, editar, eliminar emisoras
- Ver estadísticas por emisora
- Lista de personas por emisora

### Gestión de Personas
- Crear, editar, eliminar personas
- Asignar a emisoras
- Ver teléfonos y líneas asignadas

### Gestión de Paquetes
- Crear, editar, eliminar paquetes
- Configurar datos, minutos y SMS
- Establecer precios de costo

### Gestión de Teléfonos
- Ingresar teléfonos al almacén
- Asignar teléfonos a personas
- Devolver teléfonos al almacén
- Control de estados técnicos
- Filtros por almacén y asignados

### Gestión de Líneas
- Ingresar líneas al almacén
- Asignar líneas a personas
- Asignar/quitar paquetes
- Devolver líneas al almacén
- Control de estados
- Filtros por almacén y asignadas

## API REST

El sistema incluye endpoints API para integración con otros sistemas:

### Dashboard
- `GET /api/dashboard/stats` - Estadísticas generales
- `GET /api/dashboard/stats/emisoras` - Estadísticas por emisora
- `GET /api/dashboard/inventario` - Inventario del almacén
- `GET /api/dashboard/asignaciones` - Asignaciones activas

### Recursos
- `GET /api/emisoras` - Lista de emisoras
- `GET /api/personas` - Lista de personas
- `GET /api/paquetes` - Lista de paquetes
- `GET /api/telefonos` - Lista de teléfonos
- `GET /api/lineas` - Lista de líneas

### Recursos disponibles
- `GET /api/telefonos/disponibles` - Teléfonos en almacén
- `GET /api/lineas/disponibles` - Líneas en almacén
- `GET /api/paquetes/disponibles` - Paquetes sin asignar

## Flujo de Trabajo

### 1. Configuración Inicial
1. Crear emisoras
2. Crear paquetes de datos
3. Registrar personal

### 2. Gestión de Inventario
1. Ingresar teléfonos al almacén
2. Ingresar líneas al almacén
3. Asignar paquetes a líneas (opcional)

### 3. Asignaciones
1. Asignar teléfonos a personas
2. Asignar líneas a personas
3. Gestionar cambios de asignación

### 4. Mantenimiento
1. Actualizar estados de teléfonos
2. Cambiar estados de líneas
3. Devolver equipos al almacén

## Características Técnicas

- **Framework**: Laravel 10
- **Base de datos**: MySQL/MariaDB
- **Frontend**: Bootstrap 5, jQuery, DataTables
- **Notificaciones**: SweetAlert2
- **Responsive**: Diseño adaptable a móviles
- **Validación**: Validación del lado del servidor
- **Seguridad**: CSRF protection, validación de datos

## Personalización

### Agregar nuevos campos
1. Modificar la migración correspondiente
2. Actualizar el modelo
3. Actualizar el controlador
4. Actualizar las vistas

### Agregar nuevas funcionalidades
1. Crear el controlador
2. Definir las rutas
3. Crear las vistas
4. Actualizar la navegación

## Mantenimiento

### Backup de base de datos
```bash
php artisan backup:run
```

### Limpiar caché
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Actualizar dependencias
```bash
composer update
npm update
```

## Soporte

Para soporte técnico o consultas sobre el sistema, contactar al equipo de desarrollo.

## Licencia

Este proyecto está bajo licencia MIT. Ver archivo LICENSE para más detalles.

---

**Desarrollado con ❤️ para la gestión eficiente de emisoras de radio**