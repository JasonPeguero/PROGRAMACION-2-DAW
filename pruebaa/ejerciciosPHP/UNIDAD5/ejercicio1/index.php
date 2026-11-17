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
                <td><?= $cliente["id"] ?></td>
                <td><?= $cliente["cliente"] ?></td>
                <td><?= $cliente["empresa"] ?></td>
                <td><?= $cliente["email"] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

<?php else: ?>

    <p>No existen clientes para mostrar.</p>

<?php endif; ?>

<br>

<p>
    Total de clientes:
    <?= $totalClientes ?>
</p>

</body>
</html>