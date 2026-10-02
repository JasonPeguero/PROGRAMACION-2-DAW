<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio1 php</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<link rel="stylesheet" href="ejerciciosPHP\ejercicio3\estilo.css">
</head>

<body>

<?php
$Nombre = ($_POST['Nombre'] ?? '');
$Empresa = ($_POST['Empresa'] ?? '');
$Correo = ($_POST['Correo'] ?? '');
$Telefono = ($_POST['Telefono'] ?? '');
$Motivo = ($_POST['Motivo'] ?? '');
$Mensaje = ($_POST['Mensaje'] ?? '');

$error = "";
$envio = false;
$mensajeresum = "";

if(empty($Nombre) || empty($Empresa) || empty($Correo) || empty($Telefono) || empty($Motivo) || empty($Mensaje)){
$error .= "Todos los campos son obligatorios";
} else {
  $envio .= "Todos los campos son correctos";
  $mensajeresum .= "Resumen de los datos " . $Nombre . "<br>"; 
  $mensajeresum .= "Resumen de los datos " . $Empresa . "<br>"; 
  $mensajeresum .= "Resumen de los datos " . $Correo . "<br>";
  $mensajeresum .= "Resumen de los datos " . $Telefono . "<br>";

    

if (empty($Nombre)) {
        $error .= "El nombre es obligatorio \n <br>";
    }
if (empty($Empresa)) {
        $error .= "LA empresa es obligatorio \n <br>";
    }
if (empty($Correo)) {
        $error .= "El correo es obligatorio \n <br>";
    }
if (empty($Telefono)) {
        $error .= "El telefono es obligatorio \n <br>";
    }

if (empty($error)) {
        $exito = true;
    }


?>



<div class = "container-sm mt-5">
<form method="POST">
  <div class="mb-3">
    <label for="Nombre" class="form-label">Nombre<span>*</span></label>
    <input type="text" class="form-control" id="Nombre" name="Nombre" aria-describedby="Nombre">
  <div class="mb-3">
    <label for="Empresa" class="form-label">Empresa<span>*</span></label>
    <input type="text" class="form-control" id="Empresa" name="Empresa">
  </div>
  <div class="mb-3">
    <label for="Correo" class="form-label">Email <span>*</span></label>
    <input type="Ematextil" class="form-control" id="Correo" name="Correo">
  </div>
  <div class="mb-3">
    <label for="Telefono" class="form-label">Teléfono<span>*</span></label>
    <input type="text" class="form-control" id="Telefono" name="Telefono">
  </div>
  
    <button type="submit" class="btn btn-primary">Enviar</button> 
</form>
<br>
<br>

<?php

if(!empty($error)):
  echo
  '<div class="alert alert-danger" role="alert">' .$error .'</div>';
else:
  echo
  '<div class="alert alert-success" role="alert">' . $envio .'</div>';
  echo
    '<div class="alert alert-success" role="alert">' . $mensajeresum .'</div>';

endif;
?>

<?php
$array_clientes = [
    'id' => 3,
    'Nombre' => 'Juan',
    'Empresa' => 'dddd',
    'Correo' => '123',
    'Telefono' => '123',
];

//$array_clientes[] = //
?>

<table class="table">
  <thead>
    <tr>
      <th scope="col">id</th>
      <th scope="col">Nombre</th>
      <th scope="col">Empresa</th>
      <th scope="col">Correo</th>
      <th scope="col">Telefono</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Nombre</td>
      <td>Otto</td>
      <td>@mdo</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Empresa</td>
      <td>Thornton</td>
      <td>@fat</td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td colspan="2">Correo</td>
      <td>@twitter</td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td>Telefono</td>
      <td>Thornton</td>
      <td>@fat</td>
    </tr>
  </tbody>
</table>

<?php
include'array_clientes';
foreach ($array_clientes as $clientes) {
echo '<tr>';
echo ' <th scope="row">' .  $clientes['id'] . '</th>';
echo '<td>' . $clientes ['Nombre'] . '</td>';
echo '<td>' . $clientes ['Empresa'] . '</td>';
echo '<td>' . $clientes ['Correo'] . '</td>';
echo '<td>' . $clientes ['Telefono'] . '</td>';
echo '<tr>';

}
?>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>