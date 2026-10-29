<?php

function Categorias(array $productos): array
{
    return array_values(array_unique(array_column($productos, 'categoria')));
}

function filtrarProductos(array $productos, string $nombre, string $categoria, string $precioMax): array
{
    $nombre = mb_strtolower($nombre);

    $filtrados = array_filter($productos, static function (array $producto) use ($nombre, $categoria, $precioMax): bool {
        if ($nombre !== '' && mb_strpos(mb_strtolower($producto['nombre']), $nombre) === false) {
            return false;
        }
        if ($categoria !== '' && $producto['categoria'] !== $categoria) {
            return false;
        }
        if ($precioMax !== '' && $producto['precio'] > (float) $precioMax) {
            return false;
        }

        return true;
    });

    return array_values($filtrados);
}

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
        $Precio = float($Precio);
        if ($Precio <= 0) {
            $errores[] = 'El precio del producto debe ser un valor positivo.';
        }
    }
    if ($Stock === '') {
        $errores[] = 'El stock del producto es obligatorio.';
    } else {
        $Stock = int($Stock);
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