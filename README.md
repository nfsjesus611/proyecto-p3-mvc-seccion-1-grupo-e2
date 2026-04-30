# Proyecto P3 – MVC | Sección 1 – Grupo E2

## 📄 Descripción del proyecto

Sistema web para la gestión de usuarios y autenticación de la estación de pasajeros del Metro de Los Teques. La aplicación permite el registro e inicio de sesión de usuarios, aplicando el patrón de arquitectura **Modelo - Vista - Controlador (MVC)** para separar responsabilidades, facilitar el mantenimiento y escalar el proyecto de forma ordenada.

---

## 🧱 Arquitectura MVC

La aplicación sigue el patrón MVC dividiendo el código en tres capas principales y agregando componentes de infraestructura comunes (core, helpers y enrutamiento).

### Flujo de una petición
1. El archivo `index.php` (front controller) recibe todas las solicitudes gracias al `.htaccess`.
2. Se cargan las rutas definidas en `routes/routes.php` que asocian URLs a métodos de controladores.
3. El controlador correspondiente (`controllers/`) recibe la petición, invoca los modelos necesarios y pasa los datos a la vista.
4. El modelo (`models/`) gestiona el acceso a la base de datos, encapsulando consultas y lógica de negocio.
5. La vista (`vistas/`) recibe los datos y genera la interfaz HTML utilizando plantillas, parciales y layouts compartidos.

### Componentes clave
- **Core** (`core/`): clases base reutilizables para conexión a BD (`Database.php`), manejo de sesiones (`Session.php`), validación de datos (`Validation.php`) y configuración de ubicación (`Location.php`).
- **Helpers** (`helpers/helpers.php`): funciones auxiliares para toda la aplicación.
- **Assets** (`frontend/asset/`): hojas de estilo, scripts y recursos gráficos organizados por tipo.
- **Webfonts** (`webfonts/`): fuentes de FontAwesome para iconografía.

---

## 🔍 Diagnóstico inicial

Antes de la refactorización, el proyecto presentaba las siguientes problemáticas:

- **Código altamente acoplado:** las consultas SQL, la lógica de negocio y la generación de HTML convivían en los mismos archivos.
- **Conexiones duplicadas a la base de datos:** cada archivo abría su propia conexión sin un único punto de acceso.
- **Sin sistema de rutas:** las URLs apuntaban directamente a archivos sueltos (ej. `login.php`, `register.php`), perdiendo control centralizado.
- **Validaciones repetitivas:** no existía una capa común de validación, repitiendo comprobaciones en cada formulario.
- **Frontend desorganizado:** los recursos estáticos (CSS, JS, imágenes) se hallaban dispersos, dificultando su gestión y actualización.

Esta situación dificultaba el mantenimiento, la reutilización de código y la incorporación de nuevas funcionalidades.

---

## 🛠️ Cambios realizados

Se llevó a cabo una migración completa hacia una arquitectura MVC con los siguientes pasos:

1. **Definición de la estructura de directorios:**
   - `backend/` → lógica del servidor (controladores, modelos, rutas, core, helpers).
   - `frontend/` → recursos estáticos (css, js, img).
   - `vistas/` → plantillas PHP puras con secciones (`auth/`, `partials/`, `menu.php`, etc.).
   - `database/` → script SQL de inicialización.
   - `webfonts/` → tipografías de FontAwesome.

2. **Implementación del Front Controller:**
   - `.htaccess` redirige todas las peticiones hacia `index.php`.
   - `index.php` carga configuración, core, rutas y despacha la solicitud.

3. **Sistema de rutas limpias:**
   - Archivo `routes/routes.php` que mapea verbos HTTP y URIs a controladores (ej. `$router->get('/login', 'AuthController@showLogin')`).

4. **Creación de controladores y modelos:**
   - `AuthController.php`: maneja registro, inicio de sesión y cierre de sesión.
   - `Usuario.php`: modelo que interactúa con la tabla `usuarios`, encapsulando consultas y operaciones de autenticación.

5. **Capa de servicios compartidos (Core):**
   - `Database.php` implementa un Singleton para la conexión PDO, evitando múltiples instancias.
   - `Session.php` gestiona mensajes flash y datos de sesión.
   - `Validation.php` centraliza reglas de validación de formularios.

6. **Separación total de vistas:**
   - Las vistas (`vistas/`) reciben únicamente datos procesados, sin lógica de negocio.
   - Se reutilizan parciales (`partials/`) y un menú común (`menu.php`).
   - Páginas de error personalizadas (`errors/404.php`).

7. **Organización de activos frontend:**
   - Bootstrap y FontAwesome versionados en `frontend/asset/`.
   - Scripts propios (ej. `formulario3.js`) separados de librerías.

8. **Base de datos:**
   - Script `squma.sql` en `database/` permite recrear la estructura desde cero.

---

## 🧾 Evidencia en Git
