<?php

function validarFormulario(
    string $Nombre,
    string $Categoría,
    string $Precio,
    string $Stock,
    string $Descripcion,
): array {
    $errores = [];

    if ($Nombre === '') {
        $errores[] = 'El nombre del producto es obligatorio.';
    }
    if ($Categoría === '') {
        $errores[] = 'La categoría del producto es obligatoria.';
    }
    if ($Precio === '') {
        $errores[] = 'El precio del producto es obligatorio.';
    } else {
        $Precio = floatval($Precio);
        if ($Precio <= 0) {
            $errores[] = 'El precio del producto debe ser un valor positivo.';
        }
    }
    if ($Stock === '') {
        $errores[] = 'El stock del producto es obligatorio.';
    } else {
        $Stock = intval($Stock);
        if ($Stock < 0) {
            $errores[] = 'El stock del producto debe ser un valor no negativo.';
        }
    }
    if ($Descripcion === '') {
        $errores[] = 'La descripción del producto es obligatoria.';
    }
    
    return $errores;
}

?>