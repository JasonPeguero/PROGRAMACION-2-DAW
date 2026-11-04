<?php
// Guarda, modifica o elimina las cookies de preferencias.
// Esto debe hacerse antes de escribir cualquier HTML.

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (isset($_POST["restablecer"])) {
        // ELIMINAR: se envía cada cookie con una fecha ya pasada
        setcookie("usuario", "", time() - 3600);
        setcookie("idioma", "", time() - 3600);
        setcookie("registros", "", time() - 3600);
        setcookie("vista", "", time() - 3600);
        header("Location: index.php");
        exit;
    }

    $usuario = trim($_POST["usuario"]);

    if ($usuario === "") {
        $error = "Escribe un nombre de usuario.";
    } else {
        // GUARDAR / ACTUALIZAR: si la cookie ya existe, setcookie() la sobrescribe
        $caduca = time() + 60 * 60 * 24 * 30;   // 30 días
        setcookie("usuario", $usuario, $caduca);
        setcookie("idioma", $_POST["idioma"], $caduca);
        setcookie("registros", $_POST["registros"], $caduca);
        setcookie("vista", $_POST["vista"], $caduca);
        header("Location: index.php");
        exit;
    }
}

// Valores que se muestran en el formulario (cookie guardada o valor por defecto)
$usuario   = $_COOKIE["usuario"] ?? "";
$idioma    = $_COOKIE["idioma"] ?? "es";
$registros = $_COOKIE["registros"] ?? "5";
$vista     = $_COOKIE["vista"] ?? "lista";
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Preferencias</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="estilos.css">
</head>
<body>
  <main class="container contenedor my-4">
    <h1 class="h3">Preferencias</h1>
    <p><a href="index.php">← Volver al panel</a></p>

    <?php if ($error !== ""): ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="post" class="card card-body">
      <div class="mb-3">
        <label for="usuario" class="form-label">Nombre de usuario</label>
        <input type="text" id="usuario" name="usuario" class="form-control" value="<?= htmlspecialchars($usuario) ?>">
      </div>

      <div class="mb-3">
        <label for="idioma" class="form-label">Idioma</label>
        <select id="idioma" name="idioma" class="form-select">
          <option value="es" <?= $idioma === "es" ? "selected" : "" ?>>Español</option>
          <option value="en" <?= $idioma === "en" ? "selected" : "" ?>>English</option>
          <option value="fr" <?= $idioma === "fr" ? "selected" : "" ?>>Français</option>
        </select>
      </div>

      <div class="mb-3">
        <label for="registros" class="form-label">Registros a visualizar</label>
        <select id="registros" name="registros" class="form-select">
          <option value="5" <?= $registros === "5" ? "selected" : "" ?>>5</option>
          <option value="10" <?= $registros === "10" ? "selected" : "" ?>>10</option>
        </select>
      </div>

      <div class="mb-3">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="vista" id="lista" value="lista" <?= $vista === "lista" ? "checked" : "" ?>>
          <label class="form-check-label" for="lista">Lista</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="vista" id="tarjetas" value="tarjetas" <?= $vista === "tarjetas" ? "checked" : "" ?>>
          <label class="form-check-label" for="tarjetas">Tarjetas</label>
        </div>
      </div>

      <div class="d-flex gap-2">
        <button type="submit" class="btn btn-primary">Guardar</button>
        <button type="submit" name="restablecer" class="btn btn-outline-danger">Restablecer</button>
      </div>
    </form>
  </main>
</body>
</html>