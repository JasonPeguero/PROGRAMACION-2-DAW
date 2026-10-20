<?php

const PRIORIDADES = ['Baja', 'Media', 'Alta', 'Crítica'];
const CATEGORIAS  = ['Aplicación web', 'Servidor', 'Base de datos', 'Red', 'Cuenta de usuario', 'Otra'];
const ESTADO_INICIAL = 'Pendiente';

function generarIdIncidencia(int $ano, int $secuencia): string
{
    return sprintf('%04d-%05d', $ano, $secuencia);
}

function validarFormulario(
    string $nombre,
    string $correo,
    string $empresa,
    string $asunto,
    string $descripcion,
    string $prioridad,
    string $categoria
): array {
    $errores = [];

    if ($nombre === '') {
        $errores[] = 'El nombre del cliente es obligatorio.';
    }
    if (!filter_var($correo)) {
        $errores[] = 'El correo electrónico no es válido.';
    }
    if ($empresa === '') {
        $errores[] = 'El nombre de la empresa es obligatorio.';
    }
    if ($asunto === '') {
        $errores[] = 'El asunto es obligatorio.';
    }
    if ($descripcion === '') {
        $errores[] = 'La descripción es obligatoria.';
    }

    
    if (!in_array($prioridad, PRIORIDADES, true)) {
        $errores[] = 'Debe seleccionar una prioridad válida.';
    }
    if (!in_array($categoria, CATEGORIAS, true)) {
        $errores[] = 'Debe seleccionar una categoría válida.';
    }

    return $errores;
}


function mostrarIncidencia(
    string $id,
    string $fecha,
    string $nombre,
    string $correo,
    string $empresa,
    string $asunto,
    string $descripcion,
    string $prioridad,
    string $categoria,
    string $estado
): string {
    return "INCIDENCIA REGISTRADA \n\n"
        . "ID: $id \n"
        . "Fecha: $fecha\n"
        . "Cliente: $nombre ($empresa) \n"
        . "Email: $correo \n\n"
        . "Asunto: \n$asunto \n\n"
        . "Descripción: \n$descripcion \n\n"
        . "Prioridad: $prioridad \n"
        . "Categoría: $categoria \n\n"
        . "Estado: $estado";
}