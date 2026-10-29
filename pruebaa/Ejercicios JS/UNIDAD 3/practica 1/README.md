# Práctica 1. Centro de operaciones

Página sencilla para ALBOR LOGISTICS que practica el uso de objetos del navegador con JavaScript.

## Archivos

| Archivo | Función |
|---|---|
| `centro-operaciones.html` | Página principal con los botones y la información del navegador. |
| `js/app.js` | Código JavaScript que conecta los botones con las acciones. |
| `seguimiento.html` | Página que se abre en una ventana nueva y muestra una tabla de viajes. |

## Cómo usarla

Abre `centro-operaciones.html` en el navegador. Desde sus botones puedes abrir el seguimiento, consultar la URL, volver atrás o recargar la página.

## Objetos utilizados

- `document` busca los elementos HTML y muestra información en la página.
- `window.open()` abre `seguimiento.html` en otra ventana.
- `location` proporciona la URL, el protocolo y la acción para recargar.
- `history.back()` vuelve a la página anterior.
- `navigator.userAgent` muestra información del navegador.

El archivo JavaScript está separado del HTML y se carga desde la carpeta `js`.
