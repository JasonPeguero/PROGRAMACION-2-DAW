<?php
require "funciones.php";
exigir_login();

$rol = $_SESSION["rol"];

$id = (int)($_GET["id"] ?? 0);
$inc = buscar_incidencia($id);

if ($inc === null) {
    error_pagina(404, "La incidencia no existe.");
}
// Un cliente no puede ver incidencias de otros clientes,
// y un técnico solo las que tiene asignadas.
if (!puede_ver($inc)) {
    error_pagina(403, "No tienes permiso para ver esta incidencia.");
}

$observaciones = $inc["observaciones"] ?? [];

mostrar_cabecera("Incidencia " . $inc["id"]);
?>
<h1 class="h3">Incidencia #<?= $inc["id"] ?>: <?= e($inc["titulo"]) ?></h1>

<div class="card card-body mb-3">
  <dl class="row mb-0">
    <dt class="col-sm-3">Descripción</dt>
    <dd class="col-sm-9"><?= nl2br(e($inc["descripcion"])) ?></dd>

    <dt class="col-sm-3">Cliente</dt>
    <dd class="col-sm-9"><?= e($inc["cliente"]) ?></dd>

    <dt class="col-sm-3">Técnico asignado</dt>
    <dd class="col-sm-9"><?= e(texto_tecnico($inc)) ?></dd>

    <dt class="col-sm-3">Prioridad</dt>
    <dd class="col-sm-9"><span class="badge <?= clase_prioridad($inc["prioridad"]) ?>"><?= e($inc["prioridad"]) ?></span></dd>

    <dt class="col-sm-3">Estado</dt>
    <dd class="col-sm-9"><span class="badge <?= clase_estado($inc["estado"]) ?>"><?= e($inc["estado"]) ?></span></dd>

    <dt class="col-sm-3">Fecha de creación</dt>
    <dd class="col-sm-9"><?= e($inc["fecha"]) ?></dd>
  </dl>
</div>

<h2 class="h5">Observaciones</h2>
<?php if (count($observaciones) === 0): ?>
  <p class="text-muted">Todavía no hay observaciones.</p>
<?php else: ?>
  <ul class="list-group mb-3">
    <?php foreach ($observaciones as $o): ?>
      <li class="list-group-item"><?= e($o) ?></li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>

<div class="d-flex gap-2">
  <?php if ($rol === "Administrador" || $rol === "Técnico"): ?>
    <a href="editar-incidencia.php?id=<?= $inc["id"] ?>" class="btn btn-primary">Editar</a>
  <?php endif; ?>
  <a href="incidencias.php" class="btn btn-secondary">Volver al listado</a>
</div>
<?php mostrar_pie(); ?>
