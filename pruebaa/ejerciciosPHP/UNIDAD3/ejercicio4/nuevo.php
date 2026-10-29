<?php

require_once 'datos.php';
require_once 'funciones.php';

$errores = [];
$nombre = $categoria = $precio = $stock = $descripcion = '';

if (isset($_POST['registrar'])) {
    $nombre      = trim((string) ($_POST['Nombre'] ?? ''));
    $categoria   = trim((string) ($_POST['Categoria'] ?? ''));
    $precio      = trim((string) ($_POST['Precio'] ?? ''));
    $stock       = trim((string) ($_POST['Stock'] ?? ''));
    $descripcion = trim((string) ($_POST['Descripcion'] ?? ''));

    $errores = validarFormulario($nombre, $categoria, $precio, $stock, $descripcion);

    if (empty($errores)) {
        $id = guardarProducto($nombre, $categoria, (float) $precio, (int) $stock, $descripcion);

        header('Location: detalle.php?id=' . $id . '&creado=1');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ejercicio4</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<div class="container-sm">
    <h1 class="mb-4">Nuevo producto</h1>

    <p class="mb-4"><a href="index.php">Inicio</a>  
    <a href="productos.php">lista de productos</a></p>

    <?php if (!empty($errores)): ?>
        <div class="mb-3">
            <ul>
                <?php foreach ($errores as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="Nombre" class=" mb-1">Nombre del producto<span>*</span></label>
            <input type="text" class="w-100" id="Nombre" name="Nombre"  required value="<?php echo htmlspecialchars($nombre); ?>">
        </div>
        <div class="mb-3">
            <label for="Categoria" class="mb-1">Categoria<span>*</span></label>
            <input type="text" class="w-100" id="Categoria" name="Categoria" required value="<?php echo htmlspecialchars($categoria); ?>">
        </div>
        <div class="mb-3">
            <label for="Precio" class="mb-1">Precio<span>*</span></label>
            <input type="number" class="w-100" id="Precio" name="Precio" required value="<?php echo htmlspecialchars($precio); ?>">
        </div>
        <div class="mb-3">
            <label for="Stock" class="mb-1">Stock<span>*</span></label>
            <input type="number" class="w-100" id="Stock" name="Stock"  required value="<?php echo htmlspecialchars($stock); ?>">
        </div>
        <div class="mb-3">
            <label for="Descripcion" class="mb-1">Descripcion del producto<span>*</span></label>
            <input type="text" class="w-100" id="Descripcion" name="Descripcion" required value="<?php echo htmlspecialchars($descripcion); ?>">
        </div>

        <button type="submit" name="registrar">Registrar producto</button>
    </form>
</div>
</body>
</html>