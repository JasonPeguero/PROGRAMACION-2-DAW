<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

const ARCHIVO     = __DIR__ . "/incidencias.json";   // Aquí se guardan las incidencias
const ESTADOS     = ["Pendiente", "En proceso", "Resuelta", "Cerrada"];
const PRIORIDADES = ["Baja", "Media", "Alta", "Crítica"];

//usuarios y contraseñas
function lista_usuarios() {
    return [
        "admin"     => ["password" => "admin123",   "rol" => "Administrador"],
        "tecnico01" => ["password" => "tecnico123", "rol" => "Técnico"],
        "tecnico02" => ["password" => "tecnico123", "rol" => "Técnico"],
        "cliente01" => ["password" => "cliente123", "rol" => "Cliente"],
        "cliente02" => ["password" => "cliente123", "rol" => "Cliente"],
    ];
}

// Devuelve los nombres de usuario que tienen un ro
function usuarios_con_rol($rol) {
    $resultado = [];
    foreach (lista_usuarios() as $nombre => $datos) {
        if ($datos["rol"] === $rol) {
            $resultado[] = $nombre;
        }
    }
    return $resultado;
}



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

// Cambia el color segun la prioridad de la incidencia
function clase_prioridad($prioridad) {
    if ($prioridad === "Baja")  return "bg-secondary";
    if ($prioridad === "Media") return "bg-info text-dark";
    if ($prioridad === "Alta")  return "bg-warning text-dark";
    return "bg-danger"; // Crítica
}

// Cambia el color segun el estado de la incidencia
function clase_estado($estado) {
    if ($estado === "Pendiente")  return "bg-secondary";
    if ($estado === "En proceso") return "bg-primary";
    if ($estado === "Resuelta")   return "bg-success";
    return "bg-dark"; // Cerrada
}

function texto_tecnico($inc) {
    return $inc["tecnico"] === "" ? "Sin asignar" : $inc["tecnico"];
}


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

// incidecias se guardan en un Json
function cargar_incidencias() {
    if (!file_exists(ARCHIVO)) {
        return [];
    }
    $datos = json_decode(file_get_contents(ARCHIVO), true);
    if (!is_array($datos)) {
        return [];
    }

//asegura que cada incidencia tenga los campos correctos y que el id sea un número
    $lista = [];
    foreach ($datos as $inc) {
        if (!is_array($inc) || !isset($inc["id"]) || !is_numeric($inc["id"])) {
            continue;
        }
        $lista[] = [
            "id"            => (int)$inc["id"],
            "titulo"        => $inc["titulo"] ?? "",
            "descripcion"   => $inc["descripcion"] ?? "",
            "cliente"       => $inc["cliente"] ?? "",
            "tecnico"       => $inc["tecnico"] ?? "",
            "prioridad"     => $inc["prioridad"] ?? "Media",
            "estado"        => $inc["estado"] ?? "Pendiente",
            "fecha"         => $inc["fecha"] ?? ($inc["fecha_creacion"] ?? ""),
            "observaciones" => is_array($inc["observaciones"] ?? null) ? $inc["observaciones"] : [],
        ];
    }
    return $lista;
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

// Si no hay sesión iniciada, vuelve al login
function exigir_login() {
    if (!isset($_SESSION["usuario"])) {
        header("Location: login.php");
        exit;
    }
}

// Si el rol del usuario no estA muestra error 403
function exigir_rol($roles_permitidos) {
    exigir_login();
    if (!in_array($_SESSION["rol"], $roles_permitidos, true)) {
        error_pagina(403, "Acceso no autorizado. No tienes permiso para ver esta página.");
    }
}

// Comprueba si el usuario puede ver la incidencia
function puede_ver($inc) {
    $rol = $_SESSION["rol"] ?? "";
    $usuario = $_SESSION["usuario"] ?? "";

    if ($rol === "Administrador") return true;
    if ($rol === "Técnico")       return $inc["tecnico"] === $usuario;
    if ($rol === "Cliente")       return $inc["cliente"] === $usuario;
    return false;
}

// Muestra una página de error
function error_pagina($codigo, $mensaje) {
    http_response_code($codigo);
    ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Error <?= $codigo ?> · Soporte InformAtico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <main class="container my-4">
        <div class="alert alert-danger" role="alert"><strong>Error <?= $codigo ?>:</strong> <?= e($mensaje) ?></div>
        <a href="panel.php" class="btn btn-secondary">Volver al panel</a>
    </main>
</body>
</html>
<?php
    exit;
}

// Muestra los botones según el rol del usuario
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