<?php
session_start();   // Las sesiones guardan los datos del usuario en el servidor

// Si ya está autenticado, no tiene sentido mostrar el login
if (isset($_SESSION["usuario"])) {
    header("Location: panel.php");
    exit;
}


// Usuario, contraseña y su rol
$usuarios = [
    "admin"     => ["password" => 'admin123', "rol" => "Administrador"],
    "tecnico01" => ["password" => 'tecnico123', "rol" => "Técnico"],
    "cliente01" => ["password" => 'cliente123', "rol" => "Cliente"],
];

$error = "";
//
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario  = trim($_POST["usuario"] ?? "");
    $password = $_POST["password"] ?? "";

    // Comprobar usuario y contraseña
    if (isset($usuarios[$usuario]) && $usuarios[$usuario]["password"] === $password) {
        $_SESSION["usuario"] = $usuario;
        $_SESSION["rol"] = $usuarios[$usuario]["rol"];
        header("Location: panel.php");
        exit;
    }
    $error = "Usuario o contraseña incorrectos.";

    if($password=== "") {
        $error = "La contraseña no puede estar vacía.";

    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login · Soporte Informático</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
  <main class="container my-4" style="max-width: 420px;">
    <h1 class="h3">Soporte Informático</h1>

    <form method="post" class="card card-body">
      <div class="mb-3">
        <label for="usuario" class="form-label">Usuario</label>
        <input type="text" id="usuario" name="usuario" class="form-control"  >
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Contraseña</label>
        <input type="password" id="password" name="password" class="form-control" >
      </div>
      <button type="submit" class="btn btn-primary">Iniciar sesión</button>
    </form>

    <?php if ($error !== ""): ?>
      <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
  </main>
</body>
</html>