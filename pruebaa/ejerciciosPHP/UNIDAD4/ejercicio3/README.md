# Gestión de incidencias

Aplicación web interna, hecha en PHP, para gestionar las incidencias que comunican los clientes de una empresa de soporte informático.

Parte del sistema de login y roles del ejercicio anterior (usuarios `admin`, `tecnico01` y `cliente01`) y añade la gestión de incidencias, con permisos distintos según el rol de cada usuario.

## Cómo ejecutarla

1. Copia la carpeta `gestion-incidencias/` dentro de `htdocs` (XAMPP).
2. Arranca Apache desde el panel de XAMPP.
3. Abre `http://localhost/gestion-incidencias/` en el navegador.

También se puede probar sin XAMPP: dentro de la carpeta, ejecutar `php -S localhost:8000` y abrir `http://localhost:8000`.

Requisitos: PHP 7 o superior (probada con PHP 8.3). No necesita base de datos.
La carpeta debe poder escribirse, porque las incidencias se guardan en el archivo `incidencias.json`.

## Usuarios de prueba

| Usuario   | Contraseña | Rol           |
|-----------|------------|---------------|
| admin     | admin123   | Administrador |
| tecnico01 | tecnico123 | Técnico       |
| tecnico02 | tecnico123 | Técnico       |
| cliente01 | cliente123 | Cliente       |
| cliente02 | cliente123 | Cliente       |

## Estructura del proyecto

```
gestion-incidencias/
├── index.php               Redirige al panel (con sesión) o al login (sin sesión)
├── login.php               Inicio de sesión
├── logout.php              Cierre de sesión
├── panel.php               Página principal: resumen de incidencias y accesos según el rol
├── incidencias.php         Listado de incidencias, paginación, cookie y eliminar
├── nueva-incidencia.php    Formulario para crear una incidencia
├── editar-incidencia.php   Formulario para modificar una incidencia
├── detalle-incidencia.php  Todos los datos de una incidencia y sus observaciones
├── usuarios.php            Listado de usuarios (solo administrador)
├── funciones.php           Funciones comunes: usuarios, permisos, lectura y escritura del JSON...
├── estilos.css             Estilos propios sobre Bootstrap
├── incidencias.json        Datos de las incidencias (12 de ejemplo)
└── README.md
```

## Datos de una incidencia

| Campo           | Contenido                                                      |
|-----------------|----------------------------------------------------------------|
| `id`            | Número único, se asigna solo al crearla                        |
| `titulo`        | Texto de hasta 100 caracteres                                  |
| `descripcion`   | Texto libre                                                    |
| `cliente`       | Usuario cliente que la ha comunicado                           |
| `tecnico`       | Técnico asignado (puede estar vacío: "Sin asignar")            |
| `prioridad`     | Baja, Media, Alta o Crítica                                    |
| `estado`        | Pendiente, En proceso, Resuelta o Cerrada                      |
| `fecha`         | Fecha y hora de creación                                       |
| `observaciones` | Lista de notas, cada una con la fecha y el usuario que la puso |

Al crear una incidencia el estado es siempre **Pendiente**.

## Permisos por rol

| Acción                                      | Cliente        | Técnico            | Administrador |
|---------------------------------------------|----------------|--------------------|---------------|
| Crear incidencia                            | Sí             | No                 | Sí            |
| Consultar incidencias y su estado           | Solo las suyas | Solo las asignadas | Todas         |
| Cambiar el estado                           | No             | Sí (las asignadas) | Sí            |
| Cambiar la prioridad                        | No             | Sí (las asignadas) | Sí            |
| Añadir observaciones                        | No             | Sí (las asignadas) | Sí            |
| Modificar título, descripción y cliente     | No             | No                 | Sí            |
| Asignar o cambiar el técnico                | No             | No                 | Sí            |
| Eliminar incidencia                         | No             | No                 | Sí            |
| Ver la lista de usuarios                    | No             | No                 | Sí            |

Un cliente no puede ver las incidencias de otros clientes, y un técnico solo ve las que tiene asignadas.

## Cookies

El listado de incidencias recuerda durante 30 días cuántas incidencias quiere ver el usuario en cada página (**5, 10 o 20**; por defecto 10).

- Se elige en el formulario "Incidencias por página" y se guarda con el botón **Guardar preferencias**.
- Se guarda en la cookie `por_pagina`.
- Antes de usar el valor de la cookie se comprueba que sea 5, 10 o 20, porque el usuario podría modificarla.

## Seguridad

Todos los permisos se comprueban **en el servidor**, no solo ocultando botones:

- **Sesión obligatoria:** cada página llama a `exigir_login()`. Sin sesión se redirige al login.
- **Rol obligatorio:** las páginas restringidas llaman a `exigir_rol()` y responden con **error 403** si el rol no está permitido.
- **Acceso a cada incidencia:** `puede_ver()` comprueba que la incidencia sea del cliente o esté asignada al técnico. Si alguien escribe a mano la URL de una incidencia ajena, recibe 403. Si no existe, recibe 404.
- **El técnico solo puede cambiar lo suyo:** aunque manipule el formulario, el servidor solo aplica estado, prioridad y observación. Título, descripción, cliente y técnico solo los guarda si el usuario es administrador.
- **El cliente solo crea a su nombre:** al crear una incidencia, el servidor pone como cliente al usuario de la sesión y deja el técnico sin asignar, sin fiarse del formulario.
- **Validación de datos:** estado, prioridad, cliente y técnico se comprueban contra las listas permitidas, y el título tiene un límite de longitud.
- **Protección contra XSS:** todo lo que escribe un usuario se muestra con `e()` (`htmlspecialchars`).
- **Token CSRF:** los formularios de crear, editar y eliminar llevan un token oculto, y el servidor comprueba que sea el de la sesión.
- **Eliminar solo por POST:** se hace con un botón de formulario con confirmación, nunca con un enlace.
- **Sesión:** se usa `session_regenerate_id()` al iniciar sesión, y el cierre de sesión borra los datos y la cookie de sesión.

## Adaptación a distintos perfiles y pantallas

- **Navegación:** menú de Bootstrap que se pliega en el móvil. Cada rol ve solo sus opciones (los clientes y el administrador ven "Nueva incidencia"; solo el administrador ve "Usuarios").
- **Formularios:** cada campo tiene su `label`, los obligatorios van marcados con `*`, y si hay errores se conserva lo que el usuario había escrito. En el móvil los campos ocupan todo el ancho.
- **Mensajes de error:** lista de problemas en un aviso rojo con `role="alert"`, y páginas de error claras para 400, 403 y 404 con botón para volver al panel.
- **Mensajes de confirmación:** aviso verde tras crear, editar o eliminar, y un cuadro de confirmación antes de eliminar.
- **Tablas:** dentro de `table-responsive` (con desplazamiento horizontal en pantallas pequeñas), con `caption` y `scope` en las cabeceras. Estado y prioridad se muestran con texto y color, para no depender solo del color.
- **Accesibilidad básica:** enlace "Saltar al contenido", `aria-label` en los botones de acción de cada fila, `aria-current` en la página actual de la paginación, idioma de la página declarado (`lang="es"`) y foco visible al navegar con teclado.
- **Usabilidad:** las incidencias más recientes salen primero, hay paginación y el panel muestra cuántas incidencias hay en cada estado.

## Limitaciones

- Las contraseñas están escritas en el código en texto plano, como en el ejercicio anterior. En una aplicación real se guardarían en una base de datos con `password_hash()`.
- Los datos se guardan en un archivo JSON. Sirve para el ejercicio, pero en una aplicación real se usaría una base de datos.
- Para que el archivo `incidencias.json` no se pueda abrir directamente desde el navegador, se puede proteger con un archivo `.htaccess` (solo en Apache/XAMPP).
- Se debería usar HTTPS para que las contraseñas no viajen sin cifrar.