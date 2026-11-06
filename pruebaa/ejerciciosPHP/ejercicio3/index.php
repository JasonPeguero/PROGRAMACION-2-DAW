<?php
$Nombre = $_POST['Nombre'] ?? '';
$Empresa = $_POST['Empresa'] ?? '';
$Email = $_POST['Email'] ?? '';
$Telefono = $_POST['Telefono'] ?? '';
$MotivoConsulta = $_POST['MotivoConsulta'] ?? '';
$Mensaje = $_POST['Mensaje'] ?? '';


$Error = "";
$mensajeOk = "";
$mensajeResumen = "";
//
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

    <form action="index.php" method="get" style="margin-top: 20px;">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Buscar cliente..." name="Buscar" value="<?= htmlspecialchars($_GET['Buscar'] ?? '') ?>">
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

        if (!empty($_GET['Buscar'])) {
            $array_clientes = consultarClientes($array_clientes, $_GET['Buscar']);
        }

        // Mostrar los clientes en la tabla
        if(count($array_clientes) > 0){

            foreach ($array_clientes as $cliente) {
                echo '<tr>';
                echo '<th scope="row">' . $cliente['id'] . '</th>';
                echo '<td>' . $cliente['nombre'] . '</td>';
                echo '<td>' . $cliente['empresa'] . '</td>';
                echo '<td>' . $cliente['email'] . '</td>';
                echo '<td>' . $cliente['telefono'] . '</td>';
                echo '<td> <a href="eliminar.php?idCliente=' . $cliente['id'] . '" class="btn btn-sm btn-danger">Eliminar</a></td>';
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

</body>
</html>