<?php

print_r($_POST);

$Nombre = $_POST['Nombre'] ?? '';
$Empresa = $_POST['Empresa'] ?? '';
$Email = $_POST['Email'] ?? '';
$Telefono = $_POST['Telefono'] ?? '';


$Error = "";
$mensajeOk = "";
$mensajeResumen = "";

if (empty($Nombre) || empty($Empresa) || empty($Email) || empty($Telefono)
) {
    $Error .= " Todos los campos son obligatorios <br>";

} else {
    $mensajeOk .= "Todos los campos fueron completados correctamente <br>";
    $mensajeResumen .= "El mensaje enviado enviado correctamente, los datos son: Nombre: " . $Nombre . ", Empresa: " . $Empresa . ", Email: " . $Email . ", Teléfono: " . $Telefono . ", Motivo de consulta: " . $MotivoConsulta . ", Mensaje: " . $Mensaje . " \r <br>";

}

if (empty($Nombre)) {
    $Error .= "El campo nombre es obligatorio <br>";

}
if (empty($Empresa)) {
    $Error .= "El campo empresa es obligatorio <br>";

}

if (empty($Email)) {
    $Error .= "El campo email es obligatorio <br>";

} else{
    if (!isValidEmail($Email)) {
        $Error .= "El email no es válido <br>";

    }
}

if (empty($Telefono)) {
    $Error .= "El campo teléfono es obligatorio <br>";

}


if(!empty($mensajeOk)){
    $Nombre = "";
    $Empresa = "";
    $Email = "";
    $Telefono = "";

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

       <input type="hidden" name="enviado" value="<?= $enviado ?>"> 

        <input type="hidden" class="form-control" id="Accion" name="Accion" aria-describedby="nombreCrear"
               value="crearNuevo">

        <div class="mb-3">
            <label for="Nombre" class="form-label is-required">Nombre : </label>
            <input type="text" class="form-control" id="Nombre" name="Nombre" aria-describedby="nombreAyuda"
                   placeholder="Ingresa tu nombre" value="<?= $Nombre?>">
        
        </div>

        <div class="mb-3">
            <label for="Empresa" class="form-label is-required">Empresa : </label>
            <input type="text" class="form-control" id="Empresa" name="Empresa" aria-describedby="empresaAyuda"
                   placeholder="Ingresa el nombre de tu empresa" value="<?= $Empresa?>">
        </div>

        <div class="mb-3">
            <label for="Email" class="form-label is-required">Email : </label>
            <input type="text" class="form-control" id="Email" name="Email" aria-describedby="emailAyuda"
                   placeholder="Ingresa tu email" value="<?= $Email?>">
        </div>

        <div class="mb-3">
            <label for="Telefono" class="form-label is-required">Teléfono : </label>
            <input type="text" class="form-control" id="Telefono" name="Telefono" aria-describedby="telefonoAyuda"
                   placeholder="Ingresa tu teléfono" value="<?= $Telefono?>">
        </div>




        <button type="submit" class="btn btn-warning mb-2">Enviar</button>
        <a href="index.php">
            <button type="button" class="btn btn-danger mb-2">Cancelar</button>
        </a>
    </form>

    <?php

    if (!empty($Error)):
        echo
            '<div class="alert alert-danger" role="alert">' . $Error . '</div>';
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