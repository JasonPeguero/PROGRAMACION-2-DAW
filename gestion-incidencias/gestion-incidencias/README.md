# Gestión de incidencias

Mini aplicación en PHP para gestionar las incidencias que comunican los clientes.
Reutiliza el sistema de login y roles del ejercicio anterior.

## Cómo ejecutarla

1. Copia la carpeta `gestion-incidencias/` en tu servidor (por ejemplo `htdocs` en XAMPP).
2. Abre `http://localhost/gestion-incidencias/`.
3. También puedes usar el servidor de PHP: `php -S localhost:8000` dentro de la carpeta.

La carpeta debe tener permisos de escritura, porque las incidencias se guardan en `incidencias.json`.

## Usuarios de prueba

| Usuario    | Contraseña | Rol           |
|------------|------------|---------------|
| admin      | admin123   | Administrador |
| tecnico01  | tecnico123 | Técnico       |
| tecnico02  | tecnico123 | Técnico       |
| cliente01  | cliente123 | Cliente       |
| cliente02  | cliente123 | Cliente       |

## Archivos

| Archivo                  | Para qué sirve                                              |
|--------------------------|-------------------------------------------------------------|
| `index.php`              | Redirige al login o al panel según haya sesión              |
| `login.php` / `logout.php` | Iniciar y cerrar sesión                                   |
| `panel.php`              | Página principal con el resumen de incidencias              |
| `incidencias.php`        | Listado (con cookies, paginación) y eliminar                |
| `nueva-incidencia.php`   | Formulario para crear incidencias                           |
| `editar-incidencia.php`  | Formulario para modificar incidencias                       |
| `detalle-incidencia.php` | Ver todos los datos de una incidencia                       |
| `usuarios.php`           | Listado de usuarios (solo administrador)                    |
| `funciones.php`          | Funciones comunes: usuarios, permisos, cabecera, pie...     |
| `estilos.css`            | Estilos propios sobre Bootstrap                             |
| `incidencias.json`       | Donde se guardan las incidencias (3 de ejemplo)             |

## Permisos por rol

| Acción                          | Cliente        | Técnico            | Administrador |
|---------------------------------|----------------|--------------------|---------------|
| Crear incidencia                | Sí             | No                 | Sí            |
| Ver incidencias                 | Solo las suyas | Solo las asignadas | Todas         |
| Cambiar estado y prioridad      | No             | Sí (las asignadas) | Sí            |
| Añadir observaciones            | No             | Sí (las asignadas) | Sí            |
| Modificar título, cliente, etc. | No             | No                 | Sí            |
| Asignar técnico                 | No             | No                 | Sí            |
| Eliminar incidencia             | No             | No                 | Sí            |
| Ver usuarios                    | No             | No                 | Sí            |

## Cookies

En el listado de incidencias se guardan dos preferencias durante 30 días:

- `por_pagina`: cuántas incidencias se muestran por página (5, 10 o 20).
- `vista`: forma de ver el listado (`tabla` o `tarjetas`).

Los valores de las cookies se comprueban antes de usarlos, porque el usuario puede modificarlos.

## Seguridad

- **Permisos en el servidor:** cada página llama a `exigir_rol()` o `puede_ver()`. Aunque alguien escriba la
  URL a mano, el servidor responde con error 403 (sin permiso) o 404 (no existe). Ocultar botones no basta.
- **Cliente y técnico solo ven lo suyo:** `puede_ver()` compara el usuario de la sesión con el cliente o el técnico de la incidencia.
- **Campos según el rol:** en `editar-incidencia.php` un técnico solo puede cambiar estado, prioridad y observaciones,
  aunque intente enviar más campos.
- **Validación de datos:** estados, prioridades, clientes y técnicos se comprueban contra listas permitidas.
- **Protección XSS:** todo lo que escribe el usuario se muestra con `e()` (`htmlspecialchars`).
- **Token CSRF:** los formularios llevan un token oculto para comprobar que los envía nuestra propia web.
- **Sesión:** se usa `session_regenerate_id()` al iniciar sesión y se destruye la cookie al cerrarla.
- **Archivo de datos:** `.htaccess` impide abrir `incidencias.json` desde el navegador (en Apache).

## Adaptación a distintos perfiles y pantallas

- **Navegación:** menú con Bootstrap que se pliega en móvil y cambia según el rol.
- **Formularios:** etiquetas (`label`) asociadas a cada campo, campos obligatorios marcados con `*`,
  los datos escritos se conservan si hay errores.
- **Mensajes:** errores en rojo con `role="alert"`, confirmaciones en verde tras guardar o eliminar,
  y confirmación (`confirm`) antes de eliminar.
- **Tablas:** dentro de `table-responsive` (scroll horizontal en móvil), con `caption` y `scope`.
  Además hay una vista de tarjetas más cómoda en pantallas pequeñas.
- **Accesibilidad básica:** enlace "Saltar al contenido", foco visible con teclado,
  `aria-label` en los botones de acción, colores con texto además del color (los estados se leen, no solo se ven).

## Limitaciones (para un proyecto real)

- Las contraseñas están en texto plano dentro del código, como en el ejercicio anterior.
  En una aplicación real se guardarían en base de datos con `password_hash()`.
- Los datos se guardan en un archivo JSON; en una aplicación real se usaría una base de datos.
- Se debería usar HTTPS para que las contraseñas no viajen sin cifrar.
