<?php
$Nombre = $_POST['Nombre']  ?? '';;
$Empresa = $_POST['Empresa']  ?? '';;
$Email = $_POST['Email']  ?? '';;
$Telefono = $_POST['Telefono']  ?? '';;
$MotivoConsulta = $_POST['MotivoConsulta']  ?? '';;
$Mensaje = $_POST['Mensaje']  ?? '';;

$Error = "";
$mensajeOk = "";
$mensajeResumen = "";

// Validar campos
if (empty($Nombre) || empty($Empresa) || empty($Email) || empty($Telefono) || empty($MotivoConsulta) || empty($Mensaje)
) {
    $Error .= " Todos los campos son obligatorios \r <br>";

} else {
    $mensajeOk .= "Todos los campos fueron completados correctamente \r <br>";
    $mensajeResumen .= "El mensaje enviado enviado correctamente, los datos son: Nombre: " . $Nombre . ", Empresa: " . $Empresa . ", Email: " . $Email . ", Teléfono: " . $Telefono . ", Motivo de consulta: " . $MotivoConsulta . ", Mensaje: " . $Mensaje . " \r <br>";


}

if (empty($Nombre)) {
    $Error .= "El campo nombre es obligatorio \r <br>";

}
if (empty($Empresa)) {
    $Error .= "El campo empresa es obligatorio \r <br>";

}

if (empty($Email)) {
    $Error .= "El campo email es obligatorio \r <br>";

} else{
    if (!isValidEmail($Email)) {
        $Error .= "El email no es válido \r <br>";

    }
}

if (empty($Telefono)) {
    $Error .= "El campo teléfono es obligatorio \r <br>";

}

if (empty($MotivoConsulta)) {
    $Error .= "El campo motivo de consulta es obligatorio \r <br>";

}

if (empty($Mensaje)) {
    $Error .= "El campo mensaje es obligatorio \r <br>";

}

if(!empty($mensajeOk)){
    $Nombre = "";
    $Empresa = "";
    $Email = "";
    $Telefono = "";
    $MotivoConsulta = "";
    $Mensaje = "";
}


function isValidEmail($email) {
    return preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email); //Validacion de el corrreo
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
                <input type="hidden" name="Accion" value="eliminar">
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