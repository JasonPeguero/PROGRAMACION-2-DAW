<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejercicio1 php</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
<link rel="stylesheet" href="ejerciciosPHP/ejercicio3/estilo.css">
</head>

<body>

<?php
$Nombre = ($_POST['Nombre'] ?? '');
$Empresa = ($_POST['Empresa'] ?? '');
$Correo = ($_POST['Correo'] ?? '');
$Telefono = ($_POST['Telefono'] ?? '');
?>

<?php
$array_clientes = [
    [
        'id' => 3,
        'Nombre' => 'Juan',
        'Empresa' => 'hola',
        'Correo' => '123',
        'Telefono' => '123',
    ]
];
?>

<table class = "container-sm mt-5">
  <thead>
    <tr>
      <th scope="col">id</th>
      <th scope="col">Nombre</th>
      <th scope="col">Empresa</th>
      <th scope="col">Correo</th>
      <th scope="col">Telefono</th>
    </tr>
  </thead>
  

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
  </tbody>
</table>
<div class="container-sm mt-5">
  <a href="nuevo.php" class="btn btn-primary" role="button">Nuevo</a>
</div>

    

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>