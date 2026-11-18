<?php
require "funciones.php";   // De aquí salen la sesión y la lista de usuarios

// Si ya está autenticado, no tiene sentido mostrar el login
if (isset($_SESSION["usuario"])) {
    header("Location: panel.php");
    exit;
}

// Obtener la lista de usuarios desde el archivo JSON
$usuarios = lista_usuarios();
$error = "";

// Validar el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario  = trim($_POST["usuario"] ?? "");
    $password = $_POST["password"] ?? "";

    // Validar que el usuario y la contraseña esten bien
    if ($usuario === "" || $password === "") {
        $error = "Usuario o contraseña incorrecto.º ";
    } elseif (isset($usuarios[$usuario]) && $usuarios[$usuario]["password"] === $password) {
        session_regenerate_id(true);   // Cambia el id de sesión 
        $_SESSION["usuario"] = $usuario;
        $_SESSION["rol"] = $usuarios[$usuario]["rol"];
        header("Location: panel.php");
        exit;
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Iniciar sesion</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="estilos.css">
</head>
<body>
  <main class="container my-4">
    <div class="login-caja">
      <h1 class="h3 mb-3">Soporte Informatico</h1>

      <?php if ($error !== ""): ?>
        <div class="alert alert-danger" role="alert"><?= htmlspecialchars($error) ?></div>
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
        <button type="submit" class="btn btn-primary">Iniciar sesion</button>
      </form>
    </div>
  </main>
</body>
</html>