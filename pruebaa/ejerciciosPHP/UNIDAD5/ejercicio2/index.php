<?php

require "datos.php";
require "funciones.php";

$totalProyectos = count(obtenerProyectos());
$estados = $_GET["estado"] ?? "";
$proyectos = filtrarEstado(obtenerProyectos(), $estados);

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Proyectos</title>
    <link rel="stylesheet" href="estilo.css">
</head>

<body>

<h1>Listado de proyectos</h1>
<form method="get" action="">
    <div class="mb-3">
        <label for="Estado" class="form-label">Estado<span>*</span></label>
            <select class="form-select" id="estado" name="estado">
                <option value="">Seleccione un estado</option>
                <?php foreach (ESTADOS as $opcion): ?>
                <option value="<?php echo htmlspecialchars($opcion); ?>" <?php echo $estados == $opcion ? 'selected' : ''; ?>>
                <?php echo htmlspecialchars($opcion); ?>
                </option>
                <?php endforeach; ?>
            </select>
    </div>
    <diev class="mb-3">
        <button type="submit">Filtrar</button>
        </form>

    </div>

<?php if ($totalProyectos > 0): ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Proyecto</th>
            <th>Cliente</th>
            <th>Estado</th>
            <th>Ejecucion</th>
        </tr>

        <?php foreach ($proyectos as $proyecto): ?>
            <tr>
                <td><?= $proyecto["id"] ?></td>
                <td><?= $proyecto["proyecto"] ?></td>
                <td><?= $proyecto["cliente"] ?></td>
                <td><?= $proyecto["estado"] ?></td>
                <td><?= calcularProgreso($proyecto) ?>%</td>

            </tr>
        <?php endforeach; ?>
    </table>

<?php else: ?>

    <p>No hay ningun proyecto disponible.</p>

<?php endif; ?>

<br>

<p>
    Total de proyectos:
    <?= $totalProyectos ?>
</p>

</body>
</html>