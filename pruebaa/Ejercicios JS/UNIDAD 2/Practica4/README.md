# Acceso a Operaciones – ALBOR LOGISTICS

Pequeña página web que simula el control de acceso al panel de operaciones de ALBOR LOGISTICS. El empleado pulsa un botón, se le pide su código de empleado y, según acierte o no, se le autoriza o se bloquea el acceso.

## Estructura del proyecto

```
proyecto/
├── acceso-operaciones.html
├── js/
│   └── acceso.js
└── README.md
```

> El HTML carga el script desde `js/acceso.js`, por lo que el archivo JavaScript debe estar dentro de una carpeta llamada `js`.

## Cómo usarlo

1. Descarga o clona el proyecto respetando la estructura de carpetas anterior.
2. Abre `acceso-operaciones.html` en cualquier navegador (no requiere servidor ni dependencias).
3. Pulsa el botón **Acceder**.
4. Introduce tu código de empleado en el cuadro de diálogo que aparece.

## Funcionamiento

- Al enviar el formulario se evita la recarga de la página (`preventDefault`).
- Se solicita el código mediante `prompt()` **al menos una vez** (bucle `do...while`).
- Se permiten un máximo de **3 intentos**; el cuadro de diálogo indica el número de intento actual.
- Si el usuario cancela el cuadro de diálogo, cuenta como un intento fallido.
- La comparación ignora espacios al inicio/final y no distingue mayúsculas de minúsculas (`alb or001` no es válido, pero `albor001` y ` ALBOR001 ` sí).
- El resultado se muestra en el párrafo `#mensaje`:
  - **Acceso autorizado** → clase CSS `ok`.
  - **Acceso bloqueado** → clase CSS `error`.

## Códigos de empleado válidos (demo)

| Código     |
|------------|
| `ALBOR001` |
| `ALBOR002` |
| `ALBOR003` |

Para añadir o quitar códigos, edita el array `codigosValidos` en `js/acceso.js`. El número de intentos se controla con la constante `maxIntentos`.

## Archivos

| Archivo                  | Descripción                                                        |
|--------------------------|--------------------------------------------------------------------|
| `acceso-operaciones.html`| Página con el formulario, el botón de acceso y el área de mensajes. |
| `js/acceso.js`           | Lógica de validación del código y control de intentos.             |

## Limitaciones

- **No es un sistema de seguridad real:** los códigos válidos están visibles en el código fuente del navegador y la validación se hace en el cliente. Es un ejercicio/demostración; en un entorno real la autenticación debe realizarse en el servidor.
- El bloqueo solo dura mientras no se vuelva a pulsar el botón: el usuario puede volver a intentarlo, ya que los intentos se reinician en cada envío del formulario.
- Las clases `ok` y `error` no tienen estilos definidos, por lo que el mensaje se muestra sin formato. Puedes añadir, por ejemplo:

  ```css
  .ok { color: green; }
  .error { color: red; }
  ```

## Tecnologías

- HTML5
- JavaScript (vanilla)
