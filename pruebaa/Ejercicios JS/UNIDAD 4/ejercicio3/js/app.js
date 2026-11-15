// Flota: array de objetos Camion
let flota = [
    new Camion("1234ABC", "Volvo", "FH", 2019, 235000, "disponible"),
    new Camion("5678DEF", "Scania", "R", 2020, 180000, "en_ruta"),
    new Camion("9012GHI", "MAN", "TGX", 2017, 310000, "mantenimiento"),
    new Camion("3456JKL", "Mercedes", "Actros", 2021, 95000, "disponible"),
    new Camion("7890MNO", "DAF", "XF", 2018, 270000, "en_ruta")
];

function listadoCamiones(lista) {
    let texto = "Matrícula | Modelo | Kilómetros | Estado\n";
    for (let i = 0; i < lista.length; i++) {
        texto += lista[i].mostrarInfo() + "\n";
    }
    return texto;
}
function buscarPorMatricula(matricula) {
    for (let i = 0; i < flota.length; i++) {
        if (flota[i].matricula === matricula) {
            return flota[i];
        }
    }
    return undefined;
}

function filtrarPorEstado(estado) {
    let resultado = [];
    for (let i = 0; i < flota.length; i++) {
        if (flota[i].estado === estado) {
            resultado.push(flota[i]);
        }
    }
    return resultado;
}

function contarMantenimiento() {
    return filtrarPorEstado("mantenimiento").length;
}

function mostrar(texto) {
    document.getElementById("resultado").textContent = texto;
}

document.getElementById("btnTodos").addEventListener("click", function () {
    mostrar(listadoCamiones(flota));
});

document.getElementById("btnDisponibles").addEventListener("click", function () {
    mostrar(listadoCamiones(filtrarPorEstado("disponible")));
});

document.getElementById("btnEnRuta").addEventListener("click", function () {
    mostrar(listadoCamiones(filtrarPorEstado("en_ruta")));
});

document.getElementById("btnMantenimiento").addEventListener("click", function () {
    mostrar("Camiones en mantenimiento: " + contarMantenimiento());
});

document.getElementById("btnBuscar").addEventListener("click", function () {
    let matricula = document.getElementById("inputMatricula").value.toUpperCase();
    let camion = buscarPorMatricula(matricula);

    if (camion === undefined) {
        mostrar("No existe ningún camión con esa matrícula.");
    } else {
        mostrar(listadoCamiones([camion]));
    }
});

mostrar(listadoCamiones(flota));