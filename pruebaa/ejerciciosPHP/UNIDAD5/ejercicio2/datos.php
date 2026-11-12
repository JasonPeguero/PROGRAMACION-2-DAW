<?php

function obtenerProyectos()
{
    return [
        [
            "id" => 1,
            "proyecto" => "Albor Croft",
            "cliente" => "Señor Ilerna",
            "horasEstimadas" => 100,
            "horasRealizadas" => 100,
            "estado" => "Planificado"
        ],

        [
            "id" => 2,
            "proyecto" => "Bodega Caballero",
            "cliente" => "Bodega ",
            "horasEstimadas" => 100,
            "horasRealizadas" => 100,
            "estado" => "Finalizado"
        ],
    
        [
            "id" => 3,
            "proyecto" => "Osborne",
            "cliente" => "Osborne",
            "horasEstimadas" => 100,
            "horasRealizadas" => 110,
            "estado" => "En desarrollo"
        ],

        [
            "id" => 4,
            "proyecto" => "Bodega Caballero",
            "cliente" => "Bodega Caballero",
            "horasEstimadas" => 100,
            "horasRealizadas" => 70,
            "estado" => "En pruebas"
        ],
    ];
}

?>