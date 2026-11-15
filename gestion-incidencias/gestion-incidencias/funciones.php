<?php
// funciones.php
// Aquí está lo que se usa en TODAS las páginas: sesión, usuarios,
// lectura/escritura de incidencias, comprobación de permisos y cabecera/pie.

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

const ARCHIVO     = __DIR__ . "/incidencias.json";   // Aquí se guardan las incidencias
const ESTADOS     = ["Pendiente", "En proceso", "Resuelta", "Cerrada"];
const PRIORIDADES = ["Baja", "Media", "Alta", "Crítica"];

// ---------------------------------------------------------------
// USUARIOS (los mismos del ejercicio anterior + algunos más)
// ---------------------------------------------------------------
function lista_usuarios() {
    return [
        "admin"     => ["password" => "admin123",   "rol" => "Administrador"],
        "tecnico01" => ["password" => "tecnico123", "rol" => "Técnico"],
        "tecnico02" => ["password" => "tecnico123", "rol" => "Técnico"],
        "cliente01" => ["password" => "cliente123", "rol" => "Cliente"],
        "cliente02" => ["password" => "cliente123", "rol" => "Cliente"],
    ];
}

// Devuelve los nombres de usuario que tienen un rol (ej: todos los técnicos)
function usuarios_con_rol($rol) {
    $resultado = [];
    foreach (lista_usuarios() as $nombre => $datos) {
        if ($datos["rol"] === $rol) {
            $resultado[] = $nombre;
        }
    }
    return $resultado;
}

// ---------------------------------------------------------------
// UTILIDADES
// ---------------------------------------------------------------

// Escribe un texto de forma segura en HTML (evita código malicioso)
function e($texto) {
    return htmlspecialchars((string)$texto, ENT_QUOTES, "UTF-8");
}

// Guarda un mensaje para mostrarlo en la siguiente página
function poner_mensaje($texto, $tipo = "success") {
    $_SESSION["mensaje"] = ["texto" => $texto, "tipo" => $tipo];
}

function mostrar_mensaje() {
    if (isset($_SESSION["mensaje"])) {
        $m = $_SESSION["mensaje"];
        echo '<div class="alert alert-' . $m["tipo"] . '" role="alert">' . e($m["texto"]) . '</div>';
        unset($_SESSION["mensaje"]);
    }
}

// Color del distintivo (badge) según la prioridad
function clase_prioridad($prioridad) {
    if ($prioridad === "Baja")  return "bg-secondary";
    if ($prioridad === "Media") return "bg-info text-dark";
    if ($prioridad === "Alta")  return "bg-warning text-dark";
    return "bg-danger"; // Crítica
}

// Color del distintivo (badge) según el estado
function clase_estado($estado) {
    if ($estado === "Pendiente")  return "bg-secondary";
    if ($estado === "En proceso") return "bg-primary";
    if ($estado === "Resuelta")   return "bg-success";
    return "bg-dark"; // Cerrada
}

function texto_tecnico($inc) {
    return $inc["tecnico"] === "" ? "Sin asignar" : $inc["tecnico"];
}

// ---------------------------------------------------------------
// SEGURIDAD: TOKEN CSRF
// Sirve para comprobar que el formulario lo ha enviado nuestra
// propia página y no otra web que engaña al usuario.
// ---------------------------------------------------------------
function token() {
    if (empty($_SESSION["token"])) {
        $_SESSION["token"] = bin2hex(random_bytes(16));
    }
    return $_SESSION["token"];
}

function campo_token() {
    return '<input type="hidden" name="token" value="' . token() . '">';
}

function token_valido() {
    return isset($_POST["token"]) && hash_equals($_SESSION["token"] ?? "", $_POST["token"]);
}

// ---------------------------------------------------------------
// INCIDENCIAS (se guardan en un archivo JSON)
// ---------------------------------------------------------------
function cargar_incidencias() {
    if (!file_exists(ARCHIVO)) {
        return [];
    }
    $datos = json_decode(file_get_contents(ARCHIVO), true);
    return is_array($datos) ? $datos : [];
}

function guardar_incidencias($lista) {
    $json = json_encode(array_values($lista), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    file_put_contents(ARCHIVO, $json, LOCK_EX);
}

function buscar_incidencia($id) {
    foreach (cargar_incidencias() as $inc) {
        if ($inc["id"] === $id) {
            return $inc;
        }
    }
    return null;
}

// Sustituye una incidencia existente por su versión modificada
function actualizar_incidencia($nueva) {
    $lista = cargar_incidencias();
    foreach ($lista as $i => $inc) {
        if ($inc["id"] === $nueva["id"]) {
            $lista[$i] = $nueva;
        }
    }
    guardar_incidencias($lista);
}

function siguiente_id($lista) {
    $mayor = 0;
    foreach ($lista as $inc) {
        if ($inc["id"] > $mayor) {
            $mayor = $inc["id"];
        }
    }
    return $mayor + 1;
}

// ---------------------------------------------------------------
// PERMISOS (siempre se comprueban en el servidor)
// ---------------------------------------------------------------

// Si no hay sesión iniciada, vuelve al login
function exigir_login() {
    if (!isset($_SESSION["usuario"])) {
        header("Location: login.php");
        exit;
    }
}

// Si el rol del usuario no está en la lista, muestra error 403
function exigir_rol($roles_permitidos) {
    exigir_login();
    if (!in_array($_SESSION["rol"], $roles_permitidos, true)) {
        error_pagina(403, "Acceso no autorizado. No tienes permiso para ver esta página.");
    }
}

// ¿Puede el usuario actual ver esta incidencia?
function puede_ver($inc) {
    $rol = $_SESSION["rol"] ?? "";
    $usuario = $_SESSION["usuario"] ?? "";

    if ($rol === "Administrador") return true;
    if ($rol === "Técnico")       return $inc["tecnico"] === $usuario;
    if ($rol === "Cliente")       return $inc["cliente"] === $usuario;
    return false;
}

// Muestra una página de error y termina
function error_pagina($codigo, $mensaje) {
    http_response_code($codigo);
    mostrar_cabecera("Error " . $codigo);
    echo '<div class="alert alert-danger" role="alert"><strong>Error ' . $codigo . ':</strong> ' . e($mensaje) . '</div>';
    echo '<a href="panel.php" class="btn btn-secondary">Volver al panel</a>';
    mostrar_pie();
    exit;
}

// ---------------------------------------------------------------
// BOTONES DE ACCIONES (Ver / Editar / Eliminar) según el rol
// ---------------------------------------------------------------
function mostrar_acciones($inc) {
    $rol = $_SESSION["rol"];
    $id = $inc["id"];

    echo '<a class="btn btn-sm btn-outline-primary" href="detalle-incidencia.php?id=' . $id . '" aria-label="Ver incidencia ' . $id . '">Ver</a> ';

    if ($rol === "Administrador" || $rol === "Técnico") {
        echo '<a class="btn btn-sm btn-outline-secondary" href="editar-incidencia.php?id=' . $id . '" aria-label="Editar incidencia ' . $id . '">Editar</a> ';
    }

    if ($rol === "Administrador") {
        echo '<form method="post" action="incidencias.php" class="d-inline" onsubmit="return confirm(\'¿Seguro que quieres eliminar la incidencia ' . $id . '?\');">';
        echo campo_token();
        echo '<input type="hidden" name="id" value="' . $id . '">';
        echo '<button type="submit" class="btn btn-sm btn-outline-danger" aria-label="Eliminar incidencia ' . $id . '">Eliminar</button>';
        echo '</form>';
    }
}

// ---------------------------------------------------------------
// CABECERA Y PIE (se repiten en todas las páginas)
// ---------------------------------------------------------------
function mostrar_cabecera($titulo, $con_menu = true) {
    $rol = $_SESSION["rol"] ?? "";
    $usuario = $_SESSION["usuario"] ?? "";
    ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($titulo) ?> · Soporte Informático</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="estilos.css">
</head>
<body>
  <a href="#contenido" class="visually-hidden-focusable">Saltar al contenido</a>

  <?php if ($con_menu && $rol !== ""): ?>
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
        <span class="navbar-text me-md-3"><?= e($usuario) ?> (<?= e($rol) ?>)</span>
        <a class="btn btn-outline-light btn-sm" href="logout.php">Cerrar sesión</a>
      </div>
    </div>
  </nav>
  <?php endif; ?>

  <main id="contenido" class="container my-4">
    <?php mostrar_mensaje(); ?>
<?php
}

function mostrar_pie() {
    ?>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>
<?php
}
