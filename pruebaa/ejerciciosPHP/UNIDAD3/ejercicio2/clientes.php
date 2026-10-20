<?php

// Array de clientes
$clientes = [
    ['id' => 1, 'nombre' => 'Juan García', 'DNI' => '12345678A', 'Empresa' => 'TecnoSur',      'Correo' => 'juan@tecnosur.es',        'Telefono' => '612345678', 'Direccion' => 'Calle Mayor, 1',              'CodigoPostal' => '41001', 'Ciudad' => 'Sevilla'],
    ['id' => 2, 'nombre' => 'Ana López',   'DNI' => '87654321B', 'Empresa' => 'WebAndalucía',  'Correo' => 'ana@webandalucia.es',     'Telefono' => '612345678', 'Direccion' => 'Calle Principal, 5',          'CodigoPostal' => '41002', 'Ciudad' => 'Sevilla'],
    ['id' => 3, 'nombre' => 'Carlos Ruiz', 'DNI' => '11223344C', 'Empresa' => 'Digital Cádiz', 'Correo' => 'carlos@digitalcadiz.es',  'Telefono' => '612345678', 'Direccion' => 'Avenida de la Libertad, 10',  'CodigoPostal' => '11003', 'Ciudad' => 'Cádiz'],
    ['id' => 4, 'nombre' => 'Juan Fernández', 'DNI' => '55667788D', 'Empresa' => 'TecnoSur',      'Correo' => 'maria@tecnosur.es',       'Telefono' => '612345678', 'Direccion' => 'Calle Secundaria, 8',         'CodigoPostal' => '41004', 'Ciudad' => 'Sevilla']
    ];

// Obtener los datos de búsqueda del formulario
$nombre  = trim($_GET['nombre']  ?? '');
$Empresa = trim($_GET['Empresa'] ?? '');
$Correo  = trim($_GET['Correo']  ?? '');
$Telefono = trim($_GET['Telefono'] ?? '');
$Direccion = trim($_GET['Direccion'] ?? '');
$CodigoPostal = trim($_GET['CodigoPostal'] ?? '');
$Ciudad = trim($_GET['Ciudad'] ?? '');
$todos   = isset($_GET['todos']);

// Comprueba si existe el dato que se busca
$hayCriterio = ($nombre !== '' || $Empresa !== '' || $Correo !== '' || $Telefono !== '' || $Direccion !== '' || $CodigoPostal !== '' || $Ciudad !== '');

$resultados = [];
$criterios  = [];

// Filtra los clientes según los datos
if ($todos) {
    $resultados = $clientes; //muestra todos los clientes
} elseif ($hayCriterio) { //muestra los clientes que cumplen lo que le pidas
    foreach ($clientes as $c) {
        if ($nombre  !== '' && mb_stripos($c['nombre'],  $nombre)  === false) continue;
        if ($Empresa !== '' && mb_stripos($c['Empresa'], $Empresa) === false) continue;
        if ($Correo  !== '' && mb_stripos($c['Correo'],  $Correo)  === false) continue;
        if ($Telefono !== '' && mb_stripos($c['Telefono'], $Telefono) === false) continue;
        if ($Direccion !== '' && mb_stripos($c['Direccion'], $Direccion) === false) continue;
        if ($CodigoPostal !== '' && mb_stripos($c['CodigoPostal'], $CodigoPostal) === false) continue;
        if ($Ciudad !== '' && mb_stripos($c['Ciudad'], $Ciudad) === false) continue;
        $resultados[] = $c;
    }
    foreach ([$nombre, $Empresa, $Correo, $Telefono, $Direccion, $CodigoPostal, $Ciudad] as $valor) {
        if ($valor !== '') $criterios[] = $valor; 
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Resultados de búsqueda</title>
</head>
<body>
    <div class="container-sm mt-5">
        <h1>Resultado</h1>

        <?php if (!$todos && !$hayCriterio): ?>
            <div class="alert alert-warning" role="alert">Introduzca algun dato</div>

        <?php else: ?>
        
            <p><strong>Criterio:</strong>
                <?= $todos ? 'Todos los clientes' : htmlspecialchars(implode(', ', $criterios)) ?>
            </p>

        <?php if (empty($resultados)): ?>
                <div class="alert alert-info" role="alert">No se han encontrado clientes.</div>
        <?php else: ?>
                <table class="table table-striped">
                    <thead>
                        <tr><th>ID</th><th>Cliente</th><th>Empresa</th><th>Email</th><th>Teléfono</th><th>Dirección</th><th>Código Postal</th><th>Ciudad</th></tr>
                    </thead>
                    <tbody>
        <?php foreach ($resultados as $c): ?>
                <tr>
                <td><?= $c['id'] ?></td>
                <td><?= htmlspecialchars($c['nombre']) ?></td>
                <td><?= htmlspecialchars($c['Empresa']) ?></td>
                <td><?= htmlspecialchars($c['Correo']) ?></td>
                <td><?= htmlspecialchars($c['Telefono']) ?></td>
                <td><?= htmlspecialchars($c['Direccion']) ?></td>
                <td><?= htmlspecialchars($c['CodigoPostal']) ?></td>
                <td><?= htmlspecialchars($c['Ciudad']) ?></td>
                            </tr>
        <?php endforeach; ?>
                    </tbody>
                </table>
        <?php endif; ?>
        <?php endif; ?>

        <a href="index.php" class="btn btn-primary">Buscar</a>
        <a href="clientes.php?todos=1" class="btn btn-link">Ver todos los clientes</a>
    </div>
</body>
</html>

