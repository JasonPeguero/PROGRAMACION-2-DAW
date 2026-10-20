<?php

$nombre = $_POST['nombre'] ?? '';
$DNI = $_POST['DNI'] ?? '';
$Empresa = $_POST['Empresa'] ?? '';
$Correo = $_POST['Correo'] ?? '';
$Teléfono = $_POST['Teléfono'] ?? '';
$Dirección = $_POST['Dirección'] ?? '';
$CódigoPostal = $_POST['CódigoPostal'] ?? '';
$Ciudad = $_POST['Ciudad'] ?? '';

$errores = [];
$enviado = false;

if (isset($_POST['enviar'])) {
$nombre = htmlspecialchars(trim($_POST['nombre']));
$DNI = htmlspecialchars(trim($_POST['DNI']));
$Empresa = htmlspecialchars(trim($_POST['Empresa']));
$Correo = htmlspecialchars(trim($_POST['Correo']));
$Teléfono = htmlspecialchars(trim($_POST['Teléfono']));
$Dirección = htmlspecialchars(trim($_POST['Dirección']));
$CódigoPostal = htmlspecialchars(trim($_POST['CódigoPostal']));
$Ciudad = htmlspecialchars(trim($_POST['Ciudad']));
}

//validaciones
if ($nombre == '') {
        $errores[] = 'El nombre del cliente es obligatorio.';
    }
    if ($DNI == '') {
        $errores[] = 'El DNI/NIE es obligatorio.';
    }
    if ($Empresa == '') {
        $errores[] = 'El nombre de la empresa es obligatorio.';
    }
    if ($Correo == '') {
        $errores[] = 'El correo electrónico es obligatorio.';
    }  elseif (!filter_var($Correo, FILTER_VALIDATE_EMAIL)) {
        $errores[] = 'El correo no es válido. Usa un formato como nombre@dominio.com.';
    }

    if ($Teléfono == '') {
        $errores[] = 'El teléfono es obligatorio.';
    }elseif (!preg_match('/^(\+34)?[6-9]\d{8}$/', str_replace(' ', '', $Teléfono))) {
        $errores[] = 'El teléfono no es válido. Debe tener 9 dígitos.';
    }

    if ($Dirección == '') {
        $errores[] = 'La dirección es obligatoria.';
    }
    if ($CódigoPostal == '') {
        $errores[] = 'El código postal es obligatorio.';
    } elseif (!preg_match('/^\d{5}$/', $CódigoPostal)) {
        $errores[] = 'El código postal debe tener 5 dígitos.';
    }

    if($Ciudad == ''){
        $errores[] = 'La ciudad es obligatoria.';
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="estilos.css">
    <title>ejercicio1</title>
</head>
<body>
    <div class = "container-sm mt-5">
 <form method="POST">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre y apellidos<span>*</span></label>
            <input type="text" class="form-control" id="nombre" name="nombre">
        </div>
        <div class="mb-3">
            <label for="DNI" class="form-label">DNI/NIE<span>*</span></label>
            <input type="text" class="form-control" id="DNI" name="DNI">
        </div>
        <div class="mb-3">
            <label for="Empresa" class="form-label">Empresa<span>*</span></label>
            <input type="text" class="form-control" id="Empresa" name="Empresa">
        </div>
        <div class="mb-3">
            <label for="Correo" class="form-label">Correo electrónico<span>*</span></label>
            <input type="email" class="form-control" id="Correo" name="Correo">
        </div>
        <div class="mb-3">
            <label for="Teléfono" class="form-label">Teléfono<span>*</span></label>
            <input type="tel" class="form-control" id="Teléfono" name="Teléfono">
        </div>
        <div class="mb-3">
            <label for="Dirección" class="form-label">Dirección<span>*</span></label>
            <input type="text" class="form-control" id="Dirección" name="Dirección">
        </div>
        <div class="mb-3">
            <label for="CódigoPostal" class="form-label">Código postal<span>*</span></label>
            <input type="number" class="form-control" id="CódigoPostal" name="CódigoPostal">
        </div>
        <div class="mb-3">
            <label for="Ciudad" class="form-label">Ciudad<span>*</span></label>
            <input type="text" class="form-control" id="Ciudad" name="Ciudad">
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
    <?php

if(!empty($errores)):
  echo
  '<div class="alert alert-danger" role="alert">' .implode('<br>', $errores) . '</div>';
else:
  echo '<div class="alert alert-success" role="alert">';
        echo '<h4 class="alert-heading">CLIENTE REGISTRADO CORRECTAMENTE</h4>';
        echo '<p class="mb-1">Nombre: ' . htmlspecialchars($nombre) . '</p>';
        echo '<p class="mb-1">Empresa: ' . htmlspecialchars($Empresa) . '</p>';
        echo '<p class="mb-1">Email: ' . htmlspecialchars($Correo) . '</p>';
        echo '<p class="mb-1">Teléfono: ' . htmlspecialchars($Teléfono) . '</p>';
        echo '<p class="mb-0">Ciudad: ' . htmlspecialchars($Ciudad) . '</p>';
        echo '</div>';
endif;
  
?>
    </div>
</body>
</html>