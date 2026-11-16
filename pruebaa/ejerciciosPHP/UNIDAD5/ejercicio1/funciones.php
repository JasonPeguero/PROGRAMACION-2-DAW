<?php

function contarClientes($clientes)
{
    return count($clientes);
}

function crearMensaje($totalClientes)
{
    if ($totalClientes > 0) {
        return "Se han encontrado " . $totalClientes . " clientes.";
    }

    return "No hay clientes registrados.";
}

function ordenarClientes($clientes)
{
    usort($clientes, function ($a, $b) {
        return strcmp($a["cliente"], $b["cliente"]);
    });

    return $clientes;
}
