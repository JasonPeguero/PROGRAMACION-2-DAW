"use strict";

// Nombres de las cookies utilizadas por esta aplicación.
const nombresCookies = ["operador", "idioma", "viajes", "panel"];

// Busca una cookie por su nombre y devuelve su valor.
function leerCookie(nombre) {
  const cookies = document.cookie.split(";");

  for (let i = 0; i < cookies.length; i++) {
    const cookie = cookies[i].trim();
    const separador = cookie.indexOf("=");

    if (separador !== -1 && cookie.substring(0, separador) === nombre) {
      return decodeURIComponent(cookie.substring(separador + 1));
    }
  }

  return null;
}

// Crea o modifica una cookie con una fecha de expiración futura.
function guardarCookie(nombre, valor) {
  const fechaExpiracion = new Date();
  fechaExpiracion.setDate(fechaExpiracion.getDate() + 365);
  document.cookie = nombre + "=" + encodeURIComponent(valor) +
    "; expires=" + fechaExpiracion.toUTCString() + "; path=/; SameSite=Lax";
}

// Elimina una cookie estableciendo una fecha de expiración pasada.
function eliminarCookie(nombre) {
  document.cookie = nombre + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; SameSite=Lax";
}

// Devuelve las preferencias si están guardadas todas las cookies necesarias.
function obtenerPreferencias() {
  const preferencias = {
    operador: leerCookie("operador"),
    idioma: leerCookie("idioma"),
    viajes: leerCookie("viajes"),
    panel: leerCookie("panel")
  };

  if (preferencias.operador === null || preferencias.idioma === null ||
      preferencias.viajes === null || preferencias.panel === null) {
    return null;
  }

  return preferencias;
}

// Muestra el saludo y las preferencias guardadas en el documento.
function mostrarPreferencias(preferencias) {
  const detalle = document.getElementById("detallePreferencias");
  detalle.replaceChildren();

  const saludo = document.createElement("p");
  saludo.textContent = "Bienvenido de nuevo, " + preferencias.operador + ".";
  detalle.appendChild(saludo);

  const titulo = document.createElement("p");
  titulo.textContent = "Tus preferencias:";
  detalle.appendChild(titulo);

  const lista = document.createElement("ul");
  const datos = [
    "Idioma: " + preferencias.idioma,
    "Viajes por página: " + preferencias.viajes,
    "Último panel: " + preferencias.panel
  ];

  for (let i = 0; i < datos.length; i++) {
    const elemento = document.createElement("li");
    elemento.textContent = datos[i];
    lista.appendChild(elemento);
  }

  detalle.appendChild(lista);
  document.getElementById("resultado").hidden = false;
}

// Carga los valores guardados en el formulario al abrir la página.
function cargarPreferencias() {
  const preferencias = obtenerPreferencias();
  const mensaje = document.getElementById("mensaje");

  if (preferencias === null) {
    mensaje.textContent = "No existen preferencias guardadas. Configura tus preferencias para comenzar.";
    document.getElementById("resultado").hidden = true;
    return;
  }

  document.getElementById("nombre").value = preferencias.operador;
  document.getElementById("idioma").value = preferencias.idioma;
  document.getElementById("viajes").value = preferencias.viajes;
  document.getElementById("panel").value = preferencias.panel;
  mensaje.textContent = "Preferencias cargadas correctamente.";
  mostrarPreferencias(preferencias);
}

// Guarda los valores del formulario en cookies.
function guardarPreferencias(evento) {
  evento.preventDefault();

  const preferencias = {
    operador: document.getElementById("nombre").value.trim(),
    idioma: document.getElementById("idioma").value,
    viajes: document.getElementById("viajes").value,
    panel: document.getElementById("panel").value
  };

  if (preferencias.operador === "") {
    document.getElementById("mensaje").textContent = "Escribe el nombre del operador.";
    return;
  }

  for (let i = 0; i < nombresCookies.length; i++) {
    const nombreCookie = nombresCookies[i];
    guardarCookie(nombreCookie, preferencias[nombreCookie]);
  }

  const preferenciasGuardadas = obtenerPreferencias();
  if (preferenciasGuardadas === null) {
    document.getElementById("mensaje").textContent =
      "No se pudieron guardar las preferencias. Comprueba que las cookies estén habilitadas.";
    return;
  }

  document.getElementById("mensaje").textContent = "Preferencias guardadas correctamente.";
  mostrarPreferencias(preferenciasGuardadas);
}

// Lee y muestra las preferencias que hay almacenadas en las cookies.
function consultarPreferencias() {
  const preferencias = obtenerPreferencias();

  if (preferencias === null) {
    document.getElementById("mensaje").textContent = "No existen preferencias guardadas.";
    document.getElementById("resultado").hidden = true;
    return;
  }

  document.getElementById("mensaje").textContent = "Estas son las preferencias almacenadas en las cookies.";
  mostrarPreferencias(preferencias);
}

// Elimina todas las cookies relacionadas con las preferencias.
function eliminarPreferencias() {
  for (let i = 0; i < nombresCookies.length; i++) {
    eliminarCookie(nombresCookies[i]);
  }

  let cookiesEliminadas = true;
  for (let i = 0; i < nombresCookies.length; i++) {
    if (leerCookie(nombresCookies[i]) !== null) {
      cookiesEliminadas = false;
    }
  }

  if (!cookiesEliminadas) {
    document.getElementById("mensaje").textContent =
      "No se pudieron eliminar todas las preferencias. Comprueba la configuración de cookies.";
    return false;
  }

  document.getElementById("mensaje").textContent = "Se han eliminado las preferencias guardadas.";
  document.getElementById("resultado").hidden = true;
  return true;
}

// Elimina las cookies y devuelve el formulario a sus valores iniciales.
function restablecerFormulario() {
  const eliminadas = eliminarPreferencias();
  document.getElementById("formularioPreferencias").reset();
  if (eliminadas) {
    document.getElementById("mensaje").textContent =
      "Preferencias eliminadas. Configura tus preferencias para comenzar.";
  }
}

// Conecta los botones con sus funciones y carga las preferencias al entrar.
document.getElementById("formularioPreferencias").addEventListener("submit", guardarPreferencias);
document.getElementById("btnConsultar").addEventListener("click", consultarPreferencias);
document.getElementById("btnEliminar").addEventListener("click", eliminarPreferencias);
document.getElementById("btnRestablecer").addEventListener("click", restablecerFormulario);
cargarPreferencias();
