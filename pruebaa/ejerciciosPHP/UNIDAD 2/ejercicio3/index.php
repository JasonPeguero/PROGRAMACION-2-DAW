<?php

require_once 'funciones.php';

$errores = [];
$resumen = null;
$alertas = [];
$datos = [
    'nombre' => '', 'cliente' => '', 'desarrolladores' => '',
    'horasEstimadas' => '', 'horasRealizadas' => '', 'precio' => '',
    'presupuesto' => '', 'estado' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($datos as $campo => $_) {
        $datos[$campo] = trim((string) ($_POST[$campo] ?? ''));
    }

    // Conversión de tipos
    $nombre          = $datos['nombre'];
    $cliente         = $datos['cliente'];
    $desarrolladores = convertirEntero($datos['desarrolladores']);
    $horasEstimadas  = convertirNumero($datos['horasEstimadas']);
    $horasRealizadas = convertirNumero($datos['horasRealizadas']);
    $precioHora      = convertirNumero($datos['precio']);
    $presupuesto     = convertirNumero($datos['presupuesto']);
    $estado          = $datos['estado'];

    // Validación
    $errores = validarDatos(
        $nombre, $cliente, $desarrolladores, $horasEstimadas,
        $horasRealizadas, $precioHora, $presupuesto, $estado
    );

    // Cálculos
    if (empty($errores)) {
        $costeEstimado  = calcularCoste($horasEstimadas, $precioHora);
        $costeActual    = calcularCoste($horasRealizadas, $precioHora);
        $horasRestantes = calcularHorasRestantes($horasEstimadas, $horasRealizadas);
        $porcentaje     = calcularPorcentaje($horasRealizadas, $horasEstimadas);

        // Alertas
        $alertas[] = comprobarPresupuesto($costeActual, $costeEstimado, $presupuesto);
        $alertaHoras = comprobarHoras($horasRealizadas, $horasEstimadas);
        if ($alertaHoras !== null) {
            $alertas[] = $alertaHoras;
        }

        $resumen = generarResumen(
            $nombre, $cliente, $desarrolladores, $estado,
            $horasEstimadas, $horasRealizadas, $precioHora, $presupuesto,
            $costeEstimado, $costeActual, $horasRestantes, $porcentaje
        );
    }
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estado económico de proyectos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
<div class="container-sm mt-5 mb-5">
    <h1 class="mb-4">Estado económico de proyectos</h1>

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
            <label for="nombre" class="form-label">Nombre del proyecto<span>*</span></label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo e($datos['nombre']); ?>">
        </div>
        <div class="mb-3">
            <label for="cliente" class="form-label">Cliente<span>*</span></label>
            <input type="text" class="form-control" id="cliente" name="cliente" value="<?php echo e($datos['cliente']); ?>">
        </div>
        <div class="mb-3">
            <label for="desarrolladores" class="form-label">Número de desarrolladores<span>*</span></label>
            <input type="text" class="form-control" id="desarrolladores" name="desarrolladores" value="<?php echo e($datos['desarrolladores']); ?>">
        </div>
        <div class="mb-3">
            <label for="horasEstimadas" class="form-label">Horas estimadas<span>*</span></label>
            <input type="text" class="form-control" id="horasEstimadas" name="horasEstimadas" value="<?php echo e($datos['horasEstimadas']); ?>">
        </div>
        <div class="mb-3">
            <label for="horasRealizadas" class="form-label">Horas realizadas<span>*</span></label>
            <input type="text" class="form-control" id="horasRealizadas" name="horasRealizadas" value="<?php echo e($datos['horasRealizadas']); ?>">
        </div>
        <div class="mb-3">
            <label for="precio" class="form-label">Precio/hora (€)<span>*</span></label>
            <input type="text" class="form-control" id="precio" name="precio" value="<?php echo e($datos['precio']); ?>">
        </div>
        <div class="mb-3">
            <label for="presupuesto" class="form-label">Presupuesto máximo (€)<span>*</span></label>
            <input type="text" class="form-control" id="presupuesto" name="presupuesto" value="<?php echo e($datos['presupuesto']); ?>">
        </div>
        <div class="mb-3">
            <label for="estado" class="form-label">Estado del proyecto<span>*</span></label>
            <select class="form-select" id="estado" name="estado">
                <option value="">-- Selecciona un estado --</option>
                <?php foreach (ESTADOS as $opcion): ?>
                    <option value="<?php echo e($opcion); ?>" <?php echo $datos['estado'] === $opcion ? 'selected' : ''; ?>>
                        <?php echo e($opcion); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Calcular</button>
    </form>

    <?php foreach ($alertas as $alerta): ?>
        <div class="alert alert-<?php echo e($alerta['tipo']); ?> mt-4 mb-0 fw-bold">
            <?php echo e($alerta['mensaje']); ?>
        </div>
    <?php endforeach; ?>

    <?php if ($resumen !== null): ?>
        <pre class="mt-4"><?php echo e($resumen); ?></pre>
    <?php endif; ?>
</div>
</body>
</html>