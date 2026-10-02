function calcular() {
let Distancia = document.getElementById('DistanciaInput').value;
let Consumo = document.getElementById('ConsumoInput').value;
let pCombustible = document.getElementById('pCombustibleInput').value;
let Peajes = document.getElementById('PeajesInput').value;
 
let CombustibleNecesario = (Consumo / 100) * Distancia;
let CosteCombustible = CombustibleNecesario * pCombustible;
let CosteTotal = CosteCombustible + Peajes;
 
document.getElementById('Distancia').innerHTML = Distancia + "km";
document.getElementById('Consumo').innerHTML = Consumo + "  l/100 km";
document.getElementById('pCombustible').innerHTML = pCombustible + " €/1";
document.getElementById('Peajes').innerHTML = Peajes + " €";
document.getElementById('CombustibleNecesario').innerHTML = CombustibleNecesario + " l";
document.getElementById('CosteCombustible').innerHTML = CosteCombustible + " €";
document.getElementById('CosteTotal').innerHTML = CosteTotal + " €";
}
 
document.getElementById('btnCalcular').addEventListener('click', calcular);