<?php
require "funciones.php";
exigir_login();
// Solo un administrador o el técnico pueden ver la incidencia
$rol = $_SESSION["rol"];

// Buscar la incidencia por id
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

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Incidencia <?= $inc["id"] ?> · Soporte Informático</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="estilos.css">
</head>
<body>
  <a href="#contenido" class="visually-hidden-focusable">Saltar al contenido</a>

  <!-- Menú de navegación varia segun el rol -->
  <nav class="navbar navbar-expand-md navbar-dark bg-dark" aria-label="Navegación principal">
    <div class="container">
      <a class="navbar-brand" href="panel.php">Soporte Informático</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu" aria-controls="menu" aria-expanded="false" aria-label="Mostrar u ocultar el menú">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="menu">
        <ul class="navbar-nav me-auto">
          <li class="nav-item"><a class="nav-link" href="panel.php">Panel</a></li>
          <li class="nav-item"><a class="nav-link" href="incidencias.php"><?= $rol === "Administrador" ? "Incidencias" : "Mis incidencias" ?></a></li>
          <?php if ($rol === "Cliente" || $rol === "Administrador"): ?>
            <li class="nav-item"><a class="nav-link" href="nueva-incidencia.php">Nueva incidencia</a></li>
          <?php endif; ?>
          <?php if ($rol === "Administrador"): ?>
            <li class="nav-item"><a class="nav-link" href="usuarios.php">Usuarios</a></li>
          <?php endif; ?>
        </ul>
        <span class="navbar-text me-md-3"><?= e($_SESSION["usuario"]) ?> (<?= e($rol) ?>)</span>
        <a class="btn btn-outline-light btn-sm" href="logout.php">Cerrar sesión</a>
      </div>
    </div>
  </nav>

  <main id="contenido" class="container my-4">
    <?php mostrar_mensaje(); ?>

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

<!--- Solo un administrador o el técnico asignado pueden editar la incidencia -->  
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
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>