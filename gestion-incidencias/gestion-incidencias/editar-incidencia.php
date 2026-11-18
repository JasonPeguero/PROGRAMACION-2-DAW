<?php
require "funciones.php";
// Solo pueden editar el administrador y los técnicos
exigir_rol(["Administrador", "Técnico"]);

$rol = $_SESSION["rol"];
$usuario = $_SESSION["usuario"];

// 1. Buscar la incidencia
$id = (int)($_GET["id"] ?? $_POST["id"] ?? 0);
$inc = buscar_incidencia($id);

if ($inc === null) {
    error_pagina(404, "La incidencia no existe.");
}
// Un técnico solo puede editar las incidencias que tiene asignadas
if (!puede_ver($inc)) {
    error_pagina(403, "No tienes permiso para editar esta incidencia.");
}

if (!isset($inc["observaciones"])) {
    $inc["observaciones"] = [];
}

$errores = [];
$observacion = "";

// 2. Si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (!token_valido()) {
        error_pagina(400, "La petición no es válida. Vuelve a intentarlo.");
    }

    // Estos campos pueden cambiarlos el administrador y el técnico
    $inc["estado"]    = $_POST["estado"] ?? "";
    $inc["prioridad"] = $_POST["prioridad"] ?? "";
    $observacion      = trim($_POST["observacion"] ?? "");

    // Estos campos SOLO puede cambiarlos el administrador
    if ($rol === "Administrador") {
        $inc["titulo"]      = trim($_POST["titulo"] ?? "");
        $inc["descripcion"] = trim($_POST["descripcion"] ?? "");
        $inc["cliente"]     = $_POST["cliente"] ?? "";
        $inc["tecnico"]     = $_POST["tecnico"] ?? "";
    }

    // Validaciones
    if (!in_array($inc["estado"], ESTADOS, true)) {
        $errores[] = "El estado no es válido.";
    }
    if (!in_array($inc["prioridad"], PRIORIDADES, true)) {
        $errores[] = "La prioridad no es válida.";
    }
    if ($rol === "Administrador") {
        if ($inc["titulo"] === "") {
            $errores[] = "El título es obligatorio.";
        } elseif (strlen($inc["titulo"]) > 100) {
            $errores[] = "El título no puede tener más de 100 caracteres.";
        }
        if ($inc["descripcion"] === "") {
            $errores[] = "La descripción es obligatoria.";
        }
        if (!in_array($inc["cliente"], usuarios_con_rol("Cliente"), true)) {
            $errores[] = "El cliente no es válido.";
        }
        if ($inc["tecnico"] !== "" && !in_array($inc["tecnico"], usuarios_con_rol("Técnico"), true)) {
            $errores[] = "El técnico no es válido.";
        }
    }

    // Guardar
    if (count($errores) === 0) {
        if ($observacion !== "") {
            $inc["observaciones"][] = "[" . date("Y-m-d H:i") . "] " . $usuario . ": " . $observacion;
        }
        actualizar_incidencia($inc);
        poner_mensaje("La incidencia " . $inc["id"] . " se ha actualizado correctamente.");
        header("Location: detalle-incidencia.php?id=" . $inc["id"]);
        exit;
    }
}

mostrar_cabecera("Editar incidencia");
?>
<h1 class="h3">Editar incidencia #<?= $inc["id"] ?></h1>
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
  <input type="hidden" name="id" value="<?= $inc["id"] ?>">

  <?php if ($rol === "Administrador"): ?>
    <!-- El administrador puede modificar todo -->
    <div class="mb-3">
      <label for="titulo" class="form-label">Título <span class="obligatorio">*</span></label>
      <input type="text" id="titulo" name="titulo" class="form-control" maxlength="100" value="<?= e($inc["titulo"]) ?>" required>
    </div>
    <div class="mb-3">
      <label for="descripcion" class="form-label">Descripción <span class="obligatorio">*</span></label>
      <textarea id="descripcion" name="descripcion" class="form-control" rows="4" required><?= e($inc["descripcion"]) ?></textarea>
    </div>
    <div class="mb-3">
      <label for="cliente" class="form-label">Cliente <span class="obligatorio">*</span></label>
      <select id="cliente" name="cliente" class="form-select" required>
        <?php foreach (usuarios_con_rol("Cliente") as $c): ?>
          <option value="<?= e($c) ?>" <?= $c === $inc["cliente"] ? "selected" : "" ?>><?= e($c) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="mb-3">
      <label for="tecnico" class="form-label">Técnico asignado</label>
      <select id="tecnico" name="tecnico" class="form-select">
        <option value="">Sin asignar</option>
        <?php foreach (usuarios_con_rol("Técnico") as $t): ?>
          <option value="<?= e($t) ?>" <?= $t === $inc["tecnico"] ? "selected" : "" ?>><?= e($t) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  <?php else: ?>
    <!-- El técnico solo ve estos datos, no los puede cambiar -->
    <dl>
      <dt>Título</dt><dd><?= e($inc["titulo"]) ?></dd>
      <dt>Descripción</dt><dd><?= nl2br(e($inc["descripcion"])) ?></dd>
      <dt>Cliente</dt><dd><?= e($inc["cliente"]) ?></dd>
    </dl>
  <?php endif; ?>

  <div class="row">
    <div class="col-12 col-md-6 mb-3">
      <label for="estado" class="form-label">Estado <span class="obligatorio">*</span></label>
      <select id="estado" name="estado" class="form-select" required>
        <?php foreach (ESTADOS as $est): ?>
          <option value="<?= e($est) ?>" <?= $est === $inc["estado"] ? "selected" : "" ?>><?= e($est) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-12 col-md-6 mb-3">
      <label for="prioridad" class="form-label">Prioridad <span class="obligatorio">*</span></label>
      <select id="prioridad" name="prioridad" class="form-select" required>
        <?php foreach (PRIORIDADES as $p): ?>
          <option value="<?= e($p) ?>" <?= $p === $inc["prioridad"] ? "selected" : "" ?>><?= e($p) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>

  <div class="mb-3">
    <label for="observacion" class="form-label">Añadir observación</label>
    <textarea id="observacion" name="observacion" class="form-control" rows="3"><?= e($observacion) ?></textarea>
  </div>

  <?php if (count($inc["observaciones"]) > 0): ?>
    <h2 class="h6">Observaciones anteriores</h2>
    <ul>
      <?php foreach ($inc["observaciones"] as $o): ?>
        <li><?= e($o) ?></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

  <div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary">Guardar cambios</button>
    <a href="incidencias.php" class="btn btn-secondary">Cancelar</a>
  </div>
</form>
<?php mostrar_pie(); ?>
