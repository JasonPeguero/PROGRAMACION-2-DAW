# Práctica 2. Generador de partes de viaje

Aplicación para ALBOR LOGISTICS que genera un parte de viaje a partir de un formulario y permite abrirlo en una ventana nueva.

## Archivos

| Archivo | Función |
|---|---|
| `generador-parte.html` | Formulario y zona de resultados (estilos con Bootstrap 5.3.8 desde CDN). |
| `js/parte.js` | Genera el parte con el DOM, obtiene la fecha con `Date` y crea la ventana nueva con `window.open()`. |

## Uso

Abre `generador-parte.html` en el navegador (hace falta conexión a internet para cargar Bootstrap), completa todos los campos y pulsa **Generar parte**. Después, pulsa **Abrir parte en nueva ventana**. Si el navegador bloquea la ventana emergente, permite las ventanas emergentes para esta página.

## Notas técnicas

- Una sola función (`rellenarParte`) escribe el parte tanto en la página como en la ventana nueva.
- Los datos se insertan con `textContent`/`createElement`, por lo que no se interpretan como HTML.
- La validación de campos obligatorios usa los atributos `required` y `min` del formulario.