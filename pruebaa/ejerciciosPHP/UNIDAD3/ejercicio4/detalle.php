<?php

require_once 'datos.php';
require_once 'funciones.php';

$producto = buscarProductoPorId((int) ($_GET['id'] ?? 0));

if ($producto === null) {
    http_response_code(404);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<div class="container-sm">
    <?php if ($producto === null): ?>
        <h1 class="mb-4">Producto no encontrado</h1>
        <div class="mb-3">No existe ningún producto con ese identificador.</div>
    <?php else: ?>
        <h1 class="mb-4"><?php echo htmlspecialchars($producto['nombre']); ?></h1>

        <?php if (isset($_GET['creado'])): ?>
            <div class="mb-3">El producto se ha registrado correctamente.</div>
        <?php endif; ?>

        <table class="mb-4">
            <tr>
                <th>ID</th><td><?php echo $producto['id']; ?></td></tr>
            <tr>
                <th>Nombre</th><td><?php echo htmlspecialchars($producto['nombre']); ?></td>
            </tr>
            <tr>
                <th>Categoría</th><td><?php echo htmlspecialchars($producto['categoria']); ?></td>
            </tr>
            <tr>
                <th>Precio</th><td><?php echo number_format($producto['precio'], 2, ',', '.'); ?> €</td>
            </tr>
            <tr>
                <th>Stock</th><td><?php echo $producto['stock']; ?></td></tr>
            <tr>
                <th>Descripción</th><td><?php echo nl2br(htmlspecialchars($producto['descripcion'])); ?></td>
            </tr>
        </table>
    <?php endif; ?>

    <a href="productos.php">Volver al listado</a>
</div>
</body>
</html>