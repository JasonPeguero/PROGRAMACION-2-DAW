"use strict";

const NOMBRE_APP = "ALBOR LOGISTICS";
const PAGINA_INICIAL = "viajes.html";

// Página que se muestra como principal en el iframe
let paginaActual = PAGINA_INICIAL;

// Muestra un mensaje en el panel de información
function mostrarMensaje(texto, tipo) {
  const mensaje = document.getElementById("mensaje");
  mensaje.textContent = texto;
  mensaje.className = "alert alert-" + tipo;
}

// Rellena la informacion del panel
function mostrarInformacion() {
  const plataforma = (navigator.userAgentData && navigator.userAgentData.platform) || navigator.platform || "Desconocida";
  document.getElementById("infoApp").textContent = NOMBRE_APP;
  document.getElementById("infoURL").textContent = location.href;
  document.getElementById("infoPlataforma").textContent = plataforma;
}

// Carga una pagina en el iframe y marca el boton activo del menú
function cargarPagina(pagina) {
  const marco = document.getElementById("marco");
  marco.src = pagina;           // el iframe navega al archivo
  paginaActual = pagina;
  document.getElementById("infoPagina").textContent = pagina;
  document.getElementById("mensaje").className = "";
  document.getElementById("mensaje").textContent = "";

  // Resalta en el menu la pagina que muestra
  for (const boton of document.querySelectorAll("[data-pagina]")) {
    boton.classList.toggle("active", boton.dataset.pagina === pagina);
  }
}

// Recarga el contenido del iframe
function recargarContenido() {
  const marco = document.getElementById("marco");
  try {
    marco.contentWindow.location.reload();
    mostrarMensaje("Contenido recargado.", "success");
  } catch (error) {
    marco.src = paginaActual;
    mostrarMensaje("Contenido recargado.", "success");
  }
}

// Abre el contenido actual del iframe en una ventana aparte
function abrirEnNuevaVentana() {
  const ventana = window.open(paginaActual, "_blank", "width=800,height=600");
  if (!ventana) {
    mostrarMensaje("El navegador ha bloqueado la ventana emergente. Permítela para este sitio.", "danger");
  }
}

//informacion, eventos y contenido inicial
document.addEventListener("DOMContentLoaded", () => {
  mostrarInformacion();

  // Acción para los tres botones del menu
  for (const boton of document.querySelectorAll("[data-pagina]")) {
    boton.addEventListener("click", () => cargarPagina(boton.dataset.pagina));
  }
  document.getElementById("btnRecargar").addEventListener("click", recargarContenido);
  document.getElementById("btnNuevaVentana").addEventListener("click", abrirEnNuevaVentana);

  cargarPagina(PAGINA_INICIAL);
});