<?php

require "datos.php";
require "funciones.php";

// DATOS
$clientes = obtenerClientes();

// PROCESAMIENTO
$totalClientes = contarClientes($clientes);
$mensaje = crearMensaje($totalClientes);

// LÓGICA DE NEGOCIO
$clientesOrdenados = ordenarClientes($clientes);

// HTML
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

<div class="mensaje">
    <?php echo $mensaje; ?>
</div>

<?php

<<<<<<< HEAD
if ($totalClientes > 0) {
=======
        <?php foreach ($clientesOrdenados as $cliente): ?>
            <tr>
                <td><?= $cliente["id"] ?></td>
                <td><?= $cliente["cliente"] ?></td>
                <td><?= $cliente["empresa"] ?></td>
                <td><?= $cliente["email"] ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
>>>>>>> b0d0b0a7b8cd58a0543de455337a756d514b3d50

    echo "<table>";

    echo "<tr>";
    echo "<th>ID</th>";
    echo "<th>CLIENTE</th>";
    echo "<th>EMPRESA</th>";
    echo "<th>EMAIL</th>";
    echo "</tr>";

    foreach ($clientesOrdenados as $cliente) {

        echo "<tr>";

        echo "<td>";
        echo $cliente["id"];
        echo "</td>";

        echo "<td>";
        echo $cliente["cliente"];
        echo "</td>";

        echo "<td>";
        echo $cliente["empresa"];
        echo "</td>";

        echo "<td>";
        echo $cliente["email"];
        echo "</td>";

        echo "</tr>";
    }

    echo "</table>";

} else {

    echo "<p>No existen clientes para mostrar.</p>";

}

?>

<br>

<p>
    Total de clientes:
<<<<<<< HEAD
    <?php echo $totalClientes; ?>
=======
    <?= $totalClientes ?>
>>>>>>> b0d0b0a7b8cd58a0543de455337a756d514b3d50
</p>

</body>
</html>