<?php

require_once 'funciones.php';

date_default_timezone_set('Europe/Madrid');

$errores         = [];
$textoIncidencia = null;
$nombre = $correo = $empresa = $asunto = $descripcion = $prioridad = $categoria = '';

if (isset($_POST['registrar'])) {
    $nombre      = trim((string) ($_POST['Nombre'] ?? ''));
    $correo      = trim((string) ($_POST['Correo'] ?? ''));
    $empresa     = trim((string) ($_POST['Empresa'] ?? ''));
    $asunto      = trim((string) ($_POST['Asunto'] ?? ''));
    $descripcion = trim((string) ($_POST['Descripcion'] ?? ''));
    $prioridad   = trim((string) ($_POST['Prioridad'] ?? ''));
    $categoria   = trim((string) ($_POST['Categoria'] ?? ''));

    $errores = validarFormulario($nombre, $correo, $empresa, $asunto, $descripcion, $prioridad, $categoria);

    if (empty($errores)) {
        // TODO: obtener el número secuencial real desde una base de datos.
        // Por ahora se usa un valor aleatorio, por lo que el ID podría repetirse.
        $secuencia = random_int(1, 99999);

        $id    = generarIdIncidencia((int) date('Y'), $secuencia);
        $fecha = date('d/m/Y H:i');

        // TODO: almacenar las incidencias en una base de datos.

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
    <title>ejercicio3</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<div class="container-sm mt-5 mb-5">
    <h1 class="mb-4">Registro de incidencias</h1>

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
        <div class="alert alert-success fw-bold">La incidencia se ha registrado correctamente.</div>
        <pre><?php echo htmlspecialchars($textoIncidencia); ?></pre>
    <?php else: ?>
        <form method="POST" novalidate>
    <div class="mb-3">
        <label for="Nombre" class="form-label">Nombre del cliente<span>*</span></label>
        <input type="text" class="form-control" id="Nombre" name="Nombre" value="<?php echo htmlspecialchars($nombre); ?>">
    </div>
    <div class="mb-3">
        <label for="Correo" class="form-label">Correo electrónico<span>*</span></label>
        <input type="email" class="form-control" id="Correo" name="Correo" value="<?php echo htmlspecialchars($correo); ?>">
    </div>
    <div class="mb-3">
        <label for="Empresa" class="form-label">Empresa<span>*</span></label>
        <input type="text" class="form-control" id="Empresa" name="Empresa" value="<?php echo htmlspecialchars($empresa); ?>">
    </div>
    <div class="mb-3">
        <label for="Asunto" class="form-label">Asunto<span>*</span></label>
        <input type="text" class="form-control" id="Asunto" name="Asunto" value="<?php echo htmlspecialchars($asunto); ?>">
    </div>
    <div class="mb-3">
        <label for="Descripcion" class="form-label">Descripción de la incidencia<span>*</span></label>
        <input type="text" class="form-control" id="Descripcion" name="Descripcion" value="<?php echo htmlspecialchars($descripcion); ?>">
    </div>
    <div class="mb-3">
        <label for="Prioridad" class="form-label">Prioridad<span>*</span></label>
            <select class="form-select" id="Prioridad" name="Prioridad">
                <option value="">Seleccione una prioridad</option>
                <?php foreach (PRIORIDADES as $opcion): ?>
                <option value="<?php echo htmlspecialchars($opcion); ?>" <?php echo $prioridad == $opcion ? : ''; ?>>
                <?php echo htmlspecialchars($opcion); ?>
                </option>
                <?php endforeach; ?>
            </select>
    </div>
    <div class="mb-3">
        <label for="Categoria" class="form-label">Categoría<span>*</span></label>
            <select class="form-select" id="Categoria" name="Categoria">
                <option value="">Pendiente</option>
                <?php foreach (CATEGORIAS as $opcion): ?>
                <option value="<?php echo htmlspecialchars($opcion); ?>" <?php echo $categoria == $opcion ? : ''; ?>>
                <?php echo htmlspecialchars($opcion); ?>
                </option>
                <?php endforeach; ?>
            </select>
    </div>

            <button type="submit" name="registrar" class="btn btn-primary">Registrar incidencia</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>