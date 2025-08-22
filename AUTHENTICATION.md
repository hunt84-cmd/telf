# 🔐 Sistema de Autenticación - Sistema de Emisoras

## 📋 Descripción General

Se ha implementado un sistema de autenticación completo para proteger todas las vistas y funcionalidades del sistema de gestión de emisoras. El sistema incluye:

- **Login/Logout** con validación de credenciales
- **Gestión de usuarios** con roles (admin/user)
- **Protección de rutas** mediante middleware de autenticación
- **Gestión de perfiles** de usuario
- **Sistema de sesiones** seguro

## 🚀 Características Principales

### 🔑 Autenticación
- Formulario de login con validación
- Verificación de credenciales
- Gestión de sesiones
- Logout seguro

### 👥 Gestión de Usuarios
- **Rol Administrador**: Acceso completo al sistema
- **Rol Usuario**: Acceso limitado (configurable)
- Estados activo/inactivo
- Verificación de email

### 🛡️ Seguridad
- Middleware de autenticación
- Verificación de usuarios activos
- Protección CSRF
- Encriptación de contraseñas
- Timeout de sesiones

## 📁 Archivos Implementados

### Modelos
- `app/Models/User.php` - Modelo de usuario con roles y estados

### Controladores
- `app/Http/Controllers/AuthController.php` - Controlador de autenticación

### Middleware
- `app/Http/Middleware/AdminMiddleware.php` - Verificación de administradores
- `app/Http/Middleware/EnsureUserIsActive.php` - Verificación de usuarios activos

### Vistas
- `resources/views/auth/login.blade.php` - Formulario de login
- `resources/views/auth/profile.blade.php` - Perfil del usuario

### Migraciones
- `database/migrations/2024_01_01_000000_create_users_table.php` - Tabla de usuarios

### Seeders
- `database/seeders/UserSeeder.php` - Usuarios por defecto

### Configuración
- `config/auth.php` - Configuración de autenticación
- `config/session.php` - Configuración de sesiones

## 🔧 Instalación y Configuración

### 1. Ejecutar Migraciones
```bash
php artisan migrate
```

### 2. Ejecutar Seeders
```bash
php artisan db:seed
```

### 3. Verificar Configuración
- Asegurarse de que `config/auth.php` esté configurado
- Verificar `config/session.php` para sesiones

## 👤 Usuarios por Defecto

### Administrador Principal
- **Email**: `admin@emisoras.com`
- **Contraseña**: `admin123`
- **Rol**: `admin`
- **Estado**: `activo`

### Usuarios de Ejemplo
- **Email**: `juan@emisoras.com`
- **Contraseña**: `password123`
- **Rol**: `user`

- **Email**: `maria@emisoras.com`
- **Contraseña**: `password123`
- **Rol**: `user`

## 🛣️ Rutas de Autenticación

### Rutas Públicas
- `GET /login` - Formulario de login
- `POST /login` - Procesar login
- `POST /logout` - Cerrar sesión

### Rutas Protegidas
- `GET /profile` - Perfil del usuario
- `PUT /profile` - Actualizar perfil
- `GET /dashboard` - Dashboard principal
- Todas las rutas del sistema (emisoras, personas, etc.)

## 🔒 Middleware Implementado

### Auth Middleware
- Verifica que el usuario esté autenticado
- Redirige al login si no hay sesión

### Admin Middleware
- Verifica que el usuario sea administrador
- Acceso restringido a funciones administrativas

### User Active Middleware
- Verifica que el usuario esté activo
- Cierra sesión si el usuario está inactivo

## 🎨 Interfaz de Usuario

### Login
- Diseño moderno y responsive
- Validación en tiempo real
- Mensajes de error claros
- Información de credenciales por defecto

### Perfil de Usuario
- Información del usuario
- Edición de datos personales
- Cambio de contraseña
- Estado de la cuenta

### Navegación
- Menú de usuario en navbar
- Indicador de rol
- Acceso rápido al perfil
- Botón de logout

## 🔐 Funciones de Seguridad

### Validación
- Credenciales requeridas
- Verificación de contraseña actual
- Confirmación de nueva contraseña
- Validación de email único

### Sesiones
- Regeneración de tokens CSRF
- Invalidación de sesiones
- Timeout configurable
- Cookies seguras

### Contraseñas
- Encriptación con Hash
- Verificación de contraseña actual
- Validación de fortaleza
- Confirmación requerida

## 🚨 Manejo de Errores

### Errores de Autenticación
- Credenciales incorrectas
- Usuario inactivo
- Sesión expirada
- Acceso no autorizado

### Mensajes de Usuario
- Notificaciones de éxito
- Alertas de error
- Validación de formularios
- Confirmaciones de acciones

## 📱 Responsive Design

- Compatible con dispositivos móviles
- Navegación adaptativa
- Formularios optimizados
- Iconos Font Awesome

## 🔄 Flujo de Autenticación

1. **Acceso inicial** → Redirige a `/login`
2. **Formulario de login** → Validación de credenciales
3. **Verificación** → Comprobar usuario activo
4. **Crear sesión** → Generar token CSRF
5. **Acceso al sistema** → Redirigir al dashboard
6. **Navegación** → Todas las rutas protegidas
7. **Logout** → Invalidar sesión y redirigir

## 🛠️ Personalización

### Roles de Usuario
- Modificar `User` model para nuevos roles
- Actualizar middleware según necesidades
- Configurar permisos específicos

### Configuración de Sesiones
- Modificar `config/session.php`
- Ajustar timeout de sesiones
- Configurar driver de sesiones

### Estilos y Temas
- Personalizar vistas en `resources/views/auth/`
- Modificar CSS en los archivos de vista
- Adaptar iconos y colores

## 📊 Monitoreo y Logs

### Actividad de Usuarios
- Login/logout registrados
- Intentos fallidos de autenticación
- Cambios de contraseña
- Accesos al sistema

### Seguridad
- Tokens CSRF generados
- Sesiones creadas/destruidas
- Intentos de acceso no autorizado

## 🚀 Próximas Mejoras

- [ ] Recuperación de contraseñas
- [ ] Verificación de email
- [ ] Autenticación de dos factores
- [ ] Logs de auditoría
- [ ] Gestión de usuarios por administradores
- [ ] Permisos granulares por módulo

## 📞 Soporte

Para cualquier consulta sobre el sistema de autenticación:

1. Revisar la documentación
2. Verificar logs del sistema
3. Comprobar configuración de base de datos
4. Validar archivos de configuración

---

**Nota**: Este sistema de autenticación está diseñado para entornos de producción y incluye las mejores prácticas de seguridad de Laravel.