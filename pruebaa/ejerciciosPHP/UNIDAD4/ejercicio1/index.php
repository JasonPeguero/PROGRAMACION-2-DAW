<?php
$usuario   = $_COOKIE["usuario"] ?? "invitado";
$idioma    = $_COOKIE["idioma"] ?? "es";
$registros = (int) ($_COOKIE["registros"] ?? 5);
$vista     = $_COOKIE["vista"] ?? "lista";

//mensaje que aparece segun el idioma elegido
$saludos = ["es" => "Hola", "en" => "Hello"];
$saludo = $saludos[$idioma] ?? "Hola";

// Datos
$empleados = [
    "Laura Gómez", 
    "Pedro Ruiz", 
    "Marta Díaz", 
    "Carlos Vega", 
    "Ana Torres",
    "Luis Moreno", 
    "Elena Ramos", 
    "Javier Ortiz", 
    "Sara Molina", 
    "Pablo Núñez"
];

// Solo se muestran tantos empleados como indica la preferencia
$visibles = array_slice($empleados, 0, $registros);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Panel interno</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  <link rel="stylesheet" href="estilos.css">
</head>
<body>
  <main class="container contenedor my-4">
    <h1 class="h3"><?= $saludo ?>, <?= htmlspecialchars($usuario) ?></h1>
    <p><a href="preferencias.php">Modificar preferencias</a></p>

    <h2 class="h5">Empleados</h2>

    <?php if ($vista === "tarjetas"): ?>
      <div class="row g-3">
        <?php foreach ($visibles as $nombre): ?>
          <div class="col-6 col-md-4">
            <div class="card card-body"><?= $nombre ?></div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php else: ?>
      <ul class="list-group">
        <?php foreach ($visibles as $nombre): ?>
          <li class="list-group-item"><?= $nombre ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
  </main>
</body>
</html>