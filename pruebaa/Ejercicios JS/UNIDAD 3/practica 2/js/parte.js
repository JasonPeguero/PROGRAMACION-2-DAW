"use strict";

// Conserva los últimos datos para poder generar el parte en otra ventana.
let datosViaje = null;

// Añade una línea al parte sin interpretar los datos como código HTML.
function agregarDato(contenedor, etiqueta, valor) {
  const linea = document.createElement("p");
  const nombre = document.createElement("strong");
  nombre.textContent = etiqueta + ": ";
  linea.append(nombre, document.createTextNode(valor));
  contenedor.append(linea);
}

// Escapa texto antes de incluirlo en el documento HTML de la ventana secundaria.
function escaparHTML(valor) {
  return valor.replace(/[&<>"']/g, (caracter) => ({
    "&": "&amp;",
    "<": "&lt;",
    ">": "&gt;",
    '"': "&quot;",
    "'": "&#39;"
  })[caracter]);
}

// Lee los campos y genera el parte en la página actual mediante el DOM.
function generarParte(evento) {
  evento.preventDefault();

  const formulario = document.getElementById("formularioViaje");
  if (!formulario.reportValidity()) return;

  const campos = new FormData(formulario);
  datosViaje = {
    codigo: campos.get("codigo").trim(),
    matricula: campos.get("matricula").trim(),
    conductor: campos.get("conductor").trim(),
    origen: campos.get("origen").trim(),
    destino: campos.get("destino").trim(),
    distancia: campos.get("distancia"),
    estado: campos.get("estado")
  };

  const resultado = document.getElementById("resultado");
  resultado.replaceChildren();
  agregarDato(resultado, "Viaje", datosViaje.codigo);
  agregarDato(resultado, "Camión", datosViaje.matricula);
  agregarDato(resultado, "Conductor", datosViaje.conductor);
  agregarDato(resultado, "Origen", datosViaje.origen);
  agregarDato(resultado, "Destino", datosViaje.destino);
  agregarDato(resultado, "Distancia", datosViaje.distancia + " km");
  agregarDato(resultado, "Estado", datosViaje.estado);

  document.getElementById("parteGenerado").hidden = false;
  document.getElementById("abrirParte").disabled = false;
  document.getElementById("mensaje").textContent = "Parte de viaje generado correctamente.";
}

// Abre una ventana y escribe en ella el parte y su fecha de generación.
function abrirParteEnVentana() {
  if (!datosViaje) return;

  const ventana = window.open("", "_blank", "width=720,height=700");
  if (!ventana) {
    document.getElementById("mensaje").textContent =
      "El navegador ha bloqueado la ventana emergente. Permítela para abrir el parte.";
    return;
  }

  const fecha = new Date().toLocaleString("es-ES");
  const codigo = escaparHTML(datosViaje.codigo);
  const matricula = escaparHTML(datosViaje.matricula);
  const conductor = escaparHTML(datosViaje.conductor);
  const origen = escaparHTML(datosViaje.origen);
  const destino = escaparHTML(datosViaje.destino);
  const distancia = escaparHTML(datosViaje.distancia);
  const estado = escaparHTML(datosViaje.estado);

  // El contenido de la ventana se genera con los datos introducidos en el formulario.
  ventana.document.open();
  ventana.document.write(`<!DOCTYPE html>
    <html lang="es">
    <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Parte de viaje ${codigo} · ALBOR LOGISTICS</title>
      <style>
        body { max-width: 680px; margin: 3rem auto; padding: 0 1.25rem; font: 16px Arial, sans-serif; color: #172b4d; }
        article { padding: 2rem; border: 1px solid #d5deea; border-top: 6px solid #f0a52b; }
        h1 { color: #123b68; }
        p { margin: 1rem 0; }
        footer { margin-top: 2rem; padding-top: 1rem; border-top: 1px solid #d5deea; color: #52657d; }
      </style>
    </head>
    <body>
      <article>
        <header><h1>ALBOR LOGISTICS</h1><p><strong>PARTE DE VIAJE</strong></p></header>
        <main>
          <p><strong>Viaje:</strong> ${codigo}</p>
          <p><strong>Camión:</strong> ${matricula}</p>
          <p><strong>Conductor:</strong> ${conductor}</p>
          <p><strong>Origen:</strong> ${origen}</p>
          <p><strong>Destino:</strong> ${destino}</p>
          <p><strong>Distancia:</strong> ${distancia} km</p>
          <p><strong>Estado:</strong> ${estado}</p>
        </main>
        <footer>
          <p><strong>Identificación:</strong> ALBOR LOGISTICS</p>
          <p><strong>Fecha de generación:</strong> ${escaparHTML(fecha)}</p>
        </footer>
      </article>
    </body>
    </html>`);
  ventana.document.close();
}

// Registra los eventos cuando el documento ya está disponible.
document.getElementById("formularioViaje").addEventListener("submit", generarParte);
document.getElementById("abrirParte").addEventListener("click", abrirParteEnVentana);