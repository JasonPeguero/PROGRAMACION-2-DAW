let rutas = [
    {origen: "Jerez", destino: "Sevilla"},
    {origen: "Jerez", destino: "Madrid"},
    {origen: "Cádiz", destino: "Málaga"},
    {origen: "Sevilla", destino: "Valencia"},
    {origen: "Madrid", destino: "Barcelona"}
];

function listadoRutas(lista) {
    let texto = "";
    for (let i = 0; i < lista.length; i++) {
        texto += (i + 1) + ". " + lista[i].origen + " = " + lista[i].destino + "<br>";
    }
    return texto;
}

function contarRutas() {
    return rutas.length;
}

function mostrarRutas() {
    document.getElementById("mostrarRutas").innerHTML = listadoRutas(rutas);
    document.getElementById("contarRutas").innerHTML = contarRutas();
}

function buscarRuta(ciudad) {
    let encontradas = [];
    for (let i = 0; i < rutas.length; i++) {
        if (rutas[i].origen === ciudad || rutas[i].destino === ciudad) {
            encontradas.push(rutas[i]);
        }
    }
    return encontradas;
}

function añadirRuta() {
    let origen = document.getElementById("origen").value;
    let destino = document.getElementById("destino").value;

    if (origen === "" || destino === "") {
        document.getElementById("mensaje").innerHTML = "Escribe origen y destino.";
        return;
    }

    rutas.push({origen: origen, destino: destino});
    document.getElementById("mensaje").innerHTML = "Ruta añadida.";
    mostrarRutas();
}

function eliminarRuta() {
    let numero = Number(document.getElementById("inputEliminar").value);

    if (numero < 1 || numero > rutas.length) {
        document.getElementById("mensaje").innerHTML = "Esa ruta no existe.";
        return;
    }

    rutas.splice(numero - 1, 1);  
    document.getElementById("mensaje").innerHTML = "Ruta eliminada.";
    mostrarRutas();
}


document.getElementById("btnAñadir").addEventListener("click", añadirRuta);
document.getElementById("btnEliminar").addEventListener("click", eliminarRuta);

document.getElementById("btnBuscar").addEventListener("click", function () {
    let ciudad = document.getElementById("inputBuscar").value;
    let resultado = buscarRuta(ciudad);

    document.getElementById("mostrarRutas").innerHTML = listadoRutas(resultado);
    document.getElementById("mensaje").innerHTML = resultado.length + " ruta(s) encontrada(s).";
});

document.getElementById("btnTodas").addEventListener("click", function () {
    document.getElementById("mensaje").innerHTML = "";
    mostrarRutas();
});


mostrarRutas();