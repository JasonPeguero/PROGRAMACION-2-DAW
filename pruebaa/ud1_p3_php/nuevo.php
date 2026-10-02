<?php

print_r($_POST);

$txNombre = ($_POST['txNombre']?? '');
$txEmpresa = ($_POST['txEmpresa']?? '');
$txEmail = ($_POST['txEmail']?? '');
$txTelefono = ($_POST['txTelefono']?? '');


$mensajeError = "";
$mensajeOk = "";
$mensajeResumen = "";

if (empty($txNombre) || empty($txEmpresa) || empty($txEmail) || empty($txTelefono)
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


if(!empty($mensajeOk)){
    $txNombre = "";
    $txEmpresa = "";
    $txEmail = "";
    $txTelefono = "";

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
    <title>ALTA CLIENTES</title>

    <link rel="stylesheet" href="stilos.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>

<div class="container-sm mt-5" style="min-width: 50%; max-width: 60%;">
    <h1>ALTA DE CLIENTES</h1>
    <form action="clientes.php" method="post">

        <!-- <input type="hidden" name="enviado" value="<?= $enviado ?>"> -->

        <input type="hidden" class="form-control" id="txAccion" name="txAccion" aria-describedby="nombreCrear"
               value="crearNuevo">

        <div class="mb-3">
            <label for="txNombre" class="form-label is-required">Nombre : </label>
            <input type="text" class="form-control" id="txNombre" name="txNombre" aria-describedby="nombreAyuda"
                   placeholder="Ingresa tu nombre" value="<?= $txNombre?>">
            <!-- Ayuda para el campo de nombre
            <div id="nombreAyuda" class="form-text">Ingresa tu nombre</div> -->
        </div>

        <div class="mb-3">
            <label for="txEmpresa" class="form-label is-required">Empresa : </label>
            <input type="text" class="form-control" id="txEmpresa" name="txEmpresa" aria-describedby="empresaAyuda"
                   placeholder="Ingresa el nombre de tu empresa" value="<?= $txEmpresa?>">
        </div>

        <div class="mb-3">
            <label for="txEmail" class="form-label is-required">Email : </label>
            <input type="text" class="form-control" id="txEmail" name="txEmail" aria-describedby="emailAyuda"
                   placeholder="Ingresa tu email" value="<?= $txEmail?>">
        </div>

        <div class="mb-3">
            <label for="txTelefono" class="form-label is-required">Teléfono : </label>
            <input type="text" class="form-control" id="txTelefono" name="txTelefono" aria-describedby="telefonoAyuda"
                   placeholder="Ingresa tu teléfono" value="<?= $txTelefono?>">
        </div>




        <button type="submit" class="btn btn-warning mb-2">Enviar</button>
        <a href="index.php">
            <button type="button" class="btn btn-danger mb-2">Cancelar</button>
        </a>
    </form>

    <?php

    if (!empty($mensajeError)):
        echo
            '<div class="alert alert-danger" role="alert">' . $mensajeError . '</div>';
    else:
        echo
            '<div class="alert alert-success" role="alert">' . $mensajeOk . '</div>';

        echo
            '<div class="alert alert-info" role="alert">' . $mensajeResumen . '</div>';
    endif;

    ?>

    <?php
    $array_clientes = [
        [
            'id' => 1,
            'nombre' => 'Juan Pérez',
            'empresa' => 'Empresa A',
            'email' => 'juan.perez@example.com',
            'telefono' => '123456789'
        ]
    ];

    ?>



</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>

</body>
</html>