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
        listado += rutas[i].origen + " = " + rutas[i].destino + "<br>";
    }
    document.getElementById("mostrarRutas").innerHTML = listado;

}

function buscaRuta(){
    let origen = document.getElementById("Buscar1").value;
    let destino = document.getElementById("Buscar2").value;
    let encontrado = false;


}

function añadirRuta() {
    let origen = document.getElementById("origen").value;
    let destino = document.getElementById("destino").value;
    let ruta = {origen: origen, destino: destino};
    rutas.push(ruta);
    listadoRutas();
    contarRutas();

}

function eliminarRuta() {
let origen = document.getElementById("origen").value;
let destino = document.getElementById("destino").value; 


}

function contarRutas() {
    document.getElementById("contarRutas").innerHTML = rutas.length;;
}

listadoRutas();
contarRutas();