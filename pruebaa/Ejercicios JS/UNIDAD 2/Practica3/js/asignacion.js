// Número de viajes pendientes 
let viajesPendientes = 8;

let viajesProcesados = 0;
let viajesCorrectos = 0;
let viajesConIncidencia = 0;
// Mostrar el número de viajes pendientes en el HTML
document.getElementById("pendientes").textContent = "Viajes pendientes: " + viajesPendientes;

let contador = 1;
let resultado = "";

// Bucle while para procesar los viajes pendientes
while (viajesPendientes > 0) {
  viajesProcesados++;
  viajesPendientes--;
 
// Simulación de incidencia aleatoria usamos el Math.random() para generar un número aleatorio entre 0 y 1. Si el número es menor que 0.25, consideramos que ha ocurrido una incidencia en el viaje.
  let Incidencia = Math.random() < 0.25;
 
  if (Incidencia) {
    viajesConIncidencia++;
    resultado += '<p class="incidencia">Procesando viaje ' + viajesProcesados + "... finalizado con incidencia</p>";
  } else {
    viajesCorrectos++;
    resultado += '<p class="correcto">Procesando viaje ' + viajesProcesados + "... finalizado correctamente</p>";
  }
}
// Mostrar el resultado en el HTML
resultado += '<p class="final">Todos los viajes han sido procesados correctamente.</p>';
document.getElementById("salida").innerHTML = resultado;
// Mostrar el resumen de viajes procesados, correctos y con incidencia en el HTML
document.getElementById("resumen").innerHTML =
  "<h1>Resumen</h1>" +
  "<p>Viajes procesados: " + viajesProcesados + "</p>" +
  "<p>Viajes correctos: " + viajesCorrectos + "</p>" +
  "<p>Viajes con incidencia: " + viajesConIncidencia + "</p>";
 