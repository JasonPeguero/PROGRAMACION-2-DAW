<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio2 php - Info peticion</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body>

<?php
$Metodo = $_SERVER['REQUEST_METHOD'] ?? '';
$Ip = $_SERVER['REMOTE_ADDR'] ?? '';
$Url = $_SERVER['REQUEST_URI'] ?? '';
$Navegador = $_SERVER['HTTP_USER_AGENT'] ?? '';
$Idioma = $_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '';
$FechaHora = date('d/m/Y H:i:s');

$Usuario = ($_GET['usuario'] ?? '');

$Nombre = ($_POST['Nombre'] ?? '');

$envioPost = false;
$recibidoPost = "";

if (isset($_POST['enviarPost'])) {
    $envioPost = true;
    $recibidoPost .= "Nombre recibido: " . $Nombre . "<br>";
}

?>



<div class="container-sm mt-5">

  <h2 class="mb-4">Info peticion</h2>

  <p> Metodo HTTP <?= $Metodo ?> </p>
  <p>URL solicitada <?= $Url ?></p>
  <p>Navegador <?= $Navegador ?></p>
  <p>Direccion IP del cliente <?= $Ip ?></p>
  <p>Idioma <?= $Idioma ?></p>
  <p>Fecha y hora <?= $FechaHora ?></p>
 
  <h3 class="mb-3">Consulta mediante GET</h3>

  <form method="GET">
    <div class="mb-3">
      <label for="usuario" class="form-label">Usuario<span>*</span></label>
    </div>
  </form>

  <br>

  <?php if (!empty($Usuario)): ?>
    <div class="alert" role="alert">
      Usuario recibido: <?= $Usuario ?>
    </div>
  <?php endif; ?>

  <h3 class="mb-3">Envio mediante POST</h3>

  <form method="POST">
    <div class="mb-3">
      <label for="Nombre" class="form-label">Nombre<span>*</span></label>
      <input type="text" class="form-control" id="Nombre" name="Nombre">
    </div>
  

    <button type="submit" name="enviarPost" class="btn btn-primary">Enviar POST</button>

  <br>
  <br>


  <?php if ($envioPost): ?>
    <div class="alert" role="alert"><?= $recibidoPost ?></div>
  <?php endif; ?>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>