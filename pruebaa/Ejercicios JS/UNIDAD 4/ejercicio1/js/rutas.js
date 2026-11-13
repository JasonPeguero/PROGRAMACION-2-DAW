let rutas = [
    {origen: "Jerez", destino: "Sevilla"},
    {origen: "Jerez", destino: "Madrid"},
    {origen: "Cádiz", destino: "Málaga"},
    {origen: "Sevilla", destino: "Valencia"},
    {origen: "Madrid", destino: "Barcelona"}
]


function listadoRutas() {
    let listado = "";   
    for (let i = 0; i < rutas.length; i++) {
        listado += rutas[i].origen + " → " + rutas[i].destino + "<br>";
    }
    return listado;
}

function mostrarRutas() {
    let mensaje = document.getElementById("mensaje");
    mensaje.innerHTML = "Rutas disponibles:" + listadoRutas() + "<br> Total de rutas: " + contarRutas(); 
}

function buscarRutas() {

}

function añadirRuta() {

}

function eliminarRuta() {

}

function contarRutas() {
    return rutas.length;
}