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
    <h1>ELIMINAR CLIENTE</h1>

    <div class="card text-center">
        <div class="card-header">
            Confirmacion
        </div>
        <div class="card-body">
            <h5 class="card-title">¿Esta seguro que desea eliminar el cliente?</h5>
            <p class="card-text">Esta acción no se puede deshacer.</p>

            <form action="clientes.php" method="post">
                <input type="hidden" name="txAccion" value="eliminar">
                <input type="hidden" name="idCliente" value="<?= $_GET['idCliente'] ?>">
                <button type="submit" class="btn btn-danger">Eliminar</button>
            </form>

            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </div>
        <div class="card-footer text-body-secondary">
            <?= date('Y-m-d H:i:s')?>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

</body>
</html>