"use strict";

// Datos del último parte generado (se reutilizan en la ventana nueva)
let datosViaje = null;

// Muestra un mensaje con una alerta de Bootstrap
function mostrarMensaje(texto, tipo) {
  const mensaje = document.getElementById("mensaje");
  mensaje.textContent = texto;
  mensaje.className = "alert alert-" + tipo;
}

// Rellena el contenedor con los datos del parte
function rellenarParte(doc, contenedor, datos) {
  const lineas = [
    ["Viaje", datos.codigo],
    ["Camión", datos.matricula],
    ["Conductor", datos.conductor],
    ["Origen", datos.origen],
    ["Destino", datos.destino],
    ["Distancia", datos.distancia + " km"],
    ["Estado", datos.estado]
  ];

  // Limpia el contenedor y añade los párrafos con los datos
  contenedor.textContent = "";
  for (const [etiqueta, valor] of lineas) {
    const p = doc.createElement("p");
    const negrita = doc.createElement("strong");
    negrita.textContent = etiqueta + ": ";
    p.append(negrita, valor);
    contenedor.append(p);
  }
}

//muestra el parte
function generarParte(evento) {
  evento.preventDefault();

  // Comprueba los campos obligatorios
  const formulario = document.getElementById("formularioViaje");
  if (!formulario.reportValidity()) return;

  datosViaje = {
    codigo: document.getElementById("codigo").value.trim(),
    matricula: document.getElementById("matricula").value.trim(),
    conductor: document.getElementById("conductor").value.trim(),
    origen: document.getElementById("origen").value.trim(),
    destino: document.getElementById("destino").value.trim(),
    distancia: document.getElementById("distancia").value,
    estado: document.getElementById("estado").value
  };

  rellenarParte(document, document.getElementById("resultado"), datosViaje);
  document.getElementById("parteGenerado").hidden = false;
  mostrarMensaje("Parte de viaje generado correctamente.", "success");
}

// Abre una ventana nueva y escribe el parte y la fecha
function abrirParteEnVentana() {
  const ventana = window.open("", "_blank", "width=720,height=700");
  if (!ventana) {
    mostrarMensaje("El navegador ha bloqueado la ventana emergente. Permítela para abrir el parte.", "danger");
    return;
  }

  // Estructura básica de la ventana (sin datos del usuario)
  ventana.document.open();
  ventana.document.write(`<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Parte de viaje · ALBOR LOGISTICS</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
  <main class="container my-4">
    <h1 class="h3">ALBOR LOGISTICS</h1>
    <p><strong>PARTE DE VIAJE</strong></p>
    <div id="parte"></div>
    <hr>
    <p><strong>Identificación:</strong> ALBOR LOGISTICS</p>
    <p><strong>Fecha de generación:</strong> <span id="fecha"></span></p>
  </main>
</body>
</html>`);
  ventana.document.close();

  // Los datos se añaden con el DOM
  rellenarParte(ventana.document, ventana.document.getElementById("parte"), datosViaje);
  ventana.document.getElementById("fecha").textContent = new Date().toLocaleString("es-ES");
}

// Eventos
document.getElementById("formularioViaje").addEventListener("submit", generarParte);
document.getElementById("abrirParte").addEventListener("click", abrirParteEnVentana);