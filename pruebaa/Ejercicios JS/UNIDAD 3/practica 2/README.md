# Práctica 2. Generador de partes de viaje

Aplicación para ALBOR LOGISTICS que genera un parte de viaje a partir de un formulario y permite abrirlo en una ventana nueva.

## Archivos

| Archivo | Función |
|---|---|
| `generador-parte.html` | Formulario, estructura de la página y zona de resultados. |
| `js/parte.js` | Genera el parte en el documento, obtiene la fecha con `Date` y crea el documento de la ventana nueva con `window.open()`. |

## Uso

Abre `generador-parte.html` en el navegador, completa todos los campos y pulsa **Generar parte**. Después, pulsa **Abrir parte en nueva ventana**. Si el navegador bloquea la ventana emergente, permite las ventanas emergentes para esta página.

Los datos del parte se crean desde JavaScript; no están escritos como contenido de viaje en el HTML. El documento generado utiliza el DOM y los valores se escapan antes de insertarse en el HTML de la nueva ventana.
