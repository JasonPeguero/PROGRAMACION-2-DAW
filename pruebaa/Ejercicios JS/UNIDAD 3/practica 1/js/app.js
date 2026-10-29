"use strict";

// Guarda la ventana de seguimiento para poder cargar una dirección en ella.
let ventanaSeguimiento;

// Muestra un mensaje sencillo en la página.
function mostrarMensaje(texto) {
  document.getElementById("mensaje").textContent = texto;
}

// Abre el panel actual en otra ventana.
function abrirPanel() {
  window.open("centro-operaciones.html", "panelOperaciones");
}

// Abre la página de seguimiento y guarda la ventana.
function abrirSeguimiento() {
  ventanaSeguimiento = window.open("seguimiento.html", "seguimiento", "width=900,height=600");

  if (ventanaSeguimiento === null) {
    mostrarMensaje("Permite las ventanas emergentes para abrir el seguimiento.");
  }
}

// Abre la web corporativa en una pestaña nueva.
function abrirWeb() {
  window.open("https://campus.ilerna.com", "_blank");
}

// Muestra los datos básicos de la página y el navegador.
function mostrarInformacion() {
  document.getElementById("infoURL").textContent = location.href;
  document.getElementById("infoProtocolo").textContent = location.protocol;
  document.getElementById("infoPlataforma").textContent = navigator.userAgent;
}

// Recarga la página actual.
function recargarPagina() {
  location.reload();
}

// Vuelve a la página anterior del historial.
function volverAtras() {
  history.back();
}

// Muestra la dirección actual.
function mostrarURL() {
  mostrarMensaje("URL actual: " + location.href);
}

// Carga la dirección escrita en la ventana de seguimiento.
function cargarURL() {
  const direccion = document.getElementById("txtURL").value;

  if (!ventanaSeguimiento || ventanaSeguimiento.closed) {
    mostrarMensaje("Abre la ventana de seguimiento y luego copia la URK");
    return;
  }

  if (!direccion.startsWith("https://") && !direccion.startsWith("http://")) {
    mostrarMensaje("La dirección debe empezar por http:// o https://.");
    return;
  }

  ventanaSeguimiento.location.href = direccion;
}

// Conecta cada botón con su función.
mostrarInformacion();
document.getElementById("btnPanel").addEventListener("click", abrirPanel);
document.getElementById("btnSeguimiento").addEventListener("click", abrirSeguimiento);
document.getElementById("btnWeb").addEventListener("click", abrirWeb);
document.getElementById("btnRecargar").addEventListener("click", recargarPagina);
document.getElementById("btnVolver").addEventListener("click", volverAtras);
document.getElementById("btnMostrarURL").addEventListener("click", mostrarURL);
document.getElementById("btnCargarURL").addEventListener("click", cargarURL);
