<?php
require "funciones.php";
exigir_login();

$rol = $_SESSION["rol"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    exigir_rol(["Administrador"]);

    if (!token_valido()) {
        error_pagina(400, "La petición no es válida. Vuelve a intentarlo.");
    }

    $id = (int)($_POST["id"] ?? 0);
    $lista = cargar_incidencias();
    $nueva_lista = [];
    foreach ($lista as $inc) {
        if ($inc["id"] !== $id) {
            $nueva_lista[] = $inc;
        }
    }

    if (count($nueva_lista) < count($lista)) {
        guardar_incidencias($nueva_lista);
        poner_mensaje("La incidencia " . $id . " se ha eliminado correctamente.");
    } else {
        poner_mensaje("La incidencia no existe.", "danger");
    }
    header("Location: incidencias.php");
    exit;
}

// ---------------------------------------------------------------
// PREFERENCIAS GUARDADAS EN COOKIES
// - por_pagina: cuántas incidencias se ven en cada página
// - vista: "tabla" o "tarjetas"
// ---------------------------------------------------------------
$opciones_por_pagina = [5, 10, 20];
$opciones_vista = ["tabla", "tarjetas"];

// Valores por defecto
$por_pagina = 10;
$vista = "tabla";

// Si hay cookie guardada (y es válida), la usamos
if (isset($_COOKIE["por_pagina"]) && in_array((int)$_COOKIE["por_pagina"], $opciones_por_pagina, true)) {
    $por_pagina = (int)$_COOKIE["por_pagina"];
}
if (isset($_COOKIE["vista"]) && in_array($_COOKIE["vista"], $opciones_vista, true)) {
    $vista = $_COOKIE["vista"];
}

// Si el usuario ha pulsado "Guardar preferencias", guardamos las cookies (30 días)
if (isset($_GET["guardar"])) {
    $nuevo_por_pagina = (int)($_GET["por_pagina"] ?? 0);
    if (in_array($nuevo_por_pagina, $opciones_por_pagina, true)) {
        $por_pagina = $nuevo_por_pagina;
        setcookie("por_pagina", $por_pagina, time() + 60 * 60 * 24 * 30, "/");
    }
    $nueva_vista = $_GET["vista"] ?? "";
    if (in_array($nueva_vista, $opciones_vista, true)) {
        $vista = $nueva_vista;
        setcookie("vista", $vista, time() + 60 * 60 * 24 * 30, "/");
    }
}

// ---------------------------------------------------------------
// LISTADO: solo las incidencias que este usuario puede ver
// ---------------------------------------------------------------
$visibles = [];
foreach (cargar_incidencias() as $inc) {
    if (puede_ver($inc)) {
        $visibles[] = $inc;
    }
}
$visibles = array_reverse($visibles);   // las más nuevas primero

// Paginación
$total = count($visibles);
$paginas = max(1, (int)ceil($total / $por_pagina));
$pagina = (int)($_GET["pagina"] ?? 1);
if ($pagina < 1) { $pagina = 1; }
if ($pagina > $paginas) { $pagina = $paginas; }
$de_esta_pagina = array_slice($visibles, ($pagina - 1) * $por_pagina, $por_pagina);

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Incidencias · Soporte Informático</title>
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

<div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
  <h1 class="h3 mb-0"><?= $rol === "Administrador" ? "Incidencias" : "Mis incidencias" ?></h1>
  <?php if ($rol === "Cliente" || $rol === "Administrador"): ?>
    <a href="nueva-incidencia.php" class="btn btn-primary">Nueva incidencia</a>
  <?php endif; ?>
</div>

<!-- Preferencias (se guardan en cookies) -->
<form method="get" action="incidencias.php" class="card card-body mb-3">
  <input type="hidden" name="guardar" value="1">
  <div class="row g-2 align-items-end">
    <div class="col-12 col-sm-4">
      <label for="por_pagina" class="form-label">Incidencias por página</label>
      <select id="por_pagina" name="por_pagina" class="form-select">
        <?php foreach ($opciones_por_pagina as $n): ?>
          <option value="<?= $n ?>" <?= $n === $por_pagina ? "selected" : "" ?>><?= $n ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-12 col-sm-4">
      <label for="vista" class="form-label">Vista</label>
      <select id="vista" name="vista" class="form-select">
        <?php foreach ($opciones_vista as $v): ?>
          <option value="<?= $v ?>" <?= $v === $vista ? "selected" : "" ?>><?= ucfirst($v) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-12 col-sm-4">
      <button type="submit" class="btn btn-outline-primary w-100">Guardar preferencias</button>
    </div>
  </div>
</form>

<?php if ($total === 0): ?>
  <div class="alert alert-info" role="status">No hay incidencias que mostrar.</div>

<?php elseif ($vista === "tabla"): ?>
  <div class="table-responsive">
    <table class="table table-striped align-middle">
      <caption class="visually-hidden">Listado de incidencias</caption>
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Título</th>
          <th scope="col">Cliente</th>
          <th scope="col">Técnico</th>
          <th scope="col">Prioridad</th>
          <th scope="col">Estado</th>
          <th scope="col">Fecha</th>
          <th scope="col">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($de_esta_pagina as $inc): ?>
          <tr>
            <th scope="row"><?= $inc["id"] ?></th>
            <td><?= e($inc["titulo"]) ?></td>
            <td><?= e($inc["cliente"]) ?></td>
            <td><?= e(texto_tecnico($inc)) ?></td>
            <td><span class="badge <?= clase_prioridad($inc["prioridad"]) ?>"><?= e($inc["prioridad"]) ?></span></td>
            <td><span class="badge <?= clase_estado($inc["estado"]) ?>"><?= e($inc["estado"]) ?></span></td>
            <td><?= e($inc["fecha"]) ?></td>
            <td class="text-nowrap"><?php mostrar_acciones($inc); ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

<?php else: ?>
  <div class="row g-3">
    <?php foreach ($de_esta_pagina as $inc): ?>
      <div class="col-12 col-md-6 col-lg-4">
        <div class="card h-100">
          <div class="card-body">
            <h2 class="h6 card-title">#<?= $inc["id"] ?> · <?= e($inc["titulo"]) ?></h2>
            <p class="mb-2">
              <span class="badge <?= clase_prioridad($inc["prioridad"]) ?>"><?= e($inc["prioridad"]) ?></span>
              <span class="badge <?= clase_estado($inc["estado"]) ?>"><?= e($inc["estado"]) ?></span>
            </p>
            <p class="small text-muted mb-0">
              Cliente: <?= e($inc["cliente"]) ?><br>
              Técnico: <?= e(texto_tecnico($inc)) ?><br>
              Fecha: <?= e($inc["fecha"]) ?>
            </p>
          </div>
          <div class="card-footer"><?php mostrar_acciones($inc); ?></div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php endif; ?>

<?php if ($paginas > 1): ?>
  <nav aria-label="Paginación" class="mt-4">
    <ul class="pagination flex-wrap">
      <?php for ($i = 1; $i <= $paginas; $i++): ?>
        <li class="page-item <?= $i === $pagina ? "active" : "" ?>">
          <a class="page-link" href="incidencias.php?pagina=<?= $i ?>" <?= $i === $pagina ? 'aria-current="page"' : "" ?>><?= $i ?></a>
        </li>
      <?php endfor; ?>
    </ul>
  </nav>
<?php endif; ?>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>