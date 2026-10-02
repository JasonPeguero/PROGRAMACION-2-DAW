let Codigo = document.getElementById('Codigo');
let Matricula = document.getElementById('Matricula');
let Conductor = document.getElementById('Conductor');
let Origen = document.getElementById('Origen');
let Destino = document.getElementById('Destino');
let Distancia = document.getElementById('Distancia');

function validaciones(){
    if(Codigo.value.trim() == ""){
        alert("El codigo es obligatorio");
    }

    if(Matricula.value.trim() == ""){
        alert("La matricula es obligatoria");
       
    } 
     else if(!/^[0-9]{4}[A-Z]{3}$/.test(Matricula.value.trim())){
        alert(" El formato de la matricula no es correcto");
    }

    if(Conductor.value.trim() == ""){
        alert("El conductor es obligatorio");
    }

    if(Origen.value.trim() == Destino.value.trim()){
        alert("El origen no puede ser igual al destino");
    }

    if(Distancia.value.trim() == ""){
        alert("La distancia es obligatoria");
       
    } 
}