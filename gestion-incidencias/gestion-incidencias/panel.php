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

mostrar_cabecera("Panel");
?>
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

<h2 class="h5">¿Qué quieres hacer?</h2>
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
<?php mostrar_pie(); ?>
