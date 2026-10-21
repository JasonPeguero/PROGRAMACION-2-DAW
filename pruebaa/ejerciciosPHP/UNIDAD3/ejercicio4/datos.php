<?php

session_start();

function obtenerProductos(): array
{
    return $_SESSION['productos'] ?? [];
}
function guardarProducto(string $nombre, string $categoria, float $precio, int $stock, string $descripcion)
{
    $id = count(obtenerProductos()) + 1;
 
    $_SESSION['productos'][] = [
        'id'          => $id,
        'nombre'      => $nombre,
        'categoria'   => $categoria,
        'precio'      => $precio,
        'stock'       => $stock,
        'descripcion' => $descripcion,
    ];
 
    return $id;
}


//Busca el producto
function buscarProductoPorId(int $id): ?array
{
    foreach (obtenerProductos() as $producto) {
        if ($producto['id'] === $id) {
            return $producto;
        }
    }

    return null;
}