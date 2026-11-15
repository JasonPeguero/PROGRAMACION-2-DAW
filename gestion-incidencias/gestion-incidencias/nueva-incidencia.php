<?php
require "funciones.php";
// Solo pueden crear incidencias los clientes y el administrador
exigir_rol(["Cliente", "Administrador"]);

$rol = $_SESSION["rol"];
$titulo = "";
$descripcion = "";
$prioridad = "Media";
$cliente = "";
$tecnico = "";
$errores = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!token_valido()) {
        error_pagina(400, "La petición no es válida. Vuelve a intentarlo.");
    }

    $titulo      = trim($_POST["titulo"] ?? "");
    $descripcion = trim($_POST["descripcion"] ?? "");
    $prioridad   = $_POST["prioridad"] ?? "";

    // Un cliente solo puede crear incidencias a su nombre y sin técnico.
    // El administrador elige cliente y técnico.
    if ($rol === "Cliente") {
        $cliente = $_SESSION["usuario"];
        $tecnico = "";
    } else {
        $cliente = $_POST["cliente"] ?? "";
        $tecnico = $_POST["tecnico"] ?? "";
    }

    // Validaciones
    if ($titulo === "") {
        $errores[] = "El título es obligatorio.";
    } elseif (strlen($titulo) > 100) {
        $errores[] = "El título no puede tener más de 100 caracteres.";
    }
    if ($descripcion === "") {
        $errores[] = "La descripción es obligatoria.";
    }
    if (!in_array($prioridad, PRIORIDADES, true)) {
        $errores[] = "La prioridad no es válida.";
    }
    if (!in_array($cliente, usuarios_con_rol("Cliente"), true)) {
        $errores[] = "Debes elegir un cliente válido.";
    }
    if ($tecnico !== "" && !in_array($tecnico, usuarios_con_rol("Técnico"), true)) {
        $errores[] = "El técnico elegido no es válido.";
    }

    // Si todo está bien, guardamos
    if (count($errores) === 0) {
        $lista = cargar_incidencias();
        $lista[] = [
            "id"            => siguiente_id($lista),
            "titulo"        => $titulo,
            "descripcion"   => $descripcion,
            "cliente"       => $cliente,
            "tecnico"       => $tecnico,
            "prioridad"     => $prioridad,
            "estado"        => "Pendiente",
            "fecha"         => date("Y-m-d H:i"),
            "observaciones" => [],
        ];
        guardar_incidencias($lista);
        poner_mensaje("La incidencia se ha creado correctamente.");
        header("Location: incidencias.php");
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Nueva incidencia · Soporte Informático</title>
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

<h1 class="h3">Nueva incidencia</h1>
<p class="text-muted">Los campos marcados con <span class="obligatorio">*</span> son obligatorios.</p>

<?php if (count($errores) > 0): ?>
  <div class="alert alert-danger" role="alert">
    <p class="mb-1"><strong>Revisa el formulario:</strong></p>
    <ul class="mb-0">
      <?php foreach ($errores as $error): ?>
        <li><?= e($error) ?></li>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<form method="post" class="card card-body">
  <?= campo_token() ?>

  <div class="mb-3">
    <label for="titulo" class="form-label">Título <span class="obligatorio">*</span></label>
    <input type="text" id="titulo" name="titulo" class="form-control" maxlength="100" value="<?= e($titulo) ?>" required>
  </div>

  <div class="mb-3">
    <label for="descripcion" class="form-label">Descripción <span class="obligatorio">*</span></label>
    <textarea id="descripcion" name="descripcion" class="form-control" rows="4" required><?= e($descripcion) ?></textarea>
  </div>

  <div class="mb-3">
    <label for="prioridad" class="form-label">Prioridad <span class="obligatorio">*</span></label>
    <select id="prioridad" name="prioridad" class="form-select" required>
      <?php foreach (PRIORIDADES as $p): ?>
        <option value="<?= e($p) ?>" <?= $p === $prioridad ? "selected" : "" ?>><?= e($p) ?></option>
      <?php endforeach; ?>
    </select>
  </div>

  <?php if ($rol === "Administrador"): ?>
    <div class="mb-3">
      <label for="cliente" class="form-label">Cliente <span class="obligatorio">*</span></label>
      <select id="cliente" name="cliente" class="form-select" required>
        <option value="">Selecciona un cliente</option>
        <?php foreach (usuarios_con_rol("Cliente") as $c): ?>
          <option value="<?= e($c) ?>" <?= $c === $cliente ? "selected" : "" ?>><?= e($c) ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <div class="mb-3">
      <label for="tecnico" class="form-label">Técnico asignado</label>
      <select id="tecnico" name="tecnico" class="form-select">
        <option value="">Sin asignar</option>
        <?php foreach (usuarios_con_rol("Técnico") as $t): ?>
          <option value="<?= e($t) ?>" <?= $t === $tecnico ? "selected" : "" ?>><?= e($t) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  <?php endif; ?>

  <div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary">Crear incidencia</button>
    <a href="incidencias.php" class="btn btn-secondary">Cancelar</a>
  </div>
</form>
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>