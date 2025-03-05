# 📨 Sistema de Notificaciones

## 📝 Descripción

Un sistema de notificaciones moderno y completo construido con Laravel. El proyecto incluye funcionalidades como gestión de notificaciones, preferencias de usuario, panel de control, y más.

## 📸 Capturas de Pantalla

### 📊 Dashboard

![Dashboard](/screenshots/dashboard.png)
_Panel principal con vista general de notificaciones_

### 📝 Creación de Notificaciones

![Crear Notificación](/screenshots/create-notification.png)
_Interfaz para crear nuevas notificaciones_

### 📋 Lista de Notificaciones

![Lista de Notificaciones](/screenshots/list-notifications.png)
_Vista de todas las notificaciones en el sistema_

### 🔍 Vista Previa de Notificación

![Vista Previa](/screenshots/preview-notification.png)
_Vista previa de notificaciones antes de enviar_

### ⚙️ Tipos de Notificaciones

![Tipos de Notificaciones](/screenshots/tipos-notifications.png)
_Gestión de tipos de notificaciones_

### ✏️ Edición de Tipos de Notificaciones

![Editar Tipos](/screenshots/edit-tipo-notifications.png)
_Interfaz de edición para tipos de notificaciones_

## 🚀 Tecnologías Utilizadas

### Frontend

-   🎨 Tailwind CSS para la interfaz de usuario
-   ⚡ Livewire para interactividad en tiempo real
-   🌐 Laravel Blade para el renderizado de vistas

### Backend

-   🛠️ Laravel como framework principal
-   🗃️ SQLite como base de datos
-   📨 Sistema de eventos y listeners
-   🔄 Queue system para procesamiento de notificaciones
-   📝 Sistema de programación de notificaciones

## 🛠️ Requisitos Previos

-   PHP 8.1 o superior
-   Composer
-   Node.js y NPM
-   SQLite

## ⚙️ Configuración del Proyecto

1. **Clonar el repositorio**

```bash
git clone https://github.com/MichaelVairoDev/Notification_System.git
cd Notification_System
```

2. **Instalar dependencias**

```bash
composer install
npm install
```

3. **Configurar el entorno**

```bash
cp .env.example .env
php artisan key:generate
```

4. **Configurar la base de datos**

```bash
touch database/database.sqlite
php artisan migrate
```

## 🚀 Iniciar el Proyecto

### Iniciar Servicios

El proyecto incluye scripts para iniciar todos los servicios necesarios:

#### Windows

```bash
./start-services.ps1
```

#### Linux/Mac

```bash
./start-services.sh
```

Estos scripts iniciarán:

-   Servidor de desarrollo de Laravel
-   Compilación de assets con Vite
-   Queue worker para procesamiento de notificaciones
-   Programador de tareas para notificaciones programadas

### Manualmente

1. **Compilar assets**

```bash
npm run dev
```

2. **Iniciar el servidor**

```bash
php artisan serve
```

3. **Iniciar queue worker**

```bash
php artisan queue:work
```

4. **Iniciar el programador de tareas**

```bash
php artisan schedule:work
```

## 📊 Características Principales

-   📨 Sistema de notificaciones en tiempo real
-   👤 Preferencias de notificación por usuario
-   📅 Programación de notificaciones
-   📱 Diseño responsive
-   🔔 Notificaciones en tiempo real
-   ⚙️ Panel de administración
-   📋 Tipos de notificaciones personalizables

## 🔐 Seguridad

-   Autenticación de usuarios
-   Políticas de acceso
-   Validación de datos
-   Sistema de roles y permisos

## 📝 Licencia

Este proyecto está bajo la Licencia MIT.

## 📞 Soporte

Para soporte o preguntas, por favor abre un issue en el repositorio.

---

⌨️ con ❤️ por [Michael Vairo]
