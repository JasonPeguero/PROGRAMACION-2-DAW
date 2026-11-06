<?php
session_start();

// Comprobar si el usuario ha iniciado sesión
if (!isset($_SESSION["usuario"])) {
    header("Location: login.php");
    exit;
}

$usuario = $_SESSION["usuario"];
$rol = $_SESSION["rol"];

// Secciones y roles permitidos
$secciones = [
    "usuarios"        => ["titulo" => "Usuarios",        "roles" => ["Administrador"],            "texto" => "Gestión de usuarios de la aplicación."],
    "incidencias"     => ["titulo" => "Incidencias",     "roles" => ["Administrador", "Técnico"], "texto" => "Listado de todas las incidencias."],
    "configuracion"   => ["titulo" => "Configuración",   "roles" => ["Administrador"],            "texto" => "Ajustes generales de la aplicación."],
    "clientes"        => ["titulo" => "Clientes",        "roles" => ["Técnico"],                  "texto" => "Listado de clientes atendidos."],
    "informes"        => ["titulo" => "Informes",        "roles" => ["Administrador", "Técnico"], "texto" => "Informes de actividad del servicio."],
    "mis-incidencias" => ["titulo" => "Mis incidencias", "roles" => ["Cliente"],                  "texto" => "Incidencias que has abierto."],
    "mi-perfil"       => ["titulo" => "Mi perfil",       "roles" => ["Cliente"],                  "texto" => "Tus datos de cliente."],
];

// Muestra el menú de navegación según el rol del usuario
$menu = [];
foreach ($secciones as $clave => $seccion) {
    if (in_array($rol, $seccion["roles"])) {
        $menu[$clave] = $seccion["titulo"];
    }
}

// Comprobar si se ha pedido una sección y si el usuario tiene permiso para verla
$pedida = $_GET["seccion"] ?? null;
$error = "";
$seccion = null;

if ($pedida !== null) {
    if (!isset($secciones[$pedida])) {
        http_response_code(404);
        $error = "404 - Sección no encontrada";
    } elseif (!in_array($rol, $secciones[$pedida]["roles"])) {
        http_response_code(403);
        $error = "403 - Acceso no autorizado";
    } else {
        $seccion = $secciones[$pedida];
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
</head>
<body>
  <main class="container my-4" style="max-width: 720px;">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <span>Usuario: <strong><?= htmlspecialchars($usuario) ?></strong> (<?= htmlspecialchars($rol) ?>)</span>
      
    </div>

    <h1 class="h3">Panel</h1>
    <p>Bienvenido, <?= htmlspecialchars($usuario) ?>. Has iniciado sesión como <strong><?= htmlspecialchars($rol) ?></strong>.</p>

    <div class="list-group mb-3">
      <?php foreach ($menu as $clave => $titulo): ?>
        <a href="panel.php?seccion=<?= $clave ?>" class="list-group-item list-group-item-action"><?= $titulo ?></a>
      <?php endforeach; ?>
    </div>
    
    <?php if ($error !== ""): ?>
      <div class="alert alert-danger"><strong><?= $error ?></strong></div>
    <?php elseif ($seccion !== null): ?>
      <div class="card card-body">
        <h2 class="h5"><?= $seccion["titulo"] ?></h2>
        <p class="mb-0"><?= $seccion["texto"] ?></p>
      </div>
    <?php endif; ?>
    <br>
    <a href="logout.php" class="btn btn-secondary ">Cerrar sesión</a>
  </main>
</body>
</html>