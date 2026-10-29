# Práctica 3. Preferencias del operador mediante cookies

Aplicación para ALBOR LOGISTICS que guarda las preferencias del operador en cookies del navegador y las recupera al volver a abrir la página.

## Archivos

| Archivo | Función |
|---|---|
| `preferencias.html` | Formulario, botones de gestión y zona para mostrar las preferencias. |
| `js/cookies.js` | Crea, lee y elimina cookies y actualiza la página. |

## Uso

Abre `preferencias.html`, escribe el nombre y selecciona las opciones. Pulsa **Guardar preferencias** para almacenar los datos durante un año. Al volver a entrar, se cargan automáticamente si las cookies siguen disponibles.

- **Consultar preferencias** muestra los valores almacenados.
- **Eliminar preferencias** borra las cookies de la aplicación.
- **Restablecer** borra las cookies y devuelve el formulario a sus valores iniciales.

La práctica utiliza `document.cookie`; no utiliza `localStorage`. Para probarla en XAMPP, coloca el proyecto dentro de la carpeta servida por Apache y abre la página desde `localhost`.
