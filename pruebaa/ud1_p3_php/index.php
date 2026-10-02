<?php



$txNombre = ($_POST['txNombre']?? '');
$txEmpresa = ($_POST['txEmpresa']?? '');
$txEmail = ($_POST['txEmail']?? '');
$txTelefono = ($_POST['txTelefono']?? '');
$txMotivoConsulta = ($_POST['txMotivoConsulta']?? '');
$txMensaje = ($_POST['txMensaje']?? '');

$mensajeError = "";
$mensajeOk = "";
$mensajeResumen = "";

if (empty($txNombre) || empty($txEmpresa) || empty($txEmail) || empty($txTelefono) || empty($txMotivoConsulta) || empty($txMensaje)
) {
    $mensajeError .= " Todos los campos son obligatorios \r <br>";
    //echo $mensajeError;
} else {
    $mensajeOk .= "Todos los campos fueron completados correctamente \r <br>";
    $mensajeResumen .= "El mensaje enviado enviado correctamente, los datos son: Nombre: " . $txNombre . ", Empresa: " . $txEmpresa . ", Email: " . $txEmail . ", Teléfono: " . $txTelefono . ", Motivo de consulta: " . $txMotivoConsulta . ", Mensaje: " . $txMensaje . " \r <br>";

    //echo $mensajeOk;
}

if (empty($txNombre)) {
    $mensajeError .= "El campo nombre es obligatorio \r <br>";
    //echo $mensajeError;
}
if (empty($txEmpresa)) {
    $mensajeError .= "El campo empresa es obligatorio \r <br>";
    //echo $mensajeError;
}

if (empty($txEmail)) {
    $mensajeError .= "El campo email es obligatorio \r <br>";
    //echo $mensajeError;
} else{
    if (!isValidEmail($txEmail)) {
        $mensajeError .= "El email no es válido \r <br>";
        //echo $mensajeError;
    }
}

if (empty($txTelefono)) {
    $mensajeError .= "El campo teléfono es obligatorio \r <br>";
    //echo $mensajeError;
}

if (empty($txMotivoConsulta)) {
    $mensajeError .= "El campo motivo de consulta es obligatorio \r <br>";
    //echo $mensajeError;
}

if (empty($txMensaje)) {
    $mensajeError .= "El campo mensaje es obligatorio \r <br>";
    //echo $mensajeError;
}

if(!empty($mensajeOk)){
    $txNombre = "";
    $txEmpresa = "";
    $txEmail = "";
    $txTelefono = "";
    $txMotivoConsulta = "";
    $txMensaje = "";
}


function isValidEmail($email) {
    return preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email);
}


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Listado</title>

    <link rel="stylesheet" href="stilos.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>

<div class="container-sm mt-5" style="min-width: 50%; max-width: 60%;">
    <h1>LISTADO CLIENTES</h1>
    <a href="nuevo.php">
        <button class="btn btn-primary">NUEVO</button>
    </a>

    <form action="clientes.php" method="get" style="margin-top: 20px;">
        <div class="input-group">
            <input hidden="hidden" name="txAccion" value="accionBuscar">
            <input type="text" class="form-control" placeholder="Buscar cliente..." name="txBuscar">
            <button class="btn btn-outline-secondary" type="submit">Buscar</button>
        </div>
    </form>




    <table class="table" style="margin-top: 20px;">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">NOMBRE</th>
            <th scope="col">EMPRESA</th>
            <th scope="col">EMAIL</th>
            <th scope="col">TELEFONO</th>
            <th scope="col">ACCIONES</th>
        </tr>
        </thead>
        <tbody>

        <?php
        include 'clientes.php';

        if(count($array_clientes) > 0){

            foreach ($array_clientes as $cliente) {
                echo '<tr>';
                echo '<th scope="row">' . $cliente['id'] . '</th>';
                echo '<td>' . $cliente['nombre'] . '</td>';
                echo '<td>' . $cliente['empresa'] . '</td>';
                echo '<td>' . $cliente['email'] . '</td>';
                echo '<td>' . $cliente['telefono'] . '</td>';
                echo '<td> <a href="eliminar.php?idCliente=' . $cliente['id'] . '" class="btn btn-sm btn-danger">Eliminar</a></td>';
                echo '<td> <a href="ficha_clientes.php?idCliente=' . $cliente['id'] . '" class="btn btn-sm btn-success">Modificar</a></td>';

                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="6">No hay clientes registrados.</td></tr>';
        }


        ?>

        </tbody>
    </table>

    <?php if (isset($_GET['mensaje'])): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $_GET['mensaje']; ?>
        </div>
    <?php endif; ?>

</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

</body>
</html>