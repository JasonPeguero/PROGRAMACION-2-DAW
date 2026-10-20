# Asignación de Viajes

Pequeña página web que simula el procesamiento de una cola de viajes pendientes. Cada viaje se procesa de forma automática y puede finalizar correctamente o con una incidencia (generada al azar). Al terminar se muestra un resumen con los totales.

## Estructura del proyecto

```
proyecto/
├── asignacion-viajes.html
├── js/
│   └── asignacion.js
└── README.md
```

> El HTML carga el script desde `js/asignacion.js`, por lo que el archivo JavaScript debe estar dentro de una carpeta llamada `js`.

## Cómo usarlo

1. Descarga o clona el proyecto respetando la estructura de carpetas anterior.
2. Abre `asignacion-viajes.html` en cualquier navegador (no requiere servidor ni dependencias).
3. El procesamiento se ejecuta automáticamente al cargar la página.
4. Recarga la página para lanzar una nueva simulación con resultados distintos.

## Funcionamiento

- Se parte de **8 viajes pendientes** (`viajesPendientes`).
- Un bucle `while` procesa los viajes uno a uno hasta que no quedan pendientes.
- Por cada viaje se simula una incidencia con `Math.random()`: si el valor es menor que `0.25`, el viaje termina **con incidencia** (probabilidad aproximada del 25 %); en caso contrario, termina **correctamente**.
- Se lleva la cuenta de viajes procesados, correctos y con incidencia.
- El resultado se pinta en tres zonas de la página:

| Elemento HTML | Contenido                                                        |
|---------------|------------------------------------------------------------------|
| `#pendientes` | Número de viajes pendientes al iniciar.                          |
| `#salida`     | Una línea por viaje indicando si finalizó bien o con incidencia. |
| `#resumen`    | Totales de viajes procesados, correctos y con incidencia.        |

Las líneas de `#salida` usan las clases CSS `correcto`, `incidencia` y `final`, por si se quieren estilizar.

## Archivos

| Archivo                   | Descripción                                                      |
|---------------------------|------------------------------------------------------------------|
| `asignacion-viajes.html`  | Página con los contenedores donde se muestran los resultados.    |
| `js/asignacion.js`        | Lógica de la simulación: bucle de procesamiento y contadores.    |

## Personalización

- **Número de viajes:** cambia el valor inicial de `viajesPendientes` en `js/asignacion.js`.
- **Probabilidad de incidencia:** modifica el umbral `0.25` en la comparación `Math.random() < 0.25`.
- **Estilos:** añade reglas CSS para las clases `correcto`, `incidencia` y `final`, por ejemplo:

  ```css
  .correcto { color: green; }
  .incidencia { color: red; }
  .final { font-weight: bold; }
  ```

## Limitaciones

- Es una simulación: las incidencias son aleatorias y no hay datos reales de viajes ni asignación a conductores.
- El mensaje final ("Todos los viajes han sido procesados correctamente") se muestra siempre, incluso cuando algún viaje ha terminado con incidencia; indica que se ha terminado de procesar la cola, no que todos hayan ido bien.
- No hay interacción del usuario: el proceso se ejecuta una sola vez al cargar la página.

## Tecnologías

- HTML5
- JavaScript (vanilla)
