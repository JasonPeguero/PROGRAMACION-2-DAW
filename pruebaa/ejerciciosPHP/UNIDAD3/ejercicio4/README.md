# Gestión de productos (ejercicio4)

Aplicación web en PHP para registrar, buscar y consultar productos. Los datos se guardan en la sesión del usuario (`$_SESSION`), por lo que no se necesita base de datos.

## 1. Objetivo de la aplicación

Practicar el desarrollo web con PHP puro:

- Registrar productos mediante un formulario con validación en el servidor.
- Listar los productos y filtrarlos por nombre, categoría y precio máximo.
- Consultar la ficha completa de cada producto.
- Separar la lógica (datos y funciones) de la presentación (páginas HTML).

## 2. Estructura del proyecto

```
ejercicio4/
├── index.php       Página de inicio con enlaces a las demás secciones
├── productos.php   Listado de productos y formulario de búsqueda (GET)
├── nuevo.php       Formulario de alta de producto (POST)
├── detalle.php     Ficha de un producto (GET, por id)
├── datos.php       Capa de datos: acceso a los productos almacenados en sesión
├── funciones.php   Funciones auxiliares: validación, filtrado y categorías
├── estilos.css     Estilos propios (se combinan con Bootstrap 5.3 vía CDN)
└── README.md       Esta documentación
```

Cada página incluye con `require_once` los archivos `datos.php` y/o `funciones.php` que necesita.

## 3. Funcionamiento de los formularios

### Formulario de alta (`nuevo.php`)

1. El usuario rellena nombre, categoría, precio, stock y descripción. Todos los campos son obligatorios (marcados con `*` en rojo).
2. Al pulsar **Registrar producto**, el formulario se envía por POST a la propia página.
3. Los valores se limpian con `trim()` y se pasan a `validarFormulario()`.
4. Si hay errores, se muestran en una lista y los campos conservan lo escrito por el usuario.
5. Si todo es correcto, se guarda el producto con `guardarProducto()` y se redirige a `detalle.php?id=X&creado=1`, donde aparece un mensaje de confirmación.

### Formulario de búsqueda (`productos.php`)

1. El usuario puede filtrar por **nombre** (coincidencia parcial, sin distinguir mayúsculas), **categoría** (desplegable generado con las categorías existentes) y **precio máximo**.
2. Al pulsar **Buscar**, el formulario se envía por GET a la misma página.
3. Se valida que el precio máximo sea un número mayor o igual que cero y se aplican los filtros con `filtrarProductos()`.
4. Los campos del formulario mantienen los valores buscados.

## 4. Diferencias entre GET y POST

| Aspecto | GET (búsqueda y detalle) | POST (alta de producto) |
|---|---|---|
| Uso en el proyecto | `productos.php` y `detalle.php?id=X` | `nuevo.php` |
| Datos | Viajan en la URL (`?nombre=...&categoria=...`) | Viajan en el cuerpo de la petición |
| Finalidad | Consultar información sin modificar nada | Crear datos nuevos en el servidor |
| Visibilidad | Visibles en la URL | No aparecen en la URL |
| Reutilización | Se puede guardar en favoritos o compartir | No se puede compartir directamente |
| Repetición | Segura: repetirla no cambia nada | Repetirla duplicaría el producto |

Tras un alta correcta se aplica el patrón **Post/Redirect/Get**: se redirige con `header('Location: ...')` a una página GET para que, al recargar, el navegador no reenvíe el formulario.

## 5. Validaciones realizadas

### Alta de producto (`validarFormulario()`)

- **Nombre**: obligatorio.
- **Categoría**: obligatoria.
- **Precio**: obligatorio y mayor que 0.
- **Stock**: obligatorio y mayor o igual que 0.
- **Descripción**: obligatoria.
- Además, el HTML incluye el atributo `required` y los campos de precio y stock usan `type="number"` (validación en el navegador, que nunca sustituye a la del servidor).

### Búsqueda (`productos.php`)

- El precio máximo, si se indica, debe ser numérico y mayor o igual que cero. Si no lo es, se muestra un error y se ignora el filtro.

### Seguridad en la salida

- Todo texto introducido por el usuario se imprime con `htmlspecialchars()` para evitar inyección de HTML/JavaScript (XSS).
- La descripción usa `nl2br(htmlspecialchars(...))` para respetar los saltos de línea de forma segura.
- El `id` recibido por GET se convierte a entero con `(int)`. Si el producto no existe, se devuelve el código HTTP 404 y un mensaje.

## 6. Funciones implementadas

### `datos.php`

| Función | Descripción |
|---|---|
| `obtenerProductos(): array` | Devuelve todos los productos guardados en sesión (o un array vacío). |
| `guardarProducto(nombre, categoria, precio, stock, descripcion)` | Asigna un id (nº de productos + 1), añade el producto a la sesión y devuelve el id. |
| `buscarProductoPorId(int $id): ?array` | Devuelve el producto con ese id o `null` si no existe. |

### `funciones.php`

| Función | Descripción |
|---|---|
| `Categorias(array $productos): array` | Devuelve la lista de categorías distintas, usada para el desplegable de búsqueda. |
| `filtrarProductos(array $productos, string $nombre, string $categoria, string $precioMax): array` | Filtra por nombre (parcial, sin distinguir mayúsculas), categoría exacta y precio máximo. |
| `validarFormulario(...)`: array | Valida los datos del alta y devuelve un array con los mensajes de error (vacío si todo es correcto). |

## 7. Mejoras futuras

- Sustituir la sesión por una base de datos (MySQL/SQLite con PDO) para que los datos sean permanentes y compartidos.
- Generar los ids con un contador o con autoincremento, en lugar de `count() + 1`, para evitar duplicados si se elimina algún producto.
- Añadir edición y borrado de productos.
- Permitir decimales en el precio (`step="0.01"`) y validar con `is_numeric()` y `filter_var()`.
- Convertir la categoría en un desplegable con categorías predefinidas, para evitar duplicados por errores de escritura.
- Mostrar un mensaje cuando una búsqueda no devuelve resultados.
- Añadir paginación y ordenación del listado.
- Proteger los formularios con tokens CSRF.
- Incluir un título (`<title>`) en todas las páginas y mejorar el diseño con más componentes de Bootstrap.
- Añadir pruebas automáticas de las funciones de validación y filtrado.