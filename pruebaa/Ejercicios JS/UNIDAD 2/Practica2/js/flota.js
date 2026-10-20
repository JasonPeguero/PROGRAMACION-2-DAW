//lista de camiones
let matricula = ["1234ABC", "5678DEF", "9012GHJ", "3456KLM", "7890NPR", "2468STV", "1357WXY", "8642BCD", "9753FGH", "1597JKL"];
let marca = ["Volvo", "Scania", "MAN", "Mercedes", "DAF", "Iveco", "Renault", "Volvo", "Scania", "MAN"];
let modelo = ["FH", "R450", "TGX", "Actros", "XF", "S-Way", "T High", "FM", "S500", "TGS"];
let kilometros = [235000, 182400, 310250, 97800, 154300, 68900, 276500, 121700, 45200, 203100];
let estado = ["en_ruta", "disponible", "mantenimiento", "mantenimiento", "disponible", "en_ruta", "mantenimiento", "disponible", "en_ruta", "disponible"];
//
let totalCamiones = 0;
let disponibles = 0;
let enRuta = 0;
let enMantenimiento = 0;
let kilometrosTotales = 0;

let listaCamiones = " ";
let avisoMantenimiento = " ";


for (let i = 0; i < 10; i++) {

  totalCamiones++;
  kilometrosTotales += kilometros[i];

  let textoEstado = " ";

  if (estado[i] === "disponible") {
    disponibles = disponibles + 1;
    textoEstado = "Disponible";
  } else if (estado[i] === "en_ruta") {
    enRuta = enRuta + 1;
    textoEstado = "En ruta";
  } else if (estado[i] === "mantenimiento") {
    enMantenimiento = enMantenimiento + 1;
    textoEstado = "En mantenimiento";
    
  }

 
  listaCamiones +=
    '<article class="camion ' + estado[i] + ' ">' +
      "<p><strong>Matrícula:</strong> " + matricula[i] + "</p>" +
      "<p><strong>Modelo:</strong> " + marca[i] + " " + modelo[i] + "</p>" +
      "<p><strong>Kilómetros:</strong> " + kilometros[i] + "</p>" +
      "<p><strong>Estado:</strong> " + textoEstado + "</p>" +
    "</article>";
}


if (enMantenimiento > 3) {
  mensajeMantenimiento = "Atención: revisar disponibilidad de flota.";
} else if (enMantenimiento >= 1) {
  mensajeMantenimiento = "Mantenimiento dentro de los niveles previstos.";
} else {
  mensajeMantenimiento = "Flota disponible sin vehículos en mantenimiento.";
}



let kilometrajeMedio = 0;

if (totalCamiones > 0) {
  kilometrajeMedio = kilometrosTotales / totalCamiones;
}

// Mostrar la lista de camiones y el resumen en el HTML
document.getElementById("flota").innerHTML = listaCamiones;

document.getElementById("resumen").innerHTML =
  '<div class="etiqueta">Total de camiones</div>' + totalCamiones + '<div class="dato"><div class="valor"> </div></div>'  +
  '<div class="etiqueta">Disponibles</div>' + disponibles + '<div class="dato disponible"><div class="valor"> </div></div>'  +
  '<div class="etiqueta">En ruta</div>' + enRuta + '<div class="dato en_ruta"><div class="valor"> </div></div>'  +
  '<div class="etiqueta">En mantenimiento</div>'+ enMantenimiento +  '<div class="dato mantenimiento"><div class="valor"> </div></div></div>'  +
  '<div class="etiqueta">Kilómetros totales de la flota</div> ' + kilometrosTotales +  '<div class="dato"><div class="valor">km </div></div></div>' +
  '<div class="etiqueta">Kilometraje medio</div>'+ kilometrajeMedio / 10 +   '<div class="dato"><div class="valor">km</div></div></div>' ;

  // Mostrar el mensaje de mantenimiento en el HTML
  document.getElementById("avisoMantenimiento").innerHTML = mensajeMantenimiento;