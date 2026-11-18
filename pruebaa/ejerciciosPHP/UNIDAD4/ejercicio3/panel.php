<?php
require "funciones.php";
exigir_login();

$usuario = $_SESSION["usuario"];
$rol = $_SESSION["rol"];

// Cogemos solo las incidencias que este usuario puede ver
$visibles = [];
foreach (cargar_incidencias() as $inc) {
    if (puede_ver($inc)) {
        $visibles[] = $inc;
    }
}

// Contamos cuántas hay de cada estado
$contador = [];
foreach (ESTADOS as $estado) {
    $contador[$estado] = 0;
}
foreach ($visibles as $inc) {
    if (isset($contador[$inc["estado"]])) {
        $contador[$inc["estado"]]++;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Panel · Soporte Informático</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="estilos.css">
</head>
<body>
  <a href="#contenido" class="visually-hidden-focusable">Saltar al contenido</a>

  <!-- Menú de navegación varia por el rol -->
  <nav class="navbar navbar-expand-md navbar-dark bg-dark" aria-label="Navegación principal">
    <div class="container">
      <a class="navbar-brand" href="panel.php">Soporte Informatico</a>
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
        <span class="navbar-text me-md-3"><?= e($usuario) ?> (<?= e($rol) ?>)</span>
        <a class="btn btn-outline-light btn-sm" href="logout.php">Cerrar sesión</a>
      </div>
    </div>
  </nav>

  <main id="contenido" class="container my-4">
    <?php mostrar_mensaje(); ?>

    <h1 class="h3">Panel</h1>
    <p>Bienvenido, <?= e($usuario) ?>. Has iniciado sesión como <strong><?= e($rol) ?></strong>.</p>

    <h2 class="h5">Resumen de incidencias</h2>
    <div class="row g-3 mb-4">
      <?php foreach ($contador as $estado => $cantidad): ?>
        <div class="col-6 col-md-3">
          <div class="card text-center">
            <div class="card-body">
              <p class="display-6 mb-0"><?= $cantidad ?></p>
              <span class="badge <?= clase_estado($estado) ?>"><?= e($estado) ?></span>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="list-group">
      <a href="incidencias.php" class="list-group-item list-group-item-action">
        <?= $rol === "Administrador" ? "Ver todas las incidencias" : "Ver mis incidencias" ?>
      </a>
      <?php if ($rol === "Cliente" || $rol === "Administrador"): ?>
        <a href="nueva-incidencia.php" class="list-group-item list-group-item-action">Crear una incidencia nueva</a>
      <?php endif; ?>
      <?php if ($rol === "Administrador"): ?>
        <a href="usuarios.php" class="list-group-item list-group-item-action">Ver usuarios</a>
      <?php endif; ?>
    </div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>