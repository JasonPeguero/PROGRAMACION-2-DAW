 <?php

require_once 'datos.php';
require_once 'funciones.php';

$errores = [];

$nombre    = trim((string) ($_GET['nombre'] ?? ''));
$categoria = trim((string) ($_GET['categoria'] ?? ''));
$precioMax = trim((string) ($_GET['precioMax'] ?? ''));

w
if ($precioMax !== '' && (!is_numeric($precioMax) || $precioMax < 0)) {
    $errores[] = 'El precio maximo debe ser un numero mayor o igual que cero.';
    $precioMax = '';
}

$todos     = obtenerProductos();
$productos = filtrarProductos($todos, $nombre, $categoria, $precioMax);
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
<main class="container-sm">
    <h1 class="mb-4">Productos</h1>

    <nav class="d-flex gap-3 mb-4">
        <a href="index.php">Inicio</a>
        <a href="nuevo.php">Nuevo producto</a>
    </nav>

    <?php if (!empty($errores)): ?>
        <ul class="errors mb-3">
            <?php foreach ($errores as $error): ?>
                <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="GET" class="row g-3 align-items-end mb-4">
        <div class="col-sm-6 col-md-3">
            <label for="nombre" class="d-block mb-1">Nombre</label>
            <input type="text" class="w-100" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>">
        </div>
        <div class="col-sm-6 col-md-3">
            <label for="categoria" class="d-block mb-1">Categoria</label>
            <select class="w-100" id="categoria" name="categoria">
                <option value="">Todas</option>
                //Genera la categoria en el selector a partir de la que se le pone al prodcuto al crearlo
                <?php foreach (Categorias($todos) as $opcion): ?>
                    <option value="<?php echo htmlspecialchars($opcion); ?>" <?php echo $categoria === $opcion ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($opcion); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="col-sm-6 col-md-3">
            <label for="precioMax" class="d-block mb-1">Precio maximo</label>
            <input type="text" class="w-100" id="precioMax" name="precioMax" value="<?php echo htmlspecialchars($precioMax); ?>">
        </div>
        <div class="col-sm-6 col-md-3 d-flex align-items-center gap-3">
            <button type="submit">Buscar</button>   
        </div>
    </form>

    <?php if (empty($productos)): ?>
    <?php else: ?>
        <div class="table-responsive">
        <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Categoria</th>
                <th class="text-end">Precio</th>
                <th class="text-end">Stock</th>
                <th class="text-end"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $producto): ?>
             <tr>
                <td><?php echo $producto['id']; ?></td>
                <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                <td><?php echo htmlspecialchars($producto['categoria']); ?></td>
                <td class="text-end"><?php echo number_format($producto['precio'], 2, ',', '.'); ?> €</td>
                <td class="text-end"><?php echo $producto['stock']; ?></td>
                <td class="text-end">  <a href="detalle.php?id=<?php echo $producto['id']; ?>">Ver detalle</a> <!-- abre una nueva pagina con los detalles del producto segun su id --> </td>
            </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</main>
</body>
</html>