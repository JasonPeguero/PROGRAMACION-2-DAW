<?php

require "datos.php";
require "funciones.php";

$clientes = obtenerClientes();
$totalClientes = contarClientes($clientes);
$mensaje = crearMensaje($totalClientes);
$clientesOrdenados = ordenarClientesPorNombre($clientes);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de clientes</title>
    <link rel="stylesheet" href="estilos.css">
</head>

<body>

<h1>Listado de clientes</h1>

<?php if ($totalClientes > 0): ?>

    <table>
        <tr>
            <th>ID</th>
            <th>CLIENTE</th>
            <th>EMPRESA</th>
            <th>EMAIL</th>
        </tr>

        <?php foreach ($clientesOrdenados as $cliente): ?>
            <tr>
                <td><?= e($cliente["id"]) ?></td>
                <td><?= e($cliente["cliente"]) ?></td>
                <td><?= e($cliente["empresa"]) ?></td>
                <td><?= e($cliente["email"]) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

<?php else: ?>

    <p>No existen clientes para mostrar.</p>

<?php endif; ?>

<br>

<p>
    Total de clientes:
    <?= e($totalClientes) ?>
</p>

</body>
</html>