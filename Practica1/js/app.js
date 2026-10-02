
//buscar elementos del formulario
let CodigoViaje = document.getElementById('CodigoViaje');
let CiudadOrigen = document.getElementById('CiudadOrigen');
let CiudadDestino = document.getElementById('CiudadDestino');
let EstadoViaje = document.getElementById('EstadoViaje');
let MatriculaCamion = document.getElementById('MatriculaCamion');
//validacion de formulario
function validar(){

    if(CodigoViaje.value.trim() == ""){
        alert("El codigo de viaje es obligatorio");
    }
    if(CiudadOrigen.value.trim() == ""){
        alert("La ciudad de origen es obligatoria");
    }
    if(CiudadDestino.value.trim() == ""){
        alert("La ciudad de destino es obligatoria");
    }
    if(EstadoViaje.value.trim() == ""){
        alert("El estado del viaje es obligatorio");
    }


function validarEstadoViaje(){
    switch (EstadoViaje.value.trim()) {
        case "pendiente":
            alert("El viaje esta pendiente");
            break;
        case "en_ruta":
            alert("El viaje esta en curso");
            break;
        case "entregado":
            alert("El viaje se ha entregado");
            break;
            case "incidencia":
            alert("El viaje se ha cancelado");
            break;
        default:
            alert("El estado del viaje sin asignar");
            break;
    }
}
}