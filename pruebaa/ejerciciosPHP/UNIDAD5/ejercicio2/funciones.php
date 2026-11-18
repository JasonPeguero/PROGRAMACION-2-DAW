

<?php

const ESTADOS = ["Planificado", "En desarrollo", "En pruebas", "Finalizado"];

function obtenerProyecto($id)
{
    foreach(obtenerProyectos() as $proyecto){
        if ($proyecto["id"] === $id) {
        return $proyecto;
        }
}

return null;
}

function filtrarEstado($proyectos, $estado)

{
    if($estado === ""){
        return $proyectos;
    }

    $resultado = [];
    foreach ($proyectos as $proyecto) {
        if ($proyecto["estado"] === $estado) {
            $resultado[] = $proyecto;
        }
    }
    return $resultado;
}

function calcularProgreso($proyecto)
{
    if($proyecto["horasEstimadas"] <= 0){
        return 0;
    }

    return (int)($proyecto["horasRealizadas"] * 100 / $proyecto["horasEstimadas"]);
}

function horasSuperadas($proyecto)
{ 
    if($proyecto["horasRealizadas"] > $proyecto["horasEstimadas"]){
        return "horas estimadas superadas";
    }
}
return "";

?>