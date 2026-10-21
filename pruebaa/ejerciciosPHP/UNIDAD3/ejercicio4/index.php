<?php

require_once 'funciones.php';

date_default_timezone_set('Europe/Madrid');

$errores         = [];
$textoIncidencia = null;
$nombre = $correo = $empresa = $asunto = $descripcion = $prioridad = $categoria = '';

if (isset($_POST['registrar'])) {
    $nombre      = trim((string) ($_POST['Nombre'] ?? ''));
    $correo      = trim((string) ($_POST['Categoría'] ?? ''));
    $empresa     = trim((string) ($_POST['Precio'] ?? ''));
    $asunto      = trim((string) ($_POST['Stock'] ?? ''));
    $descripcion = trim((string) ($_POST['Descripcion'] ?? ''));

    $errores = validarFormulario($nombre, $correo, $empresa, $asunto, $descripcion, $prioridad, $categoria);

    if (empty($errores)) {
        $secuencia = random_int(1, 100);

        $id    = generarIdIncidencia((int) date('Y'), $secuencia);
        $fecha = date('d/m/Y H:i');

        $textoIncidencia = mostrarIncidencia(
            $id, $fecha, $nombre, $correo, $empresa, $asunto,
            $descripcion, $prioridad, $categoria, ESTADO_INICIAL
        );
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
<div class="container-sm mt-5 mb-5">
    <h1 class="mb-4">Registrar productos</h1>

    <?php if (!empty($errores)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errores as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if ($textoIncidencia !== null): ?>
        <div class="alert alert-success fw-bold">El producto se ha registrado correctamente.</div>
        <pre><?php echo htmlspecialchars($textoIncidencia); ?></pre>
    <?php else: ?>
        <form method="POST" novalidate>
    <div class="mb-3">
        <label for="Nombre" class="form-label">Nombre del producto<span>*</span></label>
        <input type="text" class="form-control" id="Nombre" name="Nombre" value="<?php echo htmlspecialchars($nombre); ?>">
    </div>
    <div class="mb-3">
        <label for="Categoria" class="form-label">Categoría<span>*</span></label>
        <input type="text" class="form-control" id="Categoria" name="Categoria" value="<?php echo htmlspecialchars($categoria); ?>">
    </div>
    <div class="mb-3">
        <label for="Correo" class="form-label">Correo<span>*</span></label>
        <input type="email" class="form-control" id="Correo" name="Correo" value="<?php echo htmlspecialchars($correo); ?>">
    </div>
    <div class="mb-3">
        <label for="Empresa" class="form-label">Precio<span>*</span></label>
        <input type="text" class="form-control" id="Empresa" name="Empresa" value="<?php echo htmlspecialchars($empresa); ?>">
    </div>
    <div class="mb-3">
        <label for="Asunto" class="form-label">Stock<span>*</span></label>
        <input type="text" class="form-control" id="Asunto" name="Asunto" value="<?php echo htmlspecialchars($asunto); ?>">
    </div>
    <div class="mb-3">
        <label for="Descripcion" class="form-label">Descripción del producto<span>*</span></label>
        <input type="text" class="form-control" id="Descripcion" name="Descripcion" value="<?php echo htmlspecialchars($descripcion); ?>">
    </div>

            <button type="submit" name="registrar" class="btn btn-primary">Registrar producto</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>