// Códigos de empleado válidos
const codigosValidos = ["ALBOR001", "ALBOR002", "ALBOR003"];
const maxIntentos = 3;

document.getElementById("formulario").addEventListener("submit", function (evento) {
  evento.preventDefault(); // evita que el formulario recargue la página

  let intentos = 0;
  let accesoCorrecto = false;
  let codigo = "";

  // Se pide el código al menos una vez y se repite hasta acertar o llegar a 3 intentos
  do {
    codigo = prompt("Introduce tu código de empleado (intento " + (intentos + 1) + " de " + maxIntentos + "):");
    intentos++;

    if (codigo === null) {
      codigo = ""; // si cancela, cuenta como intento fallido
    }

    accesoCorrecto = codigosValidos.includes(codigo.trim().toUpperCase());
  } while (!accesoCorrecto && intentos < maxIntentos);

  let mensaje = document.getElementById("mensaje");

  if (accesoCorrecto) {
    mensaje.textContent = "Acceso autorizado. Bienvenido al panel de operaciones.";
    mensaje.className = "ok";
  } else {
    mensaje.textContent = "Acceso bloqueado. Se ha superado el número máximo de intentos.";
    mensaje.className = "error";
  }
});