<?php
require "funciones.php";

// Si ya está autenticado, no tiene sentido mostrar el login
if (isset($_SESSION["usuario"])) {
    header("Location: panel.php");
    exit;
}

$usuarios = lista_usuarios();
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario  = trim($_POST["usuario"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($usuario === "" || $password === "") {
        $error = "Debes escribir el usuario y la contraseña.";
    } elseif (isset($usuarios[$usuario]) && $usuarios[$usuario]["password"] === $password) {
        session_regenerate_id(true);   // Cambia el id de sesión por seguridad
        $_SESSION["usuario"] = $usuario;
        $_SESSION["rol"] = $usuarios[$usuario]["rol"];
        header("Location: panel.php");
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}

mostrar_cabecera("Iniciar sesión", false);
?>
<div class="login-caja">
  <h1 class="h3 mb-3">Soporte Informático</h1>

  <?php if ($error !== ""): ?>
    <div class="alert alert-danger" role="alert"><?= e($error) ?></div>
  <?php endif; ?>

  <form method="post" class="card card-body">
    <div class="mb-3">
      <label for="usuario" class="form-label">Usuario</label>
      <input type="text" id="usuario" name="usuario" class="form-control" autocomplete="username" required>
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Contraseña</label>
      <input type="password" id="password" name="password" class="form-control" autocomplete="current-password" required>
    </div>
    <button type="submit" class="btn btn-primary">Iniciar sesión</button>
  </form>
</div>
<?php mostrar_pie(); ?>
