# Registro de incidencias (ejercicio3)

Aplicación web en PHP para que un cliente registre una incidencia técnica mediante un formulario. Tras validar los datos, la aplicación genera un identificador y muestra un resumen de la incidencia registrada.

## 1. Objetivo de la aplicación

- Recoger los datos de una incidencia (cliente, empresa, asunto, descripción, prioridad y categoría).
- Validar la información en el servidor antes de aceptarla.
- Asignar a la incidencia un identificador, una fecha de registro y un estado inicial (`Pendiente`).
- Mostrar al usuario un resumen de la incidencia registrada.

## 2. Estructura del proyecto

```
ejercicio3/
├── index.php       Formulario, procesamiento del envío y visualización del resultado
├── funciones.php   Constantes y funciones: validación, generación de id y resumen
├── estilos.css     Estilos propios (se combinan con Bootstrap 5.3 vía CDN)
└── README.md       Esta documentación
```

`index.php` carga `funciones.php` con `require_once` y configura la zona horaria `Europe/Madrid` para que la fecha de registro sea la correcta.

### Constantes (`funciones.php`)

| Constante | Valor |
|---|---|
| `PRIORIDADES` | Baja, Media, Alta, Crítica |
| `CATEGORIAS` | Aplicación web, Servidor, Base de datos, Red, Cuenta de usuario, Otra |
| `ESTADO_INICIAL` | Pendiente |

Los desplegables del formulario se generan a partir de `PRIORIDADES` y `CATEGORIAS`, y esas mismas listas se usan para validar, de modo que solo hay un sitio donde modificarlas.

## 3. Funcionamiento de los formularios

La aplicación tiene un único formulario en `index.php`:

1. Al abrir la página se muestra el formulario vacío.
2. El usuario rellena nombre, correo, empresa, asunto, descripción, prioridad y categoría. Todos los campos son obligatorios (marcados con `*`).
3. Al pulsar **Registrar incidencia**, los datos se envían por POST a la propia página.
4. Los valores se limpian con `trim()` y se validan con `validarFormulario()`.
5. **Si hay errores**: se muestran en un aviso rojo y el formulario reaparece con los datos ya escritos.
6. **Si todo es correcto**: se genera el id y la fecha, se construye el resumen con `mostrarIncidencia()` y se muestra junto con un mensaje de éxito. El formulario se oculta.

El formulario usa `novalidate`, de forma que toda la validación la hace el servidor y no depende del navegador.

## 4. Diferencias entre GET y POST

| Aspecto | GET | POST |
|---|---|---|
| Uso en el proyecto | Carga inicial de la página (el navegador pide `index.php`) | Envío del formulario de incidencia |
| Datos | Viajarían en la URL | Viajan en el cuerpo de la petición |
| Visibilidad | Visibles en la URL y en el historial | No aparecen en la URL |
| Efecto | Solo consulta: muestra el formulario | Registra información nueva |

Se utiliza **POST** porque el formulario envía datos que pueden ser extensos (la descripción) y que no deben quedar expuestos en la URL ni en el historial del navegador. Además, la acción de registrar una incidencia no debe repetirse al recargar o compartir un enlace. El código detecta el envío con `isset($_POST['registrar'])`.

## 5. Validaciones realizadas

`validarFormulario()` devuelve un array con los mensajes de error (vacío si todo es correcto):

| Campo | Regla |
|---|---|
| Nombre | Obligatorio |
| Correo | Debe tener formato de correo válido (`filter_var`) |
| Empresa | Obligatoria |
| Asunto | Obligatorio |
| Descripción | Obligatoria |
| Prioridad | Debe ser uno de los valores de `PRIORIDADES` (comparación estricta con `in_array`) |
| Categoría | Debe ser uno de los valores de `CATEGORIAS` (comparación estricta con `in_array`) |

La validación de prioridad y categoría con lista cerrada evita que alguien envíe un valor manipulado que no exista en los desplegables.

### Seguridad en la salida

Todo lo que introduce el usuario se imprime con `htmlspecialchars()` (en los valores de los campos, en los errores y en el resumen) para evitar inyección de HTML o JavaScript (XSS).

## 6. Funciones implementadas

| Función | Descripción |
|---|---|
| `generarIdIncidencia(int $ano, int $secuencia): string` | Construye el identificador con formato `AAAA-NNNNN` (año y secuencia rellenada con ceros), por ejemplo `2026-00042`. |
| `validarFormulario(...): array` | Comprueba los siete campos del formulario y devuelve la lista de errores. |
| `mostrarIncidencia(...): string` | Devuelve el texto del resumen con id, fecha, cliente, empresa, correo, asunto, descripción, prioridad, categoría y estado. Se muestra dentro de un `<pre>` para conservar los saltos de línea. |

## 7. Mejoras futuras

- **Guardar las incidencias** (en sesión, fichero o base de datos), ya que ahora el resumen solo se muestra y no se almacena.
- **Generar ids únicos**: la secuencia actual es un número aleatorio entre 1 y 100 y puede repetirse. Debería ser un contador incremental o el autoincremento de una base de datos.
- Usar un campo `<textarea>` para la descripción en lugar de un `<input type="text">`.
- Validar longitudes mínimas y máximas de los textos.
- Aplicar el patrón Post/Redirect/Get para evitar reenvíos del formulario al recargar la página.
- Listado de incidencias con filtros por estado, prioridad y categoría, y cambio de estado (Pendiente, En curso, Resuelta).
- Enviar un correo de confirmación al cliente.
- Añadir estilos propios en `estilos.css` (por ejemplo, el color rojo del asterisco de los campos obligatorios).
- Proteger el formulario con un token CSRF.