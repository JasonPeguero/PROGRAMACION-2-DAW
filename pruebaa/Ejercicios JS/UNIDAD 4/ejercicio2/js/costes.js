function combustibleNecesario(distancia, consumo) {
    return distancia * consumo / 100;
}

function costeCombustible(litros, precio) {
    return litros * precio;
}

function costeTotal(combustible, peajes, adicionales) {
    return combustible + peajes + adicionales;
}

function costePorKilometro(total, distancia) {
    return total / distancia;
}


function calcular() {
    let distancia = Number(document.getElementById("distancia").value);
    let consumo = Number(document.getElementById("consumo").value);
    let precio = Number(document.getElementById("precio").value);
    let peajes = Number(document.getElementById("peajes").value);
    let adicionales = Number(document.getElementById("adicionales").value);

    if (distancia <= 0) {
        document.getElementById("resultado").innerHTML = "La distancia debe ser mayor que 0.";
        return;
    }

    let litros = combustibleNecesario(distancia, consumo);
    let costeComb = costeCombustible(litros, precio);
    let total = costeTotal(costeComb, peajes, adicionales);
    let porKm = costePorKilometro(total, distancia);

    document.getElementById("resultado").innerHTML =
        "<p>Distancia: " + distancia + " km<br>" +
        "Consumo: " + consumo + " l/100 km<br>" +
        "Precio combustible: " + precio + " €/l</p>" +
        "<p>Combustible necesario: " + litros + " litros<br>" +
        "Coste combustible: " +costeComb + " €</p>" +
        "<p>Peajes: " + peajes + " €<br>" +
        "Otros costes: " + adicionales + " €</p>" +
        "<h3>COSTE TOTAL: " + total + " €</h3>" +
        "<p>Coste por kilómetro: " + porKm + " €/km</p>";
}

document.getElementById("btnCalcular").addEventListener("click", calcular);