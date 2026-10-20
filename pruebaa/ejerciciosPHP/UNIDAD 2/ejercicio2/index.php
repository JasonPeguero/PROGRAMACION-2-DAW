<?php

require_once 'funciones.php';

$errores = [];
$resumen = null;
$datos = [
    'nombre' => '', 'categoria' => '', 'bruto' => '',
    'pagas' => '', 'retencion' => '', 'complementos' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($datos as $campo => $_) {
        $datos[$campo] = trim((string) ($_POST[$campo] ?? ''));
    }

    // Conversión de tipos
    $nombre       = $datos['nombre'];
    $categoria    = $datos['categoria'];
    $brutoAnual   = (float) ($datos['bruto']);
    $pagas        = (float) ($datos['pagas']);
    $retencion    = (float) ($datos['retencion']);

    $complementos = ($datos['complementos'] === '') ? 0 : (float) ($datos['complementos']);

    // Validación
    $errores = validarDatos($nombre, $categoria, $brutoAnual, $pagas, $retencion, $complementos);

    // Cálculos
    if (empty($errores)) {
        $brutoPaga   = calcularBrutoPaga($brutoAnual, $pagas);
        $importeRet  = calcularRetencion($brutoPaga, $retencion);
        $netoPaga    = calcularNeto($brutoPaga, $importeRet, $complementos);
        $netoMensual = calcularNetoMensual($brutoPaga, $importeRet, $complementos, $pagas);

        $resumen = generarResumen(
            $nombre, $categoria, $brutoAnual, $pagas,
            $brutoPaga, $importeRet, $complementos, $netoPaga, $netoMensual
        );
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cálculo de nóminas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<div class="container-sm mt-5 mb-5">
    <h1 class="mb-4">Sistema de cálculo de nóminas</h1>

    <?php if (!empty($errores)): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php foreach ($errores as $error): ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre y apellidos<span>*</span></label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo e($datos['nombre']); ?>">
        </div>
        <div class="mb-3">
            <label for="categoria" class="form-label">Categoría profesional<span>*</span></label>
            <input type="text" class="form-control" id="categoria" name="categoria" value="<?php echo e($datos['categoria']); ?>">
        </div>
        <div class="mb-3">
            <label for="bruto" class="form-label">Salario bruto anual (€)<span>*</span></label>
            <input type="text" class="form-control" id="bruto" name="bruto" value="<?php echo e($datos['bruto']); ?>">
        </div>
        <div class="mb-3">
            <label for="pagas" class="form-label">Número de pagas<span>*</span></label>
            <input type="text" class="form-control" id="pagas" name="pagas" value="<?php echo e($datos['pagas']); ?>">
        </div>
        <div class="mb-3">
            <label for="retencion" class="form-label">Porcentaje de retención (%)<span>*</span></label>
            <input type="text" class="form-control" id="retencion" name="retencion" value="<?php echo e($datos['retencion']); ?>">
        </div>
        <div class="mb-3">
            <label for="complementos" class="form-label">Complementos mensuales (€)</label>
            <input type="text" class="form-control" id="complementos" name="complementos" value="<?php echo e($datos['complementos']); ?>">
        </div>

        <button type="submit" class="btn btn-primary">Calcular</button>
    </form>

    <?php if ($resumen !== null): ?>
        <pre ><?php echo e($resumen); ?></pre>
    <?php endif; ?>
</div>
</body>
</html>