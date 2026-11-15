let camiones = [
    new Camion("1234ABC", "Volvo", "FH", 235000, "en_ruta"),
    new Camion("5678DEF", "Scania", "R", 180000, "disponible"),
    new Camion("9012GHI", "MAN", "TGX", 310000, "en_ruta"),
    new Camion("3456JKL", "Mercedes", "Actros", 95000, "disponible")
];

let conductores = [
    new Conductor("11111111A", "Juan García", "600111111", 8, false),
    new Conductor("22222222B", "Pedro López", "600222222", 5, true),
    new Conductor("33333333C", "Ana Ruiz", "600333333", 12, false),
    new Conductor("44444444D", "Luis Pérez", "600444444", 3, true)
];

let rutas = [
    new Ruta("R1", "Jerez", "Madrid", 640),
    new Ruta("R2", "Cádiz", "Málaga", 235),
    new Ruta("R3", "Sevilla", "Valencia", 650),
    new Ruta("R4", "Madrid", "Barcelona", 620),
    new Ruta("R5", "Jerez", "Sevilla", 90)
];

let viajes = [
    new Viaje("VIA-001", camiones[0], conductores[0], rutas[0], "en_ruta"),
    new Viaje("VIA-002", camiones[1], conductores[1], rutas[1], "entregado"),
    new Viaje("VIA-003", camiones[2], conductores[2], rutas[2], "en_ruta"),
    new Viaje("VIA-004", camiones[3], conductores[3], rutas[3], "pendiente"),
    new Viaje("VIA-005", camiones[0], conductores[0], rutas[4], "entregado"),
    new Viaje("VIA-006", camiones[1], conductores[1], rutas[2], "asignado"),
    new Viaje("VIA-007", camiones[2], conductores[2], rutas[3], "en_ruta"),
    new Viaje("VIA-008", camiones[3], conductores[3], rutas[0], "pendiente"),
    new Viaje("VIA-009", camiones[0], conductores[2], rutas[1], "en_ruta"),
    new Viaje("VIA-010", camiones[1], conductores[3], rutas[4], "asignado")
];

function listadoViajes(lista) {
    if (lista.length === 0) {
        return "No hay viajes.";
    }
    let texto = "";
    for (let i = 0; i < lista.length; i++) {
        texto += lista[i].mostrarInfo() + "\n";
    }
    return texto;
}

function buscarViaje(codigo) {
    for (let i = 0; i < viajes.length; i++) {
        if (viajes[i].codigo === codigo) {
            return viajes[i];
        }
    }
    return undefined;
}

function viajesDeConductor(dni) {
    let resultado = [];
    for (let i = 0; i < viajes.length; i++) {
        if (viajes[i].conductor.dni === dni) {
            resultado.push(viajes[i]);
        }
    }
    return resultado;
}

function viajesDeCamion(matricula) {
    let resultado = [];
    for (let i = 0; i < viajes.length; i++) {
        if (viajes[i].camion.matricula === matricula) {
            resultado.push(viajes[i]);
        }
    }
    return resultado;
}

function viajesPorEstado(estado) {
    let resultado = [];
    for (let i = 0; i < viajes.length; i++) {
        if (viajes[i].estado === estado) {
            resultado.push(viajes[i]);
        }
    }
    return resultado;
}

function contarPendientes() {
    return viajesPorEstado("pendiente").length;
}


function mostrarResumen() {
    return "RESUMEN OPERATIVO\n\n" +
           "Viajes totales: " + viajes.length + "\n" +
           "Pendientes: " + contarPendientes() + "\n" +
           "Asignados: " + viajesPorEstado("asignado").length + "\n" +
           "En ruta: " + viajesPorEstado("en_ruta").length + "\n" +
           "Entregados: " + viajesPorEstado("entregado").length + "\n" +
           "Incidencias: " + viajesPorEstado("incidencia").length;
}

a
function mostrar(texto) {
    document.getElementById("resultado").textContent = texto;
}


document.getElementById("btnTodos").addEventListener("click", function () {
    mostrar(listadoViajes(viajes));
});

document.getElementById("btnEnRuta").addEventListener("click", function () {
    mostrar(listadoViajes(viajesPorEstado("en_ruta")));
});

document.getElementById("btnEntregados").addEventListener("click", function () {
    mostrar(listadoViajes(viajesPorEstado("entregado")));
});

document.getElementById("btnPendientes").addEventListener("click", function () {
    mostrar("Viajes pendientes: " + contarPendientes());
});

document.getElementById("btnResumen").addEventListener("click", function () {
    mostrar(mostrarResumen());
});

document.getElementById("btnBuscarCodigo").addEventListener("click", function () {
    let codigo = document.getElementById("inputCodigo").value.toUpperCase();
    let viaje = buscarViaje(codigo);
    if (viaje === undefined) {
        mostrar("No existe ese viaje.");
    } else {
        mostrar(viaje.mostrarInfo());
    }
});

document.getElementById("btnConductor").addEventListener("click", function () {
    let dni = document.getElementById("inputDni").value.toUpperCase();
    mostrar(listadoViajes(viajesDeConductor(dni)));
});

document.getElementById("btnCamion").addEventListener("click", function () {
    let matricula = document.getElementById("inputMatricula").value.toUpperCase();
    mostrar(listadoViajes(viajesDeCamion(matricula)));
});


mostrar(listadoViajes(viajes));