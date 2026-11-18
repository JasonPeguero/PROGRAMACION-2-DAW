<?php
require "funciones.php";
// Solo el administrador puede ver esta página
exigir_rol(["Administrador"]);

$rol = $_SESSION["rol"];

$usuarios = lista_usuarios();
$incidencias = cargar_incidencias();

// Contamos cuántas incidencias tiene cada usuario
function contar_incidencias($incidencias, $nombre) {
    $total = 0;
    foreach ($incidencias as $inc) {
        if ($inc["cliente"] === $nombre || $inc["tecnico"] === $nombre) {
            $total++;
        }
    }
    return $total;
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Usuarios · Soporte Informático</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="estilos.css">
</head>
<body>
  <a href="#contenido" class="visually-hidden-focusable">Saltar al contenido</a>

  <!-- Menú de navegación (cambia según el rol) -->
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

<h1 class="h3">Usuarios</h1>

<div class="table-responsive">
  <table class="table table-striped align-middle">
    <caption class="visually-hidden">Listado de usuarios</caption>
    <thead>
      <tr>
        <th scope="col">Usuario</th>
        <th scope="col">Rol</th>
        <th scope="col">Incidencias relacionadas</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($usuarios as $nombre => $datos): ?>
        <tr>
          <th scope="row"><?= e($nombre) ?></th>
          <td><?= e($datos["rol"]) ?></td>
          <td><?= contar_incidencias($incidencias, $nombre) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>